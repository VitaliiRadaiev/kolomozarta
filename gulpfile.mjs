import gulp from "gulp";
import { deleteAsync } from "del";
import * as dartSass from 'sass';
import gulpSass from "gulp-sass";
const sass = gulpSass(dartSass);
import autoprefixer from "gulp-autoprefixer";
import postcss from 'gulp-postcss';
import sortMediaQueries from 'postcss-sort-media-queries';
import plumber from "gulp-plumber";
import notify from "gulp-notify";
import cssnano from "cssnano"; // для минимизации CSS
import terser from "gulp-terser"; // для минимизации JS
import rename from 'gulp-rename'; // для переименования файлов
import browserSync from "browser-sync";

// "devDependencies": {
//     "browser-sync": "^3.0.2",
//     "del": "^7.1.0",
//     "gulp": "^5.0.0",
//     "gulp-autoprefixer": "^9.0.0",
//     "gulp-clean-css": "^4.3.0",
//     "gulp-concat": "^2.6.1",
//     "gulp-imagemin": "^9.1.0",
//     "gulp-sass": "^5.1.0",
//     "gulp-sourcemaps": "^3.0.0",
//     "gulp-terser": "^2.1.0",
//     "gulp-uglify": "^3.0.2",
//     "sass-embedded": "^1.80.3"
//   }

const paths = {
    scss: ["src/scss/**/*.scss"],
    js: "src/js/**/*.js",
    images: "src/images/**/*.{png,jpg,jpeg,gif,svg}",
    php: "**/*.php",
    dist: {
        css: "dist/css/",
        js: "dist/js/",
        images: "dist/images",
    },
};

export function styles() {
    return gulp
        .src(paths.scss, { base: "src/scss" })
        .pipe(plumber({
            errorHandler: notify.onError({
                title: "SCSS Error",
                message: "Error: <%= error.message %>"
            })
        }))
        .pipe(
            sass({
                outputStyle: "expanded",
                includePaths: ['.', 'node_modules']
            })
        )
        .pipe(
            postcss([
                sortMediaQueries()
            ])
        )
        .pipe(
            autoprefixer({
                overrideBrowserslist: ["last 3 versions"],
                cascade: true
            })
        )
        // Обычный CSS
        //.pipe(gulp.dest(paths.dist.css))
        // Минимизация CSS
        //.pipe(postcss([cssnano()]))
        //.pipe(rename({ suffix: '.min' })) // добавление суффикса .min
        .pipe(gulp.dest(paths.dist.css))
        .pipe(browserSync.stream());
}

export function scripts() {
    return gulp
        .src(paths.js, { base: 'src/js' })
        .pipe(gulp.dest(paths.dist.js))
        // Минимизация JS
        // .pipe(terser())
        // .pipe(rename({ suffix: '.min' })) // добавление суффикса .min
        // .pipe(gulp.dest(paths.dist.js))
        .pipe(browserSync.stream());
}

export function serve() {
    browserSync.init({
        proxy: "http://kolomozarta.local/",
        notify: false,
    });


    gulp.watch(paths.scss, styles);

    gulp.watch(paths.js, scripts);

    gulp.watch(paths.php).on("change", browserSync.reload);
}


export function clean() {
    return deleteAsync(["dist/**", "!dist/fonts", "!dist/images"]);
}


export default gulp.series(
    clean,
    gulp.parallel(
        styles,
        scripts
    ),
    serve
);

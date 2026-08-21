<?php

function learning_files()
{
    // CSS styles
    wp_enqueue_style('learning_main_styles', get_theme_file_uri('./dist/css/main.css'), array(), filemtime(get_theme_file_path('./dist/css/main.css')));
    wp_enqueue_style('main_aos', get_theme_file_uri('./dist/css/libs/aos.css'), array(), filemtime(get_theme_file_path('./dist/css/libs/aos.css')));


    // Scripts
    wp_enqueue_script('jquery_js', get_theme_file_uri('./dist/js/libs/jquery-3.7.1.min.js'), array('jquery'), '1.0', true);
    wp_enqueue_script('aos_js', get_theme_file_uri('./dist/js/libs/aos.js'), array('jquery'), '1.0', true);
    wp_enqueue_script('main_js', get_theme_file_uri('./dist/js/main.js'), array('jquery'), '1.0', true);
    wp_enqueue_script('utils_js', get_theme_file_uri('./dist/js/utils.js'), array('jquery'), '1.0', true);

    if (is_front_page()) {
        wp_enqueue_style('hero_style', get_theme_file_uri() . '/dist/css/blocks/block_hero.css', array(), filemtime(get_theme_file_path('/dist/css/blocks/block_hero.css')));
        wp_enqueue_style('courses_style', get_theme_file_uri() . '/dist/css/blocks/block_courses.css', array(), filemtime(get_theme_file_path('/dist/css/blocks/block_courses.css')));
    }
}

add_action('wp_enqueue_scripts', 'learning_files');

define('THEME_ADMIN_STYLE', 'dist/css/admin-styles.css');

add_action('admin_enqueue_scripts', 'load_admin_style');
function load_admin_style()
{
    wp_enqueue_style('admin-style-css', get_theme_file_uri(THEME_ADMIN_STYLE), array(), filemtime(get_theme_file_path(THEME_ADMIN_STYLE)));
}

// Те же стили — внутрь iframe TinyMCE, чтобы контент в редакторе
// выглядел как на фронте (src/scss/admin-styles.scss).
add_action('after_setup_theme', function () {
    add_editor_style(THEME_ADMIN_STYLE);
});

// add_editor_style() отдаёт URL без версии, поэтому правки стилей залипают в
// кеше браузера внутри iframe редактора. Дописать ?ver прямо в add_editor_style
// нельзя — WP проверяет file_exists() и молча отбросит путь с query-строкой.
add_filter('mce_css', function ($stylesheets) {
    $path = get_theme_file_path(THEME_ADMIN_STYLE);
    if (!file_exists($path)) {
        return $stylesheets;
    }

    $uri = get_theme_file_uri(THEME_ADMIN_STYLE);

    return str_replace($uri, add_query_arg('ver', filemtime($path), $uri), $stylesheets);
});

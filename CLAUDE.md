# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

WordPress theme "Коло Моцарта" (music school / paid video-lesson site). Admin UI labels, ACF field labels and site content are in Ukrainian — keep new admin-facing strings in Ukrainian.

Repo root = the theme directory (`wp-content/themes/kolo-mozarta`), inside a Local/LocalWP install. Local site URL: `http://kolomozarta.local/`.

Depends on plugins that are **not** in this repo: ACF Pro (Advanced Custom Fields), Contact Form 7, Presto Player, `wp_google_login`, Members (uses `_members_access_role` post meta), Rank Math.

## Commands

No npm scripts, no test suite, no linter. Everything runs through Gulp:

```bash
npx gulp            # clean + styles + scripts + BrowserSync dev server (proxies kolomozarta.local)
npx gulp styles     # compile SCSS -> dist/css
npx gulp scripts    # copy JS   -> dist/js
npx gulp clean      # wipe dist/** except dist/fonts and dist/images
```

## Build pipeline

- `src/scss/**/*.scss` → `dist/css/**` **preserving directory structure, one CSS file per SCSS entry** (dart-sass, `postcss-sort-media-queries`, autoprefixer, expanded output; minification is commented out in [gulpfile.mjs](gulpfile.mjs)). Files prefixed `_` are partials and are not emitted.
- `src/js/**/*.js` → `dist/js/**` copied verbatim. No bundling, no transpiling, no modules — plain scripts sharing the global scope.
- `dist/fonts/` and `dist/images/` have **no gulp task** — they are hand-maintained and deliberately excluded from `clean`. Adding a font/image means copying it into `dist/` yourself (`src/images` is unused by the build).
- `dist/` **is committed** to git. A change to `src/` is only complete once the rebuilt `dist/` files are committed too. Never hand-edit `dist/`.

## Architecture

### Page = ACF flexible-content sections

[page-template.php](page-template.php) ("Шаблон сторінки", available for `page`, `courses`, `updates`) is the main renderer. It reads the ACF flexible-content field `sections` and for each row:

```php
global $data;              // the current section's ACF row
$data = $section;
$data['section_key'] = $sec_key;
include get_template_directory() . '/blocks/' . $section['acf_fc_layout'] . '.php';
```

So the layout name **is** the block filename: layout `block_cta` → [blocks/block_cta.php](blocks/block_cta.php). Blocks receive data only through `global $data` (never `$args`), and are `include`d — not `get_template_part`'d — so they share the enclosing scope.

Other entry points: [page-video-lesons.php](page-video-lesons.php) (gated lessons page, hand-rolled markup), [page-videos.php](page-videos.php), [page-updates.php](page-updates.php), [page-text-content.php](page-text-content.php) (the only template that keeps the WP content editor — see `hide_content_editor_on_specific_pages` in [functions.php](functions.php)), [page-login.php](page-login.php), [single-video-lesson.php](single-video-lesson.php), [single-courses.php](single-courses.php).

### Block file contract

Every `blocks/block_*.php` follows the same shape:

```php
<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (is_admin() && $data['section_utils']['is_hide_for_users']) { return; }

    wp_enqueue_style('x_style', get_theme_file_uri() . '/dist/css/blocks/block_x.css');
    // + wp_enqueue_script(..., array('main_js'), null, false) if the block has JS
?>
    <section <?= get_section_id($data) ?> class="block-x <?= get_section_space_top($data) ?>">
    ...
<?php endif; ?>
```

Per-block CSS/JS is enqueued **inside the block file** (late enqueue works because these run during `the_content`-time rendering, before `wp_footer`). Only truly global assets live in [functions-parts/_assets.php](functions-parts/_assets.php). Same pattern for [templates/parts/product-card.php](templates/parts/product-card.php) and [templates/global-popups.php](templates/global-popups.php).

Adding a block therefore means: `blocks/block_<name>.php` + `src/scss/blocks/block_<name>.scss` (+ `src/js/blocks/block_<name>.js`, wrapped in a bare `{ }` block to avoid globals) + an ACF layout + rebuild `dist/`.

### ACF conventions (`acf-json/` local JSON)

ACF local JSON is enabled by ACF's default `acf-json/` convention — **field group edits in the WP admin must be synced to `acf-json/` and committed**. Group titles encode their role:

- `[C-Block] …` — one group per block, cloned (seamless) into the matching layout of the `sections` flexible content in `group_671e689be41f9`. Its `location` rule is irrelevant; the clone is what matters.
- `[util] section-utils` (`group_68cac8b81e59e`) — cloned into every block. Provides `section_utils.id`, `.is_hide`, `.is_hide_for_users`, `.space_top` (`lg|md|sm|0`).
- `[template part] title` / `[template part] button` — cloned into blocks that render the shared `title` / `button` partials.
- `[Block] …`, `[post] …` — per-post-type field groups.
- Site-wide fields live on the `theme_settings` options page and are read with `get_field('name', 'option')` (header/footer logos, contacts, `text_*` labels, analytics scripts).

### Shared partials

`get_template_part(get_part_path('title'), null, ['title_data' => $data['title']])` — `get_part_path()` resolves `templates/parts/<name>`. Partials read `$args`, run their data through `wp_parse_args()` with defaults, and map ACF select values to classes (e.g. button `fill_theme|stroke_theme|stroke_dark`, title `size` = `page-title|h1|h2|h3` + `text-<align>` + `bottom-line`).

### PHP helpers ([functions-parts/_custom-functions.php](functions-parts/_custom-functions.php))

`check($var)` (trim-aware truthiness — used everywhere instead of `!empty()`), `get_image($id, $classes, $echo, $size, $attrs)`, `get_section_id($data)`, `get_section_space_top($data)`, `get_part_path($name)`, `build_menu_hierarchy()` + `render_menu_link()` (menus are built manually, not via `wp_nav_menu`), `arrays_have_common_element()`, `add_inner_wrap_to_li()`, plus `dump_data()` / `cut_p_tags()` / `cleanPhoneNumber()` in [functions.php](functions.php).

### Access control

Non-administrators get no admin bar and are redirected out of `/wp-admin` ([functions.php](functions.php)). Gated content compares the current user's roles against the `_members_access_role` post meta (Members plugin) via `arrays_have_common_element()` — see [page-video-lesons.php](page-video-lesons.php) and the "cabinet" submenu in [header.php](header.php), which lists every page the current user's role can access.

### REST / AJAX

Custom namespace `site-core/v1`. Currently one route, `interesting-list` (registered in [functions.php](functions.php)), which paginates the `block_interesting` list server-side and returns pre-rendered HTML. Front end calls it through the `Fetch()` + `buildApiPath()` helpers in [src/js/main.js](src/js/main.js), which hardcode the `/wp-json/site-core/v1` prefix.

### JS

jQuery-based, all globals. [src/js/main.js](src/js/main.js) holds page-wide behaviour (menu, popups, AOS init, order form, lesson scroll-spy, Presto Player hooks) **and** the shared utilities (`slideUp/slideDown/slideToggle`, `scrollToEl`, `getScrollbarWidth`, `debounce`, `throttle`, `Fetch`). Vendor libs (jQuery, Swiper, Fancybox, AOS, popup) are vendored under `src/js/libs/` and enqueued with `array('main_js')` as dependency. Scroll lock = `overflow: hidden` + `padding-right: getScrollbarWidth()px` on `document.documentElement`.

### SCSS

`main.scss` is the global entry (`@use` of `base/_variables`, `base/_reset`, `base/_fonts`, `components/forms`, `components/global-ui`, `typography`), plus UI-kit classes (`.container`, `.container--fluid`, `.btn-default`, `.section-space-top-{lg,md,sm,0}`, `.price`). Everything else is a standalone file compiled 1:1 and enqueued on demand, so **each block/page/component SCSS must `@use "base/_variables" as *` itself** (or the relative equivalent) to get variables, `%placeholders` and mixins.

[src/scss/base/_variables.scss](src/scss/base/_variables.scss) carries brand colors (`$primary: #F8DB01`, `$text: #454545`), radii, `$ease-in`/`$ease-out`, breakpoints (`$mob`…`$full-hd` and `$mq-sm`…`$mq-4xl`), `$mouse-device`/`$touch-device`, mixins `minw()` / `maxw()` / `fluid-font($min,$max,$screenMin,$screenMax)`, and `%placeholder` extends (`%primary-btn`, `%custom-list`, `%line-decoration`, `%price`, `%mask`). Typography classes (`.page-title`, `.h1`–`.h3`, `.text-content`, `.bottom-line`, `.text-{left,center,right}`) live in [src/scss/typography.scss](src/scss/typography.scss); `.text-content` styles all WYSIWYG output.

## Notes

- `.github/` and `.vscode/` are gitignored but present locally: [.github/copilot-instructions.md](.github/copilot-instructions.md) mirrors these conventions for Copilot (keep the two in sync), and `.vscode/snip.code-snippets` has snippets matching the codebase idioms (`ifcheck`, `gtp`, `debug`, `mmin`).
- Debug leftovers (`<script>console.log(<?= json_encode($data); ?>)</script>`) appear in some blocks — remove them when touching those files rather than copying the pattern.

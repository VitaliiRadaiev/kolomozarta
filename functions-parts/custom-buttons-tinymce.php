<?php

add_action('admin_init', function () {

    add_filter('mce_external_plugins', function ($plugins) {
        $src = get_stylesheet_directory_uri() . '/functions-parts/custom-buttons-tinymce.js';
        if (is_ssl()) {
            $src = preg_replace('#^http://#', 'https://', $src);
        }

        // Файл отдаётся напрямую из functions-parts/ (вне сборки), поэтому
        // без ?ver правки JS висят в кеше браузера.
        $path = get_stylesheet_directory() . '/functions-parts/custom-buttons-tinymce.js';
        if (file_exists($path)) {
            $src = add_query_arg('ver', filemtime($path), $src);
        }

        $plugins['custom_buttons'] = $src;
        return $plugins;
    });

    add_filter('mce_buttons', function ($buttons) {
        array_push(
            $buttons,
            'title_font_sizes',
            'colors',
            'text_transform',
            'space_top',
            'space_bottom',
            'clear_formatting'
        );
        return $buttons;
    }, 99);

});

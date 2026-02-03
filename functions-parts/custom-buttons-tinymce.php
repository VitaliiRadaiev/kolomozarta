<?php

add_action('admin_init', function () {

    add_filter('mce_external_plugins', function ($plugins) {
        $src = get_stylesheet_directory_uri() . '/functions-parts/custom-buttons-tinymce.js';
        if (is_ssl()) {
            $src = preg_replace('#^http://#', 'https://', $src);
        }
        $plugins['custom_buttons'] = $src;
        return $plugins;
    });

    add_filter('mce_buttons', function ($buttons) {
        array_push($buttons, 'change_to_div',);
        return $buttons;
    }, 99);

});

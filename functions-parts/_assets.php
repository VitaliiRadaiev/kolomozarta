<?php

function learning_files()
{
    // CSS styles
    wp_enqueue_style('learning_main_styles', get_theme_file_uri('./dist/css/main.css'));
    wp_enqueue_style('main_aos', get_theme_file_uri('./dist/css/libs/aos.css'));


    // Scripts
    wp_enqueue_script('jquery_js', get_theme_file_uri('./dist/js/libs/jquery-3.7.1.min.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('slick_styles', get_theme_file_uri('/dist/css/libs/slick.css'));
    wp_enqueue_script('slick_js', get_theme_file_uri('/dist/js/libs/slick.min.js'), array('jquery'), '1.0', true);
    wp_enqueue_script('aos_js', get_theme_file_uri('./dist/js/libs/aos.js'), array('jquery'), '1.0', true);
    wp_enqueue_script('main_js', get_theme_file_uri('./dist/js/main.js'), array('jquery'), '1.0', true);

    if (is_front_page()) {
        wp_enqueue_style('hero_style', get_theme_file_uri() . '/dist/css/blocks/block_hero.css');
        wp_enqueue_style('courses_style', get_theme_file_uri() . '/dist/css/blocks/block_courses.css');
    }
}

add_action('wp_enqueue_scripts', 'learning_files');
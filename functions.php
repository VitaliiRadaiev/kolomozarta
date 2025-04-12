<?php

include_once 'functions-parts/_assets.php';
include_once 'functions-parts/_post-type-registration.php';

add_action('after_setup_theme', function(){
    if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
});
add_action('admin_init', function() {
    if (is_user_logged_in() && !current_user_can('administrator') && !wp_doing_ajax()) {
        wp_redirect(home_url());
        exit;
    }
});
add_action('login_enqueue_scripts', function() {
    if (is_user_logged_in() && !current_user_can('administrator')) {
        wp_redirect(home_url());
        exit;
    }
});



function learning_features()
{
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'learning_features');

//Remove text editor
function hide_content_editor_on_specific_pages()
{
    global $post;
    if ($post->post_type === 'page') {
        remove_post_type_support($post->post_type, 'editor');
    }
}

add_action('add_meta_boxes', 'hide_content_editor_on_specific_pages');


function cut_p_tags($dirty_html)
{
    $nice_html = $dirty_html;
    $nice_html = str_replace("<p>", "", $nice_html);
    $nice_html = str_replace("</p>", "", $nice_html);
    return $nice_html;
}

//For debug
function dump_data($data, $should_die = false)
{

    echo '<pre>';
    var_dump($data);
    echo '</pre>';

    if ($should_die) {
        die();
    }
}

function cleanPhoneNumber($phone) {
    return preg_replace('/\D/', '', $phone);
 }

/*
 * REMOVE EMOJI ICONS
 * */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


//Remove trash
remove_action('wp_head', 'feed_links_extra', 3); // remove rss links
remove_action('wp_head', 'feed_links', 2); // remove rss links from comments
remove_action('wp_head', 'rsd_link');  // RSD
remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer
remove_action('wp_head', 'wp_generator');  // hide WordPress version
remove_action('wp_head', 'start_post_rel_link', 10);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
remove_action('wp_head', 'wp_shortlink_wp_head', 10);
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('template_redirect', 'rest_output_link_header', 11);


//Remove menus items
function remove_menus()
{
    //    remove_menu_page('index.php');                  //Консоль
    //    remove_menu_page('edit.php');                   //Записи
    //    remove_menu_page('upload.php');                 //Медиафайлы
    //    remove_menu_page('edit.php?post_type=page');    //Страницы
    remove_menu_page('edit-comments.php');          //Комментарии
    //    remove_menu_page('themes.php');                 //Внешний вид
    //    remove_menu_page('plugins.php');                //Плагины
    //    remove_menu_page('users.php');                  //Пользователи
    //    remove_menu_page('tools.php');                  //Инструменты
    //    remove_menu_page('options-general.php');        //Настройки

    //    remove_menu_page('admin.php?page=pmxi-admin-import');
    //    remove_menu_page('edit.php?post_type=acf-field-group');
    //        remove_menu_page( 'admin.php?page=Wordfence' );
    //        remove_menu_page( 'admin.php?page=pmxi-admin-import' );
    //        remove_menu_page( 'admin.php?page=wpseo_dashboard' );
}

add_action('admin_menu', 'remove_menus');


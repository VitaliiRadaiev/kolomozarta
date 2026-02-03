<?php

include_once 'functions-parts/_assets.php';
include_once 'functions-parts/_post-type-registration.php';
include_once 'functions-parts/_custom-functions.php';
// include_once 'functions-parts/custom-buttons-tinymce.php';

add_action('after_setup_theme', function () {
    if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
});
add_action('admin_init', function () {
    if (is_user_logged_in() && !current_user_can('administrator') && !wp_doing_ajax()) {
        wp_redirect(home_url());
        exit;
    }
});
add_action('login_enqueue_scripts', function () {
    if (is_user_logged_in() && !current_user_can('administrator')) {
        wp_redirect(home_url());
        exit;
    }
});



function learning_features()
{
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerMenuLocation', 'Footer Menu Location');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'learning_features');

//Remove text editor
function hide_content_editor_on_specific_pages()
{
    global $post;

    if (!is_a($post, 'WP_Post')) {
        return;
    }

    $template = get_page_template_slug($post->ID);

    if ($post->post_type === 'page' && $template !== 'page-text-content.php') {
        remove_post_type_support('page', 'editor');
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

function cleanPhoneNumber($phone)
{
    return preg_replace('/\D/', '', $phone);
}

/*
 * REMOVE EMOJI ICONS
 * */
//remove_action('wp_head', 'print_emoji_detection_script', 7);
//remove_action('wp_print_styles', 'print_emoji_styles');


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

function ajax_get_interesting_list($request)
{
    $page = (int) $request->get_param('page');
    $page_id = $request->get_param('page-id');
    $sections = get_field('sections', $page_id);
    $text_more_details = get_field('text_more_details', 'option');
    $chunk_size = 6;

    $block_interesting = array_filter($sections, function ($section) {
        return ($section['acf_fc_layout'] === 'block_interesting');
    });

    $list_elements = '';
    $has_more = false;

    if (!empty($block_interesting)) {
        $block = reset($block_interesting);
        $interesting_list = $block['interesting_list'];

        if (!empty($interesting_list)) {
            $offset = ($page - 1) * $chunk_size;
            $paged_items = array_slice($interesting_list, $offset, $chunk_size);

            $total_items = count($interesting_list);
            $has_more = ($offset + $chunk_size) < $total_items;

            ob_start();
?>
            <?php foreach ($paged_items as $item): ?>
                <li class="interesting__list-item">
                    <?php
                    $interesting_id = $item->ID;
                    $interesting_img_id = get_post_thumbnail_id($interesting_id);
                    $interesting_img = wp_get_attachment_image_url($interesting_img_id, 'medium');
                    $interesting_title = $item->post_title;
                    $interesting_permalink = get_field('interesting_link', $interesting_id);
                    $interesting_content = $item->post_content;

                    if ($interesting_img): ?>
                        <img src="<?= esc_url($interesting_img); ?>" alt="<?= esc_attr($interesting_title); ?>">
                    <?php endif;

                    if ($interesting_title): ?>
                        <h3><?= esc_html($interesting_title); ?></h3>
                    <?php endif;

                    if ($interesting_permalink): ?>
                        <a class="btn" href="<?= $interesting_permalink['url'] ?>" target="<?= $interesting_permalink['target'] ?>"><?= check($interesting_permalink['title']) ? $interesting_permalink['title'] : $text_more_details ?></a>
                    <?php endif;

                    if ($interesting_content): ?>
                        <p class="courses__list-description"><?= esc_html($interesting_content); ?></p>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
<?php
            $list_elements = ob_get_clean();
        }
    }

    return rest_ensure_response([
        'posts' => $list_elements,
        'has_more' => $has_more,
    ]);
}

add_action('rest_api_init', function () {
    register_rest_route('site-core/v1', 'interesting-list', array(
        'methods'  => 'GET',
        'callback' => 'ajax_get_interesting_list',
        'permission_callback' => '__return_true',
        'args'     => array(
            'page-id' => array(
                'required' => false,
                'default'  => 1,
                'validate_callback' => function ($param) {
                    return is_numeric($param) && intval($param) > 0;
                }
            ),
            'page' => array(
                'required' => false,
                'default'  => 1,
                'validate_callback' => function ($param) {
                    return is_numeric($param) && intval($param) > 1;
                }
            ),
        )
    ));
});
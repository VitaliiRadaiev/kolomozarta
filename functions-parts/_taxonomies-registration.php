<?php
add_action('init', 'init_taxonomies');
function init_taxonomies()
{
    register_taxonomy('product_category', array('product'), array(
        'label' => 'Категорії продуктів',
        'labels' => array(
            'name'                       => 'Категорії продуктів',
            'singular_name'              => 'Категорія продукту',
            'add_new_item'               => 'Додати нову Категорію',
            'edit_item'                  => 'Редагувати Категорію',
            'new_item_name'              => 'Назва нової Категорії',
            'search_items'               => 'Пошук Категорій',
            'not_found'                  => 'Категорій не знайдено',
            'menu_name'                  => 'Категорії',
            'back_to_items'              => '← Повернутися до Категорій',
        ),
        'description'        => 'Категорія для Продукту',
        'public'             => true,
        'publicly_queryable' => true,
        'hierarchical'       => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'show_in_rest'       => true,
        'rest_base'          => 'product-category',
        'show_admin_column'  => true,
        'show_in_quick_edit' => true,
        'show_tagcloud'      => false,
        'meta_box_cb'        => 'post_categories_meta_box',
        'rewrite'            => array(
            'slug'       => 'product-category',
            'with_front' => true,
            'pages'      => true,
        ),
        'query_var' => true,
    ));
}

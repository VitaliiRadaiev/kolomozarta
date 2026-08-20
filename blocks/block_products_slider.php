<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (is_admin() && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('swiper_bundle_style', get_theme_file_uri() . '/dist/css/libs/swiper-bundle.css');
    wp_enqueue_script('swiper_bundle_js', get_theme_file_uri('./dist/js/libs/swiper-bundle.js'), array('main_js'), null, true);

    wp_enqueue_style('products_slider_style', get_theme_file_uri('./dist/css/blocks/block_products_slider.css'));
    wp_enqueue_script('products_slider_js', get_theme_file_uri('./dist/js/blocks/block_products_slider.js'), array('main_js'), null, true);

    $display_mode = $data['display_mode'] ?? 'default';

    $query_args = [
        'post_type'        => 'product',
        'post_status'      => 'publish',
        'posts_per_page'   => 16,
        'orderby'          => [
            'menu_order' => 'ASC',
            'date'       => 'DESC',
        ],
        'suppress_filters' => false,
    ];

    if ($display_mode === 'by_category' && check($data['tax'] ?? null)) {
        $query_args['tax_query'] = [[
            'taxonomy' => 'product_category',
            'field'    => 'term_id',
            'terms'    => $data['tax'],
        ]];
        $the_posts = get_posts($query_args);
    } elseif ($display_mode === 'custom' && check($data['custom_list'] ?? null)) {
        $the_posts = $data['custom_list'];
    } else {
        $the_posts = get_posts($query_args);
    }
?>

    <section <?= get_section_id($data) ?> class="products-slider <?= get_section_space_top($data) ?>">
        <div class="container">
            <?php get_template_part(get_part_path('title'), null, [
                'title_data' => $data['title']
            ]) ?>

            <div data-slider="products-slider" class="products-slider__slider">
                <div class="swiper swiper-has-buttons">
                    <div class="swiper-wrapper">
                        <?php if (check($the_posts ?? null)): ?>
                            <?php foreach ($the_posts as $item):
                                if (!is_object($item) || $item->post_status !== 'publish') {
                                    continue;
                                }
                            ?>
                                <div class="swiper-slide">
                                    <?php get_template_part(get_part_path('product-card'), null, ['post_id' => $item->ID]); ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="slider-pagination-wrapper">
                        <div class="swiper-pagination"></div>
                    </div>

                    <button type="button" class="swiper-button prev">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </button>
                    <button type="button" class="swiper-button next">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
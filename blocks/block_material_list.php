<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (is_admin() && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_script('material_list_js', get_theme_file_uri('./dist/js/blocks/block_material_list.js'), array('main_js'), null, true);
    wp_enqueue_style('material_list_style', get_theme_file_uri() . '/dist/css/blocks/block_material_list.css');

    $material_title   = $data['material_title'];
    $btn_details      = get_field('btn_details', 'option');
    $text_all         = get_field('text_all', 'option');
    $text_categories  = get_field('text_categories', 'option');

    $products_query = new WP_Query([
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ]);

    $product_categories = get_terms([
        'taxonomy'   => 'product_category',
        'hide_empty' => true,
    ]);

?>
<section <?= get_section_id($data) ?> class="material <?= get_section_space_top($data) ?>">
    <div class="container">
        <div class="material__wrap">
            <div data-aos="fade-up" class="material__title">
                <h2><?= $material_title ?></h2>
            </div>

            <?php if (!is_wp_error($product_categories) && !empty($product_categories)): ?>
                <div data-aos="fade-up" class="material__tabs">
                    <?php if (!empty($text_categories)): ?>
                        <span class="material__tabs-label"><?= esc_html($text_categories) ?>:</span>
                    <?php endif; ?>
                    <button class="material__tabs-btn is-active" type="button" data-filter="all"><?= esc_html($text_all) ?></button>
                    <?php foreach ($product_categories as $term): ?>
                        <button class="material__tabs-btn" type="button" data-filter="<?= esc_attr($term->slug) ?>"><?= esc_html($term->name) ?></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($products_query->have_posts()): ?>
                <ul data-aos="fade-up" class="material__list">
                    <?php while ($products_query->have_posts()): $products_query->the_post();
                        $post_id           = get_the_ID();
                        $title             = get_the_title();
                        $short_description = get_field('short_description', $post_id);
                        $price             = get_field('price', $post_id);
                        $gallery           = get_field('gallery', $post_id);
                        $link_url          = get_field('link', $post_id);
                        if (empty($link_url)) {
                            $link_url = get_permalink($post_id);
                        }
                        $post_terms     = wp_get_post_terms($post_id, 'product_category');
                        $term_slugs     = (!is_wp_error($post_terms) && !empty($post_terms))
                            ? wp_list_pluck($post_terms, 'slug')
                            : [];
                        $data_categories = esc_attr(wp_json_encode($term_slugs));
                    ?>
                        <li class="material__list-item" data-categories="<?= $data_categories ?>">
                            <?php get_template_part(get_part_path('product-card'), null, [
                                'post_id' => $post_id,
                            ]) ?>
                        </li>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>
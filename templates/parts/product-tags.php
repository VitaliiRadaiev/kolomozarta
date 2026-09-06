<?php
$post_id    = $args['post_id'] ?? null;
$classes    = $args['classes'] ?? '';
$attributes = $args['attributes'] ?? '';

if (!check($post_id)) {
    return;
}

$terms = get_the_terms($post_id, 'product_tag');

if (empty($terms) || is_wp_error($terms)) {
    return;
}

wp_enqueue_style('product-tags_style', get_theme_file_uri('./dist/css/templates/parts/product-tags.css'));
?>

<ul class="product-tags <?= $classes ?>" <?= $attributes ?>>
    <?php foreach ($terms as $term):
        $icon_id = get_field('icon', $term);
    ?>
        <li class="product-tags__item">
            <?php if (check($icon_id ?? null)):
                get_image($icon_id, 'product-tags__icon', true, 'full', [
                    'alt'     => '',
                    'sizes'   => '20px',
                    'loading' => 'lazy',
                ]);
            endif; ?>
            <span class="product-tags__name"><?= esc_html($term->name) ?></span>
        </li>
    <?php endforeach; ?>
</ul>

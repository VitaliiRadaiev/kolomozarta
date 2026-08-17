<?php
$product_price_data = $args['product_price_data'] ?? [];
$classes = $args['classes'] ?? '';
$attributes = $args['attributes'] ?? '';

$product_price_data = wp_parse_args($product_price_data, [
    'product_for_price' => null,
    'is_bottom_line' => false,
]);

$product_id = $product_price_data['product_for_price'];
$is_bottom_line = $product_price_data['is_bottom_line'];

if (!check($product_id ?? null)) {
    return;
}

wp_enqueue_style('product-price_style', get_theme_file_uri('./dist/css/templates/parts/product-price.css'));

$old_price = get_field('old_price', $product_id);
$price = get_field('price', $product_id);
?>

<div class="price <?= $is_bottom_line ? 'bottom-line' : '' ?> <?= $classes ?>" <?= $attributes ?>>
    <?php if (check($old_price ?? null)): ?>
        <div class="price__old">
            <?= $old_price ?>
        </div>
    <?php endif; ?>
    <?php if (check($price ?? null)): ?>
        <div class="price__main">
            <?= $price ?>
        </div>
    <?php endif; ?>
</div>

<?php
$post_id = $args['post_id'] ?? null;
$classes = $args['classes'] ?? '';
$attributes = $args['attributes'] ?? '';

if (!check($post_id)) {
    return;
}
wp_enqueue_style('swiper_bundle_style', get_theme_file_uri() . '/dist/css/libs/swiper-bundle.css');
wp_enqueue_script('swiper_bundle_js', get_theme_file_uri('./dist/js/libs/swiper-bundle.js'), array('main_js'), null, false);

wp_enqueue_style('product-card_style', get_theme_file_uri('./dist/css/templates/parts/product-card.css'));
wp_enqueue_script('product-card_js', get_theme_file_uri('./dist/js/templates/parts/product-card.js'), array('main_js'), null, true);

$btn_details      = get_field('btn_details', 'option');

$title             = get_the_title();
$short_description = get_field('short_description', $post_id);
$price             = get_field('price', $post_id);
$gallery           = get_field('gallery', $post_id);
$link_url          = get_field('link', $post_id);
if (empty($link_url)) {
    $link_url = get_permalink($post_id);
}

?>

<a class="product-card <?= $classes ?>" href="<?= esc_url($link_url) ?>" <?= $attributes ?>>
    <?php if (!empty($gallery)): ?>
        <div class="product-card__slider">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($gallery as $img_id): ?>
                        <div class="swiper-slide">
                            <?= wp_get_attachment_image($img_id, 'large') ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <button class="product-card__slider-prev" type="button" aria-label="Попередній слайд"></button>
            <button class="product-card__slider-next" type="button" aria-label="Наступний слайд"></button>
        </div>
    <?php endif; ?>
    <h3 class="product-card__title"><?= esc_html($title) ?></h3>
    <?php if (!empty($short_description)): ?>
        <p class="product-card__desc"><?= esc_html($short_description) ?></p>
    <?php endif; ?>
    <div class="product-card__footer">
        <?php if (!empty($price)): ?>
            <span class="product-card__price"><?= esc_html($price) ?></span>
        <?php endif; ?>
        <span class="product-card__btn btn-default"><?= esc_html($btn_details) ?></span>
    </div>
</a>
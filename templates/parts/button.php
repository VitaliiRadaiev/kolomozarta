<?php
$button_data = $args['button_data'] ?? [];
$classes = $args['classes'] ?? '';
$attributes = $args['attributes'] ?? '';

$button_data = wp_parse_args($button_data, [
    'button_style' => 'fill_theme', // fill_theme, stroke_theme, stroke_dark
    'button_text' => '',
    'button_type' => 'link', // link, form
    'form_type' => 'contact', // order, contact
    'link' => '',
    'order_product' => null
]);

$button_style_map = [
    'fill_theme' => 'btn-default',
    'stroke_theme' => 'stroke_theme',
    'stroke_dark' => 'stroke_dark'
];
?>

<?php if ($button_data['button_type'] === 'link' && check($button_data['link'])): ?>
    <a href="btn-default <?= $button_data['link']['url'] ?>"
        target="<?= check($button_data['link']['target']) ? $button_data['link']['target'] : '_self' ?>"
        class="<?= $button_style_map[$button_data['button_style']] ?> <?= $classes ?>"
        aria-label="<?= esc_attr($button_data['link']['title']) ?>"
        <?= $attributes ?>>
        <?= $button_data['link']['title'] ?>
    </a>
<?php elseif ($button_data['button_type'] === 'form' && check($button_data['button_text'])): ?>
    <?php 
        $button_default_attributes = 'data-action="open-popup" data-popup="#popup-contact-us"';
        $is_order = false;
        if( ($button_data['form_type'] === 'order') && check($button_data['order_product'] ?? null)) {
            $is_order = true;
            $title          = get_the_title($button_data['order_product']);
            $price          = get_field('price', $button_data['order_product']);
            $price_subtitle = get_field('price_subtitle', $button_data['order_product']);

            $button_default_attributes = 'data-price="' . $price . '"
                                          data-title="' . $title . '"
                                          data-subtitle="' . $price_subtitle .'"';
        }
    ?>
    <button class="btn-default <?= check(!$is_order) ?'': 'openOrderPopup' ?> <?= $button_style_map[$button_data['button_style']] ?> <?= $classes ?>" <?= $button_default_attributes ?> <?= $attributes ?>>
        <?= $button_data['button_text'] ?>
    </button>

<?php endif; ?>
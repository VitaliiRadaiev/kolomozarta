<?php
$classes       = $args['classes'] ?? '';
$attributes    = $args['attributes'] ?? '';
$faq_item_data = $args['faq_item_data'] ?? [];

$faq_item_data = wp_parse_args($faq_item_data, [
    'title'   => null,
    'text'    => null,
    'is_open' => false,
]);

$title   = $faq_item_data['title'];
$text    = $faq_item_data['text'];
$is_open = $faq_item_data['is_open'] === true;

if (!check($title) && !check($text)) {
    return;
}

wp_enqueue_style('faq-item_style', get_theme_file_uri('./dist/css/templates/parts/faq-item.css'));

$panel_id = uniqid('faq-item-panel-');
?>

<div class="faq-item<?= $is_open ? ' active' : '' ?> <?= $classes ?>" data-accordion-item <?= $attributes ?>>
    <h3 class="faq-item__heading">
        <button type="button" class="faq-item__trigger<?= $is_open ? ' active' : '' ?>" data-accordion-trigger aria-expanded="<?= $is_open ? 'true' : 'false' ?>" aria-controls="<?= esc_attr($panel_id) ?>">
            <?php if (check($title)): ?>
                <span class="faq-item__title h4"><?= esc_html($title) ?></span>
            <?php endif; ?>
            <span class="faq-item__icon" aria-hidden="true"></span>
        </button>
    </h3>
    <?php if (check($text)): ?>
        <div id="<?= esc_attr($panel_id) ?>" class="faq-item__panel"<?= $is_open ? '' : ' hidden' ?>>
            <div class="faq-item__text text-content"><?= $text ?></div>
        </div>
    <?php endif; ?>
</div>

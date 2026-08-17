<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (is_admin() && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('block_button_price_title_style', get_theme_file_uri('./dist/css/blocks/block_button_price_title.css'));

    $alignment   = check($data['alignment'] ?? null) ? $data['alignment'] : 'left';
    $align_class = 'text-' . $alignment;

    // text_align не входить у клон title цього блоку — беремо з блокового alignment
    $title_data = wp_parse_args(['text_align' => $alignment], $data['title'] ?? []);
?>
    <section <?= get_section_id($data) ?> class="block-button-price-title <?= get_section_space_top($data) ?>">
        <div class="container">
            <div class="block-button-price-title__inner <?= $align_class ?>">
                <?php get_template_part(get_part_path('title'), null, [
                    'title_data' => $title_data
                ]) ?>

                <?php get_template_part(get_part_path('product-price'), null, [
                    'product_price_data' => $data['product-price'] ?? [],
                    'classes'            => $align_class
                ]) ?>

                <?php if (check($data['button']['link'] ?? null) || check($data['button']['button_text'] ?? null)): ?>
                    <div class="block-button-price-title__button">
                        <?php get_template_part(get_part_path('button'), null, [
                            'button_data' => $data['button']
                        ]) ?>
                    </div>
                <?php endif; ?>

                <?php if (check($data['text'] ?? null)): ?>
                    <div class="text-content <?= $align_class ?>">
                        <?= $data['text'] ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

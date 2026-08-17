<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (is_admin() && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('block_cta_style', get_theme_file_uri('./dist/css/blocks/block_cta.css'));

?>
    <section <?= get_section_id($data) ?> class="block-cta <?= get_section_space_top($data) ?>">
        <div class="container">
            <div style="background-color: <?= $data['bg_color'] ?>;" class="block-cta__inner">
                <div class="block-cta__left">
                    <?php get_template_part(get_part_path('title'), null, [
                        'title_data' => $data['title']
                    ]) ?>

                    <?php if (check($data['text'] ?? null)): ?>
                        <div class="text-content">
                            <?= $data['text'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (
                    (check($data['is_show_product_price'] ?? null) && check($data['product_for_price'] ?? null))
                    || check($data['button']['link'] ?? null) || check($data['button']['button_text'] ?? null)
                ): ?>
                    <div class="block-cta__right">
                        <?php get_template_part(get_part_path('product-price'), null, [
                            'product_price_data' => $data['product-price']
                        ]) ?>


                        <?php get_template_part(get_part_path('button'), null, [
                            'button_data' => $data['button']
                        ]) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
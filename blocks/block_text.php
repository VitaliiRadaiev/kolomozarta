<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (is_admin() && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('about_style', get_theme_file_uri() . '/dist/css/blocks/block_text.css');

    $space_top = $data['block_text_space_top'];
    $space_bottom = $data['block_text_space_bottom'];
    $text_align = $data['block_text_align'];
    $title = $data['block_text_title'];
    $text = $data['block_text_text'];
?>
    <section <?= get_section_id($data) ?> class="block-text space-top-<?= $space_top ?> space-bottom-<?= $space_bottom ?> text-<?= $text_align ?> <?= get_section_space_top($data) ?>">>
    <div data-aos="fade-up" class="container">
            <?php if ($title): ?>
                <div class="block-text__title">
                    <?= $title ?>
                </div>
            <?php endif; ?>

            <?php if ($text): ?>
                <div class="block-text__text text-content">
                    <?= add_inner_wrap_to_li($text); ?>
                </div>
            <?php endif; ?>

    </div>
</section>
<?php endif; ?>
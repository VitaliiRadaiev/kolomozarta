<?php
wp_enqueue_style('about_style', get_theme_file_uri() . '/dist/css/blocks/block_text.css');

global $data;
$space_top = $data['block_text_space_top'];
$space_bottom = $data['block_text_space_bottom'];
$text_align = $data['block_text_align'];
$title = $data['block_text_title'];
$text = $data['block_text_text'];
?>

<section class="block-text space-top-<?= $space_top ?> space-bottom-<?= $space_bottom ?> text-<?= $text_align ?>">
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
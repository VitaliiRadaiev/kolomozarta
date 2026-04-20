<?php
wp_enqueue_style('content_style', get_theme_file_uri() . '/dist/css/blocks/block_content.css');
global $data;
$songs_info = $data['songs_info'];
?>

<section class="content">
    <div data-aos="fade-up" class="container">
        <div class="content__wrap text-content">
            <?php if ($songs_info): ?>
                <?= add_inner_wrap_to_li($songs_info) ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
wp_enqueue_style('content_style', get_theme_file_uri() . '/dist/css/blocks/block_content.css');
global $data;
$songs_info = $data['songs_info'];
$songs_additional_info = $data['songs_additional_info'];
?>


<section class="content">
    <div class="container">
        <div class="content__wrap">
            <?php if ($songs_info): ?>
                <?= $songs_info ?>
            <?php endif; ?>
            <?php if ($songs_additional_info): ?>
                <div class="content__wrap-additional">
                    <?= $songs_additional_info ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

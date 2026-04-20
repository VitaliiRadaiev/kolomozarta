<?php
wp_enqueue_style('page_videos_styles', get_theme_file_uri('dist/css/pages/page-404.css'));

get_header();

$text_page_not_found = get_field('text_page_not_found', 'option');
$to_home_btn = get_field('to_home_btn', 'option');
?>

<section class="block-404">
    <div class="container block-404__inner">
        <div class="block-404__title">404</div>
        <div class="block-404__subtitle"><?= $text_page_not_found ?></div>
        <a href="<?= get_home_url(); ?>" class="block-404__btn btn-default"><?= $to_home_btn ?></a>
    </div>
</section>

<?php

get_footer();
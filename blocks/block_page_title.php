<?php
wp_enqueue_style('page_title_style', get_theme_file_uri() . '/dist/css/blocks/block_page_title.css');

global $data;

$page_title = $data['page_title'];


?>

<section class="page__hero">
    <div class="container">
        <div class="page__wrap">
            <h1 data-aos="fade-up" class="page__title">
                <?= $page_title ?>
            </h1>
            <div data-aos="fade-in" data-aos-delay="600" data-aos-duration="1000" class="page__breadcrumbs">
                <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
            </div>
        </div>
    </div>
</section>
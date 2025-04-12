<?php

wp_enqueue_style('about_style', get_theme_file_uri() . '/dist/css/blocks/block_about.css');
global $data;

$about_img = $data['about_img'];
$about_img_url = $about_img['url'];
$about_subtitle = $data['about_subtitle'];
$about_title = $data['about_title'];
$about_description = $data['about_description'];

?>

<section class="about">
    <div class="container">
        <div class="about__wrap">
            <?php if ($about_img): ?>
                <div class="about__image">
                    <img src="<?= $about_img_url ?>" alt="<?= $about_title ?>">
                </div>
            <?php endif; ?>
            <div class="about__text">
                <?php if ($about_subtitle): ?>
                <span><?= $about_subtitle ?></span>
                <?php endif;

                if ($about_title): ?>
                    <h2><?= $about_title ?></h2>
                <?php endif;

                if ($about_description):?>
                    <p><?= cut_p_tags($about_description) ?></p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>

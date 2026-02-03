<?php

wp_enqueue_style('courses_style', get_theme_file_uri() . '/dist/css/blocks/block_education.css');
global $data;

$btn_details = get_field('btn_details', 'option');
$education_title = $data['education_title'];
$education_subtitle = $data['education_subtitle'];
$education_info = $data['education_info'];
$education_works = $data['education_works'];
?>

<section class="education">
    <div class="container">
        <div class="education__wrap">
            <?php if ($education_title): ?>
                <div data-aos="fade-up" class="education__title">
                    <h2><?= $education_title ?></h2>
                </div>
            <?php endif;

            if (!empty($education_info)):?>
                <ul data-aos="fade-up" class="education__list">
                    <?php foreach ($education_info as $education_item):
                        if ($education_item['education_info_item']):?>
                            <li><?= $education_item['education_info_item'] ?></li>
                        <?php endif;
                    endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php if($education_subtitle):?>
                <div data-aos="fade-up" class="education__subtitle">
                    <h2 class="text-center"><?= $education_subtitle ?></h2>
                </div>
            <?php endif;?>
            <?php if (!empty($education_works)): ?>
                <ul data-aos="fade-up" class="education__works">
                    <?php foreach ($education_works as $work):
                        $icon = $work['icon'];
                        $name = $work['name'];
                        $invent = $work['invent'];
                        $diploma = $work['diploma']; ?>
                        <li>
                            <?php if ($icon): ?>
                                <img src="<?= $icon['url'] ?>" alt="<?= $invent ?>">
                            <?php endif; ?>
                            <div class="education__works-info">
                                <?php if ($name): ?>
                                    <h3><?= $name ?></h3>
                                <?php endif;
                                if ($invent):?>
                                    <p><?= $invent ?></p>
                                <?php endif; ?>
                            </div>
                            <a class="btn" href="<?= $diploma ?>" target="_blank">
                                <?= $btn_details ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>

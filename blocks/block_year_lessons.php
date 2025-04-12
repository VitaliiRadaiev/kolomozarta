<?php
wp_enqueue_style('year_lessons_style', get_theme_file_uri() . '/dist/css/blocks/block_year_lessons.css');
global $data;

$year_lessons_title = $data['year_lessons_title'];
$year_lessons_item = $data['year_lessons_item'];
$year_lessons_additional = $data['year_lessons_additional'];
?>

<section class="year-lessons">
    <div class="container">
        <div class="year-lessons__wrap">
            <div class="year-lessons__list">
                <?php if ($year_lessons_title): ?>
                    <h2><?= $year_lessons_title ?></h2>
                <?php endif; ?>
                <?php if (!empty($year_lessons_item)): ?>
                    <div class="year-lessons__list-wrap">
                        <?php foreach ($year_lessons_item as $item): ?>
                            <div class="year-lessons__item">
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/<?= $item['video'] ?>"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                                <?= $item['description'] ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="year-lessons__additional">
                <div class="year-lessons__additional-text">
                    <?= $year_lessons_additional['info'] ?>
                </div>
                <?php if ($year_lessons_additional['youtube_id']): ?>
                    <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/<?= $year_lessons_additional['youtube_id'] ?>"
                        frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
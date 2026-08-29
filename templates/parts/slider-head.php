<?php
$title_data = $args['title_data'] ?? [];
$has_title = check($title_data['text'] ?? null);
?>
<div class="slider-head <?= $has_title ? '' : 'slider-head--no-title' ?>">
    <?php get_template_part(get_part_path('title'), null, [
        'title_data' => $title_data,
        'classes' => 'slider-head__title'
    ]) ?>

    <?php get_template_part(get_part_path('slider-nav')) ?>
</div>

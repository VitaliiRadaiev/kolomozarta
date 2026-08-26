<?php
$title_data = $args['title_data'] ?? [];
$has_title = check($title_data['text'] ?? null);
?>
<div class="slider-head <?= $has_title ? '' : 'slider-head--no-title' ?>">
    <?php get_template_part(get_part_path('title'), null, [
        'title_data' => $title_data,
        'classes' => 'slider-head__title'
    ]) ?>

    <div class="slider-head__nav">
        <button type="button" class="swiper-button prev">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
        </button>
        <button type="button" class="swiper-button next">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </button>
    </div>
</div>

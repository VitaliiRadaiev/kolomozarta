<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (!current_user_can('administrator') && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('swiper_bundle_style', get_theme_file_uri() . '/dist/css/libs/swiper-bundle.css');
    wp_enqueue_script('swiper_bundle_js', get_theme_file_uri('./dist/js/libs/swiper-bundle.js'), array('main_js'), null, true);

    wp_enqueue_style('fancybox_style', get_theme_file_uri() . '/dist/css/libs/fancybox.css');
    wp_enqueue_script('fancybox_js', get_theme_file_uri('./dist/js/libs/fancybox.js'), array('main_js'), null, true);

    wp_enqueue_style('gallery_slider_style', get_theme_file_uri() . '/dist/css/blocks/block_gallery_slider.css');
    wp_enqueue_script('gallery_slider_js', get_theme_file_uri('./dist/js/blocks/block_gallery_slider.js'), array('main_js'), null, true);

    if (check($data['gallery'] ?? null)):

        $section_bg = $data['section_bg'] ?? [];
        $is_show_colour_bg = $section_bg['is_show_colour_bg'] ?? false;
        $counts = wp_parse_args($data['slides_count'] ?? [], [
            'mob' => 1,
            'tablet' => 2,
            'desktop' => 3,
        ]);

        $unique_id = uniqid('gallery-');
?>
        <section <?= $is_show_colour_bg ? 'style="background-color:' . $section_bg['bg-color'] . ';"' : '' ?> <?= get_section_id($data) ?> class="gallery-slider <?= $is_show_colour_bg ? get_section_padding($section_bg) : '' ?> <?= get_section_space_top($data) ?>">
            <div class="container">
                <div data-slider="gallery"
                    data-slides-mob="<?= (int) $counts['mob'] ?>"
                    data-slides-tablet="<?= (int) $counts['tablet'] ?>"
                    data-slides-desktop="<?= (int) $counts['desktop'] ?>"
                    class="gallery-slider__slider">

                    <?php get_template_part(get_part_path('slider-head'), null, [
                        'title_data' => $data['title'] ?? []
                    ]) ?>

                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($data['gallery'] as $item):
                                if (!check($item['image_id'] ?? null)) {
                                    continue;
                                } ?>
                                <div class="swiper-slide">
                                    <a href="<?= wp_get_attachment_url($item['image_id']) ?>" data-fancybox="<?= $unique_id ?>" class="gallery-slider__item">
                                        <?php get_image($item['image_id'], 'gallery-slider__image aspect-' . (check($item['ratio'] ?? null) ? $item['ratio'] : 'square')); ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="slider-pagination-wrapper">
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>

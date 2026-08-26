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

    wp_enqueue_style('certificates_slider_style', get_theme_file_uri() . '/dist/css/blocks/block_certificates_slider.css');
    wp_enqueue_script('certificates_slider_js', get_theme_file_uri('./dist/js/blocks/block_certificates_slider.js'), array('main_js'), null, true);

    if (check($data['certificates'] ?? null)):

        $unique_id = uniqid('certificates-');
?>
        <section <?= get_section_id($data) ?> class="certificates-slider <?= get_section_space_top($data) ?>">
            <div class="container">
                <div data-slider="certificates" class="certificates-slider__slider">
                    <?php get_template_part(get_part_path('slider-head'), null, [
                        'title_data' => [
                            'html_tag' => 'h2',
                            'size' => 'h2',
                            'text_align' => 'center',
                            'is_bottom_line' => false,
                            'text' => $data['title'] ?? '',
                        ]
                    ]) ?>

                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($data['certificates'] as $certificate): ?>
                                <div class="swiper-slide">
                                    <a href="<?= wp_get_attachment_url($certificate, 'full') ?>" data-fancybox="<?= $unique_id ?>" class="certificates-slider__slider-item">
                                        <?php get_image($certificate, 'certificates-slider__image'); ?>

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                        </svg>

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

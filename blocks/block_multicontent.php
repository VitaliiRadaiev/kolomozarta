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

    wp_enqueue_style('block_multicontent_style', get_theme_file_uri('./dist/css/blocks/block_multicontent.css'));
    wp_enqueue_script('block_multicontent_js', get_theme_file_uri('./dist/js/blocks/block_multicontent.js'), array('main_js'), null, true);

    $section_bg = $data['section_bg'] ?? [];
    $is_show_colour_bg = $section_bg['is_show_colour_bg'] ?? false;
    $columns = !empty($data['columns']) ? $data['columns'] : [];
?>
    <section <?= $is_show_colour_bg ? 'style="background-color:' . $section_bg['bg-color'] . ';"' : '' ?> <?= get_section_id($data) ?> class="multicontent <?= $is_show_colour_bg ? get_section_padding($section_bg) : '' ?> <?= get_section_space_top($data) ?>">
        <div class="container multicontent__container">
            <?php get_template_part(get_part_path('title'), null, [
                'title_data' => $data['title']
            ]) ?>

            <div class="multicontent__grid">
                <?php
                foreach ($columns as $column):
                    $alignment = $column['alignment'];
                    $col_sizes = $column['col_sizes'];
                    $content = check($column['content'] ?? null) ? $column['content'] : [];
                ?>
                    <div style="--col-size-mob: <?= $col_sizes['mob_size'] ?>; --col-size-tablet: <?= $col_sizes['tablet_size'] ?>; --col-size-desk: <?= $col_sizes['desk_size'] ?>;" class="multicontent__col alignment-<?= $alignment ?>">
                        <?php foreach ($content as $item): ?>


                            <?php if ($item['acf_fc_layout'] == 'title'): ?>
                                <div <?= get_space_top($item['space-top']); ?> class="multicontent-space-top">
                                    <?php get_template_part(get_part_path('title'), null, [
                                        'title_data' => $item['title']
                                    ]) ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($item['acf_fc_layout'] == 'text'): ?>
                                <div <?= get_space_top($item['space-top']); ?> class="text-content multicontent-space-top">
                                    <?= add_inner_wrap_to_li($item['text']); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($item['acf_fc_layout'] == 'price'): ?>
                                <div <?= get_space_top($item['space-top']); ?> class="multicontent-space-top">
                                    <?php get_template_part(get_part_path('product-price'), null, [
                                        'product_price_data' => $item['product-price'] ?? [],
                                    ]) ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($item['acf_fc_layout'] == 'buttons-group'): ?>
                                <div <?= get_space_top($item['space-top']); ?> class="multicontent-space-top">
                                    <?php get_template_part(get_part_path('buttons-group'), null, [
                                        'buttons' => $item['buttons-group']
                                    ]) ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($item['acf_fc_layout'] == 'image'): ?>
                                <a href="<?= wp_get_attachment_url($item['image_id'], 'full') ?>" <?= get_space_top($item['space-top']); ?> data-fancybox="" class="multicontent-space-top w-full">
                                    <?php get_image($item['image_id'], 'multicontent-img aspect-' . $item['ratio']); ?>
                                </a>
                            <?php endif; ?>

                            <?php if ($item['acf_fc_layout'] == 'images-slider' && check($item['images_ids'] ?? null)):
                                $slider_id = uniqid('multicontent-slider-');
                                $ratio = check($item['ratio'] ?? null) ? $item['ratio'] : 'square';
                            ?>
                                <div <?= get_space_top($item['space-top']); ?> data-slider="multicontent" class="multicontent__slider multicontent-space-top w-full">
                                    <div class="swiper">
                                        <div class="swiper-wrapper">
                                            <?php foreach ($item['images_ids'] as $img_id): ?>
                                                <div class="swiper-slide">
                                                    <a href="<?= wp_get_attachment_url($img_id) ?>" data-fancybox="<?= $slider_id ?>" class="multicontent__slider-item">
                                                        <?php get_image($img_id, 'multicontent__slider-image aspect-' . $ratio, true, 'large'); ?>
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <button class="multicontent__slider-prev" type="button" aria-label="Попередній слайд"></button>
                                        <button class="multicontent__slider-next" type="button" aria-label="Наступний слайд"></button>
                                    </div>
                                    <div class="slider-pagination-wrapper">
                                        <div class="swiper-pagination"></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($item['acf_fc_layout'] == 'youtube-video'): ?>
                                <div <?= get_space_top($item['space-top']); ?> class="multicontent-space-top w-full">
                                    <iframe width="560" height="315" class="multicontent-iframe aspect-<?= $item['ratio'] ?>" src="https://www.youtube.com/embed/<?= $item['id'] ?>"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                </div>
                            <?php endif; ?>

                            <?php if ($item['acf_fc_layout'] == 'video'): ?>
                                <div <?= get_space_top($item['space-top']); ?> class="multicontent-space-top w-full">
                                    <video class="multicontent-video aspect-<?= $item['ratio'] ?>" controls='true' type='video/mp4' preload="auto" poster="<?= $item['poster'] ?>" src='<?= $item['video_url'] ?>'></video>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
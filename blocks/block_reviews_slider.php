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

    wp_enqueue_style('reviews_slider_style', get_theme_file_uri() . '/dist/css/blocks/block_reviews_slider.css');
    wp_enqueue_script('reviews_slider_js', get_theme_file_uri('./dist/js/blocks/block_reviews_slider.js'), array('main_js'), null, true);

    // Один запит на всі відгуки — панелі табів збираються з цього масиву
    $reviews_query = new WP_Query([
        'post_type'      => 'review',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => check($data['is_random'] ?? null) ? 'rand' : 'date',
        'order'          => 'DESC',
    ]);

    $reviews = [];

    if ($reviews_query->have_posts()):
        while ($reviews_query->have_posts()): $reviews_query->the_post();
            $review_id = get_the_ID();
            $thumb_id  = get_post_thumbnail_id($review_id);
            $content   = apply_filters('the_content', get_the_content());

            // Ні фото, ні тексту — виводити нічого
            if (!check($thumb_id) && !check(trim(wp_strip_all_tags($content)))) {
                continue;
            }

            $post_terms = wp_get_post_terms($review_id, 'review_category');

            $reviews[] = [
                'id'       => $review_id,
                'title'    => get_the_title(),
                'thumb_id' => $thumb_id,
                'content'  => $content,
                'slugs'    => (!is_wp_error($post_terms) && !empty($post_terms)) ? wp_list_pluck($post_terms, 'slug') : [],
            ];
        endwhile;
        wp_reset_postdata();
    endif;

    if (!empty($reviews)):

        $text_all        = get_field('text_all', 'option');
        $text_categories = get_field('text_categories', 'option');

        // Перша панель — «Всі», далі по категоріях (порожні категорії пропускаємо)
        $panels = [[
            'slug'  => 'all',
            'name'  => check($text_all) ? $text_all : 'Всі',
            'items' => $reviews,
        ]];

        $review_categories = get_terms([
            'taxonomy'   => 'review_category',
            'hide_empty' => true,
        ]);

        if (!is_wp_error($review_categories) && !empty($review_categories)):
            foreach ($review_categories as $term) {
                $items = array_values(array_filter($reviews, function ($review) use ($term) {
                    return in_array($term->slug, $review['slugs'], true);
                }));

                if (empty($items)) {
                    continue;
                }

                $panels[] = [
                    'slug'  => $term->slug,
                    'name'  => $term->name,
                    'items' => $items,
                ];
            }
        endif;

        $has_tabs = count($panels) > 1;

        $section_bg        = $data['section_bg'] ?? [];
        $is_show_colour_bg = $section_bg['is_show_colour_bg'] ?? false;
        $ratio             = check($data['ratio'] ?? null) ? $data['ratio'] : 'square';
        $counts            = wp_parse_args($data['slides_count'] ?? [], [
            'mob'     => 1,
            'tablet'  => 2,
            'desktop' => 3,
        ]);

        $unique_id = uniqid('reviews-');
?>
        <section <?= $is_show_colour_bg ? 'style="background-color:' . $section_bg['bg-color'] . ';"' : '' ?> <?= get_section_id($data) ?> class="reviews-slider <?= $is_show_colour_bg ? get_section_padding($section_bg) : '' ?> <?= get_section_space_top($data) ?>">
            <div class="container">
                <div data-slider="reviews"
                    data-slides-mob="<?= (int) $counts['mob'] ?>"
                    data-slides-tablet="<?= (int) $counts['tablet'] ?>"
                    data-slides-desktop="<?= (int) $counts['desktop'] ?>"
                    class="reviews-slider__slider">

                    <?php get_template_part(get_part_path('title'), null, [
                        'title_data' => $data['title'] ?? [],
                        'classes'    => 'reviews-slider__title'
                    ]) ?>

                    <div class="reviews-slider__controls">
                        <div class="reviews-slider__tabs">
                            <?php if ($has_tabs): ?>
                                <?php foreach ($panels as $index => $panel): ?>
                                    <button type="button" class="reviews-slider__tabs-btn <?= $index === 0 ? 'is-active' : '' ?>" data-filter="<?= esc_attr($panel['slug']) ?>"><?= esc_html($panel['name']) ?></button>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="slider-head__nav">
                            <button type="button" class="swiper-button prev">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                            </button>
                            <button type="button" class="swiper-button next">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="reviews-slider__panels">
                        <?php foreach ($panels as $index => $panel):
                            $gallery_id = $unique_id . '-' . $panel['slug']; ?>
                            <div class="reviews-slider__panel" data-panel="<?= esc_attr($panel['slug']) ?>" <?= $index === 0 ? '' : 'hidden' ?>>
                                <div class="swiper">
                                    <div class="swiper-wrapper">
                                        <?php foreach ($panel['items'] as $review):
                                            $has_content = check(trim(wp_strip_all_tags($review['content'])));
                                            $has_body    = $has_content || check($review['title']); ?>
                                            <div class="swiper-slide">
                                                <article class="review-card <?= $has_body ? '' : 'review-card--media-only' ?>">
                                                    <?php if (check($review['thumb_id'])): ?>
                                                        <a href="<?= wp_get_attachment_url($review['thumb_id']) ?>" data-fancybox="<?= esc_attr($gallery_id) ?>" class="review-card__media">
                                                            <?php get_image($review['thumb_id'], 'review-card__image aspect-' . $ratio); ?>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if ($has_content): ?>
                                                        <div class="review-card__body">
                                                            <?php if ($has_content): ?>
                                                                <div class="review-card__text text-content"><?= $review['content'] ?></div>
                                                                <button type="button" class="review-card__more" data-text-more="Читати більше" data-text-less="Згорнути" hidden>Читати більше</button>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </article>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="slider-pagination-wrapper">
                                        <div class="swiper-pagination"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>

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

    $display_mode = ($data['display_mode'] ?? '') === 'custom_tabs' ? 'custom_tabs' : 'default';
    $is_random    = check($data['is_random'] ?? null);

    // Один запит на всі відгуки — далі вся вибірка по табах робиться в PHP над цим пулом
    $the_posts = get_posts([
        'post_type'        => 'review',
        'post_status'      => 'publish',
        'posts_per_page'   => -1,
        'orderby'          => 'date',
        'order'            => 'DESC',
        'suppress_filters' => false,
    ]);

    $reviews = [];

    foreach ($the_posts as $item) {
        if (!is_object($item) || $item->post_status !== 'publish') {
            continue;
        }

        $thumb_id = get_post_thumbnail_id($item->ID);
        $content  = apply_filters('the_content', $item->post_content);

        if (!check($thumb_id) && !check(trim(wp_strip_all_tags($content)))) {
            continue;
        }

        $post_terms = get_the_terms($item, 'review_category');

        $reviews[$item->ID] = [
            'id'       => $item->ID,
            'title'    => get_the_title($item),
            'thumb_id' => $thumb_id,
            'content'  => $content,
            'term_ids' => (!is_wp_error($post_terms) && !empty($post_terms)) ? array_map('intval', wp_list_pluck($post_terms, 'term_id')) : [],
        ];
    }

    if (!empty($reviews)):

        $text_all = get_field('text_all', 'option');

        // Таб «Всі» завжди перший і активний за замовчуванням
        $panels = [[
            'slug'  => 'all',
            'name'  => check($text_all) ? $text_all : 'Всі',
            'items' => array_values($reviews),
        ]];

        if ($display_mode === 'custom_tabs') {
            $tabbed_ids = [];

            foreach ((array) ($data['tabs'] ?? []) as $index => $tab) {
                $tab_mode = check($tab['tab_mode'] ?? null) ? $tab['tab_mode'] : 'term_name';
                $items    = [];

                if (($tab['tab_display_mode'] ?? '') === 'custom_list') {
                    foreach ((array) ($tab['custom_list'] ?? []) as $custom_post) {
                        $post_id = is_object($custom_post) ? (int) $custom_post->ID : (int) $custom_post;

                        if (isset($reviews[$post_id])) {
                            $items[] = $reviews[$post_id];
                        }
                    }
                } else {
                    // Кілька категорій в одному табі працюють як AND — відгук має мати всі обрані терми
                    $tab_term_ids = array_values(array_filter(array_map('intval', (array) ($tab['taxonomies'] ?? []))));

                    if (!empty($tab_term_ids)) {
                        foreach ($reviews as $review) {
                            if (empty(array_diff($tab_term_ids, $review['term_ids']))) {
                                $items[] = $review;
                            }
                        }
                    }
                }

                // Прихований таб кнопки не має, але свої відгуки в таб «Всі» так само групує
                foreach ($items as $tab_item) {
                    $tabbed_ids[] = $tab_item['id'];
                }

                if ($tab_mode === 'hidden' || empty($items)) {
                    continue;
                }

                if ($tab_mode === 'custom_tab') {
                    $name = check($tab['custom_tab'] ?? null) ? $tab['custom_tab'] : '';
                } else {
                    $term = check($tab['term_name'] ?? null) ? get_term((int) $tab['term_name'], 'review_category') : null;
                    $name = ($term && !is_wp_error($term)) ? $term->name : '';
                }

                if (!check($name)) {
                    continue;
                }

                $panels[] = [
                    'slug'  => 'tab-' . $index,
                    'name'  => $name,
                    'items' => $items,
                ];
            }

            // «Всі» — спочатку відгуки табів у порядку табів, далі всі інші
            $tabbed_ids = array_values(array_unique($tabbed_ids));
            $rest       = array_diff(array_keys($reviews), $tabbed_ids);

            $panels[0]['items'] = array_values(array_map(function ($id) use ($reviews) {
                return $reviews[$id];
            }, array_merge($tabbed_ids, array_values($rest))));

        } else {
            $review_categories = get_terms([
                'taxonomy'   => 'review_category',
                'hide_empty' => true,
            ]);

            if (!is_wp_error($review_categories) && !empty($review_categories)) {
                foreach ($review_categories as $term) {
                    $items = array_values(array_filter($reviews, function ($review) use ($term) {
                        return in_array((int) $term->term_id, $review['term_ids'], true);
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
            }
        }

        if ($is_random) {
            foreach ($panels as &$panel) {
                shuffle($panel['items']);
            }
            unset($panel);
        }

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

                    <?php if ($has_tabs): ?>
                        <?php get_template_part(get_part_path('title'), null, [
                            'title_data' => $data['title'] ?? [],
                            'classes'    => 'reviews-slider__title'
                        ]) ?>

                        <div class="reviews-slider__controls">
                            <div class="reviews-slider__tabs">
                                <?php foreach ($panels as $index => $panel): ?>
                                    <button type="button" class="reviews-slider__tabs-btn <?= $index === 0 ? 'is-active' : '' ?>" data-filter="<?= esc_attr($panel['slug']) ?>"><?= esc_html($panel['name']) ?></button>
                                <?php endforeach; ?>
                            </div>

                            <?php get_template_part(get_part_path('slider-nav')) ?>
                        </div>
                    <?php else: ?>
                        <?php get_template_part(get_part_path('slider-head'), null, [
                            'title_data' => $data['title'] ?? []
                        ]) ?>
                    <?php endif; ?>

                    <div class="reviews-slider__panels">
                        <?php foreach ($panels as $index => $panel):
                            $gallery_id = $unique_id . '-' . $panel['slug']; ?>
                            <div class="reviews-slider__panel" data-panel="<?= esc_attr($panel['slug']) ?>" <?= $index === 0 ? '' : 'hidden' ?>>
                                <div class="swiper">
                                    <div class="swiper-wrapper">
                                        <?php foreach ($panel['items'] as $review):
                                            $has_content = check(trim(wp_strip_all_tags($review['content']))); ?>
                                            <div class="swiper-slide">
                                                <article class="review-card <?= $has_content ? '' : 'review-card--media-only' ?>">
                                                    <?php if (check($review['thumb_id'])): ?>
                                                        <a href="<?= wp_get_attachment_url($review['thumb_id']) ?>" data-fancybox="<?= esc_attr($gallery_id) ?>" class="review-card__media">
                                                            <?php get_image($review['thumb_id'], 'review-card__image aspect-' . $ratio); ?>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if ($has_content): ?>
                                                        <div class="review-card__body">
                                                            <div class="review-card__text text-content"><?= $review['content'] ?></div>
                                                            <button type="button" class="review-card__more" data-text-more="Читати більше" data-text-less="Згорнути" hidden>Читати більше</button>
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

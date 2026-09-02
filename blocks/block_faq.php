<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (!current_user_can('administrator') && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('faq_style', get_theme_file_uri('./dist/css/blocks/block_faq.css'));
    wp_enqueue_script('faq_js', get_theme_file_uri('./dist/js/blocks/block_faq.js'), array('main_js'), null, true);

    $display_mode = $data['display_mode'] ?? 'default';

    // Количество элементов, видимых до нажатия на кнопку "Показати всі"
    $visible_count = 6;

    $text_show_all = get_field('text_show_all', 'option');
    $text_hide     = get_field('text_hide', 'option');

    $query_args = [
        'post_type'        => 'faq',
        'post_status'      => 'publish',
        'posts_per_page'   => -1,
        'orderby'          => [
            'menu_order' => 'ASC',
            'date'       => 'DESC',
        ],
        'suppress_filters' => false,
    ];

    if ($display_mode === 'by_category' && check($data['tax'] ?? null)) {
        $query_args['tax_query'] = [[
            'taxonomy' => 'faq_category',
            'field'    => 'term_id',
            'terms'    => $data['tax'],
        ]];
        $the_posts = get_posts($query_args);
    } elseif ($display_mode === 'custom' && check($data['custom_list'] ?? null)) {
        $the_posts = $data['custom_list'];
    } else {
        $the_posts = get_posts($query_args);
    }

    $faq_items = [];

    if (check($the_posts ?? null)) {
        foreach ($the_posts as $item) {
            if (!is_object($item) || $item->post_status !== 'publish') {
                continue;
            }

            $faq_items[] = [
                'title' => get_the_title($item),
                'text'  => apply_filters('the_content', $item->post_content ?? ''),
            ];
        }
    }

    if (!check($faq_items)) {
        return;
    }

    $has_hidden = count($faq_items) > $visible_count;
    $list_id    = uniqid('faq-list-');

    echo get_faq_schema(array_map(function ($faq_item) {
        return [
            'name' => $faq_item['title'],
            'text' => $faq_item['text'],
        ];
    }, $faq_items));
?>

    <section <?= get_section_id($data) ?> class="block-faq <?= get_section_space_top($data) ?>">
        <div class="container block-faq__wrapper">
            <?php get_template_part(get_part_path('title'), null, [
                'title_data' => $data['title']
            ]) ?>

            <div id="<?= esc_attr($list_id) ?>" class="block-faq__list" data-accordion="one">
                <?php foreach ($faq_items as $key => $faq_item):
                    get_template_part(get_part_path('faq-item'), null, [
                        'classes'       => $has_hidden && $key >= $visible_count ? 'is-hidden' : '',
                        'faq_item_data' => [
                            'title'   => $faq_item['title'],
                            'text'    => $faq_item['text'],
                            'is_open' => $key === 0,
                        ],
                    ]);
                endforeach; ?>
            </div>

            <?php if ($has_hidden): ?>
                <div class="block-faq__btn-wrap">
                    <button type="button" class="btn-default" data-faq-toggle aria-expanded="false" aria-controls="<?= esc_attr($list_id) ?>" data-text-show="<?= esc_attr($text_show_all) ?>" data-text-hide="<?= esc_attr($text_hide) ?>"><?= esc_html($text_show_all) ?></button>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
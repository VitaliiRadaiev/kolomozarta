<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (!current_user_can('administrator') && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('page_title_style', get_theme_file_uri() . '/dist/css/blocks/block_page_title.css');

    $page_title = $data['page_title'];
?>
    <section <?= get_section_id($data) ?> class="page__hero <?= get_section_space_top($data) ?>">
        <div class="container">
            <div class="page__wrap">
                <h1 data-aos="fade-up" class="page__title">
                    <?= $page_title ?>
                </h1>
                <div data-aos="fade-in" data-aos-delay="600" data-aos-duration="1000" class="page__breadcrumbs">
                    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
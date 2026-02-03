<?php
wp_enqueue_style('page_videos_styles', get_theme_file_uri('dist/css/pages/page-videos.css'));
wp_enqueue_style('page_lessons', get_theme_file_uri('dist/css/pages/page-lessons.css'));
/*
Template Name: Шаблон закритої сторінки
*/

get_header();

$lessons = get_field('lessons', get_the_ID());

$post_id = get_the_ID();
$page_permissions = get_post_meta($post_id, '_members_access_role');
$not_available_content = get_field('not_available_content', 'option');
$order_btn = get_field('order_btn', 'option');
$text_do_auth = get_field('text_do_auth', 'option');
$link_to_current_product = get_field('link_to_current_product');
$is_show_lessons_navigation = get_field('is_show_lessons_navigation');
$is_intro = get_field('is_intro');
$intro_text = get_field('intro_text');
$current_user = wp_get_current_user();

$is_show_page = false;
$is_user_logged = is_user_logged_in();


if ($is_user_logged) {
    $is_admin = current_user_can('administrator');
    $is_show_page = ($is_admin || arrays_have_common_element($current_user->roles, $page_permissions));
}
?>

<?php if ($is_show_page): ?>
    <section class="page__hero">
        <div class="container">
            <div class="page__wrap">
                <h1 class="page__title">
                    <?= get_the_title(); ?>
                </h1>
                <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
            </div>

        </div>
    </section>
    <section data-videos class="lessons">
        <div class="container lessons__container">
            <?php
            if (!empty($lessons) && $is_show_lessons_navigation):
            ?>
                <div class="lessons__nav">
                    <div class="lessons__nav-scroll-wrap-1">
                        <div class="lessons__nav-scroll-wrap-2">
                            <div data-nav-buttons-scroll-container class="lessons__nav-scroll-wrap-3">
                                <div class="lessons__nav-buttons-wrap">
                                    <?php
                                    foreach ($lessons as $key => $lesson):
                                        $item = $lesson['videos_info'];
                                        $title = $item['lesson_num'];
                                    ?>
                                        <button data-lesson-nav-btn="<?= ($key + 1) ?>" title="<?= htmlspecialchars($title, ENT_QUOTES) ?>" class="lessons__nav-btn">
                                            <?= ($key + 1) ?>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endif;
            ?>
            <?php if ($is_intro && check($intro_text)): ?>
                <div class="lessons__intro-text text-content">
                    <?= add_inner_wrap_to_li($intro_text) ?>
                </div>
            <?php endif; ?>

            <div class="lessons__content">
                <?php
                if (!empty($lessons)):
                    foreach ($lessons as $key => $lesson):
                        $item = $lesson['videos_info'];
                        $title = $item['lesson_num'];
                        $accent = $item['accent'];
                        $rows = $item['row'];
                ?>
                        <div data-lesson-item="<?= ($key + 1) ?>" class="lessons__item accent-<?= !empty($accent) ? $accent : 'red' ?>">
                            <?php if (check($title)): ?>
                                <h2 class="lessons__title">
                                    <i class="accent">
                                        <img src="<?= get_theme_file_uri() . '/dist/images/arrow.svg' ?>"
                                            alt="Icon">
                                    </i>
                                    <?= $title ?>
                                </h2>
                            <?php endif; ?>

                            <?php if (check($rows)): ?>
                                <div class="lessons__rows">
                                    <?php
                                    foreach ($rows as $row):
                                        $column_left = $row['column_left'];
                                        $column_right = $row['column_right'];
                                    ?>
                                        <div class="lessons_row">
                                            <div class="lessons__column lessons__column-left">
                                                <?php if (check($column_left['text'])): ?>
                                                    <div class="lessons__text text-content">
                                                        <?= add_inner_wrap_to_li($column_left['text'] ) ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (check($column_left['image'])): ?>
                                                    <div class="lessons__image">
                                                        <?= get_image($column_left['image']) ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (check($column_left['media'])): ?>
                                                    <div class="lessons__media-list">
                                                        <?php foreach ($column_left['media'] as $media): ?>
                                                            <div class="lessons__media-list-item">
                                                                <?php if (check($media['presto_player'])): ?>
                                                                    <div class="lessons__media">
                                                                        <?= do_shortcode('[presto_player id="' . $media['presto_player'] . '"]'); ?>
                                                                    </div>
                                                                <?php endif; ?>

                                                                <?php if (check($media['media_sign'])): ?>
                                                                    <div class="lessons__media-sign">
                                                                        <?= $media['media_sign'] ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="lessons__column lessons__column-right">
                                                <?php if (check($column_right['text'])): ?>
                                                    <div class="lessons__text text-content">
                                                        <?= add_inner_wrap_to_li($column_right['text'] ) ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (check($column_right['image'])): ?>
                                                    <div class="lessons__image">
                                                        <?= get_image($column_right['image']) ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (check($column_right['media'])): ?>
                                                    <div class="lessons__media-list">
                                                        <?php foreach ($column_right['media'] as $media): ?>
                                                            <div class="lessons__media-list-item">
                                                                <?php if (check($media['presto_player'])): ?>
                                                                    <div class="lessons__media">
                                                                        <?= do_shortcode('[presto_player id="' . $media['presto_player'] . '"]'); ?>
                                                                    </div>
                                                                <?php endif; ?>

                                                                <?php if (check($media['media_sign'])): ?>
                                                                    <div class="lessons__media-sign">
                                                                        <?= $media['media_sign'] ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="page__hero not_available_content">
        <div class="container">
            <div class="page__wrap">
                <h1 class="page__title">
                    <?= $not_available_content['title']; ?>
                </h1>

                <?php if (!$is_user_logged): ?>
                    <?php if ($not_available_content['text']): ?>
                        <div class="block-text__text">
                            <?= $not_available_content['text'] ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if ($not_available_content['text_2']): ?>
                        <div class="block-text__text">
                            <?= $not_available_content['text_2'] ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="buttons-group">
                    <?php
                    $order_url = get_post_permalink(141);

                    if ($link_to_current_product) {
                        $order_url = $link_to_current_product['url'];
                    }
                    ?>
                    <a href="<?= $order_url ?>" class="btn-default"><?= $order_btn ?></a>

                    <?php if (!$is_user_logged): ?>
                        <a href="#" data-action="open-auth-popup" class="btn-default"><?= $text_do_auth ?></a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
<?php endif; ?>

<?php
get_footer();

<?php
wp_enqueue_style('page_videos_styles', get_theme_file_uri('dist/css/pages/page-videos.css'));

//videos_info
//videos_info['lesson_num'];
//videos_info['lesson_title'];
//videos_info['lesson_desc'];
//videos_info['lesson_video'];

//lesson_add
//lesson_add['desc'];
//lesson_add['video'];


get_header(); ?>

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
    <section class="videos">
        <div class="container">
            <?php
            $args = [
                'post_type' => 'videos',
                'posts_per_page' => 5,
                'post_status' => 'publish',
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
            ];
            $query = new WP_Query($args);

            if ($query->have_posts()) : ?>
                <ul class="videos__list">
                    <?php while ($query->have_posts()) : $query->the_post();
                        $post_id = get_the_ID();
                        $lesson_info = get_field('videos_info', $post_id);
                        $lesson_num = $lesson_info["lesson_num"];
                        $lesson_accent = $lesson_info['accent'];
                        $lesson_title = $lesson_info["lesson_title"];
                        $lesson_desc = $lesson_info["lesson_desc"];
                        $lesson_video = $lesson_info["lesson_video"]['url'];
                        $lesson_add = get_field('lesson_add', $post_id);
                        $lesson_add_desc = $lesson_add["desc"];
                        $lesson_add_video = $lesson_add;

                        $presto_player = $lesson_info['presto_player'];
                        ?>

                        <li class="videos__list-item accent-<?= !empty($lesson_accent) ? $lesson_accent : 'red' ?>">
                            <div class="videos__list-content">
                                <?php if ($presto_player->ID) : ?>
                                    <?= do_shortcode('[presto_player id="' . $presto_player->ID . '"]'); ?>
                                <?php elseif ($lesson_video): ?>
                                    <video src="<?= $lesson_video ?>" controls width="100%" height="auto"></video>
                                <?php endif; ?>
                                <div class="videos__list-info">
                                    <?php if ($lesson_num): ?>
                                        <span>
                                            <i class="accent">
                                                <img src="<?= get_theme_file_uri() . '/dist/images/arrow.svg' ?>"
                                                     alt="Icon"></i>
                                            <?= $lesson_num ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($lesson_title): ?>
                                        <h2><?= $lesson_title ?></h2>
                                    <?php endif; ?>
                                    <?php if ($lesson_desc): ?>
                                        <div class="videos__list-desc">
                                            <?= $lesson_desc ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if (!empty($lesson_add)): ?>
                                <ul class="videos__list-additional">
                                    <?php foreach ($lesson_add as $lesson): ?>
                                        <li>
                                            <?php if ($lesson['desc']): ?>
                                                <div>
                                                    <i class="accent">
                                                        <img src="<?= get_theme_file_uri() . '/dist/images/note.svg' ?>"
                                                             alt="Icon"></i>
                                                    <p><?= cut_p_tags($lesson['desc']) ?></p>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($lesson["video"]['url']): ?>
                                                <video src="<?= $lesson["video"]['url'] ?>" controls width="100%"
                                                       height="auto"></video>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <?php if ($query->max_num_pages > 1): ?>
                    <div class="pagination">
                        <?= paginate_links([
                            'total' => $query->max_num_pages,
                            'current' => max(1, get_query_var('paged')),
                            'prev_text' => 'Назад',
                            'next_text' => 'Вперед',
                        ]); ?>
                    </div>
                <?php endif; ?>
                <?php wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>
<?php
get_footer();

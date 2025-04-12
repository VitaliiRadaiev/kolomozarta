<?php
wp_enqueue_style('page_updates_styles', get_theme_file_uri('dist/css/pages/page-updates.css'));

/*
Template Name: Оновлення річного відеокурсу
*/


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
    <section class="updates">
        <div class="container">
            <?php
            $args = array(
                'post_type' => 'updates',
                'posts_per_page' => -1,
            );

            $updates_query = new WP_Query($args);

            if ($updates_query->have_posts()) : ?>
                <ul class="updates__list">
                    <?php while ($updates_query->have_posts()) : $updates_query->the_post();

                        // Получаем данные для каждой записи
                        $updates_video = get_field('updates_video', get_the_ID());
                        $updates_video_id = $updates_video['updates_video_id'] ?? '';
                        $updates_video_file = $updates_video['updates_video_file'] ?? '';

                        $updates_audio = get_field('updates_audio', get_the_ID());
                        $updates_audio_plus = $updates_audio['audio_plus'] ?? '';
                        $audio_plus_text = $updates_audio['audio_plus_text'] ?? '';
                        $updates_audio_minus = $updates_audio['audio_minus'] ?? '';
                        $audio_minus_text = $updates_audio['audio_minus_text'] ?? '';
                        $updates_audio_title = $updates_audio['audio_title'] ?? '';

                        $presto_player_video = $updates_video['presto_player'];
                        $presto_player_audio_minus = $updates_audio['presto_player_minus'];
                        $presto_player_audio_plus = $updates_audio['presto_player_plus'];

                        ?>
                        <li class="updates__list-item">
                            <div class="updates__list-item-video">
                                <?php if ($presto_player_video->ID) : ?>
                                    <?= do_shortcode('[presto_player id="' . $presto_player_video->ID . '"]'); ?>
                                <?php elseif (!empty($updates_video_id)): ?>
                                    <iframe width="560" height="315"
                                            src="https://www.youtube.com/embed/<?= esc_html($updates_video_id); ?>"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                <?php else: ?>
                                    <video src="<?= $updates_video_file['url'] ?>" controls></video>
                                <?php endif; ?>
                            </div>
                            <div class="updates__list-item-info">
                                <h2><?= get_the_title(); ?></h2>
                                <?php if ($updates_audio_title) : ?>
                                    <h3><?= esc_html($updates_audio_title); ?></h3>
                                <?php endif; ?>
                                <ul class="updates__list-item-audio">
                                    <?php if ($presto_player_audio_plus->ID) : ?>
                                        <li>
                                            <?= do_shortcode('[presto_player id="' . $presto_player_audio_plus->ID . '"]'); ?>
                                            <p><?= esc_html($audio_plus_text); ?></p>
                                        </li>
                                    <?php elseif ($updates_audio_plus) : ?>
                                        <li>
                                            <audio src="<?= esc_url($updates_audio_plus['url']); ?>" controls></audio>
                                            <p><?= esc_html($audio_plus_text); ?></p>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($presto_player_audio_minus->ID) : ?>
                                        <li>
                                            <?= do_shortcode('[presto_player id="' . $presto_player_audio_minus->ID . '"]'); ?>
                                            <p><?= esc_html($audio_minus_text); ?></p>
                                        </li>
                                    <?php elseif ($updates_audio_minus) : ?>
                                        <li>
                                            <audio src="<?= esc_url($updates_audio_minus['url']); ?>" controls></audio>
                                            <p><?= esc_html($audio_minus_text); ?></p>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif;

            wp_reset_postdata();
            ?>
        </div>
    </section>
<?php
get_footer();

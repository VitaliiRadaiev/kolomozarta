<?php
wp_enqueue_style('courses_style', get_theme_file_uri() . '/dist/css/blocks/block_courses.css');
global $data;

$btn_youtube = get_field('btn_youtube', 'option');
$page_title = $data['page_title'];
$interesting_list = $data['interesting_list'];

?>
<section class="interesting">
    <div class="container">
        <div class="interesting__wrap">
            <?php if (!empty($interesting_list)): ?>
                <ul class="interesting__list">
                    <?php foreach ($interesting_list as $item): ?>
                        <li class="interesting__list-item">
                            <?php
                            $interesting_id = $item->ID;
                            $interesting_img_id = get_post_thumbnail_id($interesting_id);
                            $interesting_img = wp_get_attachment_image_url($interesting_img_id, 'medium');
                            $interesting_title = $item->post_title;
                            $interesting_permalink = get_field('interesting_link', $item->ID);
                            $interesting_content = $item->post_content;

                            if ($interesting_img): ?>
                                <img src="<?= esc_url($interesting_img); ?>" alt="<?= esc_attr($item->post_title); ?>">
                            <?php endif;

                            if ($interesting_title):?>
                                <h3><?= $interesting_title ?></h3>
                            <?php endif;

                            if ($interesting_permalink):?>
                                <a class="btn" href="<?= $interesting_permalink ?>" target="_blank"><?= $btn_youtube ?></a>
                            <?php endif;

                            if ($interesting_content):?>
                                <p class="courses__list-description"><?= $interesting_content ?> </p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>

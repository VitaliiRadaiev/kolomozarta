<?php

global $data;

$btn_details = get_field('btn_details', 'option');
$courses_title = $data['courses_title'];
$courses_list = $data['courses_list'];

?>

<section class="courses">
    <div class="container">
        <div class="courses__wrap">
            <?php if ($courses_title): ?>
                <h2 data-aos="fade-up"><?= $courses_title ?></h2>
            <?php endif; ?>

            <?php if (!empty($courses_list)): ?>
                <ul class="courses__list">
                    <?php foreach ($courses_list as $course): ?>
                        <li class="courses__list-item" data-aos="fade-up">
                            <?php
                            $course_id = $course->ID;
                            $course_img_id = get_post_thumbnail_id($course_id);
                            $course_img = wp_get_attachment_image_url($course_img_id, 'medium');
                            $course_title = $course->post_title;
                            $course_excerpt = $course->post_excerpt;
                            $course_permalink = esc_url(get_permalink($course_id));
                            $course_content = esc_html($course->post_content);

                            if ($course_img): ?>
                                <img src="<?= esc_url($course_img); ?>" alt="<?= esc_attr($course->post_title); ?>" class="no-lazy" width="165px" height="165px">
                            <?php endif;

                            if ($course_title):?>
                                <h3><?= $course_title ?></h3>
                            <?php endif;

                            if ($course_excerpt):?>
                                <p class="courses__list-subtitle"><?= $course_excerpt ?></p>
                            <?php endif;

                            if ($course_permalink):?>
                                <a class="btn" href="<?= $course_permalink ?>"><?= $btn_details ?></a>
                            <?php endif;

                            if ($course_content):?>
                                <p class="courses__list-description"><?= cut_p_tags($course_content) ?> </p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>

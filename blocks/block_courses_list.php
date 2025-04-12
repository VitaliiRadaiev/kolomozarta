<?php
wp_enqueue_style('courses_list_style', get_theme_file_uri() . '/dist/css/blocks/block_courses_list.css');
global $data;

$course_list_title = $data['course_list_title'];
$course_list_description = $data['course_list_description'];

?>

<section class="courses-list">
    <div class="container">
        <div class="courses-list__wrap">
            <?php if ($course_list_title): ?>
                <h2><?= $course_list_title ?></h2>
            <?php endif; ?>
            <?php if ($course_list_description): ?>
                <div><?= $course_list_description ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>


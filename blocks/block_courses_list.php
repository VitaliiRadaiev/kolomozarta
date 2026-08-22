<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (!current_user_can('administrator') && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('courses_list_style', get_theme_file_uri() . '/dist/css/blocks/block_courses_list.css');

    $course_list_title = $data['course_list_title'];
    $course_list_description = $data['course_list_description'];
?>
    <section <?= get_section_id($data) ?> class="courses-list <?= get_section_space_top($data) ?>">
        <div class="container">
            <div data-aos="fade-up" class="courses-list__wrap">
                <?php if ($course_list_title): ?>
                    <h2><?= $course_list_title ?></h2>
                <?php endif; ?>
                <?php if ($course_list_description): ?>
                    <div><?= $course_list_description ?></div>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php endif; ?>
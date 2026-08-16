<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (is_admin() && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('courses_info_style', get_theme_file_uri() . '/dist/css/blocks/block_courses_info.css');

    $courses_info = $data['courses_info'];

    if ($courses_info):
?>
    <section <?= get_section_id($data) ?> class="courses-info <?= get_section_space_top($data) ?>">
        <div class="container">
            <div data-aos="fade-up" class="courses-info__wrap">
                <?= $courses_info ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
<?php endif; ?>
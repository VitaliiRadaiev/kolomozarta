<?php
wp_enqueue_style('courses_info_style', get_theme_file_uri() . '/dist/css/blocks/block_courses_info.css');
global $data;

$courses_info = $data['courses_info'];
?>

<?php if ($courses_info): ?>
    <section class="courses-info">
        <div class="container">
            <div class="courses-info__wrap">
                <?= $courses_info ?>
            </div>
        </div>
    </section>
<?php endif; ?>
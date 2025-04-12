<?php
wp_enqueue_style('courses_img_style', get_theme_file_uri() . '/dist/css/blocks/block_courses_img.css');
global $data;

$courses_list_img = $data['courses_list_img']['sizes']['large'];
$courses_list_title = $data['courses_list_tile'];
$courses_list_wrap = $data['courses_list_wrap'];

?>

<section class="courses-img">
    <div class="container">
        <div class="courses-img__wrap">
            <?php if ($courses_list_img): ?>
                <img src="<?= $courses_list_img ?>" alt="Image">
            <?php endif; ?>
            <div class="courses-img__list">
                <h2><?= $courses_list_title ?></h2>
                <?php if (!empty($courses_list_wrap)): ?>
                    <ul>
                        <?php foreach ($courses_list_wrap as $item): ?>
                            <li><?= $item['courses_list_wrap_item'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
wp_enqueue_style('year_course_style', get_theme_file_uri() . '/dist/css/blocks/block_year_course.css');
global $data;

$order_btn = get_field('order_btn', 'option');
$year_course_description = $data['year_course_description'];
$year_course_img = $data['year_course_img'];
$year_course_video_title = $data['year_course_video_title'];
$year_course_video = $data['year_course_video'];
$year_course_list_title = $data['year_course_list_title'];
$year_course_list = $data['year_course_list'];
$year_course_price_title = $data['year_course_price_title'];
$year_course_price = $data['year_course_price'];
?>

<section class="year-course">
    <div class="container">
        <div class="year-course__wrap">
            <div data-aos="fade-up" class="year-course__info">
                <?php if ($year_course_description): ?>
                    <div class="year-course__description">
                        <?= $year_course_description ?>
                    </div>
                <?php endif; ?>
                <?php if ($year_course_img): ?>
                    <div class="year-course__img">
                        <img src="<?= $year_course_img['sizes']['large'] ?>" alt="Image">
                    </div>
                <?php endif; ?>
            </div>
            <div data-aos="fade-up" class="year-course__video">
                <?php if ($year_course_video_title): ?>
                    <h2><?= $year_course_video_title ?></h2>
                <?php endif; ?>
                <?php if ($year_course_video): ?>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $year_course_video ?>"
                            frameborder="0"
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                <?php endif; ?>
            </div>
            <div data-aos="fade-up" class="year-course__lists">
                <?php if ($year_course_list_title): ?>
                    <h2><?= $year_course_list_title ?></h2>
                <?php endif; ?>
                <?php if (!empty($year_course_list)): ?>
                    <div class="year-course__lists-wrap">
                        <?php foreach ($year_course_list as $year_course): ?>
                            <div class="year-course__lists-item text-content">
                                <script>
                                    console.log( <?= json_encode($year_course['text']); ?> );
                                </script>
                                <?= add_inner_wrap_to_li($year_course['text']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div data-aos="fade-up" class="year-course__lists-price">
                <?php if ($year_course_price_title): ?>
                    <p><?= $year_course_price_title ?></p>
                <?php endif; ?>
                <?php if ($year_course_price) : ?>
                    <span><?= $year_course_price ?></span>
                <?php endif; ?>
                <button class="openOrderPopup"
                        data-price="<?= $year_course_price ?>"
                        data-title="<?= the_title() ?>"
                        data-subtitle="<?= $year_course_price_title ?>"
                        ><?= $order_btn ?></button>
            </div>
        </div>
    </div>
</section>

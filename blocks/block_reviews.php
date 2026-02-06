<?php
wp_enqueue_style('swiper_bundle_style', get_theme_file_uri() . '/dist/css/libs/swiper-bundle.css');
wp_enqueue_script('swiper_bundle_js', get_theme_file_uri('./dist/js/libs/swiper-bundle.js'), array('main_js'), null, false);

wp_enqueue_style('reviews_style', get_theme_file_uri() . '/dist/css/blocks/block_reviews.css');
wp_enqueue_script('reviews_js', get_theme_file_uri('./dist/js/blocks/block_reviews.js'), array('main_js'), null, false);

global $data;

$reviews_title = $data['reviews_title'];
$reviews_list = $data['reviews_list'];

?>

<?php if (!empty($reviews_list)): ?>
    <section class="reviews">
        <div class="container">
            <div class="reviews__wrap">
                <?php if ($reviews_title): ?>
                    <h2> <?= $reviews_title ?></h2>
                <?php endif; ?>
                <div data-slider="reviews" class="reviews__slider">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($reviews_list as $review): ?>
                                <div class="swiper-slide">
                                    <div class="reviews__slider-item">
                                        <?php if ($review['avatar']): ?>
                                            <img src="<?= $review['avatar']['sizes']['medium'] ?>" alt="Avatar">
                                        <?php endif; ?>
                                        <p><?= cut_p_tags($review['text']) ?></p>
                                        <span><?= $review['author'] ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="slider-pagination-wrapper">
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
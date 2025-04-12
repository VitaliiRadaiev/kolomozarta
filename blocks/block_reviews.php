<?php
wp_enqueue_style('reviews_style', get_theme_file_uri() . '/dist/css/blocks/block_reviews.css');
global $data;

$reviews_title = $data['reviews_title'];
$reviews_list = $data['reviews_list'];

?>

<section class="reviews">
    <div class="container">
        <div class="reviews__wrap">
            <?php if ($reviews_title): ?>
                <h2> <?= $reviews_title ?></h2>
            <?php endif; ?>
            <?php if (!empty($reviews_list)): ?>
                <div class="reviews__slider">
                    <?php foreach ($reviews_list as $review): ?>
                        <div class="reviews__slider-item">
                            <?php if ($review['avatar']): ?>
                                <img src="<?= $review['avatar']['sizes']['medium'] ?>" alt="Avatar">
                            <?php endif; ?>
                            <p><?= cut_p_tags($review['text']) ?></p>
                            <span><?= $review['author'] ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
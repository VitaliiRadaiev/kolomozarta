<?php
wp_enqueue_style('year_updates_style', get_theme_file_uri() . '/dist/css/blocks/block_year_updates.css');
global $data;

$year_updates_title = $data['year_updates_title'];
$year_updates_list = $data['year_updates_list'];
$year_updates_buttons = $data['year_updates_buttons'];
$order_btn = get_field('order_btn', 'option');
?>

<section class="year-updates">
    <div class="container">
        <div class="year-updates__wrap">
            <?php if ($year_updates_title): ?>
                <h2><?= $year_updates_title ?></h2>
            <?php endif; ?>
            <?php if (!empty($year_updates_list)): ?>
                <div class="year-updates__list">
                    <?php foreach ($year_updates_list as $year_update): ?>
                        <div class="year-updates__item">
                            <?= $year_update['item'] ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($year_updates_buttons)): ?>
                <div class="year-updates__buttons">
                    <?php foreach ($year_updates_buttons as $button): ?>
                        <div class="year-updates__buttons-item">
                            <?php if ($button['title']): ?>
                                <p><?= $button['title'] ?></p>
                            <?php endif; ?>
                            <?php if ($button['price']) : ?>
                                <span><?= $button['price'] ?></span>
                            <?php endif; ?>
                            <button class="openOrderPopup"
                                    data-price="<?= $button['price'] ?>"
                                    data-title="<?= the_title() ?>"
                                    data-subtitle="<?= $button['title'] ?>"
                                    ><?= $order_btn ?></button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
wp_enqueue_style('games_style', get_theme_file_uri() . '/dist/css/blocks/block_games.css');
global $data;

$games_img = $data["games_img"]['url'];
$games_subtitle = $data["games_subtitle"];
$games_list = $data["games_list"];
$games_price = $data["games_price"];
$games_pdf = $data["games_pdf"]['url'];
$order_btn = get_field('order_btn', 'option');
$instruction_btn = get_field('instruction_btn ', 'option');
?>
<section class="games">
    <div class="container">
        <div data-aos="fade-up" class="games__wrap">
            <div class="games__list">
                <?php if ($games_subtitle): ?>
                    <h2><?= $games_subtitle ?></h2>
                <?php endif; ?>
                <?php if (!empty($games_list)): ?>
                    <ul>
                        <?php foreach ($games_list as $game): ?>
                            <li><?= $game['text'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php if ($games_price): ?>
                    <span><?= $games_price ?></span>
                <?php endif; ?>
                <div class="games__btn">
                    <?php if ($order_btn): ?>
                        <button class="openOrderPopup"
                                data-price="<?= $games_price ?>"
                                data-title="<?= the_title() ?>"><?= $order_btn ?></button>
                    <?php endif; ?>
                    <?php if ($instruction_btn && $games_pdf): ?>
                        <a href="<?= $games_pdf ?>" target="_blank"><?= $instruction_btn ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="games__img">
                <?php if ($games_img): ?>
                    <img src="<?= $games_img ?>" alt="Thumbnail">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
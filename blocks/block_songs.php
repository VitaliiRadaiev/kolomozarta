<?php
wp_enqueue_style('songs_style', get_theme_file_uri() . '/dist/css/blocks/block_songs.css');
global $data;
$songs_list = $data['songs_list'];
$order_btn = get_field('order_btn', 'option');
?>

<section class="songs">
    <div class="container">
        <?php if (!empty($songs_list)): ?>
            <ul class="songs__wrap">
                <?php foreach ($songs_list as $song):
                    $song_img = $song['songs_img']['sizes']['large'] ?? null;
                    $song_title = $song['songs_title'] ?? null;
                    $song_price = $song['songs_price'] ?? null;
                    $song_demo = $song['songs_demo'] ?? null;
                    $btn_text = $song_demo['text'] ?? null;
                    $btn_link = $song_demo['link'] ?? null;
                    $btn_icon = $song_demo['icon'] ?? null;
                    $song_detail = $song['songs_detail'] ?? null;
                    $songs_contain = $song['songs_contain'] ?? null;
                    ?>
                    <li class="songs__item">
                        <div class="songs__item-info">
                            <?php if ($song_img): ?>
                                <img src="<?= $song_img ?>" alt="Image">
                            <?php endif; ?>
                            <?php if ($song_title): ?>
                                <h2><?= $song_title ?></h2>
                            <?php endif; ?>
                            <?php if ($song_price): ?>
                                <span><?= $song_price ?></span>
                            <?php endif; ?>
                            <?php if ($songs_contain): ?>
                                <p><?= $songs_contain ?></p>
                            <?php endif; ?>
                            <button class="openOrderPopup"
                                    data-price="<?= $song_price ?>"
                                    data-title="<?= the_title() ?>"><?= $order_btn ?></button>
                        </div>
                        <div class="songs__item-additional">
                            <?php if ($song_detail): ?>
                                <div><?= $song_detail ?></div>
                            <?php endif; ?>
                            <?php if ($btn_link && $btn_text && $btn_icon): ?>
                                <a href="<?= $btn_link ?>" class="link" target="_blank">
                                    <img src="<?= $btn_icon['url'] ?>" alt="Icon">
                                    <p><?= $btn_text ?></p>
                                </a>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>


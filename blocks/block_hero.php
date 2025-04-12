<?php


global $data;

$hero_title = $data['hero_title'];
$hero_subtitle = $data['hero_subtitle'];
$hero_description = $data['hero_description'];


?>

<section class="hero">
    <div class="container">
        <div class="hero__wrap">
            <?php if ($hero_title): ?>
                <h1><?= $hero_title ?></h1>
            <?php endif; ?>

            <?php if ($hero_subtitle): ?>
                <p class="hero__subtitle">
                    <?= $hero_subtitle ?>
                </p>
            <?php endif; ?>

            <?php if ($hero_description): ?>
                <p class="hero__description">
                    <?= $hero_description ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

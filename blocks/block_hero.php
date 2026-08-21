<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (is_admin() && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('hero_style', get_theme_file_uri() . '/dist/css/blocks/block_hero.css');

    $hero_title = $data['hero_title'];
    $hero_subtitle = $data['hero_subtitle'];
    $hero_description = $data['hero_description'];
?>
    <section <?= get_section_id($data) ?> class="hero <?= get_section_space_top($data) ?>">
        <div class="container">
            <div data-aos="fade-up" class="hero__wrap">
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
<?php endif; ?>
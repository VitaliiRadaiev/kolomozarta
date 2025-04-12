<?php
wp_enqueue_style('header_styles', get_theme_file_uri('dist/css/components/header.css'));

//Variables
$whatsapp = get_field('whatsapp', 'option');
$viber = get_field('viber', 'option');
$header_logo = get_field('header_logo', 'option');
?>

<!DOCTYPE html>
<html <?php language_attributes() ?>>

<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head() ?>
</head>

<body <?php body_class() ?>>

    <!--    Header Line with contacts and social media-->
    <div class="entire__line" data-aos="fade">
        <div class="container">
            <div class="entire__line-wrap">
                <ul class="entire__line-contacts">
                    <?php
                    if ($whatsapp): ?>
                        <li>
                            <a href="https://wa.me/<?= cleanPhoneNumber($whatsapp) ?>" target="_blank">
                                <?= $whatsapp ?>
                                <span>(WhatsApp)</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($viber): ?>
                        <li>
                            <a href="viber://chat?number=%2B<?= cleanPhoneNumber($viber) ?>" target="_blank">
                                <?= $viber ?>
                                <span>(Viber)</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php if (have_rows('social_media', 'option')): ?>
                    <ul class="entire__line-social">
                        <?php while (have_rows('social_media', 'option')): the_row();
                            $icon = get_sub_field('icon')['url'];
                            $link = get_sub_field('link');
                        ?>
                            <li>
                                <?php if ($link && $icon): ?>
                                    <a href="<?= esc_url($link); ?>" target="_blank">
                                        <img src="<?= esc_url($icon); ?>" alt="Social Media Icon">
                                    </a>
                                <?php endif; ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <header class="header" id="header">
        <!--    Header Navigation-->
        <div class="container">
            <div class="header__nav">
                <?php
                if ($header_logo): ?>
                    <div class="header__logo" data-aos="fade">
                        <a href="<?= site_url() ?>">
                            <img src="<?= $header_logo['sizes']['medium'] ?>" alt="Коло Моцарта" class="no-lazy" width="190px">
                        </a>
                    </div>
                <?php endif; ?>

                <?php
                wp_nav_menu(array(
                    'theme_location' => 'headerMenuLocation',
                    'container' => 'nav',
                    'container_class' => 'header__menu-wrap',
                    'menu_class' => 'header__menu',
                    'fallback_cb' => false,
                ));
                ?>
                <div class="header__nav-mobile">
                    <button class="openMenu" aria-label="Open menu">
                        <span></span>
                    </button>
                </div>

                <div class="menu__popup">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'headerMenuLocation',
                        'container' => 'nav',
                        'container_class' => 'menu__popup-wrap',
                        'menu_class' => 'menu__popup-mob',
                        'fallback_cb' => false,
                    ));
                    ?>
                    <div class="entire__line">
                        <div class="container">
                            <div class="entire__line-wrap">
                                <ul class="entire__line-contacts">
                                    <?php
                                    if ($whatsapp): ?>
                                        <li>
                                            <a href="https://wa.me/<?= cleanPhoneNumber($whatsapp) ?>" target="_blank">
                                                <?= $whatsapp ?>
                                                <span>(WhatsApp)</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($viber): ?>
                                        <li>
                                            <a href="viber://chat?number=%2B<?= cleanPhoneNumber($viber) ?>" target="_blank">
                                                <?= $viber ?>
                                                <span>(Viber)</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <?php if (have_rows('social_media', 'option')): ?>
                                    <ul class="entire__line-social">
                                        <?php while (have_rows('social_media', 'option')): the_row();
                                            $icon = get_sub_field('icon')['url'];
                                            $link = get_sub_field('link');
                                        ?>
                                            <li>
                                                <?php if ($link && $icon): ?>
                                                    <a href="<?= esc_url($link); ?>" target="_blank">
                                                        <img src="<?= esc_url($icon); ?>" alt="Social Media Icon">
                                                    </a>
                                                <?php endif; ?>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
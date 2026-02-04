<?php
wp_enqueue_style('header_styles', get_theme_file_uri('dist/css/components/header.css'));

//Variables
$whatsapp = get_field('whatsapp', 'option');
$viber = get_field('viber', 'option');
$header_logo = get_field('header_logo', 'option');
$text_cabinet = get_field('text_cabinet', 'option');
?>

<!DOCTYPE html>
<html <?php language_attributes() ?>>

<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head() ?>

    <?php echo  get_field('analytics_scripts_before_head', 'options'); ?>
</head>

<body <?php body_class() ?> > 

    <?php echo get_field('analytics_scripts_after_body', 'options'); ?>

    <?php
    $text_entrance = get_field('text_entrance', 'options');
    $text_exit = get_field('text_exit', 'options');
    $menu_locations = get_nav_menu_locations();
    $menu_id = $menu_locations['headerMenuLocation'];
    $menu_items = wp_get_nav_menu_items($menu_id);
    $header_menu = build_menu_hierarchy($menu_items);
    ?>
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
                // wp_nav_menu(array(
                //     'theme_location' => 'headerMenuLocation',
                //     'container' => 'nav',
                //     'container_class' => 'header__menu-wrap',
                //     'menu_class' => 'header__menu',
                //     'fallback_cb' => false,
                // ));
                ?>

                <nav class="header__menu-wrap">
                    <ul id="menu-header-menu" class="header__menu">
                        <?php foreach ($header_menu as $item): ?>
                            <li class="<?= isset($item->children) ? 'has-submenu menu-item-has-children' : '' ?> menu-item menu-item-type-post_type">
                                <?php render_menu_link($item); ?>

                                <?php if (isset($item->children)): ?>
                                    <ul class="sub-menu">
                                        <?php foreach ($item->children as $item): ?>
                                            <li class="<?= isset($item->children) ? 'has-submenu-child menu-item-has-children' : '' ?> menu-item menu-item-type-post_type">
                                                <?php render_menu_link($item); ?>

                                                <?php if (isset($item->children)): ?>
                                                    <ul class="sub-menu">
                                                        <?php foreach ($item->children as $item): ?>
                                                            <li class="<?= isset($item->children) ? 'has-submenu-child menu-item-has-children' : '' ?> menu-item menu-item-type-post_type">
                                                                <?php render_menu_link($item); ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endif; ?>

                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>

                        <?php
                        if (is_user_logged_in()):
                            $logout_url = wp_logout_url(home_url());
                            $current_user = wp_get_current_user();
                            $pages = get_posts(array(
                                'post_type'      => 'page',
                                'posts_per_page' => -1,
                                'post_status'    => 'publish',
                            ));
                            $pages = array_filter($pages, function ($page) use ($current_user) {
                                $page_permissions = get_post_meta($page->ID, '_members_access_role');
                                return arrays_have_common_element($current_user->roles, $page_permissions);
                            });
                        ?>
                            <?php if (!empty($pages)): ?>
                                <li class="has-submenu menu-item-has-children menu-item menu-item-type-post_type">
                                    <a href="#" target="_self" class=""> <?= $text_cabinet ?> </a>

                                    <ul class="sub-menu">
                                        <?php foreach ($pages as $page): ?>
                                            <li class="menu-item menu-item-type-post_type">
                                                <a href="<?= get_the_permalink($page->ID); ?>" target="_self" class="">🎵 <?= $page->post_title ?> </a>
                                            </li>
                                        <?php endforeach; ?>
                                        <li class="menu-item menu-item-type-post_type">
                                            <a href="<?= esc_url($logout_url) ?>" target="_self" class=""> <?= $text_exit ?> </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li class="menu-item menu-item-type-post_type">
                                    <a href="<?= esc_url($logout_url) ?>" target="_self" class=""> <?= $text_exit ?> </a>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="menu-item menu-item-type-post_type">
                                <a href="#" data-action="open-auth-popup" class=""> <?= $text_entrance ?> </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

                <div class="header__nav-mobile">
                    <button class="openMenu" aria-label="Open menu">
                        <span></span>
                    </button>
                </div>

                <div class="menu__popup">
                    <?php
                    // wp_nav_menu(array(
                    //     'theme_location' => 'headerMenuLocation',
                    //     'container' => 'nav',
                    //     'container_class' => 'menu__popup-wrap',
                    //     'menu_class' => 'menu__popup-mob',
                    //     'fallback_cb' => false,
                    // ));
                    ?>
                    <nav class="menu__popup-wrap">
                        <ul id="menu-header-menu" class="menu__popup-mob">
                            <?php foreach ($header_menu as $item): ?>
                                <li class="<?= isset($item->children) ? 'has-submenu menu-item-has-children' : '' ?> menu-item menu-item-type-post_type">
                                    <?php render_menu_link($item); ?>

                                    <?php if (isset($item->children)): ?>
                                        <ul class="sub-menu">
                                            <?php foreach ($item->children as $item): ?>
                                                <li class="<?= isset($item->children) ? 'has-submenu-child menu-item-has-children' : '' ?> menu-item menu-item-type-post_type">
                                                    <?php render_menu_link($item); ?>

                                                    <?php if (isset($item->children)): ?>
                                                        <ul class="sub-menu">
                                                            <?php foreach ($item->children as $item): ?>
                                                                <li class="<?= isset($item->children) ? 'has-submenu-child menu-item-has-children' : '' ?> menu-item menu-item-type-post_type">
                                                                    <?php render_menu_link($item); ?>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>

                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>

                            <?php
                            if (is_user_logged_in()):
                                $logout_url = wp_logout_url(home_url());
                                $current_user = wp_get_current_user();
                                $pages = get_posts(array(
                                    'post_type'      => 'page',
                                    'posts_per_page' => -1,
                                    'post_status'    => 'publish',
                                ));
                                $pages = array_filter($pages, function ($page) use ($current_user) {
                                    $page_permissions = get_post_meta($page->ID, '_members_access_role');
                                    return arrays_have_common_element($current_user->roles, $page_permissions);
                                });
                            ?>
                                <?php if (!empty($pages)): ?>
                                    <li class="has-submenu menu-item-has-children menu-item menu-item-type-post_type">
                                        <a href="#" target="_self" class=""> <?= $text_cabinet ?> </a>

                                        <ul class="sub-menu">
                                            <?php foreach ($pages as $page): ?>
                                                <li class="menu-item menu-item-type-post_type">
                                                    <a href="<?= get_the_permalink($page->ID); ?>" target="_self" class="">🎵 <?= $page->post_title ?> </a>
                                                </li>
                                            <?php endforeach; ?>
                                            <li class="menu-item menu-item-type-post_type">
                                                <a href="<?= esc_url($logout_url) ?>" target="_self" class=""> <?= $text_exit ?> </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php else: ?>
                                    <li class="menu-item menu-item-type-post_type">
                                        <a href="<?= esc_url($logout_url) ?>" target="_self" class=""> <?= $text_exit ?> </a>
                                    </li>
                                <?php endif; ?>
                            <?php else: ?>
                                <li class="menu-item menu-item-type-post_type">
                                    <a href="#" data-action="open-auth-popup" class=""> <?= $text_entrance ?> </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>

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
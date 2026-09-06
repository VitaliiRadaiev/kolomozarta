<?php
wp_enqueue_style('header_styles', get_theme_file_uri('dist/css/components/header.css'));

//Variables
$whatsapp = get_field('whatsapp', 'option');
$viber = get_field('viber', 'option');
$header_logo = get_field('header_logo', 'option');
$text_cabinet = get_field('text_cabinet', 'option');
$email = get_field('email', 'option');
$contact_button = get_field('sontact_button', 'option')['button'] ?? [];
$text_contact_us = get_field('text_contact_us', 'option');
?>

<!DOCTYPE html>
<html <?php language_attributes() ?>>

<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head() ?>

    <?php echo  get_field('analytics_scripts_before_head', 'options'); ?>
</head>

<body <?php body_class() ?>>

    <?php echo get_field('analytics_scripts_after_body', 'options'); ?>

    <?php
    $text_entrance = get_field('text_entrance', 'options');
    $text_exit = get_field('text_exit', 'options');
    $text_no_courses = get_field('text_no_courses', 'options');
    $menu_locations = get_nav_menu_locations();
    $menu_id = $menu_locations['headerMenuLocation'];
    $menu_items = wp_get_nav_menu_items($menu_id);
    $header_menu = build_menu_hierarchy($menu_items);
    ?>
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


                <?php if (check($whatsapp) || check($viber) || check($email) || check($contact_button['button_text'] ?? null)): ?>
                    <div class="header-contacts">
                        <button type="button" class="header-contacts__toggle" aria-expanded="false" aria-haspopup="true">
                            <?= $text_contact_us ?>
                        </button>

                        <div class="header-contacts__dropdown">
                            <ul class="header-contacts__list">
                                <?php if (check($whatsapp)): ?>
                                    <li>
                                        <a href="https://wa.me/<?= cleanPhoneNumber($whatsapp) ?>" target="_blank">
                                            <img src="<?= get_theme_file_uri() . '/dist/images/whatsapp.svg' ?>" alt="WhatsApp">
                                            <?= $whatsapp ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if (check($viber)): ?>
                                    <li>
                                        <a href="viber://chat?number=%2B<?= cleanPhoneNumber($viber) ?>" target="_blank">
                                            <img src="<?= get_theme_file_uri() . '/dist/images/viber.svg' ?>" alt="Viber">
                                            <?= $viber ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if (check($email)): ?>
                                    <li class="header-contacts__email">
                                        <a href="mailto:<?= antispambot($email) ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="15" viewBox="0 0 18 15" fill="currentColor" aria-hidden="true">
                                                <path d="M17.982 12.928c0 .434-.158.809-.474 1.125a1.537 1.537 0 0 1-1.125.475H1.6c-.434 0-.809-.158-1.125-.475A1.537 1.537 0 0 1 0 12.928V1.995C0 1.56.158 1.186.475.87A1.537 1.537 0 0 1 1.6.395h14.783c.433 0 .808.158 1.125.475.316.316.474.691.474 1.125v10.933Zm-1.6-11.25H1.6a.303.303 0 0 0-.22.097.303.303 0 0 0-.097.22c0 .574.132 1.104.396 1.59a3.95 3.95 0 0 0 1.08 1.257l2.013 1.591c.674.533 1.345 1.064 2.013 1.59.27.224.615.508 1.037.853.422.346.809.519 1.16.519H9c.352 0 .738-.173 1.16-.519.422-.345.768-.63 1.037-.852l2.013-1.59 2.013-1.592c.328-.246.656-.612.984-1.098.328-.487.492-.94.492-1.363 0-.129-.006-.278-.017-.448-.012-.17-.112-.255-.3-.255Zm.317 3.533a6.094 6.094 0 0 1-.703.668 264.93 264.93 0 0 0-2.144 1.67 97.422 97.422 0 0 0-2.127 1.723c-.375.316-.791.63-1.248.94-.457.31-.95.466-1.477.466h-.018a2.57 2.57 0 0 1-1.476-.466 15.03 15.03 0 0 1-1.248-.94A97.611 97.611 0 0 0 4.13 7.549a161.232 161.232 0 0 0-2.162-1.67 17.74 17.74 0 0 1-.352-.325 6.121 6.121 0 0 1-.334-.343v7.717c0 .082.032.155.097.22a.303.303 0 0 0 .22.097h14.783a.303.303 0 0 0 .22-.097.302.302 0 0 0 .096-.22V5.211Z" />
                                            </svg>
                                            <?= antispambot($email) ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>

                            <?php get_template_part(get_part_path('button'), null, [
                                'button_data' => $contact_button,
                                'classes'     => 'header-contacts__btn',
                            ]); ?>
                        </div>
                    </div>
                <?php endif; ?>

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
                                        <?php if (check($text_no_courses ?? null)): ?>
                                            <p>
                                                <?= $text_no_courses ?>
                                            </p>
                                        <?php endif; ?>
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
                                                <img src="<?= get_theme_file_uri() . '/dist/images/whatsapp.svg' ?>" alt="WhatsApp">
                                                <?= $whatsapp ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($viber): ?>
                                        <li>
                                            <a href="viber://chat?number=%2B<?= cleanPhoneNumber($viber) ?>" target="_blank">
                                                <img src="<?= get_theme_file_uri() . '/dist/images/viber.svg' ?>" alt="Viber">
                                                <?= $viber ?>
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
    <?php if(!is_front_page() && !is_404() && !is_search()):?>
        <div class="container">
            <div class="breadcrumbs">
                <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
            </div>
        </div>
    <?php endif;?>
    <main>
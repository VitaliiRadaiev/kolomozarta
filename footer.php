<!--Scripts and styles-->
<?php
wp_enqueue_style('footer_styles', get_theme_file_uri('dist/css/components/footer.css'));

//Variables

$footer_logo = get_field('footer_logo', 'option');
$footer_quote = get_field('footer_info_quote', 'option');
$footer_description = get_field('footer_info_description', 'option');
$footer_title = get_field('footer_info_heading', 'option');
$footer_copyright = get_field('copyright', 'option');
$text_auth = get_field('text_auth', 'option');
$text_privacy_policy = get_field('text_privacy_policy', 'option');

$menu_locations = get_nav_menu_locations();
$menu_id = $menu_locations['footerMenuLocation'];
$menu_items = wp_get_nav_menu_items($menu_id);
$footer_menu = build_menu_hierarchy($menu_items);
?>

</main>


<footer class="footer" id="footer">
    <!--    Footer Content-->
    <div class="container--fluid">
        <div class="footer__content">
            <div class="footer__head">
                <?php
                if ($footer_logo): ?>
                    <div class="footer__logo">
                        <a href="<?= site_url() ?>">
                            <img src="<?= $footer_logo['url'] ?>" alt="<?= $footer_logo['title'] ?>" width="100px">
                        </a>
                    </div>
                <?php endif; ?>
                
                <div class="footer__menu">
                    <?php foreach($footer_menu as $item):?>
                        <?php render_menu_link($item); ?>
                    <?php endforeach;?>
                </div>
            </div>

            <div class="footer__info">
                <?php
                if ($footer_quote): ?>
                    <p><strong><?= $footer_quote ?></strong></p>
                <?php endif; ?>

                <?php
                if ($footer_description): ?>
                    <p><?= $footer_description ?></p>
                <?php endif; ?>

                <?php
                if ($footer_title): ?>
                    <h3><?= $footer_title ?></h3>
                <?php endif; ?>


            </div>
        </div>
    </div>
    <!--    Footer Copyright-->
    <div class="footer__copyright">
        <div class="container">
            <div class="footer__copyright-wrap">
                <?php
                if ($footer_copyright): ?>
                    <p><?= $footer_copyright ?></p>
                <?php endif; ?>
                <?php if (have_rows('social_media', 'option')): ?>
                    <ul class="footer__social">
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
</footer>

<?php include get_template_directory() . '/templates/global-popups.php' ?>

<?php wp_footer(); ?>
</body>

</html>
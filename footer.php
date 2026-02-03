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

<div class="order__form-wrapper">
    <div class="order__form">
        <span class="order__form-title"></span>
        <span class="order__form-price"></span>

        <?= do_shortcode('[contact-form-7 id="d281f51" title="Контактна форма"]') ?>

        <script>
            const checkboxWrap = document.querySelector('.order__form .checkbox-wrap');
            if (checkboxWrap) {
                checkboxWrap.insertAdjacentHTML('beforeend', `
                <label class="checkbox">
                    <input data-checkbox-confirm type="checkbox" name="confirm-privacy-policy" autocomplete="off">
                    <div class="checkbox__label">
                        <?= $text_privacy_policy ?>
                    </div>
                </label>
            `);

                const checkboxConfirm = document.querySelector('[data-checkbox-confirm]');
                const submitBtn = document.querySelector('.order__form input[type="submit"]');
                checkboxConfirm.addEventListener('change', (e) => {
                    submitBtn.classList.toggle('can-submit', e.target.checked);
                });
            }
        </script>
    </div>
</div>

<div class="auth-popup">
    <div class="auth-popup__body">
        <div class="auth-popup__content">
            <button data-action="close-auth-popup">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </button>
            <div class="auth-popup__title h3">
                <?= $text_auth ?>
            </div>
            <div class="auth-popup__buttons-wrap">
                <?php echo do_shortcode('[google_login button_text="Google Login" force_display="yes" /]'); ?>
            </div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>

</html>
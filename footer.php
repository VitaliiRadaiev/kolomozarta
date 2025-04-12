<!--Scripts and styles-->
<?php
wp_enqueue_style('footer_styles', get_theme_file_uri('dist/css/components/footer.css'));

//Variables

$footer_logo = get_field('footer_logo', 'option');
$footer_quote = get_field('footer_info_quote', 'option');
$footer_description = get_field('footer_info_description', 'option');
$footer_title = get_field('footer_info_heading', 'option');
$footer_copyright = get_field('copyright', 'option');
?>


</main>


<footer class="footer" id="footer"> 
    <!--    Footer Content-->
    <div class="container--fluid">
        <div class="footer__content">
            <?php
            if ($footer_logo):?>
                <div class="footer__logo">
                    <a href="<?= site_url() ?>">
                        <img src="<?= $footer_logo['url'] ?>" alt="<?= $footer_logo['title'] ?>" width="100px">
                    </a>
                </div>
            <?php endif; ?>

            <div class="footer__info">
                <?php
                if ($footer_quote):?>
                    <p><strong><?= $footer_quote ?></strong></p>
                <?php endif; ?>

                <?php
                if ($footer_description):?>
                    <p><?= $footer_description ?></p>
                <?php endif; ?>

                <?php
                if ($footer_title):?>
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
                if ($footer_copyright):?>
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
    </div>
</div>

<?php wp_footer(); ?>
</body>

</html>
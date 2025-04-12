<?php

/*
Template Name: Login
*/
wp_enqueue_style('page_login_styles', get_theme_file_uri('dist/css/pages/page-login.css'));
get_header();

?>

    <section class="login">
        <div class="container">
            <div class="login__wrap">
                <div class="login__title">
                    <h1 class="page__title"><?= get_the_title() ?></h1>
                    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
                </div>
                <?php echo do_shortcode('[google_login button_text="Google Login" force_display="yes" /]'); ?>
                <?php /*
                <div class="login__form">
                    <form action="#">
                        <label for="email">
                            <input type="text" name="email" placeholder="Пошта">
                        </label>
                        <label for="password">
                            <input type="text" name="password" placeholder="Пароль">
                        </label>
                        <p>При реєстрації підтвердження буде надіслано на електронну пошту.</p>
                        <div class="login__form-buttons">
                            <button type="button">Зареєструватись</button>
                            <button type="button">Увійти</button>
                        </div>
                    </form>
                </div>
                */ ?>
            </div>
        </div>
    </section>


<?php
get_footer();

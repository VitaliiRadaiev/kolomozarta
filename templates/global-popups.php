<?php
wp_enqueue_style('popup_styles', get_theme_file_uri('./dist/css/libs/popup.css'));
wp_enqueue_style('popup-contact-us_styles', get_theme_file_uri('./dist/css/components/popup-contact-us.css'));

wp_enqueue_script('popup_js', get_theme_file_uri('./dist/js/libs/popup.js'), array('main_js'), null, false);


$popup_contact_us = get_field('popup_contact_us', 'option');
?>


<div class="order__form-wrapper">
    <div class="order__form">
        <span class="order__form-title"></span>
        <span class="order__form-price"></span>

        <?= do_shortcode('[contact-form-7 id="d281f51" title="Контактна форма"]') ?>
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


<div class="popup popup-contact-us" id="popup-contact-us">
    <div class="popup__body">
        <div class="popup__content popup-contact-us__content">
            <div class="popup-contact-us__inner order__form">
                <?php if (!empty($popup_contact_us['title'])): ?>
                    <div class="h2">
                        <?= $popup_contact_us['title'] ?>
                    </div>
                <?php endif; ?>

                <?= do_shortcode('[contact-form-7 id="d281f51" title="Контактна форма"]') ?>
            </div>
        </div>
    </div>
</div>

<div data-popup="add-right-padding" class="popup-contact-us-trigger-btn-wrap">
    <button data-action="open-popup" data-popup="#popup-contact-us" class="popup-contact-us-trigger-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
            <path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 0 0-1.032-.211 50.89 50.89 0 0 0-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 0 0 2.433 3.984L7.28 21.53A.75.75 0 0 1 6 21v-4.03a48.527 48.527 0 0 1-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979Z" />
            <path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 0 0 1.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0 0 15.75 7.5Z" />
        </svg>
    </button>
</div>

<script>
    const checkboxWraps = document.querySelectorAll('.order__form .checkbox-wrap');
    checkboxWraps.forEach(checkboxWrap => {
        if (checkboxWrap) {
            checkboxWrap.insertAdjacentHTML('beforeend', `
                    <label class="checkbox">
                        <input data-checkbox-confirm type="checkbox" name="confirm-privacy-policy" autocomplete="off">
                        <div class="checkbox__label">
                            <?= $text_privacy_policy ?>
                        </div>
                    </label>
                `);
            const form = checkboxWrap.closest('form');
            const checkboxConfirm = form.querySelector('[data-checkbox-confirm]');
            const submitBtn = form.querySelector('input[type="submit"]');
            checkboxConfirm.addEventListener('change', (e) => {
                submitBtn.classList.toggle('can-submit', e.target.checked);
            });
        }
    });
</script>
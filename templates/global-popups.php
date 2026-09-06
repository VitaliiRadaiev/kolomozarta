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

<div data-popup="add-right-padding" class="scroll-top-wrap">
    <button type="button" class="scroll-top" data-action="scroll-top" aria-label="Вгору">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M12 5V19M12 5L6 11M12 5L18 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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
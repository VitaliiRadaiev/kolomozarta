<?php

wp_enqueue_style('contacts_style', get_theme_file_uri() . '/dist/css/blocks/block_contacts.css');
global $data;

$contact_numbers = $data['contact_numbers'];
$contact_numbers_title = $contact_numbers['contact_numbers_title'];
$contact_numbers_subtitle = $contact_numbers['contact_numbers_subtitle'];
$whatsapp = get_field('whatsapp', 'option');
$viber = get_field('viber', 'option');
$social_contacts = $data['social_contacts'];
$contacts_social_title = $data['contacts_social_title'];
$contacts_img = $data['contacts_img'];
?>

<section class="contacts">
    <div class="container">
        <div data-aos="fade-up" class="contacts__wrap">
            <div class="contacts__info">
                <div class="contacts__info-numbers">
                    <?php if ($contact_numbers_title): ?>
                        <h2><?= $contact_numbers_title ?></h2>
                    <?php endif; ?>
                    <?php if ($contact_numbers_subtitle): ?>
                        <p><?= $contact_numbers_subtitle ?></p>
                    <?php endif; ?>
                    <ul>
                        <li>
                            <?php if ($viber): ?>
                                <a href="viber://chat?number=%2B<?= cleanPhoneNumber($viber) ?>" target="_blank">
                                    <img src="<?= get_theme_file_uri() . '/dist/images/viber.svg' ?>" alt="Viber">
                                    <?= $viber ?>(Viber)
                                </a>
                            <?php endif; ?>
                        </li>
                        <li>
                            <?php if ($whatsapp): ?>
                                <a href="https://wa.me/<?= cleanPhoneNumber($whatsapp) ?>" target="_blank">
                                    <img src="<?= get_theme_file_uri() . '/dist/images/whatsapp.svg' ?>"
                                         alt="WhatsApp">
                                    <?= $whatsapp ?>(WhatsApp)
                                </a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
                <div class="contacts__info-socials">
                    <?php if ($contacts_social_title): ?>
                        <h2><?= $contacts_social_title ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($social_contacts)): ?>
                        <ul>
                            <?php foreach ($social_contacts as $social_contact): ?>
                                <li>
                                    <a target="_blank"
                                       href="<?= $social_contact['link'] ?>"><img
                                                src="<?= $social_contact['icon']['url'] ?>" alt="Icon"></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
            <div class="contacts__image">
                <?php if ($contacts_img): ?>
                    <img src="<?= $contacts_img['url'] ?>" alt="Contacts">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
wp_enqueue_style('group_description_style', get_theme_file_uri() . '/dist/css/blocks/block_group_description.css');
global $data;

$group_desc_title = $data['group_desc_title'];
$group_desc_subtitle = $data['group_desc_subtitle'];
$group_desc_img = $data['group_desc_img']['sizes']['large'];
$group_desc_content = $data['group_desc_content'];
$group_desc_list_title = $data['group_desc_list_title'];
$group_desc_list = $data['group_desc_list'];
?>

<section class="group-description">
    <div class="container">
        <div data-aos="fade-up" class="group-description__wrap">
            <div class="group-description__img">
                <h2><?= $group_desc_title ?></h2>
                <p><?= $group_desc_subtitle ?></p>
                <img class="group-description__mask" src="<?= $group_desc_img ?>" alt="Image">
            </div>
            <div class="group-description__content text-content">
                <div><?= $group_desc_content ?></div>
                <h3><?= $group_desc_list_title ?></h3>

                <?php if (!empty($group_desc_list)): ?>
                    <ul class="group-description__list no-style">
                        <?php foreach ($group_desc_list as $item): ?>
                            <li class="group-description__item">
                                <img src="<?= $item['img']['sizes']['medium'] ?>" alt="Image">
                                <p><?= $item['text'] ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

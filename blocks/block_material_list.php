<?php
wp_enqueue_style('material_list_style', get_theme_file_uri() . '/dist/css/blocks/block_material_list.css');
global $data;
$material_title = $data['material_title'];
$material_list = $data['material_list'];

?>

<section class="material">
    <div class="container">
        <div class="material__wrap">
            <div data-aos="fade-up" class="material__title">
                <h2><?= $material_title ?></h2>
            </div>
            <?php if (!empty($material_title)): ?>
                <ul data-aos="fade-up" class="material__list">
                    <?php foreach ($material_list as $item): ?>
                        <li class="material__list-item">
                            <img src="<?= $item['img']['sizes']['large'] ?>" alt="Image">
                            <h3><?= $item['title'] ?></h3>
                            <img class="material__list-item-arrow" src="<?= get_template_directory_uri() . '/dist/images/wide-arrow-down.svg' ?>" alt="">
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>

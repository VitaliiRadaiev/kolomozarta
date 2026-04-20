<?php
wp_enqueue_style('material_description_style', get_theme_file_uri() . '/dist/css/blocks/block_material_description.css');
global $data;

$btn_details = get_field('btn_details', 'option');
$material_desc = $data['material_desc'];
?>
<section class="material-description">
    <div class="container">
        <?php if (!empty($material_desc)): ?>
            <div class="material-description__list">
                <?php foreach ($material_desc as $material):
                    $material_item_links = [];
                    $material_title = $material['title'];
                    $material_item = $material['material_item'];

                    foreach ($material_item as $item) {
                        if ($item['link']) {
                            $material_item_links[] = $item['link']['url'];
                        }
                    }
                ?>
                        <div class="material-description__item">
                            <div data-aos="fade-up" class="material-description__title">
                                <h2><?= $material_title ?></h2>
                            </div>
                            <?php if (!empty($material_item)): ?>
                                <?php foreach ($material_item as $item):
                                ?>
                                        <div data-aos="fade-up" class="material-description__video">
                                            <?php if ($item['material']): ?>
                                                <iframe width="560" height="315"
                                                    src="https://www.youtube.com/embed/<?= $item['material'] ?>"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen></iframe>
                                            <?php else: ?>
                                                <?php
                                                if ($item['image']) {
                                                    echo wp_get_attachment_image($item['image'], 'full');
                                                }
                                                ?>
                                            <?php endif; ?>
                                            <div class="material-description__text">
                                                <?= $item['info'] ?>
                                                <?php if ($item['link']): ?>
                                                    <a href="<?= $item['link']['url'] ?>"><?= $btn_details ?></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                <?php
                endforeach;
                ?>
            </div>
        <?php endif; ?>
    </div>
</section>
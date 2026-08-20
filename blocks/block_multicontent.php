<?php
global $data;

$left_col_size = (int) $data['columns_size'];
$right_col_size = 12 - $left_col_size;
$left_column = $data['left_column'];
$right_column = $data['right_column'];

function render_content($content)
{
    foreach ($content as $item):
?>

        <?php if ($item['acf_fc_layout'] == 'text'): ?>
            <div class="text-content">
                <?= add_inner_wrap_to_li($item['text']); ?>
            </div>
        <?php endif; ?>

        <?php if ($item['acf_fc_layout'] == 'price'): ?>
            <?php get_template_part(get_part_path('product-price'), null, [
                'product_price_data' => $item['product-price'] ?? [],
            ]) ?>
        <?php endif; ?>

        <?php if ($item['acf_fc_layout'] == 'buttons-group'): ?>
            <?php get_template_part(get_part_path('buttons-group'), null, [
                'buttons' => $item['buttons-group']
            ]) ?>
        <?php endif; ?>

        <?php if ($item['acf_fc_layout'] == 'image'): ?>
            <?php get_image($item['image_id'], 'content-img aspect-' . $item['ratio']); ?>
        <?php endif; ?>

        <?php if ($item['acf_fc_layout'] == 'youtube-video'): ?>
            <iframe width="560" height="315" class="aspect-<?= $item['ratio'] ?>" src="https://www.youtube.com/embed/<?= $item['id'] ?>"
                frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        <?php endif; ?>

        <?php if ($item['acf_fc_layout'] == 'video'): ?>
            <video class="aspect-<?= $item['ratio'] ?>" controls='true' type='video/mp4' preload="auto" poster="<?= $item['poster'] ?>" src='<?= $item['video_url'] ?>'></video>
        <?php endif; ?>
<?php
    endforeach;
}
?>

<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (is_admin() && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('block_multicontent_style', get_theme_file_uri('./dist/css/blocks/block_multicontent.css'));
?>

    <section <?= get_section_id($data) ?> class="multicontent <?= get_section_space_top($data) ?>">
        <div class="container multicontent__container">
            <?php get_template_part(get_part_path('title'), null, [
                'title_data' => $data['title']
            ]) ?>

            <div class="multicontent__grid">
                <?php if (!($left_col_size == 0)): ?>
                    <div style="--col-size: <?= $left_col_size ?>;" class="multicontent__col alignment-<?= $left_column['alignment'] ?>">
                        <?php render_content($left_column['content']); ?>
                    </div>
                <?php endif; ?>
                <?php if (!($right_col_size == 0)): ?>
                    <div style="--col-size: <?= $right_col_size ?>;" class="multicontent__col alignment-<?= $right_column['alignment'] ?>">
                        <?php render_content($right_column['content']); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
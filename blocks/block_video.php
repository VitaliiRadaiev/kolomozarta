<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (is_admin() && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('video_style', get_theme_file_uri() . '/dist/css/blocks/block_video.css');

    $video_title = $data['video_title'];
    $video_link = $data['video_link'];
?>
    <section <?= get_section_id($data) ?> class="video <?= get_section_space_top($data) ?>">
    <div class="container">
        <div class="video__wrap">
            <?php if ($video_title) : ?>
                <h2 data-aos="fade-up"><?= $video_title ?></h2>
            <?php endif; ?>
            <?php if ($video_link): ?>
                <iframe data-aos="fade-up" width="560" height="315" src="https://www.youtube.com/embed/<?= esc_attr($video_link); ?>"
                        frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

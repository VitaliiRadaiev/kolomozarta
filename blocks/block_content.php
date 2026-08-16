<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (is_admin() && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('content_style', get_theme_file_uri() . '/dist/css/blocks/block_content.css');
    $songs_info = $data['songs_info'];
?>
    <section <?= get_section_id($data) ?> class="content <?= get_section_space_top($data) ?>">
    <div data-aos="fade-up" class="container">
        <div class="content__wrap text-content">
            <?php if ($songs_info): ?>
                <?= add_inner_wrap_to_li($songs_info) ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

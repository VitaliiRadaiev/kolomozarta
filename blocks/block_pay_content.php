<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (!current_user_can('administrator') && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    $lesson_data = get_fields($data['video-lesson']->ID);
    $video_url = $lesson_data['videos_info']['lesson_video']['url'];
    echo do_shortcode('[presto_player id=467]');
?>
    <section <?= get_section_id($data) ?> class="reviews <?= get_section_space_top($data) ?>">
        <div class="container">
            <video style="width:100%;height:auto;" loop controls='true' type='video/mp4' preload="auto" src='<?= $video_url ?>'></video>
        </div>
    </section>
<?php endif; ?>
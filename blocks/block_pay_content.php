<?php
global $data;

$lesson_data = get_fields($data['video-lesson']->ID);
$video_url = $lesson_data['videos_info']['lesson_video']['url'];
echo do_shortcode('[presto_player id=467]');
?>
asndlkhbfkahjsdm

<section class="reviews">
    <div class="container">
        <video style="width:100%;height:auto;" loop controls='true' type='video/mp4' preload="auto" src='<?=$video_url?>'></video>
    </div>
</section>

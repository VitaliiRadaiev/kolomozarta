<?php
wp_enqueue_style('courses_style', get_theme_file_uri() . '/dist/css/blocks/block_courses.css');
global $data;

$text_more_details = get_field('text_more_details', 'option');
$text_load_more = get_field('text_load_more', 'option');
$interesting_list = $data['interesting_list'];
$chunk_size = 6;
?>

<section data-section="interesting" data-page-id="<?= get_the_ID() ?>" class="interesting">
    <div class="container">
        <div data-aos="fade-up" class="interesting__wrap">
            <?php if (!empty($interesting_list)): 
                $paged_items = array_slice($interesting_list, 0, $chunk_size);
                ?>
                <ul data-list class="interesting__list">
                    <?php foreach ($paged_items as $item): ?>
                        <li class="interesting__list-item">
                            <?php
                            $interesting_id = $item->ID;
                            $interesting_img_id = get_post_thumbnail_id($interesting_id);
                            $interesting_img = wp_get_attachment_image_url($interesting_img_id, 'medium');
                            $interesting_title = $item->post_title;
                            $interesting_permalink = get_field('interesting_link', $item->ID);
                            $interesting_content = $item->post_content;

                            if ($interesting_img): ?>
                                <img src="<?= esc_url($interesting_img); ?>" alt="<?= esc_attr($item->post_title); ?>">
                            <?php endif;

                            if ($interesting_title): ?>
                                <h3><?= $interesting_title ?></h3>
                            <?php endif;

                            if ($interesting_permalink): ?>
                                <a class="btn" href="<?= $interesting_permalink['url'] ?>" target="<?= $interesting_permalink['target'] ?>"><?= check($interesting_permalink['title']) ? $interesting_permalink['title'] : $text_more_details ?></a>
                            <?php endif;

                            if ($interesting_content): ?>
                                <p class="courses__list-description"><?= $interesting_content ?> </p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <?php if(count($interesting_list) > $chunk_size):?>
                    <div class="interesting__btn-wrap">
                        <button data-action="load-more" class="btn-default"><?= $text_load_more ?></button>
                    </div>
                <?php endif;?>
            <?php endif; ?>
        </div>
    </div>
</section>
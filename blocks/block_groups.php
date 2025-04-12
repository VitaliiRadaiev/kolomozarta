<?php

wp_enqueue_style('groups_style', get_theme_file_uri() . '/dist/css/blocks/block_groups.css');
global $data;

$groups_title = $data['groups_title'];
$groups_list = $data['groups_list'];

?>
<section class="groups">
    <div class="container">
        <div class="groups__wrap">
            <?php if ($groups_title): ?>
                <div class="groups__title">
                    <h2><?= $groups_title ?></h2>
                </div>
            <?php endif; ?>
            <?php if (!empty($groups_list)): ?>
                <ul class="groups__list">
                    <?php foreach ($groups_list as $group):
                        $group_title = $group['group_title'] ?? null;
                        $group_age = $group['group_age'] ?? null;
                        $group_img = $group['group_img']['sizes']['medium'] ?? null;
                        $group_video = $group['group_video'] ?? null;
                        ?>
                        <li class="groups__item">
                            <?php if ($group_img): ?>
                                <img src="<?= $group_img ?>" alt="Image">
                            <?php endif; ?>
                            <?php if ($group_title): ?>
                                <h3><?= $group_title ?></h3>
                            <?php endif; ?>
                            <?php if ($group_age): ?>
                                <span><?= $group_age ?></span>
                            <?php endif; ?>
                            <?php if ($group_video): ?>
                                <iframe width="560" height="315"
                                        src="https://www.youtube.com/embed/<?= esc_attr($group_video); ?>"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>

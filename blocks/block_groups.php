<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (!current_user_can('administrator') && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('groups_style', get_theme_file_uri() . '/dist/css/blocks/block_groups.css');

    $groups_title = $data['groups_title'];
    $groups_list = $data['groups_list'];
?>
    <section <?= get_section_id($data) ?> class="groups <?= get_section_space_top($data) ?>">
        <div class="container">
            <div class="groups__wrap">
                <?php if ($groups_title): ?>
                    <div data-aos="fade-up" class="groups__title">
                        <h2><?= $groups_title ?></h2>
                    </div>
                <?php endif; ?>
                <?php if (!empty($groups_list)): ?>
                    <ul data-aos="fade-up" class="groups__list">
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
<?php endif; ?>
<?php
global $data;
if (!$data['section_utils']['is_hide']):
    if (is_admin() && $data['section_utils']['is_hide_for_users']) {
        return;
    }

    wp_enqueue_style('double_list_style', get_theme_file_uri() . '/dist/css/blocks/block_double_list.css');

    $double_list_wrap = $data["double_list_wrap"];
?>
    <section <?= get_section_id($data) ?> class="double-list <?= get_section_space_top($data) ?>">
        <div class="container">
            <?php if (!empty($double_list_wrap)): ?>
                <div data-aos="fade-up" class="double-list__wrap">
                    <?php foreach ($double_list_wrap as $item):
                        $double_list = $item["double_list"];
                        $double_list_title = $item["double_list_title"];
                    ?>
                        <div class="double-list__item">
                            <?php if ($double_list_title): ?>
                                <h3><?= $double_list_title ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($double_list)): ?>
                                <ul>
                                    <?php foreach ($double_list as $list_item): ?>
                                        <li><?= $list_item['content'] ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
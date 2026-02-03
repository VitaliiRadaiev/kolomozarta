    <section data-videos class="videos">
        <div class="container">
            <?php
            if (!empty($lessons)) : ?>
                <ul class="videos__list">
                    <?php foreach ($lessons as $lesson):
                        $lesson_info = $lesson['videos_info'];
                        $lesson_num = $lesson_info["lesson_num"];
                        $lesson_accent = $lesson_info['accent'];
                        $lesson_title = $lesson_info["lesson_title"];
                        $lesson_desc = $lesson_info["lesson_desc"];
                        $lesson_add = $lesson['lesson_add'];
                        $lesson_add_desc = $lesson_add["desc"];
                        $lesson_add_video = $lesson_add;

                        $presto_player = $lesson_info['presto_player'];
                    ?>
                        <li class="videos__list-item accent-<?= !empty($lesson_accent) ? $lesson_accent : 'red' ?>">
                            <div class="videos__list-content">
                                <?php if ($presto_player->ID) : ?>
                                    <?= do_shortcode('[presto_player id="' . $presto_player->ID . '"]'); ?>
                                    <?= do_shortcode('[presto_player id="632"]'); ?>
                                <?php endif; ?>
                                <div class="videos__list-info">
                                    <?php if ($lesson_num): ?>
                                        <span>
                                            <i class="accent">
                                                <img src="<?= get_theme_file_uri() . '/dist/images/arrow.svg' ?>"
                                                    alt="Icon"></i>
                                            <?= $lesson_num ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($lesson_title): ?>
                                        <h2><?= $lesson_title ?></h2>
                                    <?php endif; ?>
                                    <?php if ($lesson_desc): ?>
                                        <div class="videos__list-desc">
                                            <?= $lesson_desc ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if (!empty($lesson_add)): ?>
                                <ul class="videos__list-additional">
                                    <?php foreach ($lesson_add as $lesson): ?>
                                        <li>
                                            <?php if ($lesson['desc']): ?>
                                                <div>
                                                    <i class="accent">
                                                        <img src="<?= get_theme_file_uri() . '/dist/images/note.svg' ?>"
                                                            alt="Icon"></i>
                                                    <p><?= cut_p_tags($lesson['desc']) ?></p>
                                                </div>
                                            <?php endif; ?>
                                            <?php
                                            $sub_presto_player = $lesson['presto_player'];
                                            if ($sub_presto_player):
                                            ?>
                                                <?php if ($sub_presto_player->ID) : ?>
                                                    <?= do_shortcode('[presto_player id="' . $sub_presto_player->ID . '"]'); ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php
            endif;
            ?>
        </div>
    </section>
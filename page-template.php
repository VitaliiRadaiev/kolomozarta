<?php

/*
Template Name: Шаблон сторінки
Template Post Type: page, courses, updates
*/

get_header();


while (have_posts()): the_post();

    $sections = get_field('sections');
//    var_dump($sections);
    if ($sections && is_array($sections)) {
        foreach ($sections as $sec_key => $section) {
            $sec_name = $section['acf_fc_layout'];
            global $data;
            $data = $section;
            $data['section_key'] = $sec_key;

            include get_template_directory() . '/blocks/' . $sec_name . '.php';
        }
    } else { ?>
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 20px">Сторінка пуста! Наповніть сторінку блоками.</h2>
        </div>
    <?php }

endwhile;


get_footer();
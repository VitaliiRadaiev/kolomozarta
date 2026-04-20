<?php
wp_enqueue_style('page_text_content_styles', get_theme_file_uri('dist/css/pages/page-text-content.css'));
/*
Template Name: Текстовий контент
*/
get_header(); ?> 

<article class="article">
    <div class="container">
        <div class="page__wrap">
            <h1 class="page__title">
                <?= the_title() ?>
            </h1>
        </div>
        <div class="article__text-content">
            <?php 
                $content = apply_filters('the_content', get_the_content());
                echo add_inner_wrap_to_li($content);
            ?>
        </div>
    </div>
</article>

<?php
get_footer();

<?php
global $data;

$page_title = $data['page_title'];


?>

<section class="page__hero">
    <div class="container">
        <div class="page__wrap">
            <h1 class="page__title">
                <?= $page_title ?>
            </h1>
            <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
        </div>

    </div>
</section>

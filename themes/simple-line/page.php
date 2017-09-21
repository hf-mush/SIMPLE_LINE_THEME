<?php
    get_header();
    if (have_posts()) :
        while (have_posts()) :
            the_post();
?>
<div class="content content__breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
    <?php if(function_exists('bcn_display')) bcn_display(); ?>
</div>
<article class="article g-article">
    <header class="header g-article__header">
        <h1 class="title g-article__header__title"><?php the_title(); ?></h1>
        <div class="text g-article__header__date"><?php the_time('Y.m.d'); ?></div>
    </header>
    <div class="inner g-article__inner">
        <?php
            the_content();
        ?>
    </div>
    <footer class="footer g-article__footer"></footer>
</article>
<?php
        endwhile;
    endif;

    echo get_template_part('parts/content/categories', 'list');
    echo get_template_part('parts/content/links', 'external');
    get_footer();
?>

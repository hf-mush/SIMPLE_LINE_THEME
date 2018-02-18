<?php
get_header();
?>
<div class="content content__breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
    <?php if(function_exists('bcn_display')) bcn_display(); ?>
</div>
<article class="article g-article">
    <header class="header g-article__header">
        <h1 class="title g-article__header__title">404 Not Found.</h1>
        <div class="text g-article__header__date">- - -</div>
    </header>
    <div class="inner g-article__inner">
      <p>The page is not exists.</p>
    </div>
    <footer class="footer g-article__footer">
        <div class="text text__meta">Posted by - - -</div>
    </footer>
</article>
<?php
echo get_template_part('parts/content/categories', 'list');
echo get_template_part('parts/content/links', 'external');
?>
<?php
get_footer();
?>

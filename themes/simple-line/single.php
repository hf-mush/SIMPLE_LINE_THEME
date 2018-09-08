<?php
  get_header();
  if (have_posts()) {
    while (have_posts()) {
      the_post();
      $image_url = get_the_post_thumbnail_url($post->ID, 'full');
?>
<div class="content content__breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
  <?php if (function_exists('bcn_display')) bcn_display(); ?>
</div>
<article class="article g-article">
  <div class="article__thumbnail" style="background-image:url('<?php echo $image_url; ?>');"></div>
  <header class="header g-article__header">
    <h1 class="title g-article__header__title"><?php the_title(); ?></h1>
    <?php echo get_template_part('parts/content/social', 'buttons'); ?>
  </header>
  <div class="inner g-article__inner">
    <?php the_content(); ?>
  </div>
  <footer class="footer g-article__footer">
    <div class="text text__meta">In <?php the_time('Y.m.d'); ?></div>
    <?php echo get_template_part('parts/content/social', 'buttons'); ?>
  </footer>
</article>
<?php
    }
  }
?>
<div class="content content__wrapper">
<?php
  echo get_template_part('parts/content/list', 'related');
  echo get_template_part('parts/content/list', 'latest');
?>
</div>
<?php
  echo get_template_part('parts/content/categories', 'list');
  echo get_template_part('parts/content/links', 'external');
  get_footer();
?>

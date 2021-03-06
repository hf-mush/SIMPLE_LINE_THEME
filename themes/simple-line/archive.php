<?php
  get_header();
?>
<div class="content--archives">
  <h1 class="title content__title">Archives : <?php single_cat_title(); ?></h1>
  <div class="list list--archives">
<?php
  if (have_posts()) {
    while (have_posts()) {
      the_post();
      $image_url = get_the_post_thumbnail_url($post->ID, 'full');
?>
    <section class="list__item">
      <div class="item__thumbnail" style="background-image:url('<?php echo $image_url; ?>');"><a class="thumbnail-link" href="<?php echo get_the_permalink(); ?>"></a></div>
      <div class="item__content">
        <h2 class="title content__item-title"><a class="link" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
        <div class="text content__item-extract"><?php echo mb_substr(get_the_excerpt(), 0, 100); ?></div>
        <p class="text content__item-date">Published <?php echo get_the_date('Y.m.d'); ?></p>
      </div>
    </section>
<?php
      }
    }
?>
  </div>
<?php 
  echo get_template_part('parts/content/archive', 'pager');
?>
</div>
<?php
  echo get_template_part('parts/content/categories', 'list');
  echo get_template_part('parts/content/links', 'external');
  get_footer();
?>

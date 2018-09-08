<?php
  get_header();
?>
<div class="content content--featured">
  <h2 class="title content__title">Featured Articles</h2>
<?php
  $count_posts = wp_count_posts();
  $published_posts = $count_posts->publish;
  if ($published_posts === 0) {
?>
  <ul class="list list--articles">
    <li class="list__item">
      <div class="item__thumbnail"><a class="link">No Img.</a></div>
      <div class="item__content">
        <div class="title content__item-title">Nothing Posts.</div>
        <div class="text content__item-extract">Not posted yet.</div>
        <div class="text content__item-date">Posted ...</div>
      </div>
    </li>
  </ul>
<?php
  } else {
    echo get_template_part('parts/content/list', 'front');
  }
?>
</div>
<?php
  echo get_template_part('parts/content/categories', 'list');
  echo get_template_part('parts/content/links', 'external');
  get_footer();
?>

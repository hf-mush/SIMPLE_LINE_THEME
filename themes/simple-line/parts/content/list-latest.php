<?php
  $args = array(
    'posts_per_page' => 5,
    'offset' => 0,
    'category_name' => '',
    'orderby' => 'date',
    'order' => 'DESC',
    'include' => '',
    'exclude' => $post_id,
    'meta_key' => '',
    'meta_value' => '',
    'post_type' => 'post',
    'post_mime_type' => '',
    'post_parent' => '',
    'author' => '',
    'post_status' => 'publish',
    'suppress_filters' => true 
  );
  $post_list = get_posts($args);
?>
<div class="content content--pasted">
  <div class="title content__title">Latest Posts</div>
  <ul class="list list--pasted">
<?php
  if (count($post_list) > 0) {
    foreach ($post_list as $posts) {
      setup_postdata($posts);
?>
    <li class="list__item">
      <div class="title"><a class="link" href="<?php echo get_the_permalink($posts->ID); ?>"><?php echo   $posts->post_title; ?></a></div>
      <div class="text"><?php echo get_the_date('Y.m.d', $posts->ID); ?></div>
    </li>
<?php
    }
    wp_reset_postdata();
  }
?>
  </ul>
</div>

<ul class="list list--articles">
<?php
  $args = array(
    'posts_per_page' => 5,
    'offset' => 0,
    'category' => '',
    'category_name' => '',
    'orderby' => 'date',
    'order' => 'DESC',
    'include' => '',
    'exclude' => '',
    'meta_key' => '',
    'meta_value' => '',
    'post_type' => 'post',
    'post_mime_type' => '',
    'post_parent' => '',
    'author' => '',
    'post_status' => 'publish',
    'suppress_filters' => true 
  );
  $data = get_posts($args);
  foreach ($data as $post) {
    setup_postdata($post);
    $image_url = get_the_post_thumbnail_url($post->ID, 'full');
?>
  <li class="list__item">
    <div class="item__thumbnail" style="background-image:url('<?php echo $image_url; ?>');"><a class="thumbnail-link" href="<?php echo get_the_permalink($post->ID); ?>"></a></div>
    <div class="item__content">
      <div class="title content__item-title"><a class="link" href="<?php echo get_the_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></div>
      <div class="text content__item-extract"><?php echo get_the_excerpt($post->ID); ?></div>
      <div class="text content__item-date"><?php echo get_the_time('Y.m.d', $post->ID) ?></div>
    </div>
  </li>
<?php
  }
?>
</ul>

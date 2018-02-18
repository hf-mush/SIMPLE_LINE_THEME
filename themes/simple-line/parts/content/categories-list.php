<?php
$cat_args = array(
    'type' => 'post',
    'child_of' => 0,
    'parent' => '',
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => 0,
    'hierarchical' => 1,
    'exclude' => '',
    'include' => '',
    'number' => '',
    'taxonomy' => 'category',
    'pad_counts' => false
);
$category = get_categories($cat_args);
?>
<div class="content content--category">
    <h2 class="title content__title">Featured Categories</h2>
    <ul class="list list--category">
        <?php for ($i = 0; $i < count($category); $i++) : ?>
        <li class="list__item"><a href="<?php echo get_category_link($category[$i]->term_id); ?>"><?php echo $category[$i]->cat_name; ?></a></li>
        <?php endfor; ?>
    </ul>
</div>
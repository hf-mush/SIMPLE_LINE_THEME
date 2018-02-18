<?php
get_header();
$category_array = [];
$post_id = '';
if (have_posts()) :
    while (have_posts()) :
        the_post();
        $post_id = get_the_ID();
        $category = get_the_category();
        for ($i = 0; $i < count($category); $i++) :
            array_push($category_array, $category[$i]->cat_ID);
        endfor;
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
    endwhile;
endif;
?>
<div class="content content__wrapper">
    <?php
    $category_ids = implode(',', $category_array);
    $args = array(
        'posts_per_page' => 5,
        'offset' => 0,
        'category' => $category_ids,
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
        <div class="title content__title">Related Articles</div>
        <ul class="list list--pasted">
            <?php
            if (count($post_list) > 0) :
                foreach ($post_list as $posts) :
                    setup_postdata($posts);
            ?>
            <li class="list__item">
                <div class="title"><a class="link" href="<?php echo get_the_permalink($posts->ID); ?>"><?php echo   $posts->post_title; ?></a></div>
                <div class="text"><?php echo get_the_date('Y.m.d', $posts->ID); ?></div>
            </li>
            <?php
                endforeach;
                wp_reset_postdata();
            endif;
            ?>
        </ul>
    </div>
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
            if (count($post_list) > 0) :
                foreach ($post_list as $posts) :
                    setup_postdata($posts);
            ?>
            <li class="list__item">
                <div class="title"><a class="link" href="<?php echo get_the_permalink($posts->ID); ?>"><?php echo   $posts->post_title; ?></a></div>
                <div class="text"><?php echo get_the_date('Y.m.d', $posts->ID); ?></div>
            </li>
            <?php
                endforeach;
                wp_reset_postdata();
            endif;
            ?>
        </ul>
    </div>
</div>
<?php
echo get_template_part('parts/content/categories', 'list');
echo get_template_part('parts/content/links', 'external');
get_footer();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
	<?php
		$description = '';
		$ogp_description = '';
		$ogp_title = '';
		$ogp_url = '';
		$ogp_type = '';
		$ogp_image = '';
		$favicon_path = get_template_directory_uri() . '/favicon';
		if (is_single() || is_page()) :
			if (have_posts()) :
				while(have_posts()) :
					the_post();
    				$searchPattern = '/<img.*?src=(["\'])(.+?)\1.*?>/i';
					$description = mb_substr(strip_tags(get_the_excerpt()), 0, 100) . '... | ' . get_bloginfo('name');
					$ogp_description = mb_substr(strip_tags(get_the_excerpt()), 0, 100) . '... | ' . get_bloginfo('name');
					if (has_post_thumbnail()) :
						$image = wp_get_attachment_image_src(get_post_thumbnail_id(), array(468, 468));
						$ogp_image = $image[0];
				    elseif (preg_match($searchPattern, $post->post_content, $imgurl) && !is_archive()) :
						$ogp_image = $imgurl[2];
					else :
						$ogp_image = get_template_directory_uri() . '/img/hiroshifujita.png';
					endif;
				endwhile;
			endif;
			$ogp_title = get_the_title() . ' | ' . get_bloginfo('name');
			$ogp_url = get_the_permalink();
			$ogp_type = 'article';
		elseif (is_front_page() || is_home()) :
			$description = get_bloginfo('description') . ' | ' . get_bloginfo('name');
			$ogp_description = get_bloginfo('description') . ' | ' . get_bloginfo('name');
			$ogp_title = get_bloginfo('name');
			$ogp_url = esc_url(home_url());
			$ogp_type = 'website';
			$ogp_image = get_template_directory_uri() . '/img/hiroshifujita.png';
		else :
			$description = 'Archive | ' . get_bloginfo('description') . ' | ' . get_bloginfo('name');
			$ogp_description = 'Archive | ' . get_bloginfo('description') . ' | ' . get_bloginfo('name');
			$ogp_title = get_bloginfo('name');
			$ogp_url = esc_url(home_url());
			$ogp_type = 'website';
			$ogp_image = get_template_directory_uri() . '/img/hiroshifujita.png';
		endif;
		if (is_home()) :
			$canonical_url = esc_url(home_url());
		elseif (is_category()) :
			$canonical_url = get_category_link(get_query_var('cat'));
		elseif (is_404()) :
			$canonical_url = esc_url(home_url()) . "/404";
		elseif (is_page() || is_single()) :
			$canonical_url = get_permalink();
		    if ($paged >= 2 || $page >= 2) :
				$canonical_url = $canonical_url.'page/' . max($paged, $page) . '/';
			endif;
		else : 
			$canonical_url = esc_url(home_url());
		endif;
	?>
	<meta charset="<?php echo get_bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="hiroshifujita,hiroshifujita.com,hiroshi,fujita">
	<meta name="description" content="<?php echo $description; ?>">
	<meta property="og:description" content="<?php echo $ogp_description; ?>">
	<meta property="og:title" content="<?php echo $ogp_title; ?>">
	<meta property="og:url" content="<?php echo $ogp_url; ?>">
	<meta property="og:type" content="<?php echo $ogp_type; ?>">
	<meta property="og:image" content="<?php echo $ogp_image; ?>">
	<meta property="og:locale" content="ja_JP">
	<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>">
	<meta property="fb:app_id" content="1775113936140086">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $favicon_path; ?>/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $favicon_path; ?>/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $favicon_path; ?>/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $favicon_path; ?>/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $favicon_path; ?>/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $favicon_path; ?>/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $favicon_path; ?>/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $favicon_path; ?>/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $favicon_path; ?>/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $favicon_path; ?>/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $favicon_path; ?>/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $favicon_path; ?>/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $favicon_path; ?>/favicon-16x16.png">
	<link rel="manifest" href="<?php echo $favicon_path; ?>/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo $favicon_path; ?>/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<link rel="alternate" type="application/rss+xml" title="RSSフィード" href="<?php echo get_bloginfo('rss2_url'); ?>">
	<link rel="alternate" type="application/rss+xml" title="RSSフィード" href="<?php echo get_bloginfo('atom_url'); ?>">
	<link rel="alternate" media="handheld" href="<?php echo esc_url(home_url()); ?>">
	<link rel="canonical" href="<?php echo $canonical_url; ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php echo get_bloginfo('pingback_url'); ?>">
	<?php
		if (is_singular()) wp_enqueue_script('comment-reply');
		wp_head();
	?>
  </head>
  <body>
	<?php
		echo get_template_part('parts/social/google', 'script');
		echo get_template_part('parts/social/facebook', 'script');
		echo get_template_part('parts/social/twitter', 'script');
		echo get_template_part('parts/social/hatena', 'script');
		echo get_template_part('parts/social/line', 'script');
	?>
    <header class="outer g-header">
      <div class="inner g-header__inner">
        <h1 class="title g-header__title"><a class="link" href="<?php echo esc_url(home_url()); ?>"><?php echo get_bloginfo('name'); ?></a></h1>
		<div class="text g-header__description"><span><?php echo get_bloginfo('description'); ?></span></div>
      </div>
    </header>
    <div class="outer g-container">
      <div class="inner g-container__inner">
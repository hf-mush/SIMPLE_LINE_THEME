<!DOCTYPE html>
<html lang="ja">
<?php
	$description = '';
	$ogp_description = '';
	$ogp_title = '';
	$ogp_url = '';
	$ogp_type = '';
	$ogp_image = '';
	$favicon_path = get_template_directory_uri().'/favicon';
	if (is_single() || is_page()) :
		if (have_posts()) :
			while(have_posts()) :
				the_post();
    			$searchPattern = '/<img.*?src=(["\'])(.+?)\1.*?>/i';
				$description = mb_substr(strip_tags(get_the_excerpt()), 0, 100).'... | '.get_bloginfo('name');
				$ogp_description = mb_substr(strip_tags(get_the_excerpt()), 0, 100).'... | '.get_bloginfo('name');
				if (has_post_thumbnail()) :
					$image = wp_get_attachment_image_src(get_post_thumbnail_id(), array(468, 468));
					$ogp_image = $image[0];
			    elseif (preg_match($searchPattern, $post->post_content, $imgurl) && !is_archive()) :
					$ogp_image = $imgurl[2];
				else :
					$ogp_image = get_template_directory_uri().'/img/hiroshifujita.jpg';
				endif;
			endwhile;
		endif;
		$ogp_title = get_the_title().' | '.get_bloginfo('name');
		$ogp_url = get_the_permalink();
		$ogp_type = 'article';
	elseif (is_front_page() || is_home()) :
		$description = get_bloginfo('description').' | '.get_bloginfo('name');
		$ogp_type = 'website';
		$ogp_title = get_bloginfo('name');
		$ogp_url = esc_url(home_url());
		$ogp_description = get_bloginfo('description').' | '.get_bloginfo('name');
		$ogp_image = get_template_directory_uri().'/img/hiroshifujita.jpg';
	else :
		$description = 'Archive | '.get_bloginfo('description').' | '.get_bloginfo('name');
		$ogp_type = 'website';
		$ogp_title = get_bloginfo('name');
		$ogp_url = esc_url(home_url());
		$ogp_description = 'Archive | '.get_bloginfo('description').' | '.get_bloginfo('name');
		$ogp_image = get_template_directory_uri().'/img/hiroshifujita.jpg';
	endif;
	if (is_home()) :
		$canonical_url = esc_url(home_url());
	elseif (is_category()) :
		$canonical_url = get_category_link(get_query_var('cat'));
	elseif (is_404()) :
		$canonical_url = esc_url(home_url())."/404";
	elseif (is_page() || is_single()) :
		$canonical_url = get_permalink();
	    if ($paged >= 2 || $page >= 2) :
			$canonical_url = $canonical_url.'page/'.max($paged, $page) . '/';
		endif;
	else : 
		$canonical_url = esc_url(home_url());
	endif;
	$theme_info = wp_get_theme();
?>
  <head>
		<!-- version <?php echo $theme_info->get('Version'); ?> -->
		<meta charset="<?php echo get_bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="keywords" content="hiroshi blog,hiroshifujita,hiroshifujita.com,hiroshi,blog,fujita">
		<meta name="description" content="<?php echo $description; ?>">
		<meta property="og:description" content="<?php echo $ogp_description; ?>">
		<meta property="og:title" content="<?php echo $ogp_title; ?>">
		<meta property="og:url" content="<?php echo $ogp_url; ?>">
		<meta property="og:type" content="<?php echo $ogp_type; ?>">
		<meta property="og:image" content="<?php echo $ogp_image; ?>">
		<meta property="og:locale" content="ja_JP">
		<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>">
		<meta property="fb:app_id" content="<?php echo FB_APP_ID ?>">
		<meta name="google-site-verification" content="<?php echo GOOGLE_SITE_IDENTITY ?>">
		<meta name="msapplication-TileColor" content="#437cb5">
		<meta name="msapplication-TileImage" content="<?php echo $favicon_path; ?>/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
<?php
	$appleSize = [57,60,72,76,114,120,144,152,180];
	for ($i = 0; $i < count($appleSize); $i++) {
		$size = $appleSize[$i];
		$suffix = "${size}x${size}"
?>
		<link rel="apple-touch-icon" type="image/png" sizes="<?php echo $suffix; ?>" href="<?php echo $favicon_path; ?>/apple-icon-<?php echo $suffix; ?>.png">
<?php
	}
	$androidSize = [192];
	for ($i = 0; $i < count($androidSize); $i++) {
		$size = $androidSize[$i];
		$suffix = "${size}x${size}"
?>
		<link rel="icon" type="image/png" sizes="<?php echo $suffix; ?>"  href="<?php echo $favicon_path; ?>/android-icon-<?php echo $suffix; ?>.png">
<?php
	}
	$faviconSize = [16,32,96];
	for ($i = 0; $i < count($faviconSize); $i++) {
		$size = $faviconSize[$i];
		$suffix = "${size}x${size}"
?>
		<link rel="icon" type="image/png" sizes="<?php echo $suffix; ?>" href="<?php echo $favicon_path; ?>/favicon-<?php echo $suffix; ?>.png">
<?php
	}
?>
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $favicon_path; ?>/apple-touch-icon.png">
		<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#437cb5">
		<link rel="manifest" href="<?php echo $favicon_path; ?>/site.webmanifest">
		<link rel="alternate" type="application/rss+xml" title="RSSフィード" href="<?php echo get_bloginfo('rss2_url'); ?>">
		<link rel="alternate" type="application/rss+xml" title="RSSフィード" href="<?php echo get_bloginfo('atom_url'); ?>">
		<link rel="alternate" media="handheld" href="<?php echo esc_url(home_url()); ?>">
		<link rel="canonical" href="<?php echo $canonical_url; ?>">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php echo get_bloginfo('pingback_url'); ?>">
<?php
	if (is_singular()) {
		wp_enqueue_script('comment-reply');
	}
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
<?php
set_include_path(get_include_path().PATH_SEPARATOR.dirname(__FILE__));
include_once 'config/defines.php';

add_theme_support('post-thumbnails', array('post', 'page'));
add_theme_support('menus');
add_theme_support('automatic-feed-links');
add_theme_support('custom-header', array());
add_theme_support('custom-background', array());

function setup_theme_title() {
  add_theme_support('title-tag');
}

add_action('after_setup_theme', 'setup_theme_title');
if (!isset($content_width)) $content_width = 1024;
function wp_theme_version() {
  $theme = wp_get_theme();
  return $theme->get('Version');
}

if (!is_admin()) :
  function custom_site_enqueue_resource() {
    wp_dequeue_script('jquery');
    wp_dequeue_script('jquery-ui-core');
    // wp_register_script('bundle', get_template_directory_uri() . '/js/bundle.js', array(), false, false);
    // wp_enqueue_script('bundle', get_template_directory_uri() . '/js/bundle.js', array(), wp_theme_version());
    wp_register_style('style', get_stylesheet_uri(), array(), false);
    wp_enqueue_style('style', get_stylesheet_uri(), array(), wp_theme_version());
  }
  add_action('wp_enqueue_scripts', 'custom_site_enqueue_resource');
endif;

function custom_widgets_init() {
  if (function_exists('register_sidebar')) :
    register_sidebar(
      array(
        'name' => 'prime-sidebar',
        'id' => 'sidebar-prime',
        'description' => 'MAIN SIDEBAR',
        'before_widget' => '<div class="sidebar__widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="sidebar__header title__sidebar">',
        'after_title' => '</h2>'
      )
    );
  endif;
}
add_action('widgets_init', 'custom_widgets_init');

function custom_login_logo() {
  echo '<style type="text/css">h1 a { background: none no-repeat center center !important; }</style>';
}
add_action('login_head', 'custom_login_logo');

function new_excerpt_mblength($length) {
  return 100;
}
add_filter('excerpt_mblength', 'new_excerpt_mblength');

function new_excerpt_more($more) {
  return '...';
}	
add_filter('excerpt_more', 'new_excerpt_more');
?>

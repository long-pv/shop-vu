<?php

/**
 * dev_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package dev_theme
 */

if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dev_theme_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on dev_theme, use a find and replace
		* to change 'dev_theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('dev_theme', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'dev_theme'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'dev_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dev_theme_content_width()
{
	$GLOBALS['content_width'] = apply_filters('dev_theme_content_width', 640);
}
add_action('after_setup_theme', 'dev_theme_content_width', 0);

// xóa các menu k cần thiết trong Appearance
function remove_appearance_menus()
{
	// Xóa "Theme File Editor"
	remove_submenu_page('themes.php', 'theme-editor.php');

	// Xóa "patterns"
	remove_submenu_page('themes.php', 'site-editor.php?path=/patterns');

	// xóa tool chỉnh sửa mặc định trong plugins
	remove_submenu_page('plugins.php', 'plugin-editor.php');
}
add_action('admin_menu', 'remove_appearance_menus', 999);

/**
 * Enqueue scripts and styles.
 */
function dev_theme_scripts()
{
	// style gốc style.css
	wp_enqueue_style('dev_theme-style', get_stylesheet_uri(), array(), _S_VERSION);

	// bootstrap js
	wp_enqueue_script('dev_theme-script-bootstrap_bundle', get_template_directory_uri() . '/assets/inc/bootstrap/bootstrap.bundle.min.js', array('jquery'), _S_VERSION, true);

	// matchHeight
	wp_enqueue_script('dev_theme-script-matchHeight', get_template_directory_uri() . '/assets/inc/matchHeight/jquery.matchHeight.js', array('jquery'), _S_VERSION, true);

	// slick
	wp_enqueue_style('dev_theme-style-slick-theme', get_template_directory_uri() . '/assets/inc/slick/slick-theme.css', array(), _S_VERSION);
	wp_enqueue_style('dev_theme-style-slick', get_template_directory_uri() . '/assets/inc/slick/slick.css', array(), _S_VERSION);
	wp_enqueue_script('dev_theme-script-slick', get_template_directory_uri() . '/assets/inc/slick/slick.min.js', array('jquery'), _S_VERSION, true);

	//add custom main css/js
	$main_css_file_path = get_template_directory() . '/assets/css/main.css';
	$main_js_file_path = get_template_directory() . '/assets/js/main.js';
	$ver_main_css = file_exists($main_css_file_path) ? filemtime($main_css_file_path) : '1.0.0';
	$ver_main_js = file_exists($main_js_file_path) ? filemtime($main_js_file_path) : '1.0.0';
	wp_enqueue_style('dev_theme-style-main', get_template_directory_uri() . '/assets/css/main.css', array(), $ver_main_css);
	wp_enqueue_script('dev_theme-script-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $ver_main_js, true);

	// ajax admin
	wp_localize_script('dev_theme-script-main', 'custom_ajax', array('ajax_url' => admin_url('admin-ajax.php')));

	// sử dụng cho hiển thị comment
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'dev_theme_scripts');

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}

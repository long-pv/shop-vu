<?php

/**
 * dev_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package dev_theme
 */

if (!defined('_S_VERSION')) {
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
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
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
require get_template_directory() . '/inc/breadcrumbs.php';
// like_post
require get_template_directory() . '/inc/like_post.php';

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// The function "write_log" is used to write debug logs to a file in PHP.
function write_log($log = null, $title = 'Debug')
{
	if ($log) {
		if (is_array($log) || is_object($log)) {
			$log = print_r($log, true);
		}

		$timestamp = date('Y-m-d H:i:s');
		$text = '[' . $timestamp . '] : ' . $title . ' - Log: ' . $log . "\n";
		$log_file = WP_CONTENT_DIR . '/debug.log';
		$file_handle = fopen($log_file, 'a');
		fwrite($file_handle, $text);
		fclose($file_handle);
	}
}

// Tạo menu theme settings chung
// Setup theme setting page
if (function_exists('acf_add_options_page')) {
	// Trang cài đặt chính
	acf_add_options_page(array(
		'page_title' => 'Theme Settings',
		'menu_title' => 'Theme Settings',
		'menu_slug'  => 'theme-settings',
		'capability' => 'edit_posts',
		'redirect'   => false,
		'position'   => 80
	));

	// Submenu: General Settings
	acf_add_options_sub_page(array(
		'page_title'  => 'General Settings',
		'menu_title'  => 'General Settings',
		'parent_slug' => 'theme-settings',
		'menu_slug'   => 'general-settings',
		'capability'  => 'edit_posts'
	));

	// Submenu: Insert code
	acf_add_options_sub_page(array(
		'page_title'  => 'Insert code settings',
		'menu_title'  => 'Insert code settings',
		'parent_slug' => 'theme-settings',
		'menu_slug'   => 'insert-code-settings',
		'capability'  => 'edit_posts'
	));
}
// end

// auto active plugins
function activate_my_plugins()
{
	$plugins = [
		'advanced-custom-fields-pro\acf.php',
	];

	foreach ($plugins as $plugin) {
		$plugin_path = WP_PLUGIN_DIR . '/' . $plugin;

		if (file_exists($plugin_path) && !is_plugin_active($plugin)) {
			activate_plugin($plugin);
		}
	}
}
add_action('admin_init', 'activate_my_plugins');

// stop upgrading ACF pro plugin
add_filter('site_transient_update_plugins', 'disable_plugins_update');
function disable_plugins_update($value)
{
	// disable acf pro
	if (isset($value->response['advanced-custom-fields-pro/acf.php'])) {
		unset($value->response['advanced-custom-fields-pro/acf.php']);
	}
	return $value;
}

// general settings
// Hide notification in admin
function remove_plugin_notices()
{
	$turn_off_admin_notifications = get_field('turn_off_admin_notifications', 'option') ?? false;
	if ($turn_off_admin_notifications) {
		global $wp_filter;
		if (isset($wp_filter['admin_notices'])) {
			unset($wp_filter['admin_notices']);
		}
		if (isset($wp_filter['all_admin_notices'])) {
			unset($wp_filter['all_admin_notices']);
		}
	}
}
add_action('admin_init', 'remove_plugin_notices');

// Hide comment menu
function remove_comments_admin_menu()
{
	$hide_comment_function = get_field('hide_comment_function', 'option') ?? false;
	if ($hide_comment_function) {
		remove_menu_page('edit-comments.php');
	}
}
add_action('admin_menu', 'remove_comments_admin_menu');
function remove_comments_admin_bar($wp_admin_bar)
{
	$hide_comment_function = get_field('hide_comment_function', 'option') ?? false;
	if ($hide_comment_function) {
		$wp_admin_bar->remove_node('comments');
	}
}
add_action('admin_bar_menu', 'remove_comments_admin_bar', 999);

// Chèn code vào <head>
function insert_custom_code_into_header()
{
	if (!is_admin()) {
		$custom_code = get_field('insert_code_header', 'option');
		if (!empty($custom_code)) {
			echo $custom_code;
		}
	}
}
add_action('wp_head', 'insert_custom_code_into_header', 99);

// Chèn code ngay sau thẻ <body>
function insert_custom_code_into_body()
{
	if (!is_admin()) {
		$custom_code = get_field('insert_code_body', 'option');
		if (!empty($custom_code)) {
			echo $custom_code;
		}
	}
}
add_action('wp_body_open', 'insert_custom_code_into_body', 99);

// Chèn code vào footer trước </body>
function insert_custom_code_into_footer()
{
	if (!is_admin()) {
		$custom_code = get_field('insert_code_footer', 'option');
		if (!empty($custom_code)) {
			echo $custom_code;
		}
	}
}
add_action('wp_footer', 'insert_custom_code_into_footer', 99);

// tắt chức năng tự cập nhật
function disable_auto_update_if_enabled()
{
	$disable_auto_update = get_field('disable_auto_update', 'option');
	if ($disable_auto_update) {
		define('AUTOMATIC_UPDATER_DISABLED', true);
		define('WP_AUTO_UPDATE_CORE', false);
		define('DISALLOW_FILE_MODS', true);
		define('DISALLOW_FILE_EDIT', true);
		add_filter('auto_update_plugin', '__return_false');
	}
}
add_action('init', 'disable_auto_update_if_enabled');

function custom_upload_size_limit($bytes)
{
	$upload_limit = get_field('upload_size_limit', 'option') ?? 2;
	return $upload_limit * 1024 * 1024;
}
add_filter('upload_size_limit', 'custom_upload_size_limit');
// end general settings

// remove wp_version
function remove_wp_version_strings($src)
{
	global $wp_version;
	$query_string = parse_url($src, PHP_URL_QUERY);
	if ($query_string) {
		parse_str($query_string, $query);
		if (!empty($query['ver']) && $query['ver'] === $wp_version) {
			$src = remove_query_arg('ver', $src);
		}
	}
	return $src;
}
add_filter('script_loader_src', 'remove_wp_version_strings');
add_filter('style_loader_src', 'remove_wp_version_strings');
function remove_version_wp()
{
	return '';
}
add_filter('the_generator', 'remove_version_wp');
// end remove wp_version

// hide default logo on login page
function custom_login_logo()
{
	echo '<style type="text/css">#login h1 a {display: none !important;}</style>';
}
add_action('login_head', 'custom_login_logo');

// validate tiêu đề các bài viết
add_action('admin_footer', 'validate_title_post_admin');
function validate_title_post_admin()
{
?>
	<script>
		jQuery(document).ready(function($) {
			// Validate post title
			if ($('#post').length > 0) {
				$('#post').submit(function() {
					var title_post = $('#title').val();
					if (title_post.trim() === '') {
						alert('Please enter "Title".');
						$('#title').focus();
						return false;
					}
				});
			}
		});
	</script>
<?php
}

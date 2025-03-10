<?php

/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package dev_theme
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function dev_theme_woocommerce_setup()
{
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'dev_theme_woocommerce_setup');

// inc function
require get_template_directory() . '/inc/woo/product_card.php';
require get_template_directory() . '/inc/woo/filter_sidebar.php';
require get_template_directory() . '/inc/woo/related_products.php';
require get_template_directory() . '/inc/woo/breadcrumb.php';
require get_template_directory() . '/inc/woo/single_container.php';
require get_template_directory() . '/inc/woo/checkout_city_vietnam.php';
require get_template_directory() . '/inc/woo/checkout_terms_checkbox.php';
require get_template_directory() . '/inc/woo/checkout_change_field.php';
require get_template_directory() . '/inc/woo/myaccount_info.php';
require get_template_directory() . '/inc/woo/myaccount_sidebar.php';
require get_template_directory() . '/inc/woo/myaccount_vouchers.php';
require get_template_directory() . '/inc/woo/myaccount_address.php';

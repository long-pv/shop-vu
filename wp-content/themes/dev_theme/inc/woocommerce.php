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

function get_product_card_html($product_id = null)
{
	if (!$product_id) {
		$product_id = get_the_ID();
	}

	$product = wc_get_product($product_id);
	if (!$product) return '';

	ob_start(); ?>
	<article class="product_item" data-mh="product_item">
		<a href="<?php echo get_permalink($product_id); ?>" class="product_item_img_block" aria-label="<?php echo get_the_title($product_id); ?>">
			<?php echo get_the_post_thumbnail($product_id, 'full', ['class' => 'product_item_thumbnail']); ?>
		</a>
		<div class="product_item_content">
			<?php if ($product->is_on_sale()) {
				$regular_price = $product->get_regular_price();
				$sale_price = $product->get_sale_price();
				if ($regular_price > 0) {
					$discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
			?>
					<div class="product_item_sale_noti">Sale <?php echo $discount_percentage; ?>%</div>
			<?php
				}
			}
			?>

			<h3 class="product_item_title" data-mh="product_item_title">
				<a class="product_item_title_link" href="<?php echo get_permalink($product_id); ?>">
					<?php echo get_the_title($product_id); ?>
				</a>
			</h3>
			<div class="product_item_price">
				<?php
				$price_html = $product->get_price_html();
				if ($price_html) {
				?>
					<span class="product_item_price_text">
						<?php echo $price_html; ?>
					</span>
				<?php
				}
				?>
			</div>
			<div class="product_item_add_to_cart">
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</div>
		</div>
	</article>
<?php
	return ob_get_clean();
}

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

// card từng sản phẩm
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
// end

// sidebar filter
function woo_filter_sidebar()
{
?>
	<div class="woo_filter_sidebar">
		<h2 class="woo_filter_title">Lọc Sản Phẩm</h2>

		<form method="GET" class="woo_filter_form">
			<input type="hidden" name="orderby" value="<?php echo !empty($_GET['orderby']) ? $_GET['orderby'] : '' ?>">

			<!-- nhập tên sản phẩm -->
			<?php
			$title_search = !empty($_GET['title']) ?: '';
			?>
			<div class="woo_filter_item">
				<div class="woo_filter_item_title">
					Tìm kiếm tên sản phẩm
				</div>
				<input type="text" name="title" class="woo_filter_input_text" placeholder="Nhập tên sản phẩm" value="<?php echo $title_search; ?>">
			</div>

			<!-- hiển thị category -->
			<?php
			if (is_post_type_archive('product')) {
				$product_cat = !empty($_GET['product_cat']) ?: '';
			?>
				<div class="woo_filter_item">
					<div class="woo_filter_item_title">
						Danh mục sản phẩm
					</div>

					<div class="woo_filter_list_checkbox">
						<label class="woo_filter_label_checkbox" for="cat_all">
							<input type="radio" id="cat_all" name="product_cat" class="woo_filter_input_radio" value="" <?php checked(empty($product_cat)); ?>>
							Tất cả danh mục
						</label>
						<?php
						$categories = get_terms(array(
							'taxonomy' => 'product_cat',
							'hide_empty' => true,
						));
						foreach ($categories as $category) {
							$slug = $category->slug;
							$name = $category->name;
						?>
							<label class="woo_filter_label_checkbox" for="cat_<?php echo $slug; ?>">
								<input type="radio" id="cat_<?php echo $slug; ?>" name="product_cat" value="<?php echo $slug; ?>" <?php checked($product_cat == $slug); ?>>
								<?php echo $name; ?>
							</label>
						<?php
						};
						?>
					</div>
				</div>
			<?php
			};
			?>

			<!-- hiển thị tags -->
			<?php
			$selected_tags = !empty($_GET['product_tags']) ? $_GET['product_tags'] : [];
			$tags = get_terms([
				'taxonomy' => 'product_tag',
				'hide_empty' => false,
			]);

			if (!empty($tags)):
			?>
				<div class="woo_filter_item">
					<div class="woo_filter_item_title">
						Chọn tags
					</div>
					<div class="woo_filter_list_checkbox">
						<?php
						foreach ($tags as $tag):
							$tag_id = $tag->term_id;
							$checked = in_array($tag_id, $selected_tags) ? 'checked' : '';
							$name = $tag->name ?? '';
						?>
							<label class="woo_filter_label_checkbox" for="<?php echo $tag_id; ?>">
								<input type="checkbox" name="product_tags[]" id="<?php echo $tag_id; ?>" value="<?php echo $tag_id; ?>" <?php echo $checked; ?>>
								<?php echo $name; ?>
							</label>
							<br>
						<?php
						endforeach;
						?>
					</div>
				</div>
			<?php
			endif;
			?>

			<!-- Lấy danh sách các thuộc tính -->
			<?php
			$selected_attributes = !empty($_GET['product_attributes']) ? $_GET['product_attributes'] : [];
			$attributes = wc_get_attribute_taxonomies();

			if (!empty($attributes)) {
			?>
				<div class="woo_filter_item">
					<div class="woo_filter_item_title">
						Chọn thuộc tính
					</div>
					<?php foreach ($attributes as $attribute) {
						$terms = get_terms([
							'taxonomy' => 'pa_' . $attribute->attribute_name,
							'hide_empty' => false,
						]);

						if (!empty($terms)) {
					?>
							<div class="woo_filter_list_attr">
								<div class="woo_filter_subtitle">
									<?php echo $attribute->attribute_label; ?>
								</div>
								<div class="woo_filter_list_checkbox">
									<?php foreach ($terms as $term) {
										$term_id = $term->term_id;
										$checked = in_array($term_id, $selected_attributes) ? 'checked' : '';
										$name = $term->name ?? '';
									?>
										<label class="woo_filter_label_checkbox" for="attribute_<?php echo $term_id; ?>">
											<input type="checkbox" name="product_attributes[]" id="attribute_<?php echo $term_id; ?>" value="<?php echo $term_id; ?>" <?php echo $checked; ?>>
											<?php echo $name; ?>
										</label>
										<br>
									<?php
									}
									?>
								</div>
							</div>
					<?php
						}
					}
					?>
				</div>
			<?php
			} ?>

			<!-- các button action -->
			<div class="woo_filter_item">
				<button type="submit" class="woo_filter_button">
					Áp dụng bộ lọc
				</button>
				<?php
				$reset_url = esc_url(
					remove_query_arg([
						'paging',
						'title',
						'product_cat',
						'min_price',
						'max_price',
						'product_tags',
						'orderby',
						'product_attributes',
					])
				);
				?>
				<a href="<?php echo $reset_url; ?>" class="woo_filter_button">
					Reset bộ lọc
				</a>
			</div>
		</form>
	</div>
	<?php
}
// end

// xóa bài viết liên quan mặc định trong woo và tạo mới chúng theo ý muốn
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
function custom_related_products_section()
{
	global $product;

	if (!$product) return;

	// Lấy danh mục của sản phẩm hiện tại
	$terms = wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'ids'));

	if (empty($terms)) return;

	// Query sản phẩm cùng danh mục
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => 4, // Hiển thị 4 sản phẩm
		'post__not_in'   => array($product->get_id()), // Loại bỏ sản phẩm hiện tại
		'tax_query'      => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'id',
				'terms'    => $terms,
			),
		),
	);

	$related_products = new WP_Query($args);

	if ($related_products->have_posts()) {
	?>
		<div class="pt-5">
			<h2>Sản phẩm liên quan</h2>
			<div class="row">
				<?php
				while ($related_products->have_posts()) {
					$related_products->the_post();
					global $product;
				?>
					<div class="col-lg-3">
						<?php echo get_product_card_html(); ?>
					</div>
				<?php
				}
				?>
			</div>
		</div>
	<?php
	}
	wp_reset_postdata();
}
add_action('woocommerce_after_single_product_summary', 'custom_related_products_section', 20);
// end

// hook thêm div container bootstrap cho trang woo
function add_container_start_single_product()
{
	echo '<div class="py-section">';
	echo '<div class="container">';
}
add_action('woocommerce_before_main_content', 'add_container_start_single_product', 1);
function add_container_end_single_product()
{
	echo '</div>';
	echo '</div>';
}
add_action('woocommerce_after_main_content', 'add_container_end_single_product', 99);
// end

// xóa breadcrumb mặc định của Woo và thay thế bằng function tự code
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
function custom_breadcrumb_woo()
{
	if (is_product()) {
		wp_breadcrumbs();
	}
}
add_action('woocommerce_before_main_content', 'custom_breadcrumb_woo', 20);
// end

// thêm row col cho phần hình ảnh và thông tin sản phẩm
// function add_bootstrap_row_start()
// {
// 	echo '<div class="row">';
// }
// add_action('woocommerce_before_single_product_summary', 'add_bootstrap_row_start', 0);
// function add_bootstrap_col_image_start()
// {
// 	echo '<div class="col-lg-6">';
// }
// add_action('woocommerce_before_single_product_summary', 'add_bootstrap_col_image_start', 5);
// function add_bootstrap_col_image_end()
// {
// 	echo '</div>'; // Đóng col-lg-6 cho ảnh
// }
// add_action('woocommerce_before_single_product_summary', 'add_bootstrap_col_image_end', 25);
// function add_bootstrap_col_summary_start()
// {
// 	echo '<div class="col-lg-6">';
// }
// add_action('woocommerce_before_single_product_summary', 'add_bootstrap_col_summary_start', 30);
// function add_bootstrap_col_summary_end()
// {
// 	echo '</div>'; // Đóng col-lg-6 cho nội dung
// }
// add_action('woocommerce_after_single_product_summary', 'add_bootstrap_col_summary_end', 5);
// function add_bootstrap_row_end()
// {
// 	echo '</div>'; // Đóng row
// }
// add_action('woocommerce_after_single_product_summary', 'add_bootstrap_row_end', 10);
// end

// hook thêm điều kiện cho việc tính phí shipping
add_action('woocommerce_cart_calculate_fees', 'custom_shipping_fee_based_on_location', 99);
function custom_shipping_fee_based_on_location($cart_object)
{
	// tránh bị tấn công
	if (is_admin() && !defined('DOING_AJAX')) {
		return;
	}

	// Lấy thông tin địa chỉ khách hàng
	$customer_country   = WC()->customer->get_billing_country();  // Quốc gia
	$customer_city      = WC()->customer->get_billing_city();     // Tỉnh/Thành phố
	$customer_district  = WC()->customer->get_billing_address_1(); // Quận/Huyện
	$customer_ward      = WC()->customer->get_billing_address_2(); // Phường/Xã (chưa dùng, nhưng có thể mở rộng)

	// Nếu khách không ở Việt Nam => phí ship 200$
	if ($customer_country != 'VN') {
		$cart_object->add_fee(__('Phí vận chuyển quốc tế', 'woocommerce'), 200, false);
		return; // Không kiểm tra tiếp các điều kiện khác
	}

	// Danh sách quận trung tâm của Hà Nội
	$hn_central_districts = ['Quận Ba Đình', 'Quận Hoàn Kiếm'];

	// Mặc định phí ship
	$shipping_fee = 10; // Các tỉnh thành khác: 10$


	if ($customer_city == 'Thành phố Hà Nội') {
		$shipping_fee = 5; // Mặc định phí ship nội thành

		// Phí thấp hơn nếu ở quận trung tâm
		if (in_array($customer_district, $hn_central_districts)) {
			$shipping_fee = 3;
		}

		// Nếu khách ở Trung tâm và "Phường Hàng Mã" => Free ship
		if ($customer_district == "Quận Hoàn Kiếm" && $customer_ward == 'Phường Hàng Mã') {
			$cart_object->add_fee(__('Miễn phí vận chuyển', 'woocommerce'), 0, false);
			return;
		}
	}

	// Áp dụng phí vào giỏ hàng
	$cart_object->add_fee(__('Phí vận chuyển', 'woocommerce'), $shipping_fee, false);
}
// end

// lựa chọn tỉnh thành/quận huyện ở Việt Nam ở trang checkout để tính ship
function select_province_and_district_vietnam_checkout()
{
	if (is_checkout()) {
	?>
		<script>
			jQuery(document).ready(function($) {
				// Tìm các ô input mặc định của WooCommerce
				var cityInput = $("#billing_city");
				var districtInput = $("#billing_address_1");
				var wardInput = $("#billing_address_2");

				// Thay thế input bằng select
				cityInput.replaceWith('<select name="billing_city" id="billing_city" class="select2"><option value="">Chọn tỉnh/thành</option></select>');
				districtInput.replaceWith('<select name="billing_address_1" id="billing_address_1" class="select2"><option value="">Chọn quận/huyện</option></select>');
				wardInput.replaceWith('<select name="billing_address_2" id="billing_address_2" class="select2"><option value="">Chọn phường/xã</option></select>');

				// Gán lại biến sau khi thay thế
				var citis = $("#billing_city");
				var districts = $("#billing_address_1");
				var wards = $("#billing_address_2");

				// Áp dụng Select2 để giao diện đẹp hơn
				citis.select2();
				districts.select2();
				wards.select2();

				<?php
				// Đường dẫn file JSON trong theme
				$json_path = get_template_directory() . '/inc/json/city_vn.json';
				$json_data = file_get_contents($json_path);
				?>
				var data_city = <?php echo $json_data; ?>;
				renderCity(data_city);

				function renderCity(data) {
					citis.empty().append('<option value="">Chọn tỉnh/thành</option>');
					districts.empty().append('<option value="">Chọn quận/huyện</option>');
					wards.empty().append('<option value="">Chọn phường/xã</option>');

					$.each(data, function(index, item) {
						citis.append($('<option>', {
							value: item.Name,
							text: item.Name,
							'data-id': item.Id
						}));
					});

					citis.change(function() {
						var cityID = $(this).find(':selected').data("id");
						districts.empty().append('<option value="">Chọn quận/huyện</option>');
						wards.empty().append('<option value="">Chọn phường/xã</option>');

						if (cityID) {
							var selectedCity = data.find(n => n.Id == cityID);
							$.each(selectedCity.Districts, function(index, item) {
								districts.append($('<option>', {
									value: item.Name,
									text: item.Name,
									'data-id': item.Id
								}));
							});
						}
						districts.trigger('change'); // Cập nhật select2
					});

					districts.change(function() {
						var districtID = $(this).find(':selected').data("id");
						wards.empty().append('<option value="">Chọn phường/xã</option>');

						if (districtID) {
							var cityID = citis.find(':selected').data("id");
							var selectedCity = data.find(n => n.Id == cityID);
							var selectedDistrict = selectedCity.Districts.find(n => n.Id == districtID);

							$.each(selectedDistrict.Wards, function(index, item) {
								wards.append($('<option>', {
									value: item.Name,
									text: item.Name
								}));
							});
						}
						wards.trigger('change'); // Cập nhật select2
					});
				}
			});
		</script>
	<?php
	}
}
add_action('wp_footer', 'select_province_and_district_vietnam_checkout', 99);
// end

// hiển thị duy nhất 1 quốc gia
add_filter('woocommerce_countries', 'custom_allowed_countries', 99);
function custom_allowed_countries($countries)
{
	return array(
		'VN' => __('Việt Nam', 'woocommerce'), // Việt Nam
	);
}
// end

// Trường billing_address_2 thay đổi thành bắt buộc và có thêm label
add_filter('woocommerce_checkout_fields', 'customize_billing_address_2', 999);
function customize_billing_address_2($fields)
{
	// khai báo text label và trạng thái required
	if (!empty($fields['billing']['billing_address_2'])) {
		$fields['billing']['billing_address_2'] = array(
			'label'       => __('Ward / Commune', 'woocommerce'),
			'required'    => true,
		);
	}
	return $fields;
}
// end

// Thêm checkbox đồng ý điều khoản trước khi đặt hàng
add_action('woocommerce_review_order_before_submit', 'custom_add_terms_checkbox', 99);
function custom_add_terms_checkbox()
{
	?>
	<p class="form-row validate-required" id="custom_terms_field" data-priority="90">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
			<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox" name="custom_terms_checkbox" id="custom_terms_checkbox">
			<span>Tôi đồng ý với <a href="#" target="_blank">điều khoản</a>.</span>
		</label>
	</p>
<?php
}
add_action('woocommerce_checkout_process', 'custom_validate_terms_checkbox', 99);
function custom_validate_terms_checkbox()
{
	if (!isset($_POST['custom_terms_checkbox'])) {
		wc_add_notice(__('<strong>Điều khoản</strong> là một trường bắt buộc.', 'woocommerce'), 'error', array('id' => 'custom_terms_field'));
	}
}
// end
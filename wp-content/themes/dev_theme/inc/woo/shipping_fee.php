<?php
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
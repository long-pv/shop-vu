<?php
// xóa field trong checkout
add_filter('woocommerce_checkout_fields', function ($fields) {
    unset($fields['billing']['billing_postcode']); // Xóa Postcode trong phần Billing
    unset($fields['shipping']['shipping_postcode']); // Xóa Postcode trong phần Shipping
    return $fields;
});

// đưa field điện thoại thành bắt buộc
add_filter('woocommerce_checkout_fields', function ($fields) {
    $fields['billing']['billing_phone']['required'] = true; // Bắt buộc nhập số điện thoại
    return $fields;
});

<?php
add_filter('woocommerce_account_menu_items', function ($items) {
    // Đổi tên tab
    $items['dashboard']  = 'Trang chủ'; // Dashboard -> Trang chủ
    $items['orders']     = 'Đơn hàng của tôi'; // Orders -> Đơn hàng của tôi
    $items['downloads']  = 'Tải xuống của tôi'; // Downloads -> Tải xuống của tôi
    $items['edit-address'] = 'Địa chỉ'; // Addresses -> Địa chỉ
    $items['edit-account'] = 'Tài khoản'; // Account details -> Tài khoản
    $items['customer-logout'] = 'Đăng xuất'; // Logout -> Đăng xuất

    // Thay đổi thứ tự
    return [
        'dashboard'        => $items['dashboard'],
        'orders'           => $items['orders'],
        'edit-account'     => $items['edit-account'],
        'edit-address'     => $items['edit-address'],
        'downloads'        => $items['downloads'],
        'customer-logout'  => $items['customer-logout'],
    ];
});

add_filter('woocommerce_account_menu_items', function ($items) {
    unset($items['downloads']); // Xóa tab downloads
    unset($items['dashboard']); // Xóa tab dashboard
    return $items;
}, 99);

// luôn đi tới trang order khi vào my account
add_action('template_redirect', function () {
    if (is_account_page() && !is_wc_endpoint_url()) {
        $current_url = $_SERVER['REQUEST_URI'];
        // Kiểm tra nếu URL có chứa "vouchers" thì không redirect
        if (strpos($current_url, '/vouchers') === false) {
            wp_safe_redirect(wc_get_endpoint_url('orders', '', wc_get_page_permalink('myaccount')));
            exit;
        }
    }
});

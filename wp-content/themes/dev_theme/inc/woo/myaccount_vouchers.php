<?php
// Thêm tab Vouchers vào trước "Đăng xuất" 
// cách 2: có thểm thêm ở myaccount_sidebar.php
add_filter('woocommerce_account_menu_items', function ($items) {
    $items = array_slice($items, 0, -1, true)
        + ['vouchers' => 'Vouchers']
        + array_slice($items, -1, 1, true);
    return $items;
}, 99);

// khai báo url - cần vào setting để lưu lại Permalink
add_action('init', function () {
    add_rewrite_endpoint('vouchers', EP_ROOT | EP_PAGES);
});

// Custom giao diện
add_action('woocommerce_account_vouchers_endpoint', function () {
    echo '<h2>Vouchers của bạn</h2>';

    // Fake danh sách voucher
    $vouchers = [
        ['code' => 'DISCOUNT10', 'amount' => '10%', 'expiry' => '2025-12-31'],
        ['code' => 'FREESHIP50', 'amount' => 'Free Ship', 'expiry' => '2025-06-30'],
        ['code' => 'VIPSALE2025', 'amount' => '20%', 'expiry' => '2025-11-15'],
    ];

    if (!empty($vouchers)) {
        echo '<table style="width:100%; border-collapse: collapse; text-align: left;">
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px;">Mã Voucher</th>
                    <th style="border: 1px solid #ddd; padding: 8px;">Giá Trị</th>
                    <th style="border: 1px solid #ddd; padding: 8px;">Hạn sử dụng</th>
                </tr>';

        foreach ($vouchers as $voucher) {
            echo '<tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($voucher['code']) . '</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($voucher['amount']) . '</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($voucher['expiry']) . '</td>
                  </tr>';
        }

        echo '</table>';
    } else {
        echo '<p>Bạn chưa có voucher nào.</p>';
    }
});

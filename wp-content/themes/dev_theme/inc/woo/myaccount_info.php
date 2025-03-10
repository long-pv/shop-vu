<?php
remove_action('woocommerce_account_edit-account_endpoint', 'woocommerce_account_edit_account');
add_action('woocommerce_account_edit-account_endpoint', function () {
    if (!is_user_logged_in()) {
        wp_safe_redirect(wc_get_page_permalink('myaccount'));
        exit;
    }

    $user = wp_get_current_user();
?>

    <h2>Cập nhật tài khoản của bạn</h2>

    <form id="edit-account-form">
        <p>
            <label for="custom_first_name">Họ</label>
            <input type="text" name="custom_first_name" id="custom_first_name" value="<?php echo esc_attr($user->first_name); ?>" required>
        </p>

        <p>
            <label for="custom_last_name">Tên</label>
            <input type="text" name="custom_last_name" id="custom_last_name" value="<?php echo esc_attr($user->last_name); ?>" required>
        </p>

        <p>
            <label for="custom_email">Email</label>
            <input type="email" name="custom_email" id="custom_email" value="<?php echo esc_attr($user->user_email); ?>" required>
        </p>

        <p>
            <button type="submit">Lưu thay đổi</button>
        </p>

        <p id="edit-account-message"></p> <!-- Chỗ hiển thị thông báo -->
    </form>
<?php
});

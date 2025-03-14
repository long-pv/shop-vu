<?php
remove_action('woocommerce_account_edit-address_endpoint', 'woocommerce_account_edit_address');
add_action('woocommerce_account_edit-address_endpoint', function () {
    $user_id = get_current_user_id();
    $billing_address_1 = get_user_meta($user_id, 'billing_address_1', true);
    $billing_address_2 = get_user_meta($user_id, 'billing_address_2', true);
    $billing_city = get_user_meta($user_id, 'billing_city', true);
?>

    <h2>Cập nhật địa chỉ của bạn</h2>

    <form id="edit-address-form">
        <p>
            <label for="billing_city">Thành phố</label>
            <input type="text" name="billing_city" id="billing_city" value="<?php echo esc_attr($billing_city); ?>" required>
        </p>

        <p>
            <label for="billing_address_1">Quận/Huyện</label>
            <input type="text" name="billing_address_1" id="billing_address_1" value="<?php echo esc_attr($billing_address_1); ?>" required>
        </p>

        <p>
            <label for="billing_address_2">Xã/Phường</label>
            <input type="text" name="billing_address_2" id="billing_address_2" value="<?php echo esc_attr($billing_address_2); ?>">
        </p>

        <p>
            <button type="submit">Lưu thay đổi</button>
        </p>

        <p id="edit-address-message"></p> <!-- Chỗ hiển thị thông báo -->
    </form>

<?php
});

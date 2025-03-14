<?php
remove_action('woocommerce_account_edit-account_endpoint', 'woocommerce_account_edit_account');
add_action('woocommerce_account_edit-account_endpoint', function () {
    $user = wp_get_current_user();
?>

    <h2>Cập nhật tài khoản của bạn</h2>

    <form id="custom-my-account-form">
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

function update_custom_account()
{
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Bạn cần đăng nhập để thực hiện thao tác này.']);
    }

    $user_id = get_current_user_id();
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);

    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Email không hợp lệ.']);
    }

    wp_update_user([
        'ID' => $user_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'user_email' => $email
    ]);

    wp_send_json_success(['message' => 'Cập nhật thành công!']);
}
add_action('wp_ajax_update_custom_account', 'update_custom_account');
add_action('wp_ajax_nopriv_update_custom_account', 'update_custom_account');

add_action('wp_footer', function () {
?>
    <script>
        jQuery(document).ready(function($) {
            $('#custom-my-account-form').on('submit', function(e) {
                e.preventDefault();

                var first_name = $('#custom_first_name').val();
                var last_name = $('#custom_last_name').val();
                var email = $('#custom_email').val();

                $.ajax({
                    type: 'POST',
                    url: custom_ajax.ajax_url,
                    data: {
                        action: 'update_custom_account',
                        first_name: first_name,
                        last_name: last_name,
                        email: email,
                    },
                    beforeSend: function() {
                        $('#edit-account-message').text('Đang xử lý...');
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#edit-account-message').html('<span style="color:green;">' + response.data.message + '</span>');
                        } else {
                            $('#edit-account-message').html('<span style="color:red;">' + response.data.message + '</span>');
                        }
                    }
                });
            });
        });
    </script>
<?php
}, 99);

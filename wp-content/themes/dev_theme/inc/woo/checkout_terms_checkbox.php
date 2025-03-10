<?php
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
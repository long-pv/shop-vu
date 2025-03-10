<?php
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
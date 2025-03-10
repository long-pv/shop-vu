<?php
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
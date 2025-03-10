<?php
// xóa bài viết liên quan mặc định trong woo và tạo mới chúng theo ý muốn
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
function custom_related_products_section()
{
    global $product;

    if (!$product) return;

    // Lấy danh mục của sản phẩm hiện tại
    $terms = wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'ids'));

    if (empty($terms)) return;

    // Query sản phẩm cùng danh mục
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 4, // Hiển thị 4 sản phẩm
        'post__not_in'   => array($product->get_id()), // Loại bỏ sản phẩm hiện tại
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'id',
                'terms'    => $terms,
            ),
        ),
    );

    $related_products = new WP_Query($args);

    if ($related_products->have_posts()) {
?>
        <div class="pt-5">
            <h2>Sản phẩm liên quan</h2>
            <div class="row">
                <?php
                while ($related_products->have_posts()) {
                    $related_products->the_post();
                    global $product;
                ?>
                    <div class="col-lg-3">
                        <?php echo get_product_card_html(); ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
<?php
    }
    wp_reset_postdata();
}
add_action('woocommerce_after_single_product_summary', 'custom_related_products_section', 20);
// end
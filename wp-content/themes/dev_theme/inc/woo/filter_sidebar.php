<?php
function woo_filter_sidebar()
{
?>
    <div class="woo_filter_sidebar">
        <h2 class="woo_filter_title">Lọc Sản Phẩm</h2>

        <form method="GET" class="woo_filter_form">
            <input type="hidden" name="orderby" value="<?php echo !empty($_GET['orderby']) ? $_GET['orderby'] : '' ?>">

            <!-- nhập tên sản phẩm -->
            <?php
            $title_search = !empty($_GET['title']) ?: '';
            ?>
            <div class="woo_filter_item">
                <div class="woo_filter_item_title">
                    Tìm kiếm tên sản phẩm
                </div>
                <input type="text" name="title" class="woo_filter_input_text" placeholder="Nhập tên sản phẩm" value="<?php echo $title_search; ?>">
            </div>

            <!-- hiển thị category -->
            <?php
            if (is_post_type_archive('product')) {
                $product_cat = !empty($_GET['product_cat']) ?: '';
            ?>
                <div class="woo_filter_item">
                    <div class="woo_filter_item_title">
                        Danh mục sản phẩm
                    </div>

                    <div class="woo_filter_list_checkbox">
                        <label class="woo_filter_label_checkbox" for="cat_all">
                            <input type="radio" id="cat_all" name="product_cat" class="woo_filter_input_radio" value="" <?php checked(empty($product_cat)); ?>>
                            Tất cả danh mục
                        </label>
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'product_cat',
                            'hide_empty' => true,
                        ));
                        foreach ($categories as $category) {
                            $slug = $category->slug;
                            $name = $category->name;
                        ?>
                            <label class="woo_filter_label_checkbox" for="cat_<?php echo $slug; ?>">
                                <input type="radio" id="cat_<?php echo $slug; ?>" name="product_cat" value="<?php echo $slug; ?>" <?php checked($product_cat == $slug); ?>>
                                <?php echo $name; ?>
                            </label>
                        <?php
                        };
                        ?>
                    </div>
                </div>
            <?php
            };
            ?>

            <!-- hiển thị tags -->
            <?php
            $selected_tags = !empty($_GET['product_tags']) ? $_GET['product_tags'] : [];
            $tags = get_terms([
                'taxonomy' => 'product_tag',
                'hide_empty' => false,
            ]);

            if (!empty($tags)):
            ?>
                <div class="woo_filter_item">
                    <div class="woo_filter_item_title">
                        Chọn tags
                    </div>
                    <div class="woo_filter_list_checkbox">
                        <?php
                        foreach ($tags as $tag):
                            $tag_id = $tag->term_id;
                            $checked = in_array($tag_id, $selected_tags) ? 'checked' : '';
                            $name = $tag->name ?? '';
                        ?>
                            <label class="woo_filter_label_checkbox" for="<?php echo $tag_id; ?>">
                                <input type="checkbox" name="product_tags[]" id="<?php echo $tag_id; ?>" value="<?php echo $tag_id; ?>" <?php echo $checked; ?>>
                                <?php echo $name; ?>
                            </label>
                            <br>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            <?php
            endif;
            ?>

            <!-- Lấy danh sách các thuộc tính -->
            <?php
            $selected_attributes = !empty($_GET['product_attributes']) ? $_GET['product_attributes'] : [];
            $attributes = wc_get_attribute_taxonomies();

            if (!empty($attributes)) {
            ?>
                <div class="woo_filter_item">
                    <div class="woo_filter_item_title">
                        Chọn thuộc tính
                    </div>
                    <?php foreach ($attributes as $attribute) {
                        $terms = get_terms([
                            'taxonomy' => 'pa_' . $attribute->attribute_name,
                            'hide_empty' => false,
                        ]);

                        if (!empty($terms)) {
                    ?>
                            <div class="woo_filter_list_attr">
                                <div class="woo_filter_subtitle">
                                    <?php echo $attribute->attribute_label; ?>
                                </div>
                                <div class="woo_filter_list_checkbox">
                                    <?php foreach ($terms as $term) {
                                        $term_id = $term->term_id;
                                        $checked = in_array($term_id, $selected_attributes) ? 'checked' : '';
                                        $name = $term->name ?? '';
                                    ?>
                                        <label class="woo_filter_label_checkbox" for="attribute_<?php echo $term_id; ?>">
                                            <input type="checkbox" name="product_attributes[]" id="attribute_<?php echo $term_id; ?>" value="<?php echo $term_id; ?>" <?php echo $checked; ?>>
                                            <?php echo $name; ?>
                                        </label>
                                        <br>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            <?php
            } ?>

            <!-- các button action -->
            <div class="woo_filter_item">
                <button type="submit" class="woo_filter_button">
                    Áp dụng bộ lọc
                </button>
                <?php
                $reset_url = esc_url(
                    remove_query_arg([
                        'paging',
                        'title',
                        'product_cat',
                        'min_price',
                        'max_price',
                        'product_tags',
                        'orderby',
                        'product_attributes',
                    ])
                );
                ?>
                <a href="<?php echo $reset_url; ?>" class="woo_filter_button">
                    Reset bộ lọc
                </a>
            </div>
        </form>
    </div>
<?php
}

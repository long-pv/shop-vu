<?php
// lựa chọn tỉnh thành/quận huyện ở Việt Nam ở trang checkout để tính ship
function select_province_and_district_vietnam_checkout()
{
    if (is_checkout()) {
?>
        <script>
            jQuery(document).ready(function($) {
                // Tìm các ô input mặc định của WooCommerce
                var cityInput = $("#billing_city");
                var districtInput = $("#billing_address_1");
                var wardInput = $("#billing_address_2");

                // lấy giá trị của input
                var cityValue = $("#billing_city").val();
                var districtValue = $("#billing_address_1").val();
                var wardValue = $("#billing_address_2").val();

                // Thay thế input bằng select
                cityInput.replaceWith('<select name="billing_city" id="billing_city" class="select2"><option value="">Chọn tỉnh/thành</option></select>');
                districtInput.replaceWith('<select name="billing_address_1" id="billing_address_1" class="select2"><option value="">Chọn quận/huyện</option></select>');
                wardInput.replaceWith('<select name="billing_address_2" id="billing_address_2" class="select2"><option value="">Chọn phường/xã</option></select>');

                // Gán lại biến sau khi thay thế
                var citis_select = $("#billing_city");
                var districts_select = $("#billing_address_1");
                var wards_select = $("#billing_address_2");

                // Áp dụng Select2 để giao diện đẹp hơn
                citis_select.select2();
                districts_select.select2();
                wards_select.select2();

                <?php
                // Đường dẫn file JSON trong theme
                $json_path = get_template_directory() . '/inc/json/city_vn.json';
                $json_data = file_get_contents($json_path);
                ?>
                var data_city = <?php echo $json_data; ?>;
                renderCity(data_city);

                function renderCity(data) {
                    var citis = $("#billing_city");
                    var districts = $("#billing_address_1");
                    var wards = $("#billing_address_2");

                    citis.empty().append('<option value="">Chọn tỉnh/thành</option>');
                    districts.empty().append('<option value="">Chọn quận/huyện</option>');
                    wards.empty().append('<option value="">Chọn phường/xã</option>');

                    $.each(data, function(index, item) {
                        citis.append($('<option>', {
                            value: item.Name,
                            text: item.Name,
                            'data-id': item.Id,
                            selected: (cityValue && cityValue == item.Name),
                        }));
                    });
                    setTimeout(function() {
                        citis.val(cityValue).trigger('change');
                    }, 500);

                    citis.on('change', function() {
                        var cityID = $(this).find(':selected').data("id");
                        districts.empty().append('<option value="">Chọn quận/huyện</option>');
                        wards.empty().append('<option value="">Chọn phường/xã</option>');

                        if (cityID) {
                            var selectedCity = data.find(n => n.Id == cityID);
                            $.each(selectedCity.Districts, function(index, item) {
                                districts.append($('<option>', {
                                    value: item.Name,
                                    text: item.Name,
                                    selected: (districtValue && districtValue == item.Name),
                                    'data-id': item.Id
                                }));
                            });
                        }
                        districts.trigger('change'); // Cập nhật select2
                    });

                    districts.on('change', function() {
                        var districtID = $(this).find(':selected').data("id");
                        wards.empty().append('<option value="">Chọn phường/xã</option>');

                        if (districtID) {
                            var cityID = citis.find(':selected').data("id");
                            var selectedCity = data.find(n => n.Id == cityID);
                            var selectedDistrict = selectedCity.Districts.find(n => n.Id == districtID);

                            $.each(selectedDistrict.Wards, function(index, item) {
                                wards.append($('<option>', {
                                    value: item.Name,
                                    text: item.Name,
                                    selected: (wardValue && wardValue == item.Name),
                                }));
                            });
                        }
                        wards.trigger('change'); // Cập nhật select2
                    });
                }
            });
        </script>
<?php
    }
}
add_action('wp_footer', 'select_province_and_district_vietnam_checkout', 99);
// end

// hiển thị duy nhất 1 quốc gia
add_filter('woocommerce_countries', 'custom_allowed_countries', 99);
function custom_allowed_countries($countries)
{
    return array(
        'VN' => __('Việt Nam', 'woocommerce'), // Việt Nam
    );
}
// end

// Trường billing_address_2 thay đổi thành bắt buộc và có thêm label
add_filter('woocommerce_checkout_fields', 'customize_billing_address_2', 999);
function customize_billing_address_2($fields)
{
    // khai báo text label và trạng thái required
    if (!empty($fields['billing']['billing_address_2'])) {
        $fields['billing']['billing_address_2'] = array(
            'label'       => __('Ward / Commune', 'woocommerce'),
            'required'    => true,
        );
    }
    return $fields;
}
// end
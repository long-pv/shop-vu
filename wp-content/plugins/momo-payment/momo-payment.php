<?php

/**
 * Plugin Name: MoMo QR Payment Gateway for WooCommerce
 * Description: Thêm phương thức thanh toán bằng MoMo QR vào WooCommerce.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Chặn truy cập trực tiếp
}

// Đăng ký MoMo Payment Gateway trong WooCommerce
function add_momo_payment_gateway_class($gateways)
{
    $gateways[] = 'WC_Gateway_Momo';
    return $gateways;
}
add_filter('woocommerce_payment_gateways', 'add_momo_payment_gateway_class');

// Định nghĩa lớp WC_Gateway_Momo
add_action('plugins_loaded', 'init_momo_payment_gateway');
function init_momo_payment_gateway()
{
    class WC_Gateway_Momo extends WC_Payment_Gateway
    {
        public function __construct()
        {
            $this->id = 'momo';
            $this->icon = ''; // Thêm icon nếu cần
            $this->has_fields = false;
            $this->method_title = 'MoMo QR Payment';
            $this->method_description = 'Thanh toán qua MoMo bằng cách quét mã QR';

            $this->init_form_fields();
            $this->init_settings();

            $this->title = $this->get_option('title');
            $this->description = $this->get_option('description');
            $this->partner_code = $this->get_option('partner_code');
            $this->access_key = $this->get_option('access_key');
            $this->secret_key = $this->get_option('secret_key');

            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
        }

        public function init_form_fields()
        {
            $this->form_fields = array(
                'enabled' => array(
                    'title' => 'Bật/Tắt',
                    'type' => 'checkbox',
                    'label' => 'Bật MoMo QR Payment',
                    'default' => 'yes'
                ),
                'title' => array(
                    'title' => 'Tiêu đề',
                    'type' => 'text',
                    'default' => 'MoMo QR Payment'
                ),
                'description' => array(
                    'title' => 'Mô tả',
                    'type' => 'textarea',
                    'default' => 'Quét mã QR để thanh toán qua MoMo'
                ),
                'partner_code' => array(
                    'title' => 'Partner Code',
                    'type' => 'text'
                ),
                'access_key' => array(
                    'title' => 'Access Key',
                    'type' => 'text'
                ),
                'secret_key' => array(
                    'title' => 'Secret Key',
                    'type' => 'password'
                )
            );
        }

        public function process_payment($order_id)
        {
            $order = wc_get_order($order_id);
            $endpoint = 'https://test-payment.momo.vn/v2/gateway/api/create';
            $requestId = time();
            $data = array(
                'partnerCode' => $this->partner_code,
                'accessKey' => $this->access_key,
                'requestId' => $requestId,
                'amount' => $order->get_total(),
                'orderId' => $order_id,
                'orderInfo' => 'Thanh toán đơn hàng ' . $order_id,
                'requestType' => 'captureWallet',
                'redirectUrl' => '',
                'ipnUrl' => home_url('/wc-api/momo_ipn/'),
                'extraData' => ''
            );
            $data['signature'] = hash_hmac('sha256', json_encode($data), $this->secret_key);

            $response = wp_remote_post($endpoint, array(
                'body' => json_encode($data),
                'headers' => array('Content-Type' => 'application/json'),
                'method' => 'POST'
            ));

            if (is_wp_error($response)) {
                wc_add_notice('Lỗi khi kết nối với MoMo', 'error');
                return;
            }

            $body = json_decode(wp_remote_retrieve_body($response), true);
            if (isset($body['qrCodeUrl'])) {
                return array(
                    'result' => 'success',
                    'redirect' => $body['qrCodeUrl']
                );
            } else {
                wc_add_notice('Lỗi từ MoMo', 'error');
                return;
            }
        }
    }
}

// Xử lý IPN từ MoMo
add_action('woocommerce_api_momo_ipn', 'handle_momo_ipn');
function handle_momo_ipn()
{
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['orderId']) && isset($data['resultCode']) && $data['resultCode'] == 0) {
        $order = wc_get_order($data['orderId']);
        if ($order) {
            $order->payment_complete();
            $order->add_order_note('Thanh toán thành công qua MoMo QR.');
        }
    }
    status_header(200);
    exit;
}

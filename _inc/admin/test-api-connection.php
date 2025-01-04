<?php
add_action('wp_ajax_inp_instagram_test_connection','inp_instagram_test_connection');
function inp_instagram_test_connection()
{
    // Security: Verify nonce token
    if (!isset($_POST['_nonce']) || !wp_verify_nonce($_POST['_nonce'])) {
        wp_send_json(['error'=>true,'message' => 'Access denied'], 403);
    }
    $access_token=sanitize_text_field($_POST['accessToken']);
    $account_id=sanitize_text_field($_POST['accountID']);

    if(empty($account_id) || empty($access_token)){
        wp_send_json(['error'=>true,'message' => 'توکن دسترسی یا شناسه اکانت وارد نشده است.'], 400);
    }

    // Test API connection
    $api_url = sprintf(
        'https://graph.instagram.com/v21.0/%s/media?fields=id&access_token=%s&limit=1',
        esc_attr($account_id),
        esc_attr($access_token)
    );
    $response = wp_remote_get($api_url, [
        'timeout' => 15,
        'headers' => [
            'Accept' => 'application/json',
        ]
    ]);
    if (is_wp_error($response)) {
        wp_send_json([
            'error'=>true,
            'message' => 'خطا در اتصال به API: ' . $response->get_error_message()
        ],400);
    }
    $response_code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if ($response_code !== 200) {
        $error_message = $data['error']['message'] ?? 'خطای ناشناخته';
        wp_send_json([
            'error'=>true,
            'message' => sprintf('خطای API (کد %d): %s', $response_code, $error_message)
        ],400);
    }

    if (json_last_error() !== JSON_ERROR_NONE) {
        wp_send_json([
            'error'=>true,
            'message' => 'خطا در پردازش پاسخ API'
        ],400);
    }

    if (!isset($data['data'])) {
        wp_send_json([
            'error'=>true,
            'message' => 'ساختار پاسخ API نامعتبر است'
        ],400);
    }

    wp_send_json([
        'success'=>true,
        'message' => 'اتصال به API موفقیت‌آمیز بود!'
    ],200);

}

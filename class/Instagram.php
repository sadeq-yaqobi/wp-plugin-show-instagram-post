<?php

class Instagram
{
    private static $access_token,
        $account_id,
        $baseURL = 'https://graph.instagram.com/v21.0/',
        $limit;

    public function __construct()
    {
        $options = get_option('_inp_instagram_option_name');
        self::$access_token = $options['_inp_access_token'] ?? '';
        self::$account_id = $options['_inp_account_id'] ?? 'me';
        self::$limit = $options['_inp_post_limit'] ?? 6;
    }

    private static function apiURL(): string
    {
        $query_string = http_build_query([
            'limit' => self::$limit,
            'fields' => 'id,media_url,permalink,like_count,media_type,thumbnail_url,caption',
            'access_token' => self::$access_token
        ]);
        return self::$baseURL . self::$account_id . '/media?' . $query_string;
    }

    /**
     * Fetches Instagram posts from the API
     *
     * @return array|string|false Array of posts on success, error message on API error, false on request failure
     * @throws InvalidArgumentException If API URL is not configured
     */
    public static function getInstagramPosts()
    {
        // Validate API URL
        if (empty(self::apiURL())) {
            throw new InvalidArgumentException('Instagram API URL is not configured');
        }

        // Set up request arguments
        $args = [
            'timeout' => 15,
            'headers' => [
                'Accept' => 'application/json',
            ]
        ];

        // Make the API request
        $response = wp_remote_get(self::apiURL(), $args);

        // Check if request was successful
        if (!is_array($response) || is_wp_error($response)) {
            error_log('Instagram API request failed: ' .
                (is_wp_error($response) ? $response->get_error_message() : 'Unknown error'));
            return false;
        }


        // Parse response body
        $body = wp_remote_retrieve_body($response);
        $content = json_decode($body, true);


        // Check for API errors
        if (!$content || array_key_exists('error', $content)) {
            $error_message = $content['error']['message'] ?? 'Unknown API error';
            error_log('Instagram API error: ' . $error_message);
            return $error_message;
        }

        return $content;
    }
}

new instagram();



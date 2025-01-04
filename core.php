<?php
/*Plugin Name: نمایش پست‌های اینستاگرام
Plugin URI: http://siteyar.net/plugins/
Description:  نمایش پست‌های اینستاگرام در سایت وردپرس
Author: sadeq yaqobi
Version: 1.0.0
License: GPLv2 or later
Author URI: http://siteyar.net/sadeq-yaqobi/ */


#for security
defined('ABSPATH') || exit();

//defined required const
define('INP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('INP_PLUGIN_URL', plugin_dir_url(__FILE__));
const INP_PLUGIN_INC = INP_PLUGIN_DIR . '_inc/';
const INP_PLUGIN_VIEW = INP_PLUGIN_DIR . 'view/';
const INP_PLUGIN_class = INP_PLUGIN_DIR . 'class/';
const INP_PLUGIN_ASSETS_DIR = INP_PLUGIN_DIR . 'assets/';
const INP_PLUGIN_ASSETS_URL = INP_PLUGIN_URL . 'assets/';

/**
 * Register and enqueue frontend assets
 */
function inp_register_assets_front()
{
    // Register and enqueue CSS
    wp_register_style('inp-style', INP_PLUGIN_ASSETS_URL . 'css/front/front-style.css', [], '1.0.0');
    wp_enqueue_style('inp-style');

}

function inp_register_assets_admin()
{
    // Register and enqueue CSS
    wp_register_style('inp-admin-style', INP_PLUGIN_ASSETS_URL . 'css/admin/admin-style.css', [], '1.0.0');
    wp_enqueue_style('inp-admin-style');

    // Register and enqueue JavaScript
    wp_register_script('inp-admin-ajax', INP_PLUGIN_ASSETS_URL . 'js/admin/admin-ajax.js', ['jquery'], '1.0.0', ['strategy' => 'async', 'in_footer' => true]);
    wp_enqueue_script('inp-admin-ajax');

    wp_localize_script('inp-admin-ajax', 'inp_ajax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        '_nonce' => wp_create_nonce()
    ]);


}

add_action('wp_enqueue_scripts', 'inp_register_assets_front');
add_action('admin_enqueue_scripts', 'inp_register_assets_admin');
//activation and deactivation plugin hooks

if (is_admin()) {
    include INP_PLUGIN_INC . 'admin/menus.php';
    include INP_PLUGIN_INC . 'admin/test-api-connection.php';
} else {
    include INP_PLUGIN_VIEW . 'front/instagram-post.php';
    include INP_PLUGIN_class . 'Instagram.php';
}

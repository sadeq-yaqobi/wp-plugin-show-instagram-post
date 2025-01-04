<?php
add_action('admin_menu','inp_register_options');

// if you want to set plugin setting page under general setting menu, not by a specific menu
function inp_register_options()
{
    add_options_page(
        'تنظیمات نمایش پست‌های اینستاگرام',
        'پست‌های اینستاگرام',
        'manage_options',
        'instagram_post_setting',
        'inp_instagram_post_admin_layout' //it was implemented in view/admin/setting.php
    );
}

include_once INP_PLUGIN_VIEW . 'admin/setting.php';

<?php
function inp_instagram_post_admin_layout()
{

    if (!current_user_can('manage_options')) {
        return;
    }
    if (isset($_GET['setting-update'])) {
        add_settings_error('setting', 'setting-message', 'تنظیمات ذخیره گردید.', 'success');
    }
    settings_errors('setting-message');

    ?>
    <div class="inp-wrap">
        <form action="options.php" method="post">
            <h1><?php echo esc_html(get_admin_page_title()) ?></h1>
            <?php
            settings_fields('instagram-post'); // Output security fields
            do_settings_sections('instagram-post-html');// Output setting sections
            // Submit Button
            echo '<div class="submit-wrapper inp-submit-wrapper">';
            submit_button('ذخیره تغییرات', 'primary large');
            echo '</div>';
            ?>
        </form>
    </div>

    <?php
}

// Initialize plugin settings and fields
function inp_setting_init()
{

    register_setting('instagram-post', '_inp_instagram_option_name', 'inp_form_sanitize_input');

    // Add settings section
    add_settings_section('inp_settings_section', '', '', 'instagram-post-html');
    // Add settings fields for information that need to customize plugin features
    add_settings_field('inp_settings_field', '', 'inp_render_form', 'instagram-post-html', 'inp_settings_section');
}

add_action('admin_init', 'inp_setting_init');
function inp_render_form() {
    // Get saved settings
    $inp_setting = get_option('_inp_instagram_option_name') ?: null;

    // Security nonce field will be added
    wp_nonce_field('inp_instagram_settings', 'inp_instagram_nonce');
    ?>
    <div class=" inp-settings-wrapper">

        <!-- Quick Start Guide -->
        <div class="inp-quick-guide">
            <h2>راهنمای سریع راه‌اندازی</h2>
            <ol>
                <li>به <a href="https://developers.facebook.com" target="_blank" rel="noopener noreferrer">پنل توسعه‌دهندگان فیسبوک</a> بروید.</li>
                <li>یک اپلیکیشن جدید ایجاد کنید.</li>
                <li>در بخش Add use cases گزینه Other را انتخاب کنید</li>
                <li>در بخش Select an app type گزینه Business Activity را انتخاب کنید</li>
                <li>در بخش Add products to your app گزینه set up در زیر Instagram را انتخاب کنید</li>
                <li>در بخش API setup with Instagram business login روی add account کلیک کنید</li>
                <li>دسترسی‌های مورد نیاز را فعال کنید.</li>
                <li>توکن دسترسی و شناسه اکانت را کپی کنید.</li>
            </ol>
        </div>

        <div class="inp-element-wrapper">
            <!-- Access Token Field -->
            <div class="inp-field-group">
                <label for="access_token">توکن دسترسی اینستاگرام</label>
                <input
                        id="access_token"
                        type="text"
                        name="_inp_instagram_option_name[_inp_access_token]"
                        value="<?php echo esc_attr($inp_setting['_inp_access_token'] ?? ''); ?>"
                        class="regular-text"
                >
                <p class="description">
                    توکن دسترسی را از پنل توسعه‌دهندگان فیسبوک دریافت کنید.
                    این توکن برای دسترسی به API اینستاگرام ضروری است.
                </p>
            </div>

            <!-- Account ID Field -->
            <div class="inp-field-group">
                <label for="account_id">شناسه اکانت اینستاگرام</label>
                <input
                        id="account_id"
                        type="text"
                        name="_inp_instagram_option_name[_inp_account_id]"
                        value="<?php echo esc_attr($inp_setting['_inp_account_id'] ?? ''); ?>"
                        class="regular-text"
                        pattern="[0-9]+"
                >
                <p class="description">
                    شناسه عددی اکانت اینستاگرام خود را وارد کنید.
                    این شناسه را می‌توانید از بخش تنظیمات اکانت خود در اینستاگرام پیدا کنید.
                </p>
            </div>

            <!-- Post Limit Field -->
            <div class="inp-field-group">
                <label for="post_limit">تعداد پست‌های نمایش داده شده</label>
                <input
                        id="post_limit"
                        type="number"
                        name="_inp_instagram_option_name[_inp_post_limit]"
                        value="<?php echo esc_attr($inp_setting['_inp_post_limit'] ?? '9'); ?>"
                        min="1"
                        max="25"
                >
                <p class="description">
                    تعداد پست‌هایی که می‌خواهید در سایت نمایش داده شود را وارد کنید (بهتر است مضربی از ۳ باشد).
                </p>
            </div>

            <!-- Test Connection Button -->
            <div class="inp-field-group">
                <button type="button" id="inp-test-connection" class="button button-secondary">
                    تست اتصال به API
                </button>
                <span id="inp-connection-status" class="inp-status-message" dir="auto"></span>
            </div>
        </div>



    </div>
    <?php
}

// sanitize inputs
function inp_form_sanitize_input($input)
{
    $input['_inp_access_token'] = sanitize_text_field($input['_inp_access_token']);
    $input['_inp_account_id'] = sanitize_text_field($input['_inp_account_id']);
    $input['_inp_post_limit'] = sanitize_text_field($input['_inp_post_limit']);

    return $input;
}

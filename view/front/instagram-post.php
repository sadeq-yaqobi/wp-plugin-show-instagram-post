<?php
add_shortcode('instagram_post', 'INP_instagram_post_layout');

function INP_instagram_post_layout() {
    // Fetch Instagram posts and handle potential errors
    $response = Instagram::getInstagramPosts();

    ?>
    <div class="col-lg-3 col-md-12">
        <div class="instagram-wrapper">
            <h4 class="instagram-title">جدیدترین پست‌های اینستاگرام</h4>

            <div class="instagram-posts">
                <?php
                // Error handling
                if ($response === false) {
                    ?>
                    <div class="instagram-error">
                        <p>متأسفانه در حال حاضر امکان نمایش پست‌های اینستاگرام وجود ندارد. لطفاً بعداً دوباره امتحان کنید.</p>
                    </div>
                    <?php
                }
                // API Error message
                elseif (is_string($response)) {
                    ?>
                    <div class="instagram-error">
                        <p>خطا در دریافت پست‌های اینستاگرام:</p>
                        <p><?php echo esc_html($response); ?></p>
                    </div>
                    <?php
                }
                // Success case - we have posts
                elseif (isset($response['data']) && !empty($response['data'])) {
                    foreach ($response['data'] as $post) {
                        // Sanitize data
                        $post_id = esc_attr($post['id']);
                        $caption = esc_attr($post['caption'] ?? '');
                        $permalink = esc_url($post['permalink']);
                        $media_url = esc_url($post['media_type'] == 'VIDEO' ?
                            $post['thumbnail_url'] :
                            $post['media_url']);
                        $like_count = intval($post['like_count']);
                        ?>
                        <div class="item item-wrapper"
                             data-post-id="<?php echo $post_id; ?>"
                             title="<?php echo $caption; ?>">
                            <a href="<?php echo $permalink; ?>"
                               target="_blank"
                               rel="noopener noreferrer">
                                <img loading="lazy"
                                     src="<?php echo $media_url; ?>"
                                     alt="<?php echo $caption; ?>"
                                     class="instagram-post-image">
                                <div class="inp-like-wrapper">
                                    <span class="inp-like-counter">
                                        <?php echo number_format($like_count); ?>
                                    </span>
                                    <span class="inp-like-icon"></span>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                }
                // No posts found
                else {
                    ?>
                    <div class="instagram-empty">
                        <p>تا کنون پست اینستاگرامی منتشر نشده است.</p>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>


    <?php

}

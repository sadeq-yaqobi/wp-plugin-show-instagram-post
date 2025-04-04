# WordPress Plugin: Show Instagram Post

**Version:** 1.0.0  
**Author:** Sadeq Yaqobi  
**License:** GPL-2.0-or-later

## Description

The **Show Instagram Post** plugin is a custom WordPress plugin designed to display Instagram posts on your WordPress site. It allows seamless integration of Instagram content, enabling you to showcase your latest posts directly on your website.

## Features

- **Display Instagram Posts:** Fetch and display recent posts from a specified Instagram account.
- **Customizable Display:** Adjust the number of posts and layout to fit your site's design.
- **Shortcode Support:** Easily embed Instagram posts anywhere on your site using shortcodes.

## Installation

1. **Download the Plugin:**
   - Clone the repository:
     ```bash
     git clone https://github.com/sadeq-yaqobi/wp-plugin-show-instagram-post.git
     ```
   - Or [download the ZIP file](https://github.com/sadeq-yaqobi/wp-plugin-show-instagram-post/archive/refs/heads/main.zip) and extract it.

2. **Upload to WordPress:**
   - Upload the extracted plugin folder to the `/wp-content/plugins/` directory of your WordPress installation.

3. **Activate the Plugin:**
   - Log in to your WordPress admin dashboard.
   - Navigate to **Plugins** > **Installed Plugins**.
   - Locate **Show Instagram Post** and click **Activate**.

## Setup

1. **Configure Instagram API:**
   - Obtain the necessary API credentials from Instagram to access your account's posts.
   - In your WordPress admin dashboard, navigate to **Settings** > **Show Instagram Post**.
   - Enter your **Instagram Access Token** and **User ID** in the respective fields.
   - Save the settings.

2. **Customize Display Settings:**
   - Set the number of posts to display.
   - Choose the layout and styling options to match your site's design.

## Usage

- **Embedding Instagram Posts:**
  - Use the shortcode `[show_instagram_posts]` to display the Instagram posts on any page or post.
  - You can customize the shortcode with attributes, for example:
    ```bash
    [show_instagram_posts count="5" layout="grid"]
    ```

## File Structure

- **`_inc/`**: Contains administrative PHP files for handling plugin settings and configurations.
- **`assets/`**: Includes CSS and JavaScript files for styling and client-side functionality.
- **`class/`**: Contains PHP classes that manage the core functionalities of the plugin.
- **`view/`**: Holds template files for displaying Instagram posts.
- **`core.php`**: Core plugin functionalities and initialization.
- **`index.php`**: Initializes the plugin.

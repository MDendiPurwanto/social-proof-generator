<?php
/*
Plugin Name: Social Proof Generator
Description: Menampilkan notifikasi social proof dengan pengaturan posisi, durasi, animasi, pesan acak, dan warna kustom hanya pada halaman.
Version: 1.4.1
Author: Muhamad Dendi Purwanto
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: social-proof-generator
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Add admin menu
function socproofgen_admin_menu() {
    add_menu_page(
        esc_html__('Social Proof Settings', 'social-proof-generator'),
        esc_html__('Social Proof', 'social-proof-generator'),
        'manage_options',
        'social-proof-generator',
        'socproofgen_settings_page',
        'dashicons-testimonial',
        80
    );
}
add_action('admin_menu', 'socproofgen_admin_menu');

// Settings page callback
function socproofgen_settings_page() {
    // Save settings if form is submitted
    if (isset($_POST['socproofgen_settings_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['socproofgen_settings_nonce'])), 'socproofgen_save_settings')) {
        $position = isset($_POST['socproofgen_position']) ? sanitize_text_field(wp_unslash($_POST['socproofgen_position'])) : 'bottom-right';
        $duration = isset($_POST['socproofgen_duration']) ? absint($_POST['socproofgen_duration']) : 5;
        $animation = isset($_POST['socproofgen_animation']) ? sanitize_text_field(wp_unslash($_POST['socproofgen_animation'])) : 'fade';
        $raw_names = isset($_POST['socproofgen_names']) ? sanitize_textarea_field(wp_unslash($_POST['socproofgen_names'])) : '';
        $raw_products = isset($_POST['socproofgen_products']) ? sanitize_textarea_field(wp_unslash($_POST['socproofgen_products'])) : '';
        $names = !empty($raw_names) ? array_map('sanitize_text_field', array_filter(array_map('trim', explode("\n", $raw_names)))) : [];
        $products = !empty($raw_products) ? array_map('sanitize_text_field', array_filter(array_map('trim', explode("\n", $raw_products)))) : [];
        $bg_color = isset($_POST['socproofgen_bg_color']) ? sanitize_hex_color(wp_unslash($_POST['socproofgen_bg_color'])) : '#ffffff';
        $image_id = isset($_POST['socproofgen_image_id']) ? absint($_POST['socproofgen_image_id']) : 0;

        update_option('socproofgen_position', $position);
        update_option('socproofgen_duration', $duration);
        update_option('socproofgen_animation', $animation);
        update_option('socproofgen_names', $names);
        update_option('socproofgen_products', $products);
        update_option('socproofgen_bg_color', $bg_color);
        update_option('socproofgen_image_id', $image_id);

        echo '<div class="updated"><p>' . esc_html__('Settings saved.', 'social-proof-generator') . '</p></div>';
    }

    // Get current settings
    $settings = [
        'position' => get_option('socproofgen_position', 'bottom-right'),
        'duration' => get_option('socproofgen_duration', 5),
        'animation' => get_option('socproofgen_animation', 'fade'),
        'names' => get_option('socproofgen_names', []),
        'products' => get_option('socproofgen_products', []),
        'bg_color' => get_option('socproofgen_bg_color', '#ffffff'),
        'image_id' => get_option('socproofgen_image_id', 0),
    ];

    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Social Proof Generator Settings', 'social-proof-generator'); ?></h1>
        <form method="post">
            <?php wp_nonce_field('socproofgen_save_settings', 'socproofgen_settings_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="socproofgen_position"><?php echo esc_html__('Position', 'social-proof-generator'); ?></label></th>
                    <td>
                        <select name="socproofgen_position" id="socproofgen_position">
                            <option value="bottom-right" <?php selected($settings['position'], 'bottom-right'); ?>><?php echo esc_html__('Bottom Right', 'social-proof-generator'); ?></option>
                            <option value="bottom-left" <?php selected($settings['position'], 'bottom-left'); ?>><?php echo esc_html__('Bottom Left', 'social-proof-generator'); ?></option>
                            <option value="top-right" <?php selected($settings['position'], 'top-right'); ?>><?php echo esc_html__('Top Right', 'social-proof-generator'); ?></option>
                            <option value="top-left" <?php selected($settings['position'], 'top-left'); ?>><?php echo esc_html__('Top Left', 'social-proof-generator'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="socproofgen_duration"><?php echo esc_html__('Duration (seconds)', 'social-proof-generator'); ?></label></th>
                    <td>
                        <input type="number" name="socproofgen_duration" id="socproofgen_duration" value="<?php echo esc_attr($settings['duration']); ?>" min="1">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="socproofgen_animation"><?php echo esc_html__('Animation', 'social-proof-generator'); ?></label></th>
                    <td>
                        <select name="socproofgen_animation" id="socproofgen_animation">
                            <option value="fade" <?php selected($settings['animation'], 'fade'); ?>><?php echo esc_html__('Fade', 'social-proof-generator'); ?></option>
                            <option value="slide" <?php selected($settings['animation'], 'slide'); ?>><?php echo esc_html__('Slide', 'social-proof-generator'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="socproofgen_names"><?php echo esc_html__('Names (one per line)', 'social-proof-generator'); ?></label></th>
                    <td>
                        <textarea name="socproofgen_names" id="socproofgen_names" rows="5" class="regular-text"><?php echo esc_textarea(implode("\n", $settings['names'])); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="socproofgen_products"><?php echo esc_html__('Products (one per line)', 'social-proof-generator'); ?></label></th>
                    <td>
                        <textarea name="socproofgen_products" id="socproofgen_products" rows="5" class="regular-text"><?php echo esc_textarea(implode("\n", $settings['products'])); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="socproofgen_bg_color"><?php echo esc_html__('Background Color', 'social-proof-generator'); ?></label></th>
                    <td>
                        <input type="text" name="socproofgen_bg_color" id="socproofgen_bg_color" value="<?php echo esc_attr($settings['bg_color']); ?>" class="socproofgen-color-picker">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="socproofgen_image_id"><?php echo esc_html__('Product Image', 'social-proof-generator'); ?></label></th>
                    <td>
                        <input type="hidden" name="socproofgen_image_id" id="socproofgen_image_id" value="<?php echo esc_attr($settings['image_id']); ?>">
                        <div id="socproofgen_image_preview">
                            <?php if ($settings['image_id']) : ?>
                                <?php echo wp_get_attachment_image($settings['image_id'], 'thumbnail'); ?>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="button socproofgen_upload_image"><?php echo esc_html__('Upload Image', 'social-proof-generator'); ?></button>
                        <button type="button" class="button socproofgen_remove_image" <?php echo $settings['image_id'] ? '' : 'style="display:none;"'; ?>><?php echo esc_html__('Remove Image', 'social-proof-generator'); ?></button>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Enqueue admin scripts and styles
function socproofgen_enqueue_admin_scripts($hook) {
    if ($hook !== 'toplevel_page_social-proof-generator') {
        return;
    }

    // Enqueue WordPress color picker
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    // Enqueue media uploader
    wp_enqueue_media();

    // Enqueue admin styles
    wp_enqueue_style(
        'socproofgen-admin-style',
        plugin_dir_url(__FILE__) . 'assets/css/spg-style.css',
        [],
        filemtime(plugin_dir_path(__FILE__) . 'assets/css/spg-style.css')
    );

    // Enqueue admin scripts
    wp_enqueue_script(
        'socproofgen-admin-script',
        plugin_dir_url(__FILE__) . 'assets/js/spg-admin.js',
        ['jquery', 'wp-color-picker'],
        filemtime(plugin_dir_path(__FILE__) . 'assets/js/spg-admin.js'),
        true
    );

    // Localize script for media uploader
    wp_localize_script(
        'socproofgen-admin-script',
        'socproofgenAdmin',
        [
            'mediaTitle' => esc_js(__('Select Product Image', 'social-proof-generator')),
            'mediaButton' => esc_js(__('Use This Image', 'social-proof-generator')),
        ]
    );
}
add_action('admin_enqueue_scripts', 'socproofgen_enqueue_admin_scripts');

// Add meta box for per-page popup settings
function socproofgen_add_meta_box() {
    add_meta_box(
        'socproofgen_popup_options',
        esc_html__('Social Proof Popup Options', 'social-proof-generator'),
        'socproofgen_popup_options_callback',
        ['post', 'page'],
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'socproofgen_add_meta_box');

// Meta box callback
function socproofgen_popup_options_callback($post) {
    wp_nonce_field('socproofgen_save_popup_options', 'socproofgen_popup_nonce');
    $show_popup = get_post_meta($post->ID, '_socproofgen_show_popup', true);
    $show_popup = $show_popup === '' ? '1' : $show_popup; // Default to '1' if not set
    ?>
    <p>
        <label for="socproofgen_show_popup">
            <input type="checkbox" name="socproofgen_show_popup" id="socproofgen_show_popup" value="1" <?php checked($show_popup, '1'); ?>>
            <?php echo esc_html__('Show social proof popup on this page', 'social-proof-generator'); ?>
        </label>
    </p>
    <?php
}

// Save meta box data
function socproofgen_save_popup_options($post_id) {
    if (!isset($_POST['socproofgen_popup_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['socproofgen_popup_nonce'])), 'socproofgen_save_popup_options')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $show_popup = isset($_POST['socproofgen_show_popup']) ? '1' : '0';
    update_post_meta($post_id, '_socproofgen_show_popup', $show_popup);
}
add_action('save_post', 'socproofgen_save_popup_options');

// Add popup to footer
function socproofgen_add_popup_to_footer() {
    if (is_admin()) {
        return;
    }

    $show_popup = true;
    if (is_singular(['post', 'page'])) {
        $show_popup = get_post_meta(get_the_ID(), '_socproofgen_show_popup', true);
        $show_popup = $show_popup === '' ? '1' : $show_popup; // Default to '1' if not set
    }

    if ($show_popup !== '1') {
        return;
    }

    $settings = [
        'position' => get_option('socproofgen_position', 'bottom-right'),
        'duration' => get_option('socproofgen_duration', 5),
        'animation' => get_option('socproofgen_animation', 'fade'),
        'names' => get_option('socproofgen_names', []),
        'products' => get_option('socproofgen_products', []),
        'bg_color' => get_option('socproofgen_bg_color', '#ffffff'),
        'image_id' => get_option('socproofgen_image_id', 0),
    ];

    // Enqueue frontend styles
    wp_enqueue_style(
        'socproofgen-style',
        plugin_dir_url(__FILE__) . 'assets/css/spg-style.css',
        [],
        filemtime(plugin_dir_path(__FILE__) . 'assets/css/spg-style.css')
    );

    // Enqueue frontend scripts
    wp_enqueue_script(
        'socproofgen-script',
        plugin_dir_url(__FILE__) . 'assets/js/spg-script.js',
        ['jquery'],
        filemtime(plugin_dir_path(__FILE__) . 'assets/js/spg-script.js'),
        true
    );

    // Localize script with settings
    wp_localize_script(
        'socproofgen-script',
        'socproofgenSettings',
        [
            'position' => esc_attr($settings['position']),
            'duration' => absint($settings['duration']),
            'animation' => esc_attr($settings['animation']),
            'names' => array_map('esc_js', $settings['names']),
            'products' => array_map('esc_js', $settings['products']),
            'bg_color' => esc_attr($settings['bg_color']),
            'image_url' => $settings['image_id'] ? esc_url(wp_get_attachment_url($settings['image_id'])) : '',
        ]
    );

    // Add popup HTML
    ?>
    <div class="social-proof-popup" id="socproofgen-popup" style="background-color: <?php echo esc_attr($settings['bg_color']); ?>; display: none;">
        <?php if ($settings['image_id']) : ?>
            <?php echo wp_get_attachment_image($settings['image_id'], [50, 50], false, ['class' => 'socproofgen-product-image']); ?>
        <?php else : ?>
            <span class="socproofgen-no-image"><?php echo esc_html__('No image available', 'social-proof-generator'); ?></span>
        <?php endif; ?>
        <div class="socproofgen-content"><p></p></div>
    </div>
    <?php
}
add_action('wp_footer', 'socproofgen_add_popup_to_footer');
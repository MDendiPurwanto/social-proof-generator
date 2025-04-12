<?php
/*
Plugin Name: Social Proof Generator
Description: Menampilkan notifikasi social proof dengan pengaturan posisi, durasi, animasi, pesan acak, dan warna kustom hanya pada halaman.
Version: 1.2
Author: Muhamad Dendi Purwanto
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: social-proof-generator
*/

// Mencegah akses langsung ke file
if (!defined('ABSPATH')) {
    exit;
}

// Tambah menu pengaturan di admin
function spg_admin_menu() {
    add_menu_page(
        __('Social Proof Settings', 'social-proof-generator'),
        __('Social Proof', 'social-proof-generator'),
        'manage_options',
        'social-proof-generator',
        'spg_settings_page',
        'dashicons-testimonial',
        80
    );
}
add_action('admin_menu', 'spg_admin_menu');

// Halaman pengaturan
function spg_settings_page() {
    if (isset($_POST['spg_save_settings']) && check_admin_referer('spg_save_settings_action', 'spg_nonce')) {
        update_option('spg_position', sanitize_text_field($_POST['spg_position']));
        update_option('spg_duration', intval($_POST['spg_duration']));
        update_option('spg_animation', sanitize_text_field($_POST['spg_animation']));
        update_option('spg_names', sanitize_textarea_field($_POST['spg_names']));
        update_option('spg_products', sanitize_textarea_field($_POST['spg_products']));
        update_option('spg_bg_color', sanitize_hex_color($_POST['spg_bg_color']));
        update_option('spg_image_url', esc_url_raw($_POST['spg_image_url']));
        echo '<div class="updated"><p>' . __('Pengaturan disimpan!', 'social-proof-generator') . '</p></div>';
    }

    $settings = array(
        'position' => get_option('spg_position', 'bottom-left'),
        'duration' => get_option('spg_duration', 3000),
        'animation' => get_option('spg_animation', 'fade'),
        'names' => array_filter(array_map('trim', explode("\n", get_option('spg_names', "Andy\nBudi\nSiti")))),
        'products' => array_filter(array_map('trim', explode("\n", get_option('spg_products', "WeddingPress\nProduk Keren\nLayanan Pro")))),
        'bg_color' => get_option('spg_bg_color', '#ffffff'),
        'image_url' => get_option('spg_image_url', plugins_url('/assets/images/product-image.png', __FILE__)),
    );
    ?>
    <div class="wrap">
        <h1><?php _e('Pengaturan Social Proof Generator', 'social-proof-generator'); ?></h1>
        <form method="post">
            <?php wp_nonce_field('spg_save_settings_action', 'spg_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th><?php _e('Posisi Popup', 'social-proof-generator'); ?></th>
                    <td>
                        <select name="spg_position">
                            <option value="bottom-left" <?php selected($settings['position'], 'bottom-left'); ?>><?php _e('Kiri Bawah', 'social-proof-generator'); ?></option>
                            <option value="bottom-right" <?php selected($settings['position'], 'bottom-right'); ?>><?php _e('Kanan Bawah', 'social-proof-generator'); ?></option>
                            <option value="top-left" <?php selected($settings['position'], 'top-left'); ?>><?php _e('Kiri Atas', 'social-proof-generator'); ?></option>
                            <option value="top-right" <?php selected($settings['position'], 'top-right'); ?>><?php _e('Kanan Atas', 'social-proof-generator'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Durasi (ms)', 'social-proof-generator'); ?></th>
                    <td><input type="number" name="spg_duration" value="<?php echo esc_attr($settings['duration']); ?>" min="1000" required></td>
                </tr>
                <tr>
                    <th><?php _e('Animasi', 'social-proof-generator'); ?></th>
                    <td>
                        <select name="spg_animation">
                            <option value="fade" <?php selected($settings['animation'], 'fade'); ?>><?php _e('Fade', 'social-proof-generator'); ?></option>
                            <option value="slide" <?php selected($settings['animation'], 'slide'); ?>><?php _e('Slide', 'social-proof-generator'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Daftar Nama (satu per baris)', 'social-proof-generator'); ?></th>
                    <td><textarea name="spg_names" rows="5" style="width: 300px;" required><?php echo esc_textarea(get_option('spg_names', "Andy\nBudi\nSiti")); ?></textarea></td>
                </tr>
                <tr>
                    <th><?php _e('Daftar Produk (satu per baris)', 'social-proof-generator'); ?></th>
                    <td><textarea name="spg_products" rows="5" style="width: 300px;" required><?php echo esc_textarea(get_option('spg_products', "WeddingPress\nProduk Keren\nLayanan Pro")); ?></textarea></td>
                </tr>
                <tr>
                    <th><?php _e('Warna Latar', 'social-proof-generator'); ?></th>
                    <td><input type="color" name="spg_bg_color" value="<?php echo esc_attr($settings['bg_color']); ?>" required></td>
                </tr>
                <tr>
                    <th><?php _e('URL Gambar Produk', 'social-proof-generator'); ?></th>
                    <td><input type="url" name="spg_image_url" value="<?php echo esc_attr($settings['image_url']); ?>" style="width: 300px;" required></td>
                </tr>
            </table>
            <p><input type="submit" name="spg_save_settings" class="button-primary" value="<?php _e('Simpan Pengaturan', 'social-proof-generator'); ?>"></p>
        </form>
    </div>
    <?php
}

// Enqueue script dan style
function spg_enqueue_scripts() {
    if (is_page()) { // Hanya load di halaman
        wp_enqueue_style('spg-style', plugins_url('/assets/css/spg-style.css', __FILE__), array(), '1.2');
        wp_enqueue_script('spg-script', plugins_url('/assets/js/spg-script.js', __FILE__), array(), '1.2', true);
    }
}
add_action('wp_enqueue_scripts', 'spg_enqueue_scripts');

// Tambahkan popup ke footer hanya di halaman
function spg_add_popup_to_footer() {
    if (!is_page()) {
        return;
    }

    $settings = array(
        'position' => get_option('spg_position', 'bottom-left'),
        'duration' => get_option('spg_duration', 3000),
        'animation' => get_option('spg_animation', 'fade'),
        'names' => array_filter(array_map('trim', explode("\n", get_option('spg_names', "Andy\nBudi\nSiti")))),
        'products' => array_filter(array_map('trim', explode("\n", get_option('spg_products', "WeddingPress\nProduk Keren\nLayanan Pro")))),
        'bg_color' => get_option('spg_bg_color', '#ffffff'),
        'image_url' => get_option('spg_image_url', plugins_url('/assets/images/product-image.png', __FILE__)),
    );
    ?>
    <div class="social-proof-popup" id="spg-popup" style="background-color: <?php echo esc_attr($settings['bg_color']); ?>;">
        <img src="<?php echo esc_url($settings['image_url']); ?>" alt="<?php _e('Product Image', 'social-proof-generator'); ?>">
        <div class="spg-content"><p></p></div>
    </div>
    <script>
        var spgSettings = {
            position: '<?php echo esc_js($settings['position']); ?>',
            duration: <?php echo esc_js($settings['duration']); ?>,
            animation: '<?php echo esc_js($settings['animation']); ?>',
            names: <?php echo json_encode($settings['names'], JSON_UNESCAPED_UNICODE); ?>,
            products: <?php echo json_encode($settings['products'], JSON_UNESCAPED_UNICODE); ?>
        };
    </script>
    <?php
}
add_action('wp_footer', 'spg_add_popup_to_footer');

// Load text domain untuk terjemahan
function spg_load_textdomain() {
    load_plugin_textdomain('social-proof-generator', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'spg_load_textdomain');
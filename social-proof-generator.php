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
        esc_html__('Social Proof Settings', 'social-proof-generator'),
        esc_html__('Social Proof', 'social-proof-generator'),
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
        $position = isset($_POST['spg_position']) ? sanitize_text_field(wp_unslash($_POST['spg_position'])) : '';
        $duration = isset($_POST['spg_duration']) ? intval(wp_unslash($_POST['spg_duration'])) : 3000;
        $animation = isset($_POST['spg_animation']) ? sanitize_text_field(wp_unslash($_POST['spg_animation'])) : '';
        $names = isset($_POST['spg_names']) ? sanitize_textarea_field(wp_unslash($_POST['spg_names'])) : '';
        $products = isset($_POST['spg_products']) ? sanitize_textarea_field(wp_unslash($_POST['spg_products'])) : '';
        $bg_color = isset($_POST['spg_bg_color']) ? sanitize_hex_color(wp_unslash($_POST['spg_bg_color'])) : '';
        $image_id = isset($_POST['spg_image_id']) ? intval(wp_unslash($_POST['spg_image_id'])) : 0;

        update_option('spg_position', $position);
        update_option('spg_duration', $duration);
        update_option('spg_animation', $animation);
        update_option('spg_names', $names);
        update_option('spg_products', $products);
        update_option('spg_bg_color', $bg_color);
        update_option('spg_image_id', $image_id);
        
        wp_cache_delete('alloptions', 'options');
        
        echo '<div class="updated"><p>' . esc_html__('Pengaturan disimpan!', 'social-proof-generator') . '</p></div>';
    }

    $settings = array(
        'position' => get_option('spg_position', 'bottom-left'),
        'duration' => get_option('spg_duration', 3000),
        'animation' => get_option('spg_animation', 'fade'),
        'names' => array_filter(array_map('trim', explode("\n", get_option('spg_names', "Andy\nBudi\nSiti")))),
        'products' => array_filter(array_map('trim', explode("\n", get_option('spg_products', "WeddingPress\nProduk Keren\nLayanan Pro")))),
        'bg_color' => get_option('spg_bg_color', '#ffffff'),
        'image_id' => get_option('spg_image_id', 0),
    );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Pengaturan Social Proof Generator', 'social-proof-generator'); ?></h1>
        <form method="post">
            <?php wp_nonce_field('spg_save_settings_action', 'spg_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th><?php esc_html_e('Posisi Popup', 'social-proof-generator'); ?></th>
                    <td>
                        <select name="spg_position">
                            <option value="bottom-left" <?php selected($settings['position'], 'bottom-left'); ?>><?php esc_html_e('Kiri Bawah', 'social-proof-generator'); ?></option>
                            <option value="bottom-right" <?php selected($settings['position'], 'bottom-right'); ?>><?php esc_html_e('Kanan Bawah', 'social-proof-generator'); ?></option>
                            <option value="top-left" <?php selected($settings['position'], 'top-left'); ?>><?php esc_html_e('Kiri Atas', 'social-proof-generator'); ?></option>
                            <option value="top-right" <?php selected($settings['position'], 'top-right'); ?>><?php esc_html_e('Kanan Atas', 'social-proof-generator'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><?php esc_html_e('Durasi (ms)', 'social-proof-generator'); ?></th>
                    <td><input type="number" name="spg_duration" value="<?php echo esc_attr($settings['duration']); ?>" min="1000" required></td>
                </tr>
                <tr>
                    <th><?php esc_html_e('Animasi', 'social-proof-generator'); ?></th>
                    <td>
                        <select name="spg_animation">
                            <option value="fade" <?php selected($settings['animation'], 'fade'); ?>><?php esc_html_e('Fade', 'social-proof-generator'); ?></option>
                            <option value="slide" <?php selected($settings['animation'], 'slide'); ?>><?php esc_html_e('Slide', 'social-proof-generator'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><?php esc_html_e('Daftar Nama (satu per baris)', 'social-proof-generator'); ?></th>
                    <td><textarea name="spg_names" rows="5" style="width: 300px;" required><?php echo esc_textarea(get_option('spg_names', "Andy\nBudi\nSiti")); ?></textarea></td>
                </tr>
                <tr>
                    <th><?php esc_html_e('Daftar Produk (satu per baris)', 'social-proof-generator'); ?></th>
                    <td><textarea name="spg_products" rows="5" style="width: 300px;" required><?php echo esc_textarea(get_option('spg_products', "WeddingPress\nProduk Keren\nLayanan Pro")); ?></textarea></td>
                </tr>
                <tr>
                    <th><?php esc_html_e('Warna Latar', 'social-proof-generator'); ?></th>
                    <td><input type="color" name="spg_bg_color" value="<?php echo esc_attr($settings['bg_color']); ?>" required></td>
                </tr>
                <tr>
                    <th><?php esc_html_e('Gambar Produk', 'social-proof-generator'); ?></th>
                    <td>
                        <input type="hidden" name="spg_image_id" id="spg_image_id" value="<?php echo esc_attr($settings['image_id']); ?>">
                        <div id="spg_image_preview">
                            <?php
                            if ($settings['image_id']) {
                                echo wp_get_attachment_image($settings['image_id'], 'thumbnail', false, array('style' => 'max-width: 100px;'));
                            }
                            ?>
                        </div>
                        <button type="button" class="button" id="spg_upload_image_button"><?php esc_html_e('Pilih Gambar', 'social-proof-generator'); ?></button>
                        <button type="button" class="button" id="spg_remove_image_button" style="<?php echo $settings['image_id'] ? '' : 'display:none;'; ?>"><?php esc_html_e('Hapus Gambar', 'social-proof-generator'); ?></button>
                        <p class="description"><?php esc_html_e('Unggah atau pilih gambar dari media library untuk popup.', 'social-proof-generator'); ?></p>
                    </td>
                </tr>
            </table>
            <p><input type="submit" name="spg_save_settings" class="button-primary" value="<?php esc_attr_e('Simpan Pengaturan', 'social-proof-generator'); ?>"></p>
        </form>
    </div>
    <?php
}

// Enqueue script dan style
function spg_enqueue_scripts() {
    if (is_page()) {
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'assets/css/spg-style.css');
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'assets/js/spg-script.js');
        
        wp_enqueue_style('spg-style', plugins_url('/assets/css/spg-style.css', __FILE__), array(), $css_version);
        wp_enqueue_script('spg-script', plugins_url('/assets/js/spg-script.js', __FILE__), array(), $js_version, true);
    }
}
add_action('wp_enqueue_scripts', 'spg_enqueue_scripts');

// Enqueue media uploader scripts di halaman pengaturan
function spg_enqueue_admin_scripts($hook) {
    if ($hook !== 'toplevel_page_social-proof-generator') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script(
        'spg-admin-script',
        plugins_url('/assets/js/spg-admin.js', __FILE__),
        array('jquery'),
        filemtime(plugin_dir_path(__FILE__) . 'assets/js/spg-admin.js'),
        true
    );
    wp_localize_script(
        'spg-admin-script',
        'spgAdmin',
        array(
            'mediaTitle' => esc_js(__('Pilih Gambar Produk', 'social-proof-generator')),
            'mediaButton' => esc_js(__('Gunakan Gambar Ini', 'social-proof-generator')),
        )
    );
}
add_action('admin_enqueue_scripts', 'spg_enqueue_admin_scripts');

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
        'image_id' => get_option('spg_image_id', 0),
    );
    ?>
    <div class="social-proof-popup" id="spg-popup" style="background-color: <?php echo esc_attr($settings['bg_color']); ?>;">
        <?php
        if ($settings['image_id']) {
            echo wp_get_attachment_image(
                $settings['image_id'],
                array(50, 50),
                false,
                array(
                    'alt' => esc_attr__('Product Image', 'social-proof-generator'),
                    'class' => 'spg-product-image'
                )
            );
        } else {
            echo '<span>' . esc_html__('No image available', 'social-proof-generator') . '</span>';
        }
        ?>
        <div class="spg-content"><p></p></div>
    </div>
    <script>
        var spgSettings = {
            position: '<?php echo esc_js($settings['position']); ?>',
            duration: <?php echo esc_js($settings['duration']); ?>,
            animation: '<?php echo esc_js($settings['animation']); ?>',
            names: <?php echo json_encode($settings['names'], JSON_UNESCAPED_UNICODE); ?>,
            products: <?php echo json_encode($settings['products'], JSON_UNESCAPED_UNICODE); ?>,
            timestamp: <?php echo esc_js(time()); ?>
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
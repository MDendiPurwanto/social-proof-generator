<?php
/*
Plugin Name: Social Proof Generator
Description: Menampilkan notifikasi social proof dengan pengaturan posisi, durasi, animasi, pesan acak, dan warna kustom.
Version: 1.1
Author: Muhamad Dendi Purwanto
*/

// Mencegah akses langsung ke file
if (!defined('ABSPATH')) {
    exit;
}

// Tambah menu pengaturan di admin
function spg_admin_menu() {
    add_menu_page('Social Proof Settings', 'Social Proof', 'manage_options', 'social-proof-generator', 'spg_settings_page');
}
add_action('admin_menu', 'spg_admin_menu');

// Halaman pengaturan
function spg_settings_page() {
    if (isset($_POST['spg_save_settings'])) {
        update_option('spg_position', sanitize_text_field($_POST['spg_position']));
        update_option('spg_duration', intval($_POST['spg_duration']));
        update_option('spg_animation', sanitize_text_field($_POST['spg_animation']));
        update_option('spg_names', sanitize_textarea_field($_POST['spg_names']));
        update_option('spg_products', sanitize_textarea_field($_POST['spg_products']));
        update_option('spg_bg_color', sanitize_hex_color($_POST['spg_bg_color']));
        update_option('spg_image_url', esc_url_raw($_POST['spg_image_url']));
        echo '<div class="updated"><p>Pengaturan disimpan!</p></div>';
    }

    // Ambil pengaturan untuk digunakan di kode yang di-generate
    $names = explode("\n", get_option('spg_names', "Andy\nBudi\nSiti"));
    $products = explode("\n", get_option('spg_products', "WeddingPress\nProduk Keren\nLayanan Pro"));
    $settings = array(
        'position' => get_option('spg_position', 'bottom-left'),
        'duration' => get_option('spg_duration', 3000),
        'animation' => get_option('spg_animation', 'fade'),
        'names' => array_filter(array_map('trim', $names)), // Daftar nama acak
        'products' => array_filter(array_map('trim', $products)), // Daftar produk acak
        'bg_color' => get_option('spg_bg_color', '#ffffff'), // Warna latar
        'image_url' => get_option('spg_image_url', plugins_url('/assets/images/product-image.png', __FILE__)), // URL gambar produk
    );
    ?>
    <div class="wrap">
        <h1>Pengaturan Social Proof Generator</h1>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th>Posisi Popup</th>
                    <td>
                        <select name="spg_position">
                            <option value="bottom-left" <?php selected(get_option('spg_position'), 'bottom-left'); ?>>Kiri Bawah</option>
                            <option value="bottom-right" <?php selected(get_option('spg_position'), 'bottom-right'); ?>>Kanan Bawah</option>
                            <option value="top-left" <?php selected(get_option('spg_position'), 'top-left'); ?>>Kiri Atas</option>
                            <option value="top-right" <?php selected(get_option('spg_position'), 'top-right'); ?>>Kanan Atas</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Durasi (ms)</th>
                    <td><input type="number" name="spg_duration" value="<?php echo esc_attr(get_option('spg_duration', 3000)); ?>" min="1000"></td>
                </tr>
                <tr>
                    <th>Animasi</th>
                    <td>
                        <select name="spg_animation">
                            <option value="fade" <?php selected(get_option('spg_animation'), 'fade'); ?>>Fade</option>
                            <option value="slide" <?php selected(get_option('spg_animation'), 'slide'); ?>>Slide</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Daftar Nama (satu per baris)</th>
                    <td><textarea name="spg_names" rows="5" style="width: 300px;"><?php echo esc_textarea(get_option('spg_names', "Andy\nBudi\nSiti")); ?></textarea></td>
                </tr>
                <tr>
                    <th>Daftar Produk (satu per baris)</th>
                    <td><textarea name="spg_products" rows="5" style="width: 300px;"><?php echo esc_textarea(get_option('spg_products', "WeddingPress\nProduk Keren\nLayanan Pro")); ?></textarea></td>
                </tr>
                <tr>
                    <th>Warna Latar</th>
                    <td><input type="color" name="spg_bg_color" value="<?php echo esc_attr(get_option('spg_bg_color', '#ffffff')); ?>"></td>
                </tr>
                <tr>
                    <th>URL Gambar Produk</th>
                    <td><input type="url" name="spg_image_url" value="<?php echo esc_attr(get_option('spg_image_url', plugins_url('/assets/images/product-image.png', __FILE__))); ?>" style="width: 300px;"></td>
                </tr>
            </table>
            <p><input type="submit" name="spg_save_settings" class="button-primary" value="Simpan Pengaturan"></p>
        </form>
        
        <!-- Tombol Copy Code -->
        <h2>Kode Siap Pakai</h2>
        <textarea id="spg-code" rows="15" style="width: 100%; max-width: 600px;" readonly>
<div class="social-proof-popup" id="spg-popup" style="background-color: <?php echo esc_attr($settings['bg_color']); ?>;">
    <img src="<?php echo esc_url($settings['image_url']); ?>" alt="Product Image">
    <div class="spg-content"><p></p></div>
</div>

<style>
.social-proof-popup {
    position: fixed;
    color: #333;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    z-index: 9999;
    display: none;
    max-width: 300px;
    display: flex;
    align-items: center;
}

.social-proof-popup img {
    width: 50px;
    height: 50px;
    margin-right: 10px;
    border-radius: 5px;
}

.spg-content p {
    margin: 0;
    font-size: 14px;
    line-height: 1.4;
}

.spg-content p strong {
    font-weight: bold;
}

.spg-bottom-left { bottom: 20px; left: 20px; }
.spg-bottom-right { bottom: 20px; right: 20px; }
.spg-top-left { top: 20px; left: 20px; }
.spg-top-right { top: 20px; right: 20px; }

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { transform: translateY(100px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var popup = document.getElementById('spg-popup');
    var message = popup.querySelector('.spg-content p');
    
    // Pengaturan
    var settings = {
        position: '<?php echo esc_js($settings['position']); ?>',
        duration: <?php echo esc_js($settings['duration']); ?>,
        animation: '<?php echo esc_js($settings['animation']); ?>',
        names: <?php echo json_encode($settings['names']); ?>,
        products: <?php echo json_encode($settings['products']); ?>
    };
    
    // Terapkan posisi
    popup.classList.add('spg-' + settings.position);
    
    // Fungsi untuk memilih nama dan produk acak
    function getRandomName() {
        return settings.names[Math.floor(Math.random() * settings.names.length)];
    }
    
    function getRandomProduct() {
        return settings.products[Math.floor(Math.random() * settings.products.length)];
    }
    
    // Fungsi untuk menghasilkan tanggal dan waktu acak
    function getRandomDateTime() {
        var now = new Date();
        var randomDays = Math.floor(Math.random() * 7); // Acak 0-6 hari ke belakang
        var randomHours = Math.floor(Math.random() * 24);
        var randomMinutes = Math.floor(Math.random() * 60);
        var randomSeconds = Math.floor(Math.random() * 60);
        
        now.setDate(now.getDate() - randomDays);
        now.setHours(randomHours, randomMinutes, randomSeconds);
        
        var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        return `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()} ${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}:${now.getSeconds().toString().padStart(2, '0')} (WITA)`;
    }
    
    // Fungsi untuk menampilkan popup
    function showPopup() {
        var name = getRandomName();
        var product = getRandomProduct();
        var dateTime = getRandomDateTime();
        message.innerHTML = `${name} telah membeli <strong>${product}</strong> pada: ${dateTime}`;
        popup.style.display = 'flex';
        
        // Terapkan animasi
        popup.style.animation = settings.animation === 'fade' ? 'fadeIn 0.5s' : 'slideIn 0.5s';
        
        // Sembunyikan setelah durasi
        setTimeout(function() {
            popup.style.display = 'none';
        }, settings.duration);
    }
    
    // Tampilkan pertama kali dan ulangi setiap 10 detik
    showPopup();
    setInterval(showPopup, 10000);
});
</script>
        </textarea>
        <p><button class="button" onclick="copyCode()">Copy Code</button></p>
        <script>
            function copyCode() {
                var code = document.getElementById('spg-code');
                code.select();
                document.execCommand('copy');
                alert('Kode telah disalin!');
            }
        </script>
    </div>
    <?php
}
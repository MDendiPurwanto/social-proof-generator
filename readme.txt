=== Social Proof Generator ===
Contributors: dendiwp
Tags: social proof, notification, popup, marketing
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.4
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Menampilkan notifikasi social proof dengan pengaturan posisi, durasi, animasi, pesan acak, dan warna kustom hanya pada halaman.

== Description ==
Social Proof Generator adalah plugin WordPress yang memungkinkan Anda menampilkan notifikasi social proof di situs Anda untuk meningkatkan kepercayaan pengunjung. Plugin ini memungkinkan Anda mengatur posisi popup, durasi tampilan, jenis animasi, daftar nama dan produk secara acak, serta warna latar belakang. Notifikasi hanya ditampilkan pada halaman (bukan post) untuk fleksibilitas penggunaan.

Fitur:
- Posisi popup yang dapat disesuaikan (kiri bawah, kanan bawah, dll.)
- Durasi tampilan yang dapat diatur
- Pilihan animasi (fade atau slide)
- Daftar nama dan produk acak
- Warna latar belakang kustom
- Upload gambar produk kustom
- Hanya ditampilkan pada halaman

== Features ==
* Display social proof notifications with customizable position, duration, animation, random messages, and colors.
* Option to enable/disable pop-up on specific pages via the page editor.

== Installation ==
1. Unggah folder `social-proof-generator` ke direktori `/wp-content/plugins/`.
2. Aktifkan plugin melalui menu 'Plugins' di WordPress.
3. Buka menu 'Social Proof' di dashboard admin untuk mengatur pengaturan.
4. Simpan pengaturan, dan notifikasi akan otomatis muncul di halaman situs Anda.

== Frequently Asked Questions ==
= Apakah plugin ini bekerja pada semua tema? =
Ya, plugin ini dirancang untuk kompatibel dengan sebagian besar tema WordPress. Jika ada masalah, pastikan tema Anda mendukung hook `wp_footer`.

= Bisakah saya menonaktifkan popup pada post? =
Ya, plugin ini hanya menampilkan popup pada halaman (page) dan tidak pada post.

= Bagaimana cara terbaik untuk menambahkan gambar produk? =
Kami menyarankan mengunggah gambar ke Media Library WordPress dan  mengunggah gambar dari Media Library. Ini memastikan kompatibilitas dengan fitur WordPress seperti pengoptimalan gambar atau CDN.

= Does the plugin leave any data after uninstall? =
No, the plugin will automatically remove all its data (settings and per-page options) when you delete it via the WordPress dashboard.

== License ==
Social Proof Generator is licensed under the GNU General Public License v2 or later.
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Assets ==
All images in assets/images/ are licensed under the GNU General Public License v2 or later.

== Third-Party Libraries ==
* jQuery: MIT License, https://jquery.org/license/

== Changelog ==

= 1.1 =
* Versi awal dengan fitur dasar.

== Upgrade Notice ==
= 1.2 =
* Menambahkan implementasi langsung di footer.
* Membatasi tampilan hanya pada halaman (bukan post).
* Menambahkan text domain untuk terjemahan.
* Struktur ulang kode untuk standar WordPress.
* Perbaikan keamanan dan validasi input.

= 1.3 =
* Mengganti input URL gambar dengan media uploader untuk performa lebih baik.
* Memperbaiki error JavaScript pada media uploader.
* Menambahkan lisensi eksplisit untuk semua aset.
* Menambahkan file LICENSE untuk kepatuhan GPL.

= 1.4 =
* Added option to enable/disable social proof pop-up per page.
* Optimized script/style loading to only enqueue when pop-up is displayed.
* Mengganti input URL gambar dengan media uploader untuk performa lebih baik.
* Memperbaiki error JavaScript pada media uploader.
* Menambahkan lisensi eksplisit untuk semua aset.
* Menambahkan file LICENSE untuk kepatuhan GPL.
* Added uninstall.php to clean up plugin data (options and post meta) on deletion.
* Fixed missing assets folder in ZIP distribution.
* Fixed PHPCS errors for output escaping and input sanitization.
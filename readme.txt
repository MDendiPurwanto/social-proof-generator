=== Social Proof Generator ===
Contributors: dendiwp
Tags: social proof, notification, popup, marketing
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.2
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
- URL gambar produk kustom
- Hanya ditampilkan pada halaman

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
Kami menyarankan mengunggah gambar ke Media Library WordPress dan menggunakan URL yang dihasilkan. Ini memastikan kompatibilitas dengan fitur WordPress seperti pengoptimalan gambar atau CDN.

== Changelog ==
= 1.2 =
* Menambahkan implementasi langsung di footer.
* Membatasi tampilan hanya pada halaman (bukan post).
* Menambahkan text domain untuk terjemahan.
* Struktur ulang kode untuk standar WordPress.
* Perbaikan keamanan dan validasi input.

= 1.1 =
* Versi awal dengan fitur dasar.

== Upgrade Notice ==
= 1.2 =
Versi ini menghapus kebutuhan untuk menyalin kode dan menambahkan popup langsung ke footer hanya pada halaman. Pastikan untuk memeriksa pengaturan setelah pembaruan.
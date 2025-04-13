/*
 * Social Proof Generator Script
 * Copyright (C) 2025 Muhamad Dendi Purwanto
 * Licensed under the GNU General Public License v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

document.addEventListener('DOMContentLoaded', function() {
    var popup = document.getElementById('spg-popup');
    if (!popup) return;
    var message = popup.querySelector('.spg-content p');

    // Terapkan posisi
    popup.classList.add('spg-' + spgSettings.position);

    // Fungsi untuk memilih nama dan produk acak
    function getRandomName() {
        return spgSettings.names[Math.floor(Math.random() * spgSettings.names.length)];
    }

    function getRandomProduct() {
        return spgSettings.products[Math.floor(Math.random() * spgSettings.products.length)];
    }

    // Fungsi untuk menghasilkan tanggal dan waktu acak
    function getRandomDateTime() {
        var now = new Date();
        var randomDays = Math.floor(Math.random() * 7);
        var randomHours = Math.floor(Math.random() * 24);
        var randomMinutes = Math.floor(Math.random() * 60);
        var randomSeconds = Math.floor(Math.random() * 60);

        now.setDate(now.getDate() - randomDays);
        now.setHours(randomHours, randomMinutes, randomSeconds);

        var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()} ${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}:${now.getSeconds().toString().padStart(2, '0')} (WIB)`;
    }

    // Fungsi untuk menampilkan popup
    function showPopup() {
        var name = getRandomName();
        var product = getRandomProduct();
        var dateTime = getRandomDateTime();
        message.innerHTML = `${name} telah membeli <strong>${product}</strong> pada: ${dateTime}`;
        popup.style.display = 'flex';

        // Terapkan animasi
        popup.style.animation = spgSettings.animation === 'fade' ? 'fadeIn 0.5s' : 'slideIn 0.5s';

        // Sembunyikan setelah durasi
        setTimeout(function() {
            popup.style.display = 'none';
        }, spgSettings.duration);
    }

    // Tampilkan pertama kali dan ulangi setiap 10 detik
    showPopup();
    setInterval(showPopup, 10000);
});
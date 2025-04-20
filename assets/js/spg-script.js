/*
 * Social Proof Generator Script
 * Copyright (C) 2025 Muhamad Dendi Purwanto
 * Licensed under the GNU General Public License v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */
jQuery(document).ready(function($) {
    var settings = socproofgenSettings;
    var $popup = $('#socproofgen-popup');
    var $content = $popup.find('.socproofgen-content p');

    if (!settings.names.length || !settings.products.length) {
        return;
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

    function showPopup() {
        var name = settings.names[Math.floor(Math.random() * settings.names.length)];
        var product = settings.products[Math.floor(Math.random() * settings.products.length)];
        var dateTime = getRandomDateTime();
        $content.html(`${name} Telah membeli ${product} pada: ${dateTime}`);
        
        $popup.css({
            'display': 'block',
            'position': 'fixed',
            [settings.position.includes('bottom') ? 'bottom' : 'top']: '20px',
            [settings.position.includes('right') ? 'right' : 'left']: '20px',
        });

        if (settings.animation === 'fade') {
            $popup.fadeIn();
        } else {
            $popup.slideDown();
        }

        setTimeout(function() {
            if (settings.animation === 'fade') {
                $popup.fadeOut();
            } else {
                $popup.slideUp();
            }
        }, settings.duration * 1000);
    }

    showPopup();
    setInterval(showPopup, (settings.duration + 2) * 1000);
});
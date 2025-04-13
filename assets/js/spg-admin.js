/*
 * Social Proof Generator Script
 * Copyright (C) 2025 Muhamad Dendi Purwanto
 * Licensed under the GNU General Public License v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */


jQuery(document).ready(function($) {
    // Media uploader
    var mediaUploader;
    $('#spg_upload_image_button').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media({
            title: spgAdmin.mediaTitle, 
            button: {
                text: spgAdmin.mediaButton 
            },
            multiple: false
        });
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#spg_image_id').val(attachment.id);
            $('#spg_image_preview').html('<img src="' + attachment.url + '" style="max-width: 100px;">');
            $('#spg_remove_image_button').show();
        });
        mediaUploader.open();
    });

    // Hapus gambar
    $('#spg_remove_image_button').click(function(e) {
        e.preventDefault();
        $('#spg_image_id').val('');
        $('#spg_image_preview').html('');
        $(this).hide();
    });
});
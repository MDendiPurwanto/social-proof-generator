<?php
/**
 * Uninstall script for Social Proof Generator plugin.
 * This file is executed when the plugin is deleted via the WordPress dashboard.
 *
 * @package Social_Proof_Generator
 */

// Pastikan file ini hanya dijalankan saat uninstall
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Hapus semua opsi yang dibuat oleh plugin
delete_option('spg_position');
delete_option('spg_duration');
delete_option('spg_animation');
delete_option('spg_names');
delete_option('spg_products');
delete_option('spg_bg_color');
delete_option('spg_image_id');

// Hapus meta data per halaman
global $wpdb;
$wpdb->query(
    $wpdb->prepare(
        "DELETE FROM $wpdb->postmeta WHERE meta_key = %s",
        '_spg_show_popup'
    )
);
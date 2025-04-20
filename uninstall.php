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
delete_option('socproofgen_position');
delete_option('socproofgen_duration');
delete_option('socproofgen_animation');
delete_option('socproofgen_names');
delete_option('socproofgen_products');
delete_option('socproofgen_bg_color');
delete_option('socproofgen_image_id');

// Hapus meta data per halaman
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
delete_metadata('post', 0, '_socproofgen_show_popup', '', true);
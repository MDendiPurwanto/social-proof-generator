=== Social Proof Generator ===
Contributors: mdendipurwanto
Tags: social proof, popup, notification, marketing, engagement
Requires at least: 5.0
Tested up to: 6.8
Stable tag: 1.4.1
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

A simple plugin to display social proof pop-ups on your WordPress site.

== Description ==
Social Proof Generator allows you to display customizable social proof pop-ups on your WordPress site. You can configure the position, duration, animation, names, products, background color, and even add a product image to your pop-ups.

== Installation ==
1. Upload the `social-proof-generator` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to 'Social Proof' in the WordPress admin menu to configure the settings.

== Frequently Asked Questions ==
= Does the plugin leave any data after uninstall? =
No, the plugin will automatically remove all its data (settings and per-page options) when you delete it via the WordPress dashboard.

== Screenshots ==
1. Admin settings page for configuring the social proof pop-up.
2. Example of a social proof pop-up displayed on a page.

== Changelog ==
= 1.4 =
* Added uninstall.php to clean up plugin data on deletion.
* Fixed missing assets folder in ZIP distribution.
* Fixed PHPCS errors for output escaping and input sanitization.
* Added option to enable/disable social proof pop-up per page.
* Optimized script/style loading to only enqueue when pop-up is displayed.
* Removed load_plugin_textdomain() as it’s not needed for WordPress.org.
* Updated prefix from 'spg' to 'socproofgen_' to meet WordPress.org guidelines.
* Used wp_enqueue_script() and wp_enqueue_style() for JS and CSS.
* Fixed pop-up display, image upload, and form inputs to use textarea.

== Upgrade Notice ==
= 1.4.1 =
Added uninstall, fixed assets, PHPCS errors, per-page popup option, optimized loading, removed load_plugin_textdomain, updated prefix, used wp_enqueue, fixed pop-up, image upload, and forms.
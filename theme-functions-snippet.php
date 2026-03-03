<?php

/**
 * Theme integration snippet for the popup modal.
 *
 * Copy these functions into your theme's functions.php (or include this file).
 *
 * @package WP_Popup
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Check if we're in Cornerstone editor.
 *
 * @return bool True if in Cornerstone editor, false otherwise.
 */
function wp_popup_is_cornerstone_editing()
{
	// Check for Cornerstone query parameter
	if (isset($_GET['cornerstone']) && $_GET['cornerstone'] === 'show') {
		return true;
	}

	// Check for Cornerstone preview mode
	if (isset($_GET['cs']) && $_GET['cs'] === 'show') {
		return true;
	}

	// Check for Cornerstone REST request
	if (defined('REST_REQUEST') && REST_REQUEST && strpos($_SERVER['REQUEST_URI'], '/cornerstone/') !== false) {
		return true;
	}

	return false;
}

/**
 * Enqueue popup assets.
 */
function wp_popup_enqueue_assets()
{
	if (is_admin() || wp_popup_is_cornerstone_editing()) {
		return;
	}

	$base_path = '/wp-popup';
	$css_rel   = $base_path . '/modal-popup.css';
	$js_rel    = $base_path . '/modal-popup.js';

	$css_file = get_stylesheet_directory() . $css_rel;
	$js_file  = get_stylesheet_directory() . $js_rel;

	wp_enqueue_style(
		'wp-popup-modal',
		get_stylesheet_directory_uri() . $css_rel,
		array(),
		file_exists($css_file) ? (string) filemtime($css_file) : null
	);

	wp_enqueue_script(
		'wp-popup-modal',
		get_stylesheet_directory_uri() . $js_rel,
		array(),
		file_exists($js_file) ? (string) filemtime($js_file) : null,
		true
	);
}
add_action('wp_enqueue_scripts', 'wp_popup_enqueue_assets');

/**
 * Render popup template in footer.
 */
function wp_popup_render_template()
{
	static $rendered = false;

	if ($rendered || is_admin() || wp_popup_is_cornerstone_editing()) {
		return;
	}

	$template_file = get_stylesheet_directory() . '/wp-popup/modal-popup-template.php';

	if (file_exists($template_file)) {
		include $template_file;
		$rendered = true;
	}
}
add_action('wp_footer', 'wp_popup_render_template');
add_action('x_after_site_end', 'wp_popup_render_template');
add_action('wp_body_open', 'wp_popup_render_template');
add_action('x_after_site_begin', 'wp_popup_render_template');

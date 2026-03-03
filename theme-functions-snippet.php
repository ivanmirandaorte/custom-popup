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

	// Check for any editing-related query parameters
	if (isset($_GET['cornerstone-edit']) || isset($_GET['cornerstone-preview'])) {
		return true;
	}

	// Check for Cornerstone REST request
	if (defined('REST_REQUEST') && REST_REQUEST && isset($_SERVER['REQUEST_URI'])) {
		if (strpos($_SERVER['REQUEST_URI'], '/cornerstone/') !== false) {
			return true;
		}
	}

	// Check for Cornerstone global
	if (isset($GLOBALS['cornerstone'])) {
		return true;
	}

	// Check for Cornerstone constant
	if (defined('CORNERSTONE_ACTIVE') || defined('CS_ACTIVE')) {
		return true;
	}

	// Check for $_GET parameters that indicate editing
	if (isset($_GET['action']) && $_GET['action'] === 'cornerstone' && isset($_GET['view']) && $_GET['view'] === 'edit') {
		return true;
	}

	// Check for Cornerstone in URL pattern - case insensitive
	if (isset($_SERVER['REQUEST_URI'])) {
		$uri = strtolower($_SERVER['REQUEST_URI']);
		if (
			strpos($uri, 'cornerstone') !== false ||
			strpos($uri, 'x-cornerstone') !== false ||
			strpos($uri, 'cplugin') !== false
		) {
			return true;
		}
	}

	// Check if parent frame is set (Cornerstone uses iframe)
	if (isset($_GET['tb']) && $_GET['tb'] !== '') {
		return true;
	}

	// Check for X-Requested-With header that might indicate AJAX from Cornerstone
	$headers = getallheaders();
	if (isset($headers['X-Requested-With']) && $headers['X-Requested-With'] === 'XMLHttpRequest') {
		if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'cornerstone') !== false) {
			return true;
		}
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

	if ($rendered) {
		return;
	}

	// Check if in admin or Cornerstone editing
	if (is_admin() || wp_popup_is_cornerstone_editing()) {
		return;
	}

	// Extra safety: check if we're in an iframe (common for Cornerstone preview)
	if (isset($_GET['iframe']) || isset($_GET['cornerstone-preview'])) {
		return;
	}

	$template_file = get_stylesheet_directory() . '/wp-popup/modal-popup-template.php';

	if (file_exists($template_file)) {
		include $template_file;
		$rendered = true;
	}
}
add_action('wp_footer', 'wp_popup_render_template', 999);
add_action('x_after_site_end', 'wp_popup_render_template', 999);

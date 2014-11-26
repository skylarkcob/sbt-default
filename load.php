<?php
// Get sb-theme.php file path
$sb_theme = get_template_directory() . '/sb-theme/sb-theme.php';

// Check if sb-theme.php file exists
if(!file_exists($sb_theme)) {
	if(!is_admin()) {
		wp_die(sprintf(__('You must put <strong>SB Theme Core</strong> on your current theme to use it! Click here to %s.', 'sb-theme'), sprintf('<a href="%1$s">%2$s</a>', 'https://github.com/skylarkcob/sb-theme', __('download', 'sb-theme'))));
	} else {
		return;
	}
}

// Load SB Theme Core
require get_template_directory() . '/sb-theme/sb-theme.php';

// Check if SB Core installed and activated
if(!sb_theme_check_core()) {
	return;
}

// Check if theme's using correct SB Theme Core pack
if(!defined('SB_THEME_VERSION') || !class_exists('SB_Theme')) {
	if(!is_admin()) {
		wp_die(sprintf(__('It looks like you\'re using incorrect <strong>SB Theme Core</strong> pack! Click here to %s.', 'sb-theme'), sprintf('<a href="%1$s">%2$s</a>', 'https://github.com/skylarkcob/sb-theme', __('re-download', 'sb-theme'))));
	} else {
		return;
	}
}
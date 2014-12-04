<?php
// Get sb-theme.php file path
$sb_theme = get_template_directory() . '/sb-theme/sb-theme.php';

// Check if sb-theme.php file exists
if(!file_exists($sb_theme)) {
	if(!is_admin()) {
		wp_die(sprintf(__('You must put %1$s on your current theme to use it! Click here to %2$s.', 'sb-theme'), '<strong>SB Theme Core</strong>', sprintf('<a target="_blank" href="%1$s">%2$s</a>', 'https://github.com/skylarkcob/sb-theme/', __('download', 'sb-theme'))));
	} else {
		return;
	}
}

// Load SB Theme Core
require get_template_directory() . '/sb-theme/sb-theme.php';
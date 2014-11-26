<?php
$sb_theme = get_template_directory() . '/sb-theme/sb-theme.php';
if(!file_exists($sb_theme)) {
	if(!is_admin()) {
		wp_die(sprintf(__('You must put <strong>SB Theme Core</strong> on your current theme to use it! Click here to %s.', 'sb-theme'), sprintf('<a href="%1$s">%2$s</a>', 'https://github.com/skylarkcob/sb-theme', __('download', 'sb-theme'))));
	} else {
		return;
	}
}
require get_template_directory() . '/sb-theme/sb-theme.php';

if(!sb_theme_check_core()) {
	return;
}
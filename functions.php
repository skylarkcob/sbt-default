<?php
defined('ABSPATH') or die('Please do not pip me!');

function sb_theme_custom_language($lang) {
	return 'en_US';
}
add_filter('sb_theme_language', 'sb_theme_custom_language');

require get_template_directory() . '/load.php';

// Always put your code below this line
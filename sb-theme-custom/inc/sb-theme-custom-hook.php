<?php
defined('ABSPATH') or die('Please do not pip me!');

function sb_theme_custom_style_and_script() {
    wp_register_style('sb-theme-custom-style', SB_THEME_CUSTOM_URL . '/css/sb-theme-custom-style.css');
    wp_register_style('sb-theme-custom-mobile-style', SB_THEME_CUSTOM_URL . '/css/sb-theme-custom-mobile-style.css');
    wp_register_script('sb-theme-custom', SB_THEME_CUSTOM_URL . '/js/sb-theme-custom-script.js', array('sb-theme'), false, true);
    wp_enqueue_style('sb-theme-custom-style');
    wp_enqueue_style('sb-theme-custom-mobile-style');
    wp_enqueue_script('sb-theme-custom');
    if(SB_Theme::use_user_custom_style()) {
	    wp_register_style('sb-theme-user-custom-style', get_template_directory_uri() . '/custom-style.css');
        wp_enqueue_style('sb-theme-user-custom-style');
    }
}
add_action('wp_enqueue_scripts', 'sb_theme_custom_style_and_script');

function sb_theme_custom_minify_style_and_script() {
    if(!SB_Core::is_theme_developing() && SB_Tool::minify_style_and_script()) {
        SB_Core::minify_styles_and_scripts();
    }
}
add_action('wp_enqueue_scripts', 'sb_theme_custom_minify_style_and_script', 99, 1);
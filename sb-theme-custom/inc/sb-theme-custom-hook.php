<?php
function sb_theme_custom_style_and_script() {
    if(!sb_theme_use_old_version()) {
        SB_Lib::load_bootstrap_and_font_awesome();
    }
    SB_Theme::enqueue_custom_style( 'sb-theme-custom-style', 'sb-theme-custom-style' );
    SB_Theme::enqueue_custom_responsive_style( 'sb-theme-custom-mobile-style', 'sb-theme-custom-mobile-style' );
    SB_Theme::enqueue_custom_script( 'sb-theme-custom', 'sb-theme-custom-script' );
    if(SB_Theme::use_user_custom_style()) {
	    wp_enqueue_style( 'sb-theme-user-custom-style', get_template_directory_uri() . '/custom-style.css' );
    }
}
add_action( 'wp_enqueue_scripts', 'sb_theme_custom_style_and_script' );
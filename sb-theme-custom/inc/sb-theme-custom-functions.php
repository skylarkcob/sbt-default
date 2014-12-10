<?php
function sb_theme_custom_style_and_script() {
    SB_Theme::enqueue_custom_style('sb-theme-custom-style', 'sb-theme-custom-style');
    if(SB_Option::responsive_enabled()) {
        SB_Theme::enqueue_custom_responsive_style('sb-theme-custom-mobile-style', 'sb-theme-custom-mobile-style');
    }
    SB_Theme::enqueue_custom_script('sb-theme-custom', 'sb-theme-custom-script');
}
add_action('wp_enqueue_scripts', 'sb_theme_custom_style_and_script');

// Stop edit from here
require SB_THEME_CUSTOM_INC_PATH . '/sb-theme-custom-load.php';
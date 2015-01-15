<?php
function sb_theme_custom_style_and_script() {
    if(sb_theme_testing()) {
        SB_Theme::enqueue_custom_style('sb-theme-custom-style', 'sb-theme-custom-style');
        if(SB_Option::responsive_enabled()) {
            SB_Theme::enqueue_custom_responsive_style('sb-theme-custom-mobile-style', 'sb-theme-custom-mobile-style');
        }
        SB_Theme::enqueue_custom_script('sb-theme-custom', 'sb-theme-custom-script');
    } else {
        SB_Theme::enqueue_custom_style('sb-theme-custom-style', 'sb-theme-custom-style.min');
        if(SB_Option::responsive_enabled()) {
            SB_Theme::enqueue_custom_responsive_style('sb-theme-custom-mobile-style', 'sb-theme-custom-mobile-style.min');
        }
        SB_Theme::enqueue_custom_script('sb-theme-custom', 'sb-theme-custom-script.min');
    }
    wp_enqueue_style('sb-theme-user-custom-style', get_template_directory_uri() . '/custom-style.css');
}
add_action('wp_enqueue_scripts', 'sb_theme_custom_style_and_script');
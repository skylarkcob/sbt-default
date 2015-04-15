<?php
function sb_theme_use_old_version() {
    if(defined('SB_THEME_USE_OLD_VERSION') && (bool)SB_THEME_USE_OLD_VERSION) {
        return true;
    }
    return false;
}

// Get sb-theme.php file path
$sb_theme = get_template_directory() . '/sb-theme/sb-theme.php';

if(sb_theme_use_old_version()) {

    function sb_theme_missing_core_message() {
        $my_theme = wp_get_theme();
        $theme_name = $my_theme->get('Name');
        return sprintf('<div class="error"><p><strong>' . __('Error', 'sb-theme') . ':</strong> ' . __('The theme with name %1$s can\'t work properly because of missing %2$s core package', 'sb-theme') . '.</p></div>', '<strong>' . $theme_name . '</strong>', sprintf('<a target="_blank" href="%s" style="text-decoration: none">SB Theme</a>', 'http://github.com/skylarkcob/sb-theme'));
    }

    function sb_theme_get_default_wordpress_theme_name() {
        $transient_name = 'sb_default_wordpress_theme';
        if(false === ($default_wordpress_theme = get_transient($transient_name))) {
            $themes = wp_get_themes();
            $wp_theme = '';
            foreach($themes as $theme) {
                $author_uri = $theme->get('AuthorURI');
                if(strrpos($author_uri, 'wordpress.org') !== false) {
                    $wp_theme = $theme;
                    break;
                }
            }
            if(empty($wp_theme)) {
                foreach($themes as $theme) {
                    $text_domain = $theme->get('TextDomain');
                    if(strrpos($text_domain, 'sb-theme') === false) {
                        $wp_theme = $theme;
                        break;
                    }
                }
            }
            if(!empty($wp_theme)) {
                $default_wordpress_theme = $theme->get('TextDomain');
                set_transient($transient_name, $default_wordpress_theme, DAY_IN_SECONDS);
            }
        }
        return $default_wordpress_theme;
    }

    function sb_theme_switch_to_default_theme() {
        $default_wordpress_theme = sb_theme_get_default_wordpress_theme_name();
        if(!empty($default_wordpress_theme)) {
            switch_theme($default_wordpress_theme);
        }
    }

    function sb_theme_switch_to_default_wordpress_theme() {
        unset($_GET['activated']);
        echo sb_theme_missing_core_message();
        sb_theme_switch_to_default_theme();
    }

    // Check if sb-theme.php file exists
    if(!file_exists($sb_theme)) {
        if(!is_admin()) {
            wp_die( sb_theme_missing_core_message() );
            exit;
        } else {
            add_action('admin_notices', 'sb_theme_switch_to_default_wordpress_theme', 0);
        }
        return;
    }

    // Load SB Theme Core
    require get_template_directory() . '/sb-theme/sb-theme.php';
} else {
    function sb_check_theme_core_admin_notices() {
        unset($_GET['activated']);
        $my_theme = wp_get_theme();
        $theme_name = $my_theme->get('Name');
        printf('<div class="error"><p><strong>' . __('Error', 'sb-theme') . ':</strong> ' . __('The theme with name %1$s will be deactivated because of missing %2$s core package.', 'sb-theme') . '.</p></div>', '<strong>' . $theme_name . '</strong>', sprintf('<a target="_blank" href="%s" style="text-decoration: none">SB Theme</a>', 'http://github.com/skylarkcob/sb-theme'));
        $themes = wp_get_themes();
        $wp_theme = '';
        foreach($themes as $theme) {
            $author_uri = $theme->get('AuthorURI');
            if(strrpos($author_uri, 'wordpress.org') !== false) {
                $wp_theme = $theme;
                break;
            }
        }
        if(empty($wp_theme)) {
            foreach($themes as $theme) {
                $text_domain = $theme->get('TextDomain');
                if(strrpos($text_domain, 'sb-theme') === false) {
                    $wp_theme = $theme;
                    break;
                }
            }
        }
        if(!empty($wp_theme)) {
            switch_theme($theme->get('TextDomain'));
        }
    }

    // Check if sb-theme.php file exists
    if(!file_exists($sb_theme)) {
        if(!is_admin()) {
            wp_die(sprintf(__('<strong>Note:</strong> You must put %1$s on your current theme to use it! Click here to %2$s.', 'sb-theme'), '<strong>SB Theme Core</strong>', sprintf('<a target="_blank" href="%1$s">%2$s</a>', 'https://github.com/skylarkcob/sb-theme/', __('download', 'sb-theme'))));
            exit;
        } elseif(!empty($GLOBALS['pagenow']) && 'themes.php' === $GLOBALS['pagenow']) {
            add_action('admin_notices', 'sb_check_theme_core_admin_notices', 0);
        }
        return;
    }

    // Load SB Theme Core
    require get_template_directory() . '/sb-theme/sb-theme.php';
}
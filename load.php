<?php
defined('ABSPATH') or die('Please do not pip me!');

function sb_theme_get_language() {
    global $sb_theme;
    if(!is_array($sb_theme)) {
        $sb_theme = array();
    }
    $sb_theme_language = isset($sb_theme['language']) ? $sb_theme['language'] : 'vi';
    $sb_theme_language = apply_filters('sb_theme_language', $sb_theme_language);
    $sb_theme['language'] = $sb_theme_language;
    return $sb_theme_language;
}

$sb_theme_language = sb_theme_get_language();

define('SB_THEME_WP_PHP_VERSION', '5.2.4');

function sb_theme_php_version_error_message() {
    $sb_theme_language = sb_theme_get_language();
    $message = '<p style="font-family: arial"><strong>';
    $message .= __('PHP version error:', 'sb-theme');
    $message .= '</strong> ';
    $message .= sprintf(__('Your hosting must be support at least %1$s or later for WordPress works fine, encourage use %2$s or later.', 'sb-theme'), '<strong>' . sprintf(__('PHP %s version', 'sb-theme'), SB_THEME_WP_PHP_VERSION) . '</strong>', '<strong>' . sprintf(__('PHP %s version', 'sb-theme'), '5.4') . '</strong>');
    $message .= '</p>';
    if('vi' == $sb_theme_language) {
        $message = '<p style="font-family: arial"><strong>Lỗi phiên bản PHP:</strong> Hosting của bạn phải chạy <strong>PHP phiên bản ' . SB_THEME_WP_PHP_VERSION . '</strong> trở về sau để WordPress có thể hoạt động được, khuyến khích nên dùng <strong>PHP phiên bản 5.4</strong> trở lên.</p>';
    }
    return $message;
}

function sb_theme_php_version_error_admin_notices() {
    echo '<div class="error">' . sb_theme_php_version_error_message() . '</div>';
}

if(version_compare(PHP_VERSION, SB_THEME_WP_PHP_VERSION, '<')) {
    if(is_admin()) {
        add_action('admin_notices', 'sb_theme_php_version_error_admin_notices');
    } else {
        if('vi' == $sb_theme_language) {
            wp_die(sb_theme_php_version_error_message(), 'Lỗi server');
        } else {
            wp_die(sb_theme_php_version_error_message(), 'Server error');
        }
    }
}

define('SB_THEME_GITHUB_URL', 'http://github.com/skylarkcob/sb-theme');

function sb_theme_use_old_version() {
    $value = false;
    if(defined('SB_THEME_USE_OLD_VERSION') && (bool)SB_THEME_USE_OLD_VERSION) {
        $value = true;
    }
    return apply_filters('sb_theme_use_old_version', $value);
}

// Get sb-theme.php file path
$sb_theme = get_template_directory() . '/sb-theme/sb-theme.php';

function sb_theme_missing_core_message() {
    $sb_theme_language = sb_theme_get_language();
    $my_theme = wp_get_theme();
    $theme_name = $my_theme->get('Name');
    $message = sprintf('<div class="error"><p><strong>' . __('Error:', 'sb-theme') . '</strong> ' . __('Theme %1$s will be deactivated because of missing %2$s. Please contact %3$s via email %4$s for more information.', 'sb-theme') . '</p></div>', '<strong>' . $theme_name . '</strong>', sprintf('<a target="_blank" href="%s" style="text-decoration: none">SB Theme</a>', SB_THEME_GITHUB_URL), '<strong>SB Team</strong>', '<i>codewpvn@gmail.com</i>');
    if('vi' == $sb_theme_language) {
        $message = sprintf('<div class="error"><p><strong>Lỗi:</strong> Giao diện %1$s sẽ không hoạt động vì thiếu gói %2$s. Xin vui lòng liên hệ với %3$s thông qua địa chỉ email %4$s để biết thêm thông tin chi tiết.</p></div>', '<strong>' . $theme_name . '</strong>', sprintf('<a target="_blank" href="%s" style="text-decoration: none">SB Theme</a>', SB_THEME_GITHUB_URL), '<strong>SB Team</strong>', '<i>codewpvn@gmail.com</i>');
    }
    return $message;
}

if(sb_theme_use_old_version()) {

    function sb_theme_get_default_wordpress_theme_name() {
        $transient_name = 'sb_theme_default_wordpress_theme_name';
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
        echo sb_theme_missing_core_message();
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
            wp_die(sb_theme_missing_core_message());
            exit;
        } elseif(!empty($GLOBALS['pagenow']) && 'themes.php' === $GLOBALS['pagenow']) {
            add_action('admin_notices', 'sb_check_theme_core_admin_notices', 0);
        }
        return;
    }

    // Check file contain license key
    if(!file_exists(get_template_directory() . '/license.php')) {
        if('vi' == $sb_theme_language) {
            wp_die('<span style="font-family: Tahoma; line-height: 25px;"><strong>Lỗi:</strong> Giao diện <strong>' . $theme->get('Name') . '</strong> mà bạn đang sử dụng chưa được mua bản quyền, xin vui lòng liên hệ với <strong>SB Team</strong> thông qua địa chỉ email <strong>codewpvn@gmail.com</strong> để biết thêm thông tin chi tiết.</span>', 'Giao diện chưa mua bản quyền');
        } else {
            wp_die(__('<span style="font-family: Tahoma; line-height: 25px;"><strong>Error:</strong> <strong>' . $theme->get('Name') . '</strong> theme that you are using is not licensed, please contact <strong>SB Team</strong> via email address <strong>codewpvn@gmail.com</strong> for more information.</span>', 'sb-theme'), 'Theme is not licensed');
        }
        exit;
    }

    // Load license key
    require get_template_directory() . '/license.php';

    // Load SB Theme Core
    require get_template_directory() . '/sb-theme/sb-theme.php';
}
<?php
defined('ABSPATH') or die('Please do not pip me!');
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

if(sb_theme_use_old_version()) {

    function sb_theme_missing_core_message() {
        $my_theme = wp_get_theme();
        $theme_name = $my_theme->get('Name');
        return sprintf('<div class="error"><p><strong>' . __('Lỗi:', 'sb-theme') . '</strong> ' . __('Giao diện với tên %1$s sẽ không hoạt động vì thiếu gói %2$s.', 'sb-theme') . '.</p></div>', '<strong>' . $theme_name . '</strong>', sprintf('<a target="_blank" href="%s" style="text-decoration: none">SB Theme</a>', SB_THEME_GITHUB_URL));
    }

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
        $my_theme = wp_get_theme();
        $theme_name = $my_theme->get('Name');
        printf('<div class="error"><p><strong>' . __('Lỗi:', 'sb-theme') . '</strong> ' . __('Giao diện với tên %1$s sẽ không hoạt động vì thiếu %2$s.', 'sb-theme') . '</p></div>', '<strong>' . $theme_name . '</strong>', sprintf('<a target="_blank" href="%s" style="text-decoration: none">SB Theme</a>', SB_THEME_GITHUB_URL));
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
            wp_die('<strong>' . __('Chú ý:', 'sb-theme') . '</strong>' . sprintf(__('Bạn phải sử dụng gói %1$s để giao diện được hoạt động! Nhấn vào đây để %2$s.', 'sb-theme'), '<strong>SB Theme Core</strong>', sprintf('<a target="_blank" href="%1$s">%2$s</a>', SB_THEME_GITHUB_URL, __('download', 'sb-theme'))));
            exit;
        } elseif(!empty($GLOBALS['pagenow']) && 'themes.php' === $GLOBALS['pagenow']) {
            add_action('admin_notices', 'sb_check_theme_core_admin_notices', 0);
        }
        return;
    }

    // Check file contain license key
    if(!file_exists(get_template_directory() . '/license.php')) {
        wp_die(__('<span style="font-family: Tahoma; line-height: 25px;"><strong>Lỗi</strong>: Giao diện <strong>' . $theme->get('Name') . '</strong> mà bạn đang sử dụng chưa được mua bản quyền, xin vui lòng liên hệ với <strong>SB Team</strong> thông qua địa chỉ email <strong>codewpvn@gmail.com</strong> để biết thêm thông tin chi tiết.</span>', 'sb-theme'), 'Giao diện chưa mua bản quyền');
        exit;
    }

    // Load license key
    require get_template_directory() . '/license.php';

    // Load SB Theme Core
    require get_template_directory() . '/sb-theme/sb-theme.php';
}
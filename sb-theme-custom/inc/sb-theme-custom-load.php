<?php
sb_setup_theme_custom();

if(sb_theme_support_shop()) {
    require SB_THEME_INC_PATH . '/class-sb-product.php';
}

require SB_THEME_CUSTOM_INC_PATH . '/sb-theme-custom-admin.php';

require SB_THEME_CUSTOM_INC_PATH . '/sb-theme-custom-ajax.php';
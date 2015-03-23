<?php
// Get sb-theme.php file path
$sb_theme = get_template_directory() . '/sb-theme/sb-theme.php';

function sb_check_theme_core_admin_notices() {
	unset( $_GET['activated'] );
	$my_theme = wp_get_theme();
	$theme_name = $my_theme->get( 'Name' );
	printf( '<div class="error"><p><strong>' . __( 'Error', 'sb-theme' ) . ':</strong> ' . __( 'The theme with name %1$s will be deactivated because of missing %2$s core package.', 'sb-theme' ) . '.</p></div>', '<strong>' . $theme_name . '</strong>', sprintf( '<a target="_blank" href="%s" style="text-decoration: none">SB Theme</a>', 'http://github.com/skylarkcob/sb-theme' ) );
	$themes = wp_get_themes();
	$wp_theme = '';
	foreach ( $themes as $theme ) {
		$author_uri = $theme->get( 'AuthorURI' );
		if ( false !== strrpos( $author_uri, 'wordpress.org') ) {
			$wp_theme = $theme;
			break;
		}
	}
	if ( empty( $wp_theme ) ) {
		foreach ( $themes as $theme ) {
			$text_domain = $theme->get( 'TextDomain' );
			if ( false === strrpos( $text_domain, 'sb-theme') ) {
				$wp_theme = $theme;
				break;
			}
		}
	}
	if ( ! empty( $wp_theme ) ) {
		switch_theme( $theme->get( 'TextDomain' ) );
	}
}

// Check if sb-theme.php file exists
if ( ! file_exists( $sb_theme ) ) {
	if ( ! is_admin() ) {
		wp_die( sprintf( __( 'You must put %1$s on your current theme to use it! Click here to %2$s.', 'sb-theme' ), '<strong>SB Theme Core</strong>', sprintf( '<a target="_blank" href="%1$s">%2$s</a>', 'https://github.com/skylarkcob/sb-theme/', __( 'download', 'sb-theme' ) ) ) );
		exit;
	} else {
		if ( ! empty( $GLOBALS['pagenow'] ) && 'themes.php' === $GLOBALS['pagenow'] ) {
			add_action( 'admin_notices', 'sb_check_theme_core_admin_notices', 0 );
		}
	}
	return;
}

// Load SB Theme Core
require get_template_directory() . '/sb-theme/sb-theme.php';
<?php
add_action('wp_enqueue_scripts', 'stacy_theme_css', 999);
function stacy_theme_css() {
    wp_enqueue_style( 'stacy-parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style('stacy-child-style',get_stylesheet_directory_uri() . '/style.css',array('parent-style'));
	wp_enqueue_style('bootstrap', ST_TEMPLATE_DIR . '/css/bootstrap.css');
	wp_enqueue_style('default-style-css', get_stylesheet_directory_uri()."/css/default.css" );
	wp_enqueue_style('theme-menu-style', get_stylesheet_directory_uri().'/css/theme-menu.css');
	wp_enqueue_style('media-responsive-css', get_stylesheet_directory_uri()."/css/media-responsive.css" );
	wp_dequeue_style('default-css', get_template_directory_uri() .'/css/default.css');   
}


if ( ! function_exists( 'stacy_theme_setup' ) ) :

function stacy_theme_setup() {

//Load text domain for translation-ready
load_theme_textdomain('stacy', get_stylesheet_directory() . '/languages');
require( get_stylesheet_directory() . '/functions/customizer/customizer_general_settings.php' );
if ( is_admin() ) {
	require get_stylesheet_directory() . '/admin/admin-init.php';
}
}
endif; 
add_action( 'after_setup_theme', 'stacy_theme_setup' );

/**
 * Import options from SpicePress
 *
 */
function stacy_get_lite_options() {
	$spicepress_mods = get_option( 'theme_mods_spicepress' );
	if ( ! empty( $spicepress_mods ) ) {
		foreach ( $spicepress_mods as $spicepress_mod_k => $spicepress_mod_v ) {
			set_theme_mod( $spicepress_mod_k, $spicepress_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'stacy_get_lite_options' );

add_action( 'admin_init', 'stacy_detect_button' );
	function stacy_detect_button() {
	wp_enqueue_style('stacy-info-button', get_stylesheet_directory_uri().'/css/import-button.css');
}
?>
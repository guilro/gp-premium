<?php
/*
Addon Name: Generate Typography
Author: Thomas Usborne
Author URI: http://edge22.com
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Define the version
if ( ! defined( 'GENERATE_FONT_VERSION' ) )
	define( 'GENERATE_FONT_VERSION', GP_PREMIUM_VERSION );

if ( ! function_exists( 'generate_typography_init' ) ) :
add_action('plugins_loaded', 'generate_typography_init');
function generate_typography_init() {
	load_plugin_textdomain( 'generate-typography', false, 'gp-premium/langs/typography/' );
}
endif;

if ( ! function_exists( 'generate_fonts_setup' ) ) :
add_action('after_setup_theme','generate_fonts_setup');
function generate_fonts_setup()
{
	// Here to check if Typography is active
}
endif;

// Include functions identical between standalone addon and GP Premium
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';
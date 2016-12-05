<?php
/*
Addon Name: Generate Colors
Author: Thomas Usborne
Author URI: http://edge22.com
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Define the version
if ( ! defined( 'GENERATE_COLORS_VERSION' ) )
	define( 'GENERATE_COLORS_VERSION', GP_PREMIUM_VERSION );

if ( ! function_exists( 'generate_colors_init' ) ) :
add_action('plugins_loaded', 'generate_colors_init');
function generate_colors_init() {
	load_plugin_textdomain( 'generate-colors', false, 'gp-premium/langs/colors/' );
}
endif;

if ( ! function_exists( 'generate_colors_setup' ) ) :
add_action('after_setup_theme','generate_colors_setup');
function generate_colors_setup()
{
	// Here so we can check to see if Colors is activated
}
endif;

// Include functions identical between standalone addon and GP Premium
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';
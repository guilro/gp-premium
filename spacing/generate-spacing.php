<?php
/*
Addon Name: Generate Spacing
Author: Thomas Usborne
Author URI: http://edge22.com
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Define the version
if ( ! defined( 'GENERATE_SPACING_VERSION' ) )
	define( 'GENERATE_SPACING_VERSION', GP_PREMIUM_VERSION );

if ( ! function_exists( 'generate_spacing_init' ) ) :
add_action('plugins_loaded', 'generate_spacing_init');
function generate_spacing_init() {
	load_plugin_textdomain( 'generate-spacing', false, 'gp-premium/langs/spacing/' );
}
endif;

if ( ! function_exists( 'generate_spacing_setup' ) ) :
function generate_spacing_setup()
{
	// Here so we can check to see if Spacing is active
}
endif;

// Include functions identical between standalone addon and GP Premium
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';

// Include import/export functions
require plugin_dir_path( __FILE__ ) . 'functions/ie.php';
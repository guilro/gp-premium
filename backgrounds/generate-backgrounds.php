<?php
/*
Addon Name: Generate Backgrounds
Author: Thomas Usborne
Author URI: http://edge22.com
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Define the version
if ( ! defined( 'GENERATE_BACKGROUNDS_VERSION' ) )
	define( 'GENERATE_BACKGROUNDS_VERSION', GP_PREMIUM_VERSION );

if ( ! function_exists( 'generate_backgrounds_init' ) ) :
add_action('plugins_loaded', 'generate_backgrounds_init');
function generate_backgrounds_init() {
	load_plugin_textdomain( 'backgrounds', false, 'gp-premium/langs/backgrounds/' );
}
endif;

if ( ! function_exists( 'generate_backgrounds_setup' ) ) :
add_action('after_setup_theme','generate_backgrounds_setup');
function generate_backgrounds_setup()
{
	// This function is here just in case
	// It's kept so we can check to see if Backgrounds is active elsewhere
}
endif;

// Include functions identical between standalone addon and GP Premium
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';

// Include import/export functions
require plugin_dir_path( __FILE__ ) . 'functions/ie.php';
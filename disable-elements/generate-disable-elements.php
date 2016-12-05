<?php
/*
Addon Name: Generate Disable Elements
Author: Thomas Usborne
Author URI: http://edge22.com
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Define the version
if ( ! defined( 'GENERATE_DE_VERSION' ) )
	define( 'GENERATE_DE_VERSION', GP_PREMIUM_VERSION );

if ( !function_exists('generate_disable_elements_init') ) :
add_action('plugins_loaded', 'generate_disable_elements_init');
function generate_disable_elements_init() {
	load_plugin_textdomain( 'disable-elements', false, 'gp-premium/langs/disable-elements/' );
}
endif;

// Include functions identical between standalone addon and GP Premium
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';
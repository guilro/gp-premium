<?php
/*
Addon Name: Generate Import Export
Author: Thomas Usborne
Author URI: http://edge22.com
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Define the version
if ( ! defined( 'GENERATE_IE_VERSION' ) )
	define( 'GENERATE_IE_VERSION', GP_PREMIUM_VERSION );

if ( ! function_exists( 'generate_ie_init' ) ) :
add_action('plugins_loaded', 'generate_ie_init');
function generate_ie_init() {
	load_plugin_textdomain( 'generate-ie', false, 'gp-premium/langs/import-export/' );
}
endif;

// Include functions identical between standalone addon and GP Premium
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';
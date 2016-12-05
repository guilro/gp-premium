<?php
/*
Addon Name: Generate Copyright
Author: Thomas Usborne
Author URI: http://edge22.com
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Define the version
if ( ! defined( 'GENERATE_COPYRIGHT_VERSION' ) )
	define( 'GENERATE_COPYRIGHT_VERSION', GP_PREMIUM_VERSION );

if ( ! function_exists( 'generate_copyright_init' ) ) :
add_action('plugins_loaded', 'generate_copyright_init');
function generate_copyright_init() {
	load_plugin_textdomain( 'generate-copyright', false, 'gp-premium/langs/copyright/' );
}
endif;

// Include functions identical between standalone addon and GP Premium
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';
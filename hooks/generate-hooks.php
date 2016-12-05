<?php
/*
Addon Name: Generate Hooks
Author: Thomas Usborne
Author URI: http://edge22.com
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Define the version
if ( ! defined( 'GENERATE_HOOKS_VERSION' ) )
	define( 'GENERATE_HOOKS_VERSION', GP_PREMIUM_VERSION );

if ( ! function_exists( 'generate_hooks_init' ) ) :
add_action('plugins_loaded', 'generate_hooks_init');
function generate_hooks_init() {
	load_plugin_textdomain( 'generate-hooks', false, 'gp-premium/langs/hooks/' );
}
endif;

// Include import/export
require plugin_dir_path( __FILE__ ) . 'functions/ie.php';

// Include functions identical between standalone addon and GP Premium
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';
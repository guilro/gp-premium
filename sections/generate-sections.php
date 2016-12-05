<?php
/*
Add-on Name: Generate Sections
Author: Thomas Usborne
Author URI: http://edge22.com
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Define the version
if ( ! defined( 'GENERATE_SECTIONS_VERSION' ) )
	define( 'GENERATE_SECTIONS_VERSION', GP_PREMIUM_VERSION );

if ( ! function_exists( 'generate_sections_init' ) ) :
add_action('plugins_loaded', 'generate_sections_init');
function generate_sections_init() {
	load_plugin_textdomain( 'generate-sections', false, 'gp-premium/langs/sections/' );
}
endif;

// Include functions identical between standalone addon and GP Premium
require plugin_dir_path( __FILE__ ) . 'functions/generate-sections.php';
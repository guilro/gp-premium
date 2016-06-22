<?php
/*
Addon Name: Generate Spacing
Author: Thomas Usborne
Author URI: http://edge22.com
*/

// Define the version
if ( ! defined( 'GENERATE_SPACING_VERSION' ) )
	define( 'GENERATE_SPACING_VERSION', GP_PREMIUM_VERSION );
	
// Include assets unique to this addon
require plugin_dir_path( __FILE__ ) . 'inc/assets.php';

// Include functions identical between standalone addon and GP Premium
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';

// Include import/export functions
require plugin_dir_path( __FILE__ ) . 'functions/ie.php';
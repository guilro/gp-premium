<?php
/*
Add-on Name: Generate Blog
Author: Thomas Usborne
Author URI: http://edge22.com
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;
	
// Define the version
if ( ! defined( 'GENERATE_BLOG_VERSION' ) )
	define( 'GENERATE_BLOG_VERSION', GP_PREMIUM_VERSION );

if ( ! function_exists( 'generate_blog_init' ) ) :
add_action('plugins_loaded', 'generate_blog_init');
function generate_blog_init() {
	load_plugin_textdomain( 'generate-blog', false, 'gp-premium/langs/blog/' );
}
endif;

// Include functions identical between standalone addon and GP Premium
require plugin_dir_path( __FILE__ ) . 'functions/generate-blog.php';

// Include import/export functions
require plugin_dir_path( __FILE__ ) . 'functions/ie.php';
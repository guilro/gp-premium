<?php
/*
Plugin Name: GP Premium
Plugin URI: https://generatepress.com
Description: The entire bundle of GeneratePress add-ons. To enable your needed add-ons, go to "Appearance > GeneratePress".
Version: 1.2.86
Author: Thomas Usborne
Author URI: https://tomusborne.com
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: gp-premium
*/

define( 'GP_PREMIUM_VERSION', '1.2.86');
require plugin_dir_path( __FILE__ ) . 'inc/activation.php';

if ( ! function_exists( 'generate_package_setup' ) ) :
add_action( 'plugins_loaded', 'generate_package_setup' );
function generate_package_setup() {
  load_plugin_textdomain( 'gp-premium', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}
endif;

if ( ! function_exists( 'generate_premium_setup' ) ) :
add_action( 'after_setup_theme','generate_premium_setup' );
function generate_premium_setup()
{
	add_filter('widget_text', 'do_shortcode');
}
endif;

if ( 'activated' == get_option( 'generate_package_backgrounds' ) )
	require plugin_dir_path( __FILE__ ) . 'addons/generate-backgrounds/generate-backgrounds.php';

if ( 'activated' == get_option( 'generate_package_blog' ) )
	require plugin_dir_path( __FILE__ ) . 'addons/generate-blog/generate-blog.php';

if ( 'activated' == get_option( 'generate_package_colors' ) )
	require plugin_dir_path( __FILE__ ) . 'addons/generate-colors/generate-colors.php';
	
if ( 'activated' == get_option( 'generate_package_copyright' ) )
	require plugin_dir_path( __FILE__ ) . 'addons/generate-copyright/generate-copyright.php';
	
if ( 'activated' == get_option( 'generate_package_disable_elements' ) )
	require plugin_dir_path( __FILE__ ) . 'addons/generate-disable-elements/generate-disable-elements.php';
	
if ( 'activated' == get_option( 'generate_package_hooks' ) )
	require plugin_dir_path( __FILE__ ) . 'addons/generate-hooks/generate-hooks.php';
	
if ( 'activated' == get_option( 'generate_package_import_export' ) )
	require plugin_dir_path( __FILE__ ) . 'addons/generate-ie/generate-ie.php';
	
if ( 'activated' == get_option( 'generate_package_page_header' ) )
	require plugin_dir_path( __FILE__ ) . 'addons/generate-page-header/generate-page-header.php';
	
if ( 'activated' == get_option( 'generate_package_secondary_nav' ) )
	require plugin_dir_path( __FILE__ ) . 'addons/generate-secondary-nav/generate-secondary-nav.php';
	
if ( 'activated' == get_option( 'generate_package_spacing' ) )
	require plugin_dir_path( __FILE__ ) . 'addons/generate-spacing/generate-spacing.php';
	
if ( 'activated' == get_option( 'generate_package_typography' ) )
	require plugin_dir_path( __FILE__ ) . 'addons/generate-typography/generate-fonts.php';
	
if ( 'activated' == get_option( 'generate_package_sections' ) )
	require plugin_dir_path( __FILE__ ) . 'addons/generate-sections/generate-sections.php';
	
if ( 'activated' == get_option( 'generate_package_menu_plus' ) )
	require plugin_dir_path( __FILE__ ) . 'addons/generate-menu-plus/generate-menu-plus.php';
	
if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	// load our custom updater if it doesn't already exist
	include( dirname( __FILE__ ) . '/inc/EDD_SL_Plugin_Updater.php' );
}

add_action( 'admin_init', 'generate_premium_updater', 0 );
function generate_premium_updater()
{
	// retrieve our license key from the DB
	$license_key = trim( get_option( 'gen_premium_license_key' ) );

	// setup the updater
	$edd_updater = new EDD_SL_Plugin_Updater( 'https://generatepress.com', __FILE__, array( 
			'version' 	=> GP_PREMIUM_VERSION, 		// current version number
			'license' 	=> $license_key, 	// license key (used get_option above to retrieve from DB)
			'item_name'     => 'GP Premium', 	// name of this plugin
			'author' 	=> 'Tom Usborne',  // author of this plugin
			'url'           => home_url()
		)
	);
}
<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( !function_exists('generate_disable_elements_init') ) :
	add_action('init', 'generate_disable_elements_init');
	function generate_disable_elements_init() {
		load_plugin_textdomain( 'generate-disable-elements', false, 'gp-premium/disable-elements/languages' );
	}
endif;
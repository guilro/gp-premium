<?php
if ( !function_exists('generate_disable_elements_init') ) :
	add_action('init', 'generate_disable_elements_init');
	function generate_disable_elements_init() {
		load_plugin_textdomain( 'generate-disable-elements', false, 'gp-premium/addons/generate-disable-elements/languages' );
	}
endif;
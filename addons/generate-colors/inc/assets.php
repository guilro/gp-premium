<?php
if ( ! function_exists( 'generate_colors_init' ) ) :
	add_action('init', 'generate_colors_init');
	function generate_colors_init() {
		load_plugin_textdomain( 'generate-colors', false, 'gp-premium/addons/generate-colors/languages' );
	}
endif;

if ( ! function_exists( 'generate_colors_setup' ) ) :
	add_action('after_setup_theme','generate_colors_setup');
	function generate_colors_setup()
	{
		
	}
endif;
<?php
if ( ! function_exists( 'generate_backgrounds_init' ) ) :
	add_action('init', 'generate_backgrounds_init');
	function generate_backgrounds_init() {
		load_plugin_textdomain( 'generate-backgrounds', false, 'gp-premium/addons/generate-backgrounds/languages/' );
	}
endif;

if ( ! function_exists( 'generate_backgrounds_setup' ) ) :
	add_action('after_setup_theme','generate_backgrounds_setup');
	function generate_backgrounds_setup()
	{
		
	}
endif;
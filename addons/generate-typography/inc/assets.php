<?php
if ( ! function_exists( 'generate_typography_init' ) ) :
add_action('init', 'generate_typography_init');
function generate_typography_init() {
	load_plugin_textdomain( 'generate-typography', false, 'gp-premium/addons/generate-typography/languages' );
}
endif;

if ( ! function_exists( 'generate_fonts_setup' ) ) :
add_action('after_setup_theme','generate_fonts_setup');
function generate_fonts_setup()
{
	
}
endif;
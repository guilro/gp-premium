<?php
if ( ! function_exists( 'generate_spacing_init' ) ) :
add_action('init', 'generate_spacing_init');
function generate_spacing_init() {
	load_plugin_textdomain( 'generate-spacing', false, 'gp-premium/addons/generate-spacing/languages' );
}
endif;

if ( ! function_exists( 'generate_spacing_setup' ) ) :
function generate_spacing_setup()
{

}
endif;
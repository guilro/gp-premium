<?php
if ( ! function_exists( 'generate_sections_init' ) ) :
add_action('init', 'generate_sections_init');
function generate_sections_init() {
	load_plugin_textdomain( 'generate-sections', false, 'gp-premium/addons/generate-sections/languages' );
}
endif;
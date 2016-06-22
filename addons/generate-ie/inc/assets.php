<?php
if ( ! function_exists( 'generate_ie_init' ) ) :
add_action('init', 'generate_ie_init');
function generate_ie_init() {
	load_plugin_textdomain( 'generate-ie', false, 'gp-premium/addons/generate-ie/languages' );
}
endif;
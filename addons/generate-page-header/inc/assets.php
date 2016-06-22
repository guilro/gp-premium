<?php
if ( ! function_exists( 'generate_page_header_init' ) ) :
add_action('init', 'generate_page_header_init');
function generate_page_header_init() {
	load_plugin_textdomain( 'generate-page-header', false, 'gp-premium/addons/generate-page-header/languages' );
}
endif;
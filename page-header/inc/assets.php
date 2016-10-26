<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'generate_page_header_init' ) ) :
add_action('init', 'generate_page_header_init');
function generate_page_header_init() {
	load_plugin_textdomain( 'generate-page-header', false, 'gp-premium/page-header/languages' );
}
endif;
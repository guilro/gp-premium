<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'generate_copyright_init' ) ) :
	add_action('init', 'generate_copyright_init');
	function generate_copyright_init() {
		load_plugin_textdomain( 'generate-copyright', false, 'gp-premium/copyright/languages' );
	}
endif;
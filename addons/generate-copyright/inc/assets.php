<?php
if ( ! function_exists( 'generate_copyright_init' ) ) :
	add_action('init', 'generate_copyright_init');
	function generate_copyright_init() {
		load_plugin_textdomain( 'generate-copyright', false, 'gp-premium/addons/generate-copyright/languages' );
	}
endif;
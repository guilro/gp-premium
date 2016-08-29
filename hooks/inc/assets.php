<?php
if ( ! function_exists( 'generate_hooks_init' ) ) :
	add_action('init', 'generate_hooks_init');
	function generate_hooks_init() {
		load_plugin_textdomain( 'generate-hooks', false, 'gp-premium/hooks/languages' );
	}
endif;
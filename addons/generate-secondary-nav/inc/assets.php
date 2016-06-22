<?php
if ( ! function_exists( 'generate_secondary_nav_init' ) ) :
add_action('init', 'generate_secondary_nav_init');
function generate_secondary_nav_init() {
	load_plugin_textdomain( 'generate-secondary-nav', false, 'gp-premium/addons/generate-secondary-nav/languages' );
}
endif;
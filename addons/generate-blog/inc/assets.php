<?php
if ( ! function_exists( 'generate_blog_init' ) ) :
add_action('init', 'generate_blog_init');
function generate_blog_init() {
	load_plugin_textdomain( 'generate-blog', false, 'gp-premium/addons/generate-blog/languages/' );
}
endif;
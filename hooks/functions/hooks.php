<?php
if ( ! function_exists( 'generate_execute_hooks' ) ) :
function generate_execute_hooks( $id ) 
{
	$hooks = get_option( 'generate_hooks' );
	
	$content = isset( $hooks[$id] ) ? $hooks[$id] : null;
	
	$disable = isset( $hooks[$id . '_disable'] ) ? $hooks[$id . '_disable'] : null;

	if( ! $content || 'true' == $disable )
		return;

	$php = isset( $hooks[$id . '_php'] ) ? $hooks[$id . '_php'] : null;

	$value = do_shortcode( $content );

	if ( 'true' == $php )
		eval( "?>$value<?php " );
	else
		echo $value;
}
endif;

if ( ! function_exists( 'generate_hooks_wp_head' ) ) :
add_action('wp_head', 'generate_hooks_wp_head', 10);
function generate_hooks_wp_head()
{
	generate_execute_hooks( 'generate_wp_head' );
}
endif;

if ( ! function_exists( 'generate_hooks_before_header' ) ) :
add_action('generate_before_header', 'generate_hooks_before_header', 4);
function generate_hooks_before_header()
{
	generate_execute_hooks( 'generate_before_header' );
}
endif;

if ( ! function_exists( 'generate_hooks_before_header_content' ) ) :
add_action('generate_before_header_content', 'generate_hooks_before_header_content', 10);
function generate_hooks_before_header_content()
{
	generate_execute_hooks( 'generate_before_header_content' );
}
endif;

if ( ! function_exists( 'generate_hooks_after_header_content' ) ) :
add_action('generate_after_header_content', 'generate_hooks_after_header_content', 10);
function generate_hooks_after_header_content()
{
	generate_execute_hooks( 'generate_after_header_content' );
}
endif;

if ( ! function_exists( 'generate_hooks_after_header' ) ) :
add_action('generate_after_header', 'generate_hooks_after_header', 10);
function generate_hooks_after_header()
{
	generate_execute_hooks( 'generate_after_header' );
}
endif;

if ( ! function_exists( 'generate_hooks_inside_main_content' ) ) :
add_action('generate_before_main_content', 'generate_hooks_inside_main_content', 9);
function generate_hooks_inside_main_content()
{
	generate_execute_hooks( 'generate_before_main_content' );
}
endif;

if ( ! function_exists( 'generate_hooks_before_content' ) ) :
add_action('generate_before_content', 'generate_hooks_before_content', 10);
function generate_hooks_before_content()
{
	generate_execute_hooks( 'generate_before_content' );
}
endif;

if ( ! function_exists( 'generate_hooks_after_entry_header' ) ) :
add_action('generate_after_entry_header', 'generate_hooks_after_entry_header', 10);
function generate_hooks_after_entry_header()
{
	generate_execute_hooks( 'generate_after_entry_header' );
}
endif;

if ( ! function_exists( 'generate_hooks_after_content' ) ) :
add_action('generate_after_content', 'generate_hooks_after_content', 10);
function generate_hooks_after_content()
{
	generate_execute_hooks( 'generate_after_content' );
}
endif;

if ( ! function_exists( 'generate_hooks_before_right_sidebar_content' ) ) :
add_action('generate_before_right_sidebar_content', 'generate_hooks_before_right_sidebar_content', 5);
function generate_hooks_before_right_sidebar_content()
{
	generate_execute_hooks( 'generate_before_right_sidebar_content' );
}
endif;

if ( ! function_exists( 'generate_hooks_after_right_sidebar_content' ) ) :
add_action('generate_after_right_sidebar_content', 'generate_hooks_after_right_sidebar_content', 10);
function generate_hooks_after_right_sidebar_content()
{
	generate_execute_hooks( 'generate_after_right_sidebar_content' );
}
endif;

if ( ! function_exists( 'generate_hooks_before_left_sidebar_content' ) ) :
add_action('generate_before_left_sidebar_content', 'generate_hooks_before_left_sidebar_content', 5);
function generate_hooks_before_left_sidebar_content()
{
	generate_execute_hooks( 'generate_before_left_sidebar_content' );
}
endif;

if ( ! function_exists( 'generate_hooks_after_left_sidebar_content' ) ) :
add_action('generate_after_left_sidebar_content', 'generate_hooks_after_left_sidebar_content', 10);
function generate_hooks_after_left_sidebar_content()
{
	generate_execute_hooks( 'generate_after_left_sidebar_content' );
}
endif;

if ( ! function_exists( 'generate_hooks_before_footer' ) ) :
add_action('generate_before_footer', 'generate_hooks_before_footer', 10);
function generate_hooks_before_footer()
{
	generate_execute_hooks( 'generate_before_footer' );
}
endif;

if ( ! function_exists( 'generate_hooks_after_footer_widgets' ) ) :
add_action('generate_after_footer_widgets', 'generate_hooks_after_footer_widgets', 10);
function generate_hooks_after_footer_widgets()
{
	generate_execute_hooks( 'generate_after_footer_widgets' );
}
endif;

if ( ! function_exists( 'generate_hooks_before_footer_content' ) ) :
add_action('generate_before_footer_content', 'generate_hooks_before_footer_content', 10);
function generate_hooks_before_footer_content()
{
	generate_execute_hooks( 'generate_before_footer_content' );
}
endif;

if ( ! function_exists( 'generate_hooks_after_footer_content' ) ) :
add_action('generate_after_footer_content', 'generate_hooks_after_footer_content', 10);
function generate_hooks_after_footer_content()
{
	generate_execute_hooks( 'generate_after_footer_content' );
}
endif;

if ( ! function_exists( 'generate_hooks_wp_footer' ) ) :
add_action('wp_footer', 'generate_hooks_wp_footer', 10);
function generate_hooks_wp_footer()
{
	generate_execute_hooks( 'generate_wp_footer' );
}
endif;
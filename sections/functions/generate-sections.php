<?php
if ( ! function_exists( 'generate_sections_page_template' ) ) :
/**
 * Use our custom template if sections are enabled
 */
add_filter( 'template_include', 'generate_sections_page_template' );
function generate_sections_page_template( $template ) {

	global $post;
	$use_sections = ( isset( $post ) ) ? get_post_meta( $post->ID, '_generate_use_sections', TRUE) : '';
	
	if ( is_home() || is_archive() || is_search() || is_attachment() || is_tax() ) {
		return $template;
	}
	
	if ( isset( $use_sections['use_sections'] ) && 'true' == $use_sections['use_sections'] ) {	
		
		$new_template = dirname( __FILE__ ) . '/templates/template.php';
		
		if ( '' != $new_template ) {
			return $new_template;
		}
	}
	return $template;
	
}
endif;

if ( ! function_exists( 'generate_sections_show_excerpt' ) ) :
add_filter( 'generate_show_excerpt','generate_sections_show_excerpt' );
function generate_sections_show_excerpt( $show_excerpt )
{
	global $post;
	$use_sections = ( isset( $post ) ) ? get_post_meta( $post->ID, '_generate_use_sections', TRUE) : '';
	
	if ( isset( $use_sections['use_sections'] ) && 'true' == $use_sections['use_sections'] ) {	
		return true;
	}
	return $show_excerpt;
}
endif;

if ( ! function_exists( 'generate_sections_styles' ) ) :
/**
 * Enqueue necessary scripts if sections are enabled
 */
add_action( 'wp_enqueue_scripts', 'generate_sections_styles' );
function generate_sections_styles() {

	global $post;
	$use_sections = ( isset( $post ) ) ? get_post_meta( $post->ID, '_generate_use_sections', TRUE) : '';
	
	if ( is_home() || is_archive() || is_search() || is_attachment() || is_tax() ) {
		return;
	}
	
	if ( isset( $use_sections['use_sections'] ) && 'true' == $use_sections['use_sections'] ) {	
		wp_enqueue_style( 'generate-sections-styles', plugin_dir_url( __FILE__ ) . 'css/style.min.css' );
		wp_enqueue_script( 'generate-sections-parallax', plugin_dir_url( __FILE__ ) . 'js/parallax.min.js', array('jquery'), GENERATE_VERSION, true );
	} 
}
endif;

if ( ! function_exists( 'generate_sections_admin_body_class' ) ) :
add_filter( 'admin_body_class', 'generate_sections_admin_body_class' );
function generate_sections_admin_body_class( $classes )
{
	global $post;
	$use_sections = ( isset( $post ) ) ? get_post_meta( $post->ID, '_generate_use_sections', TRUE) : '';
	
	if ( is_home() || is_archive() || is_search() || is_attachment() || is_tax() ) {
		return $classes;
	}
	
	if ( isset( $use_sections['use_sections'] ) && 'true' == $use_sections['use_sections'] ) {	
		$classes .= ' generate-sections-enabled';
	}
	
    return $classes;
}
endif;

if ( ! function_exists( 'generate_sections_content_width' ) ) :
/**
 * Set our content width when sections are enabled
 */
add_action( 'wp','generate_sections_content_width', 50 );
function generate_sections_content_width()
{
	global $post;
	$use_sections = ( isset( $post ) ) ? get_post_meta( $post->ID, '_generate_use_sections', TRUE) : '';
	
	if ( isset( $use_sections['use_sections'] ) && 'true' == $use_sections['use_sections'] ) {	
		global $content_width;
		$content_width = 2000;
	}
}
endif;

if ( ! function_exists( 'generate_sections_body_classes' ) ) :
/**
 * Add classes to our <body> element when sections are enabled
 */
add_filter( 'body_class', 'generate_sections_body_classes');
function generate_sections_body_classes( $classes )
{
	global $post;
	$use_sections = ( isset( $post ) ) ? get_post_meta( $post->ID, '_generate_use_sections', TRUE) : '';
	$sidebars = apply_filters( 'generate_sections_sidebars', false );
	
	if ( is_home() || is_archive() || is_search() || is_attachment() || is_tax() ) {
		return $classes;
	}
	
	if ( isset( $use_sections['use_sections'] ) && 'true' == $use_sections['use_sections'] ) {	
		$classes[] = 'generate-sections-enabled';
	}
	
	if ( ! $sidebars ) {
		$classes[] = 'sections-no-sidebars';
	} else {
		$classes[] = 'sections-sidebars';
	}
	
	return $classes;
}
endif;

if ( ! function_exists( 'generate_sections_scripts' ) ) :
/**
 * Enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'generate_sections_scripts', 50 );
function generate_sections_scripts() {
	
	global $post;
	$use_sections = ( isset( $post ) ) ? get_post_meta( $post->ID, '_generate_use_sections', TRUE) : '';
	
	if ( ! isset( $use_sections['use_sections'] ) )
		return;
	
	if ( 'true' !== $use_sections['use_sections'] )
		return;
	
	if ( is_home() || is_archive() || is_search() || is_attachment() || is_tax() ) {
		return;
	}
	
	if ( function_exists( 'generate_spacing_get_defaults' ) ) :
		$spacing_settings = wp_parse_args( 
			get_option( 'generate_spacing_settings', array() ), 
			generate_spacing_get_defaults() 
		);	

		$right_padding = $spacing_settings['content_left'];
		$left_padding = $spacing_settings['content_right'];
	else :
		$right_padding = 40;
		$left_padding = 40;
	endif;
	
	$css = '.generate-sections-inside-container {padding-left:' . $left_padding . 'px;padding-right:' . $right_padding . 'px;}';

	wp_add_inline_style( 'generate-style', $css );
	
}
endif;

if ( ! function_exists( 'generate_sections_add_css' ) ) :
/**
 * Create the CSS for our sections
 */
add_action( 'wp_enqueue_scripts', 'generate_sections_add_css', 500 );
function generate_sections_add_css()
{
	
	global $post;
	$use_sections = ( isset( $post ) ) ? get_post_meta( $post->ID, '_generate_use_sections', TRUE) : '';
	
	if ( ! isset( $use_sections['use_sections'] ) )
		return;
	
	if ( 'true' !== $use_sections['use_sections'] )
		return;
	
	if ( is_home() || is_archive() || is_search() || is_attachment() || is_tax() ) {
		return;
	}
		
	$sections = ( isset( $post ) ) ? get_post_meta( $post->ID, '_generate_sections', TRUE) : '';
		
	// check if the repeater field has rows of data
	if( '' !== $sections ) :
					
		// loop through the rows of data
		$i = 0;
		foreach ( $sections['sections'] as $section ) :
			$i++;
			
			// Get image details
			$image_id = ( isset( $section['background_image'] ) ) ? intval( $section['background_image'] ) : '';
			$image_url = ( '' !== $image_id ) ? wp_get_attachment_image_src( $image_id, 'full' ) : '';
			
			// Get the padding type
			$padding_type = apply_filters( 'generate_sections_padding_type','px' );
			
			// Default padding top
			$padding_top = apply_filters( 'generate_sections_default_padding_top','40' );
			
			// Default padding bottom
			$padding_bottom = apply_filters( 'generate_sections_default_padding_bottom','40' );

			// Get the values
			$css = '';
			$background_color = ( isset( $section['background_color'] ) ) ? 'background-color: ' . $section['background_color'] . ';' : '';
			$background_image = ( '' !== $image_url ) ? 'background-image: url(' . $image_url[0] . ');' : '';
			$text_color = ( isset( $section['text_color'] ) ) ? 'color: ' . $section['text_color'] . ';' : '';
			$link_color = ( isset( $section['link_color'] ) ) ? 'color: ' . $section['link_color'] . ';' : '';
			$link_color_hover = ( isset( $section['link_color_hover'] ) ) ? 'color: ' . $section['link_color_hover'] . ';' : '';
			$top_padding = ( isset( $section['top_padding'] ) ) ? 'padding-top: ' . intval( $section['top_padding'] ) . $padding_type . ';' : 'padding-top: ' . $padding_top . 'px;';
			$bottom_padding = ( isset( $section['bottom_padding'] ) ) ? 'padding-bottom: ' . intval( $section['bottom_padding'] ) . $padding_type . ';' : 'padding-bottom: ' . $padding_bottom . 'px;';
			
			// Outer container
			if ( '' !== $background_color || '' !== $background_image ) :
				$css .= "#generate-section-$i { $background_color $background_image }";
			endif;
			
			// Inner container
			if ( '' !== $top_padding || '' !== $bottom_padding || '' !== $text_color ) :
				$css .= "#generate-section-$i .generate-sections-inside-container { $top_padding $bottom_padding $text_color }";
			endif;
			
			// Link color
			if ( '' !== $link_color ) :
				$css .= "#generate-section-$i a,#generate-section-$i a:visited { $link_color }";
			endif;
			
			// Link color hover
			if ( '' !== $link_color_hover ) :
				$css .= "#generate-section-$i a:hover { $link_color_hover }";
			endif;	
			
			// Build CSS
			wp_add_inline_style( 'generate-style', $css );
		endforeach;
			
	endif;
}
endif;

/*
 * Functions for creating the metaboxes
 */
if ( ! function_exists( 'generate_sections_add_metaboxes' ) ) :
add_action( 'init','generate_sections_add_metaboxes' );
function generate_sections_add_metaboxes()
{
	if ( ! class_exists( 'WPAlchemy_MetaBox' ) ) include_once 'wpalchemy/MetaBox.php';
	
	$post_types = apply_filters( 'generate_sections_post_types', array( 'page', 'post' ) );

	$use_sections = new WPAlchemy_MetaBox(array(
		'id' => '_generate_use_sections',
		'title' => __( 'Use Sections','generate-sections' ),
		'template' => plugin_dir_path( __FILE__ ) . 'wpalchemy/use-sections.php',
		'init_action' => 'generate_sections_metabox_init', 
		'context' => 'side',
		'priority' => 'high',
		'autosave' => TRUE,
		'types' => $post_types
	));

	$sections = new WPAlchemy_MetaBox(array(
		'id' => '_generate_sections',
		'title' => __( 'Sections','generate-sections' ),
		'template' => plugin_dir_path( __FILE__ ) . 'wpalchemy/repeating-textarea.php',
		'init_action' => 'generate_sections_metabox_init', 
		'save_filter' => 'generate_sections_repeating_save_filter',
		'autosave' => TRUE,
		'types' => $post_types
	));
}
endif;

if ( ! function_exists( 'generate_sections_save_function' ) ) :
	function generate_sections_save_function( &$item, $key ) {
	
		if( isset( $item['content'] ) ){
			$item['content'] = sanitize_post_field( 'post_content', $item['content'], $post_id, 'db' );
  		}
			
		if( isset( $item['custom_classes'] ) ){
			$item['custom_classes'] = sanitize_text_field( $item['custom_classes'] );
  		}
			
		if( isset( $item['top_padding'] ) ){
			$item['top_padding'] = absint( $item['top_padding'] );
  		}
			
		if( isset( $item['bottom_padding'] ) ){
			$item['bottom_padding'] = absint( $item['bottom_padding'] );
  		}
			
		if( isset( $item['background_image'] ) ){
			$item['background_image'] = absint( $item['background_image'] );
  		}
		
	}
endif;

if ( ! function_exists( 'generate_sections_repeating_save_filter' ) ) :
/* 
 * Sanitize the input similar to post_content
 * @param array $meta - all data from metabox
 * @param int $post_id
 * @return array
 */
function generate_sections_repeating_save_filter( $meta, $post_id ){

	if ( is_array( $meta ) && ! empty( $meta ) ){

		array_walk( $meta, 'generate_sections_save_function' );

	}

	return $meta;

}
endif;

if ( ! function_exists( 'generate_sections_metabox_init' ) ) :
/* 
 * Enqueue styles and scripts specific to metaboxs
 */
function generate_sections_metabox_init(){
	
	// I prefer to enqueue the styles only on pages that are using the metaboxes
	wp_enqueue_style( 'generate-sections-metabox', plugin_dir_url( __FILE__ ) . 'wpalchemy/css/meta.css');
	wp_enqueue_style( 'generate-style-grid', get_template_directory_uri() . '/css/unsemantic-grid.css', false, GENERATE_VERSION, 'all' );

	//make sure we enqueue some scripts just in case ( only needed for repeating metaboxes )
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-widget' );
	wp_enqueue_script( 'jquery-ui-mouse' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_style( 'wp-color-picker' );
	
	// special script for dealing with repeating textareas- needs to run AFTER all the tinyMCE init scripts, so make 'editor' a requirement
	wp_enqueue_script( 'generate-sections-metabox', plugin_dir_url( __FILE__ ) . 'wpalchemy/js/sections-metabox.js', array( 'jquery', 'editor', 'media-upload', 'wp-color-picker' ), GENERATE_SECTIONS_VERSION, true );
	$translation_array = array(
		'no_content_error' => __( 'Error: Content already detected in default editor.', 'generate-sections' ),
		'use_visual_editor' => __( 'Please activate the "Visual" tab in your main editor before transferring content.', 'generate-sections' )
	);
	wp_localize_script( 'generate-sections-metabox', 'generate_sections', $translation_array );
}
endif;

/* 
 * Recreate the default filters on the_content
 * this will make it much easier to output the meta content with proper/expected formatting
*/
if ( ! function_exists( 'generate_sections_filter_admin_init' ) ) :
add_action( 'admin_init','generate_sections_filter_admin_init' );
function generate_sections_filter_admin_init()
{
	if ( user_can_richedit() ) {
		add_filter( 'generate_section_content', 'convert_smilies'    );
		add_filter( 'generate_section_content', 'convert_chars'      );
		add_filter( 'generate_section_content', 'wpautop'            );
		add_filter( 'generate_section_content', 'shortcode_unautop'  );
		add_filter( 'generate_section_content', 'prepend_attachment' );
	}
}
endif;

if ( ! function_exists( 'generate_sections_filter' ) ) :
add_action( 'init','generate_sections_filter' );
function generate_sections_filter()
{
	if ( is_admin() )
		return;
	
	add_filter( 'generate_section_content', 'convert_smilies'    );
	add_filter( 'generate_section_content', 'convert_chars'      );
	add_filter( 'generate_section_content', 'wpautop'            );
	add_filter( 'generate_section_content', 'shortcode_unautop'  );
	add_filter( 'generate_section_content', 'prepend_attachment' );
	add_filter( 'generate_section_content', 'do_shortcode');
}
endif;
/* eof */
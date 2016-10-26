<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

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
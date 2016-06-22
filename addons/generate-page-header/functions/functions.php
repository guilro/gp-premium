<?php
if ( ! function_exists( 'generate_page_header_admin_enqueue' ) ) :
add_action('admin_enqueue_scripts','generate_page_header_admin_enqueue');
function generate_page_header_admin_enqueue() {
	wp_enqueue_script('wp-color-picker');
    wp_enqueue_style( 'wp-color-picker' );
}
endif;

if ( ! function_exists( 'generate_page_header_enqueue' ) ) :
add_action( 'wp_enqueue_scripts','generate_page_header_enqueue' );
function generate_page_header_enqueue()
{
	if ( is_home() ) :
		$options = get_option( 'generate_page_header_options', '' );
		$image_background_fixed = ( !empty( $options['page_header_add_parallax'] ) ) ? $options['page_header_add_parallax'] : '';
		$fullscreen = ( !empty( $options['page_header_full_screen'] ) ) ? $options['page_header_full_screen'] : '';
		$video = ( !empty( $options['page_header_video'] ) ) ? $options['page_header_video'] : '';
		$page_header_content = ( !empty( $options['page_header_content'] ) ) ? $options['page_header_content'] : '';
	else :
		global $post;
		$image_background_fixed = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-fixed', true ) : '';
		$fullscreen = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-full-screen', true ) : '';
		$video = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-video', true ) : '';
		$page_header_content = get_post_meta( get_the_ID(), '_meta-generate-page-header-content', true );
	endif;
	
	if ( ( '' !== $image_background_fixed || '' !== $fullscreen ) && '' !== $page_header_content ) :
		wp_enqueue_script( 'generate-page-header-parallax', plugin_dir_url( __FILE__ ) . 'js/parallax.min.js', array('jquery'), '', true );
	endif;
	
	if ( '' !== $video && '' !== $page_header_content ) :
		wp_enqueue_script( 'generate-page-header-video', plugin_dir_url( __FILE__ ) . 'js/jquery.vide.min.js', array('jquery'), '', true );
	endif;
}
endif;

/*
 * Load our image resizer
 */
if ( ! defined( 'GP_IMAGE_RESIZER' ) && ! class_exists( 'GP_Resize' ) )
	require plugin_dir_path( __FILE__ ) . 'aq_resizer.php';

/**
 * Load Page Header Blog Customizer
 */
require plugin_dir_path( __FILE__ ) . 'customizer.php';

if ( ! function_exists( 'generate_combined_page_header_start' ) ) :
add_action( 'generate_before_header','generate_combined_page_header_start', 0 );
function generate_combined_page_header_start()
{
	if ( is_home() ) :
		$options = get_option( 'generate_page_header_options', '' );
		$combine = ( !empty( $options['page_header_combine'] ) ) ? $options['page_header_combine'] : '';
		$page_header_content = ( !empty( $options['page_header_content'] ) ) ? $options['page_header_content'] : '';
	else :
		global $post;
		$combine = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-combine', true ) : '';
		$page_header_content = get_post_meta( get_the_ID(), '_meta-generate-page-header-content', true );
	endif;
	if ( '' == $combine || ! isset( $combine ) || '' == $page_header_content )
		return;
	
	echo '<div class="generate-combined-header">';
}
endif;

if ( ! function_exists( 'generate_combined_page_header_end' ) ) :
add_action( 'generate_after_header','generate_combined_page_header_end', 9 );
function generate_combined_page_header_end()
{
	if ( is_home() ) :
		$options = get_option( 'generate_page_header_options', '' );
		$combine = ( !empty( $options['page_header_combine'] ) ) ? $options['page_header_combine'] : '';
		$page_header_content = ( !empty( $options['page_header_content'] ) ) ? $options['page_header_content'] : '';
	else :
		global $post;
		$combine = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-combine', true ) : '';
		$page_header_content = get_post_meta( get_the_ID(), '_meta-generate-page-header-content', true );
	endif;
	if ( '' == $combine || ! isset( $combine ) || '' == $page_header_content  )
		return;
	
	echo '</div><!-- .generate-combined-header -->';
}
endif;

/**
 * Generate the CSS in the <head> section using the Theme Customizer
 * @since 0.1
 */
if ( !function_exists( 'generate_page_header_css' ) ) :
	function generate_page_header_css()
	{
		if ( is_home() ) :
			$options = get_option( 'generate_page_header_options', '' );
			$header_content = ( !empty( $options['page_header_content'] ) ) ? $options['page_header_content'] : '';
			$image_background = ( !empty( $options['page_header_image_background'] ) ) ? $options['page_header_image_background'] : '';
			$image_background_type = ( !empty( $options['page_header_container_type'] ) ) ? $options['page_header_container_type'] : '';
			$image_background_fixed = ( !empty( $options['page_header_add_parallax'] ) ) ? $options['page_header_add_parallax'] : '';
			$image_background_alignment = ( !empty( $options['page_header_text_alignment'] ) ) ? $options['page_header_text_alignment'] : '';
			$image_background_spacing = ( !empty( $options['page_header_padding'] ) ) ? $options['page_header_padding'] : '';
			$image_background_color = ( !empty( $options['page_header_background_color'] ) ) ? $options['page_header_background_color'] : '';
			$image_background_text_color = ( !empty( $options['page_header_text_color'] ) ) ? $options['page_header_text_color'] : '';
			$image_background_link_color = ( !empty( $options['page_header_link_color'] ) ) ? $options['page_header_link_color'] : '';
			$image_background_link_color_hover = ( !empty( $options['page_header_link_color_hover'] ) ) ? $options['page_header_link_color_hover'] : '';
			$page_header_image_custom = ( !empty( $options['page_header_image'] ) ) ? $options['page_header_image'] : '';
			$combine = ( !empty( $options['page_header_combine'] ) ) ? $options['page_header_combine'] : '';
			$fullscreen = ( !empty( $options['page_header_full_screen'] ) ) ? $options['page_header_full_screen'] : '';
			$navigation_background = ( !empty( $options['page_header_transparent_navigation'] ) ) ? $options['page_header_transparent_navigation'] : '';
			$navigation_text = ( !empty( $options['page_header_image'] ) && '' !== $navigation_background ) ? $options['page_header_navigation_text'] : '';
			$navigation_background_hover = ( !empty( $options['page_header_image'] ) && '' !== $navigation_background ) ? $options['page_header_navigation_background_hover'] : '';
			$navigation_text_hover = ( !empty( $options['page_header_navigation_text_hover'] ) && '' !== $navigation_background ) ? $options['page_header_navigation_text_hover'] : '';
			$navigation_background_current = ( !empty( $options['page_header_navigation_background_current'] ) && '' !== $navigation_background ) ? $options['page_header_navigation_background_current'] : '';
			$navigation_text_current = ( !empty( $options['page_header_navigation_text_current'] ) && '' !== $navigation_background ) ? $options['page_header_navigation_text_current'] : '';
			$site_title = ( !empty( $options['page_header_site_title'] ) ) ? $options['page_header_site_title'] : '';
			$site_tagline = ( !empty( $options['page_header_site_tagline'] ) ) ? $options['page_header_site_tagline'] : '';
			$page_header_video = ( !empty( $options['page_header_video'] ) ) ? $options['page_header_video'] : '';
			$page_header_video_ogv = ( !empty( $options['page_header_video_ogv'] ) ) ? $options['page_header_video_ogv'] : '';
			$page_header_video_webm = ( !empty( $options['page_header_video_webm'] ) ) ? $options['page_header_video_webm'] : '';
			$page_header_video_overlay = ( !empty( $options['page_header_video_overlay'] ) ) ? $options['page_header_video_overlay'] : '';
		else :
			global $post;
			$header_content = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-content', true ) : '';
			$image_background = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background', true ) : '';
			$image_background_type = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-type', true ) : '';
			$image_background_fixed = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-fixed', true ) : '';
			$image_background_alignment = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-alignment', true ) : '';
			$image_background_spacing = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-spacing', true ) : '';
			$image_background_color = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-color', true ) : '';
			$image_background_text_color = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-text-color', true ) : '';
			$image_background_link_color = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-link-color', true ) : '';
			$image_background_link_color_hover = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-link-color-hover', true ) : '';
			$page_header_image_custom = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image', true ) : '';
			$combine = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-combine', true ) : '';
			$fullscreen = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-full-screen', true ) : '';
			$navigation_background = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-transparent-navigation', true ) : '';
			$navigation_text = ( isset( $post ) && '' !== $navigation_background ) ? get_post_meta( $post->ID, '_meta-generate-page-header-navigation-text', true ) : '';
			$navigation_background_hover = ( isset( $post ) && '' !== $navigation_background ) ? get_post_meta( $post->ID, '_meta-generate-page-header-navigation-background-hover', true ) : '';
			$navigation_text_hover = ( isset( $post ) && '' !== $navigation_background ) ? get_post_meta( $post->ID, '_meta-generate-page-header-navigation-text-hover', true ) : '';
			$navigation_background_current = ( isset( $post ) && '' !== $navigation_background ) ? get_post_meta( $post->ID, '_meta-generate-page-header-navigation-background-current', true ) : '';
			$navigation_text_current = ( isset( $post ) && '' !== $navigation_background ) ? get_post_meta( $post->ID, '_meta-generate-page-header-navigation-text-current', true ) : '';
			$site_title = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-site-title', true ) : '';
			$site_tagline = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-site-tagline', true ) : '';
			$page_header_video = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-video', true ) : '';
			$page_header_video_ogv = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-video-ogv', true ) : '';
			$page_header_video_webm = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-video-webm', true ) : '';
			$page_header_video_overlay = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-video-overlay', true ) : '';
		endif;
		
		// If we don't have any content, we don't need any of the below
		if ( empty( $header_content ) )
			return;
		
		$video = false;
		if ( empty( $page_header_video ) && empty( $page_header_video_ogv ) && empty( $page_header_video_webm ) ) {
			$video = false;
		} else {
			$video = true;
		}
		
		// Figure out our background color
		if ( '' !== $page_header_video_overlay && $video ) {
			$background_color = generate_page_header_hex2rgba( $page_header_video_overlay, apply_filters( 'generate_page_header_video_overlay', 0.7 ) ) . ' !important';
		} elseif ( !empty( $image_background_color ) && ! $video ) {
			$background_color = $image_background_color;
		} else {
			$background_color = null;
		}
		
		$space = ' ';

		// Start the magic
		$visual_css = array (
		
			// if fluid
			'.generate-content-header' => array(
				'background-color' => ( 'fluid' == $image_background_type ) ? $background_color : null,
				'background-image' => ( 'fluid' == $image_background_type && !empty( $image_background ) && false == $video ) ? 'url(' . $page_header_image_custom . ')' : null,
				'background-size' => ( 'fluid' == $image_background_type && !empty( $image_background ) ) ? 'cover' : null,
				'background-attachment' => ( 'fluid' == $image_background_type && !empty( $image_background ) && !empty( $image_background_fixed ) ) ? 'fixed' : null,
				'background-position' => ( 'fluid' == $image_background_type && !empty( $image_background ) && !empty( $image_background_fixed ) ) ? 'center top' : null,
				'height' => ( '' !== $combine && '' !== $fullscreen ) ? '100vh !important' : null
			),
			
			'.separate-containers .generate-content-header' => array(
				'margin-top' => ( 'fluid' == $image_background_type || '' !== $combine ) ? '0px' : null,
			),
			
			'.inside-page-header' => array(
				'background-color' => ( !empty( $image_background ) || !empty( $image_background_color ) ) ? 'transparent' : null,
				'color' => ( !empty( $image_background_text_color ) ) ? $image_background_text_color : null,
			),
			
			// if contained
			
			'.inside-content-header' => array(
				'background-image' => ( 'fluid' !== $image_background_type && !empty( $image_background ) ) ? 'url(' . $page_header_image_custom . ')' : null,
				'background-color' => ( 'fluid' !== $image_background_type ) ? $background_color : null,
				'background-size' => ( 'fluid' !== $image_background_type && !empty( $image_background ) ) ? 'cover' : null,
				'background-attachment' => ( 'fluid' !== $image_background_type && !empty( $image_background ) && !empty( $image_background_fixed ) ) ? 'fixed' : null,
				'background-position' => ( 'fluid' !== $image_background_type && !empty( $image_background ) && !empty( $image_background_fixed ) ) ? 'center top' : null,
				'text-align' => ( !empty( $image_background_alignment ) ) ? $image_background_alignment : null,
				'padding-top' => ( !empty( $image_background_spacing ) ) ? $image_background_spacing . 'px' : null,
				'padding-bottom' => ( !empty( $image_background_spacing ) ) ? $image_background_spacing . 'px' : null,
				'color' => ( !empty( $image_background_text_color ) ) ? $image_background_text_color : null,
			),
			
			'.inside-content-header a, .inside-content-header a:visited' => array(
				'color' => ( !empty( $image_background_link_color ) ) ? $image_background_link_color : null,
			),
			
			'.inside-content-header a:hover, .inside-content-header a:active' => array(
				'color' => ( !empty( $image_background_link_color_hover ) ) ? $image_background_link_color_hover : null,
			),
			
			'.separate-containers .inside-article .page-header-below-title, .one-container .inside-article .page-header-below-title' => array(
				'margin-top' => '2em'
			),
			
			'.inside-article .page-header-post-image' => array(
				'float' => 'none',
				'margin-right' => '0px'
			),
			
			'.vertical-center-container' => array(
				'display' => 'table',
				'width' => '100%'
			),
			
			'.vertical-center-enabled' => array(
				'display' => 'table-cell',
				'vertical-align' => 'middle'
			),
			
			'.generate-combined-header' => array(
				'position' => ( '' !== $combine ) ? 'absolute' : null,
				'width' => ( '' !== $combine ) ? '100%' : null,
				'z-index' => ( '' !== $combine ) ? '99' : null
			),
			
			'.generate-combined-header .inside-header' => array(
				'-moz-box-sizing' => ( '' !== $combine && 'fluid' !== $image_background_type ) ? 'border-box' : null,
				'-webkit-box-sizing' => ( '' !== $combine && 'fluid' !== $image_background_type ) ? 'border-box' : null,
				'box-sizing' => ( '' !== $combine && 'fluid' !== $image_background_type ) ? 'border-box' : null
			),
			
			'.generate-combined-header .site-header' => array(
				'background' => ( '' !== $combine ) ? 'transparent' : null
			),
			
			'.generate-combined-header .main-navigation:not(.is_stuck):not(.toggled)' => array(
				'background' => ( '' !== $navigation_background ) ? 'transparent' : null
			),
			
			'.generate-combined-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > li > a, 
			.generate-combined-header .main-navigation:not(.is_stuck):not(.toggled) .menu-toggle,
			.generate-combined-header .main-navigation:not(.is_stuck):not(.toggled) .menu-toggle:hover,
			.generate-combined-header .main-navigation:not(.is_stuck):not(.toggled) .menu-toggle:focus,
			.main-navigation .main-navigation:not(.is_stuck):not(.toggled) .mobile-bar-items a, 
			.main-navigation .main-navigation:not(.is_stuck):not(.toggled) .mobile-bar-items a:hover, 
			.main-navigation .main-navigation:not(.is_stuck):not(.toggled) .mobile-bar-items a:focus' => array(
				'color' => ( '' !== $navigation_text ) ? $navigation_text : null
			),
			
			'.generate-combined-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > li > a:hover, 
			.generate-combined-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > li > a:focus, 
			.generate-combined-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > li.sfHover > a' => array(
				'background' => ( '' == $navigation_background_hover && '' !== $navigation_background ) ? 'transparent' : $navigation_background_hover,
				'color' => ( '' !== $navigation_text_hover ) ? $navigation_text_hover : $navigation_text
			),
			
			'.generate-combined-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > .current-menu-item > a, 
			.generate-combined-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > .current-menu-item > a:hover,
			.generate-combined-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > .current-menu-parent > a, 
			.generate-combined-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > .current-menu-parent > a:hover' => array(
				'background' => ( '' == $navigation_background_current && '' !== $navigation_background ) ? 'transparent' : $navigation_background_current,
				'color' => ( '' !== $navigation_text_current ) ? $navigation_text_current : $navigation_text
			),
			
			'.generate-combined-header .main-title a,
			.generate-combined-header .main-title a:hover,
			.generate-combined-header .main-title a:visited' => array(
				'color' => ( '' !== $site_title ) ? $site_title : null,
			),

			'.generate-combined-header .site-description' => array(
				'color' => ( isset( $site_tagline ) && '' !== $site_tagline ) ? $site_tagline : null,
			)
			
		);
		
		// Output the above CSS
		$output = '';
		foreach($visual_css as $k => $properties) {
			if(!count($properties))
				continue;

			$temporary_output = $k . ' {';
			$elements_added = 0;

			foreach($properties as $p => $v) {
				if(empty($v))
					continue;

				$elements_added++;
				$temporary_output .= $p . ': ' . $v . '; ';
			}

			$temporary_output .= "}";

			if($elements_added > 0)
				$output .= $temporary_output;
		}
		
		$output .= '@media only screen and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 1) {
			.generate-content-header, .inside-content-header {background-attachment: scroll !important;}
		}';
		
		$output = str_replace(array("\r", "\n", "\t"), '', $output);
		return $output;
	}
	
	/**
	 * Enqueue scripts and styles
	 */
	add_action( 'wp_enqueue_scripts', 'generate_page_header_scripts', 100 );
	function generate_page_header_scripts() {

		wp_add_inline_style( 'generate-style', generate_page_header_css() );
	
	}
endif;

if ( ! function_exists( 'generate_page_header_area' ) ) :
function generate_page_header_area($image_class, $content_class)
{
	// Don't run the function unless we're on a page it applies to
	if ( ! is_singular() || is_attachment() )
		return;
		
	global $post;
	$featured_image = get_post_thumbnail_id( $post->ID, 'full' );
	$page_header_image_id = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-id', true );
	$page_header_image_custom = get_post_meta( get_the_ID(), '_meta-generate-page-header-image', true );
	$page_header_video = get_post_meta( get_the_ID(), '_meta-generate-page-header-video', true );
	$page_header_video_ogv = get_post_meta( get_the_ID(), '_meta-generate-page-header-video-ogv', true );
	$page_header_video_webm = get_post_meta( get_the_ID(), '_meta-generate-page-header-video-webm', true );
	
	$use_featured_image = ( ! empty( $featured_image ) && empty( $page_header_image_custom ) ) ? true : false;
	$use_featured_image = apply_filters( 'generate_page_header_featured_image', $use_featured_image );
	
	// Get the ID of the image
	$image_id = null;
	if ( $use_featured_image ) :
		// Using featured image, and not the Page Header metabox, so we already have the ID
		$image_id = $featured_image;
	elseif ( ! empty( $page_header_image_custom ) && ! empty( $page_header_image_id ) ) :
		// We have a metabox URL and ID
		$image_id = $page_header_image_id;
	elseif ( empty( $page_header_image_id ) && ! empty( $page_header_image_custom ) ) :
		// We don't have the image ID of our metabox image, but we do have the URL
		if ( function_exists( 'attachment_url_to_postid' ) ) :
			$image_id = attachment_url_to_postid( esc_url( $page_header_image_custom ) );
		else :
			$image_id = generate_get_attachment_id_by_url( esc_url( $page_header_image_custom ) );
		endif;
	endif;
	
	// Get the other page header options
	$page_header_image_link = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-link', true );
	$page_header_content = get_post_meta( get_the_ID(), '_meta-generate-page-header-content', true );
	$page_header_content_autop = get_post_meta( get_the_ID(), '_meta-generate-page-header-content-autop', true );
	$page_header_content_padding = get_post_meta( get_the_ID(), '_meta-generate-page-header-content-padding', true );
	$page_header_crop = get_post_meta( get_the_ID(), '_meta-generate-page-header-enable-image-crop', true );
	$page_header_parallax = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-background-fixed', true );
	$page_header_full_screen = get_post_meta( get_the_ID(), '_meta-generate-page-header-full-screen', true );
	$page_header_vertical_center = get_post_meta( get_the_ID(), '_meta-generate-page-header-vertical-center', true );
	$page_header_image_width = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-width', true );
	$page_header_image_height = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-height', true );
	$page_header_container_type = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-background-type', true );
	
	// Parallax variable
	$parallax = ( ! empty( $page_header_parallax ) ) ? ' parallax-enabled' : '';
	
	// Full screen variable
	$full_screen = ( ! empty( $page_header_full_screen ) ) ? ' fullscreen-enabled' : '';
	
	// Vertical center variable
	$vertical_center_container = ( ! empty( $page_header_vertical_center ) ) ? ' vertical-center-container' : '';
	$vertical_center = ( ! empty( $page_header_vertical_center ) ) ? ' vertical-center-enabled' : '';
	
	// Do we have a video?
	$video_enabled = ( empty( $page_header_video ) && empty( $page_header_video_ogv ) && empty( $page_header_video_webm ) ) ? false : true;
	
	// Which types?
	$video_types = array(
		'mp4' => ( ! empty( $page_header_video ) ) ? 'mp4:' . $page_header_video : null,
		'ogv' => ( ! empty( $page_header_video_ogv ) ) ? 'ogv:' . $page_header_video_ogv : null,
		'webm' => ( ! empty( $page_header_video_webm ) ) ? 'webm:' . $page_header_video_webm : null,
		'poster' => ( ! empty( $page_header_image_custom ) ) ? 'poster:' . $page_header_image_custom : null
	);
	
	// Add our videos to a string
	$video_output = array();
	foreach( $video_types as $video => $val ){
		$video_output[] = $val;
	}
	
	$video = null;
	// Video variable
	if ( $video_enabled && '' !== $page_header_content ) {
		
		$ext = ( ! empty( $page_header_image_custom ) ) ? pathinfo( $page_header_image_custom, PATHINFO_EXTENSION ) : false;
		$video_options = array();
		
		if ( $ext ) $video_options[ 'posterType' ] = 'posterType:' . $ext;
		$video_options[ 'className' ] = 'className:generate-page-header-video';
		
		$video = sprintf( ' data-vide-bg="%1$s" data-vide-options="%2$s"',
			implode( ', ', array_filter( $video_output ) ),
			implode( ', ', array_filter( $video_options ) )
		);
	}
	
	// Values when to ignore crop
	$ignore_crop = array( '', '0', '9999' );
	
	// Set our image attributes
	$image_atts = array(
		'width' => ( in_array( $page_header_image_width, $ignore_crop ) ) ? 9999 : intval( $page_header_image_width ),
		'height' => ( in_array( $page_header_image_height, $ignore_crop ) ) ? 9999 : intval( $page_header_image_height ),
		'crop' => ( in_array( $page_header_image_width, $ignore_crop ) || in_array( $page_header_image_height, $ignore_crop ) ) ? false : true
	);
	
	// Get the image url
	$image_url = wp_get_attachment_image_src( $image_id, 'full', true );
	
	// Is our width larger than the OG image and not proportional?
	$width_upscale = $image_atts[ 'width' ] > $image_url[1] && $image_atts[ 'width' ] < 9999 ? true : false;
	
	// Is our height larger than the OG image and not proportional?
	$height_upscale = $image_atts[ 'height' ] > $image_url[2] && $image_atts[ 'height' ] < 9999 ? true : false;
	
	// If both the height and width are larger than the OG image, upscale
	$upscale = $width_upscale && $height_upscale ? true : false;
	
	// If the width is larger than the OG image and the height isn't proportional, upscale
	$upscale = $width_upscale && $image_atts[ 'height' ] < 9999 ? true : $upscale;

	// If the height is larger than the OG image and width isn't proportional, upscale
	$upscale = $height_upscale && $image_atts[ 'width' ] < 9999 ? true : $upscale;
	
	// If we're upscaling, set crop to true
	$crop = $upscale ? true : $image_atts[ 'crop' ];
	
	// If one of our sizes is upscaling but the other is proportional, show the full image
	if ( $width_upscale && $image_atts[ 'height' ] == 9999 || $height_upscale && $image_atts[ 'width' ] == 9999 )
		$image_atts = array();
	
	if ( ! empty( $image_atts ) ) {
		// If there's no height or width, empty the array
		if ( 9999 == $image_atts[ 'width' ] && 9999 == $image_atts[ 'height' ] )
			$image_atts = array();
	}
	
	// Create a filter for the link target
	$link_target = apply_filters( 'generate_page_header_link_target','' );
	
	// If an image is set and no content is set
	if ( '' == $page_header_content && ! empty( $image_id ) ) :
		printf( 
			'<div class="%1$s">
				%2$s
					%4$s
				%3$s
			</div>',
			$image_class . ' grid-container grid-parent generate-page-header',
			( ! empty( $page_header_image_link ) ) ? '<a href="' . esc_url( $page_header_image_link ) . '"' . $link_target . '>' : null,
			( ! empty( $page_header_image_link ) ) ? '</a>' : null,
			( ! empty( $image_atts ) && 'enable' == $page_header_crop && function_exists( 'GP_Resize' ) ) ? '<img src="' . GP_Resize( $image_url[0], $image_atts[ 'width' ], $image_atts[ 'height' ], $crop, true, $upscale ) . '" alt="' . esc_attr( get_the_title() ) . '" itemprop="image" />' : wp_get_attachment_image( $image_id, apply_filters( 'generate_page_header_default_size', 'full' ), '', array( 'itemprop' => 'image' ) )
		);
	endif;
	
	// If content is set, show it
	if ( '' !== $page_header_content && false !== $page_header_content ) :
		printf( 
			'<div %1$s class="%2$s">
				<div %3$s class="inside-page-header-container inside-content-header grid-container grid-parent %4$s">
					%5$s
						%7$s
					%6$s
				</div>
			</div>',
			( 'fluid' == $page_header_container_type ) ? $video : null,
			$content_class . $parallax . $full_screen . $vertical_center_container . ' generate-page-header generate-content-header',
			( 'fluid' !== $page_header_container_type ) ? $video : null,
			$vertical_center,
			( $page_header_content_padding == 'yes' ) ? '<div class="inside-page-header">' : null,
			( $page_header_content_padding == 'yes' ) ? '</div>' : null,
			( $page_header_content_autop == 'yes' ) ? do_shortcode( wpautop( $page_header_content ) ) : do_shortcode( $page_header_content )
		);
	endif;
}
endif;

if ( ! function_exists( 'generate_blog_page_header_area' ) ) :
function generate_blog_page_header_area($image_class, $content_class)
{

	// Don't run the function unless we're on the blog
	if ( ! is_home() )
		return;
		
	$options = get_option( 'generate_page_header_options' );
		
	$page_header_image = ( !empty( $options['page_header_image'] ) ) ? $options['page_header_image'] : '';
	$page_header_image_link = ( !empty( $options['page_header_url'] ) ) ? $options['page_header_url'] : '';
	$page_header_content = ( !empty( $options['page_header_content'] ) ) ? $options['page_header_content'] : '';
	$page_header_content_autop = ( !empty( $options['page_header_add_paragraphs'] ) ) ? $options['page_header_add_paragraphs'] : '';
	$page_header_content_padding = ( !empty( $options['page_header_add_padding'] ) ) ? $options['page_header_add_padding'] : '';
	$page_header_crop = ( !empty( $options['page_header_hard_crop'] ) ) ? $options['page_header_hard_crop'] : '';
	$page_header_parallax = ( !empty( $options['page_header_add_parallax'] ) ) ? $options['page_header_add_parallax'] : '';
	$page_header_full_screen = ( !empty( $options['page_header_full_screen'] ) ) ? $options['page_header_full_screen'] : '';
	$page_header_vertical_center = ( !empty( $options['page_header_vertical_center'] ) ) ? $options['page_header_vertical_center'] : '';
	$page_header_video = ( !empty( $options['page_header_video'] ) ) ? $options['page_header_video'] : '';
	$page_header_video_ogv = ( !empty( $options['page_header_video_ogv'] ) ) ? $options['page_header_video_ogv'] : '';
	$page_header_video_webm = ( !empty( $options['page_header_video_webm'] ) ) ? $options['page_header_video_webm'] : '';
	$page_header_container_type = ( !empty( $options['page_header_container_type'] ) ) ? $options['page_header_container_type'] : '';
	$page_header_image_width = ( isset( $options['page_header_image_width'] ) ) ? $options['page_header_image_width'] : '';
	$page_header_image_height = ( isset( $options['page_header_image_height'] ) ) ? $options['page_header_image_height'] : '';
	
	$parallax = ( ! empty( $page_header_parallax ) ) ? ' parallax-enabled' : '';
	$full_screen = ( ! empty( $page_header_full_screen ) ) ? ' fullscreen-enabled' : '';
	$vertical_center_container = ( ! empty( $page_header_vertical_center ) ) ? ' vertical-center-container' : '';
	$vertical_center = ( ! empty( $page_header_vertical_center ) ) ? ' vertical-center-enabled' : '';
	
	// Do we have a video?
	$video_enabled = ( empty( $page_header_video ) && empty( $page_header_video_ogv ) && empty( $page_header_video_webm ) ) ? false : true;
	
	// Which types?
	$video_types = array(
		'mp4' => ( ! empty( $page_header_video ) ) ? 'mp4:' . $page_header_video : null,
		'ogv' => ( ! empty( $page_header_video_ogv ) ) ? 'ogv:' . $page_header_video_ogv : null,
		'webm' => ( ! empty( $page_header_video_webm ) ) ? 'webm:' . $page_header_video_webm : null,
		'poster' => ( ! empty( $page_header_image ) ) ? 'poster:' . $page_header_image : null,
	);
	
	// Add our videos to a string
	$video_output = array();
	foreach( $video_types as $video => $val ){
		$video_output[] = $val;
	}
	
	$video = null;
	// Video variable
	if ( $video_enabled && '' !== $page_header_content ) {
		
		$ext = ( ! empty( $page_header_image ) ) ? pathinfo( $page_header_image, PATHINFO_EXTENSION ) : false;
		$video_options = array();
		
		if ( $ext ) $video_options[ 'posterType' ] = 'posterType:' . $ext;
		$video_options[ 'className' ] = 'className:generate-page-header-video';
		
		$video = sprintf( ' data-vide-bg="%1$s" data-vide-options="%2$s"',
			implode( ', ', array_filter( $video_output ) ),
			implode( ', ', array_filter( $video_options ) )
		);
	}
	
	// Values when to ignore crop
	$ignore_crop = array( '', '0', '9999' );
	
	// Set our image attributes
	$image_atts = array(
		'width' => ( in_array( $page_header_image_width, $ignore_crop ) ) ? 9999 : intval( $page_header_image_width ),
		'height' => ( in_array( $page_header_image_height, $ignore_crop ) ) ? 9999 : intval( $page_header_image_height ),
		'crop' => ( in_array( $page_header_image_width, $ignore_crop ) || in_array( $page_header_image_height, $ignore_crop ) ) ? false : true
	);
	
	// Create a filter for the link target
	$link_target = apply_filters( 'generate_page_header_link_target','' );
	
	// If an image is set and no content is set
	if ( '' == $page_header_content && '' !== $page_header_image && false !== $page_header_image ) :
	
		if ( function_exists( 'attachment_url_to_postid' ) ) :
			$image_id = attachment_url_to_postid( esc_url( $page_header_image ) );
		else :
			$image_id = generate_get_attachment_id_by_url( esc_url( $page_header_image ) );
		endif;
		
		// Get our image URL from the ID so we can get sizes
		$image_url = wp_get_attachment_image_src( $image_id, 'full', true );
		
		// Is our width larger than the OG image and not proportional?
		$width_upscale = $image_atts[ 'width' ] > $image_url[1] && $image_atts[ 'width' ] < 9999 ? true : false;
		
		// Is our height larger than the OG image and not proportional?
		$height_upscale = $image_atts[ 'height' ] > $image_url[2] && $image_atts[ 'height' ] < 9999 ? true : false;
		
		// If both the height and width are larger than the OG image, upscale
		$upscale = $width_upscale && $height_upscale ? true : false;
		
		// If the width is larger than the OG image and the height isn't proportional, upscale
		$upscale = $width_upscale && $image_atts[ 'height' ] < 9999 ? true : $upscale;

		// If the height is larger than the OG image and width isn't proportional, upscale
		$upscale = $height_upscale && $image_atts[ 'width' ] < 9999 ? true : $upscale;
		
		// If we're upscaling, set crop to true
		$crop = $upscale ? true : $image_atts[ 'crop' ];
		
		// If one of our sizes is upscaling but the other is proportional, show the full image
		if ( $width_upscale && $image_atts[ 'height' ] == 9999 || $height_upscale && $image_atts[ 'width' ] == 9999 )
			$image_atts = array();
		
		if ( ! empty( $image_atts ) ) {
			// If there's no height or width, empty the array
			if ( 9999 == $image_atts[ 'width' ] && 9999 == $image_atts[ 'height' ] )
				$image_atts = array();
		}
		
		printf( 
			'<div class="%1$s">
				%2$s
					%4$s
				%3$s
			</div>',
			$image_class . ' grid-container grid-parent generate-page-header generate-blog-page-header',
			( ! empty( $page_header_image_link ) ) ? '<a href="' . esc_url( $page_header_image_link ) . '"' . $link_target . '>' : null,
			( ! empty( $page_header_image_link ) ) ? '</a>' : null,
			( ! empty( $image_atts ) && 'enable' == $page_header_crop && function_exists( 'GP_Resize' ) ) ? '<img src="' . GP_Resize( $page_header_image, $image_atts[ 'width' ], $image_atts[ 'height' ], $crop, true, $upscale ) . '" alt="' . esc_attr( get_the_title() ) . '" itemprop="image" />' : wp_get_attachment_image( $image_id, apply_filters( 'generate_page_header_default_size', 'full' ), '', array( 'itemprop' => 'image' ) )
		);
	endif;
	
	// If content is set, show it
	if ( '' !== $page_header_content && false !== $page_header_content ) :
		printf( 
			'<div %1$s class="%2$s">
				<div %3$s class="inside-page-header-container inside-content-header grid-container grid-parent %4$s">
					%5$s
						%7$s
					%6$s
				</div>
			</div>',
			( 'fluid' == $page_header_container_type ) ? $video : null,
			$content_class . $parallax . $full_screen . $vertical_center_container . ' generate-page-header generate-content-header generate-blog-page-header',
			( 'fluid' !== $page_header_container_type ) ? $video : null,
			$vertical_center,
			( $page_header_content_padding == '1' ) ? '<div class="inside-page-header">' : null,
			( $page_header_content_padding == '1' ) ? '</div>' : null,
			( $page_header_content_autop == '1' ) ? do_shortcode( wpautop( $page_header_content ) ) : do_shortcode( $page_header_content )
		);
	endif;
}
endif;

/**
 * Prints the Post Image to post excerpts
 */
if ( ! function_exists( 'generate_page_header_post_image' ) ) :
	add_action( 'generate_after_entry_header', 'generate_page_header_post_image' );
	function generate_page_header_post_image()
	{
		global $post;
		$featured_image = ( has_post_thumbnail() ) ? apply_filters( 'generate_post_image_force_featured_image', true ) : apply_filters( 'generate_post_image_force_featured_image', false );

		// If using the featured image, stop
		if ( $featured_image )
			return;
			
		$page_header_add_to_excerpt = get_post_meta( get_the_ID(), '_meta-generate-page-header-add-to-excerpt', true );
		
		if ( $page_header_add_to_excerpt == '' )
			return;
			
		if ( 'post' == get_post_type() && !is_single() ) {
			global $post;
			$page_header_image_id = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-id', true );
			$page_header_image_custom = get_post_meta( get_the_ID(), '_meta-generate-page-header-image', true );
			
			// Get the ID of the image
			$image_id = null;
			if ( ! empty( $page_header_image_custom ) && ! empty( $page_header_image_id ) ) :
				// We have a metabox URL and ID
				$image_id = $page_header_image_id;
			elseif ( empty( $page_header_image_id ) && ! empty( $page_header_image_custom ) ) :
				// We don't have the image ID of our metabox image, but we do have the URL
				$image_id = generate_get_attachment_id_by_url( esc_url( $page_header_image_custom ) );
			endif;
	
			$page_header_image_link = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-link', true );
			$page_header_content = get_post_meta( get_the_ID(), '_meta-generate-page-header-content', true );
			$page_header_content_autop = get_post_meta( get_the_ID(), '_meta-generate-page-header-content-autop', true );
			$page_header_content_padding = get_post_meta( get_the_ID(), '_meta-generate-page-header-content-padding', true );
			$page_header_crop = get_post_meta( get_the_ID(), '_meta-generate-page-header-enable-image-crop', true );
			$page_header_image_width = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-width', true );
			$page_header_image_height = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-height', true );
			
			// Values when to ignore crop
			$ignore_crop = array( '', '0', '9999' );
			
			// Set our image attributes
			$image_atts = array(
				'width' => ( in_array( $page_header_image_width, $ignore_crop ) ) ? 9999 : intval( $page_header_image_width ),
				'height' => ( in_array( $page_header_image_height, $ignore_crop ) ) ? 9999 : intval( $page_header_image_height ),
				'crop' => ( in_array( $page_header_image_width, $ignore_crop ) || in_array( $page_header_image_height, $ignore_crop ) ) ? false : true
			);
			
			// Get the image url
			$image_url = wp_get_attachment_image_src( $image_id, 'full', true );
			
			// Is our width larger than the OG image and not proportional?
			$width_upscale = $image_atts[ 'width' ] > $image_url[1] && $image_atts[ 'width' ] < 9999 ? true : false;
			
			// Is our height larger than the OG image and not proportional?
			$height_upscale = $image_atts[ 'height' ] > $image_url[2] && $image_atts[ 'height' ] < 9999 ? true : false;
			
			// If both the height and width are larger than the OG image, upscale
			$upscale = $width_upscale && $height_upscale ? true : false;
			
			// If the width is larger than the OG image and the height isn't proportional, upscale
			$upscale = $width_upscale && $image_atts[ 'height' ] < 9999 ? true : $upscale;

			// If the height is larger than the OG image and width isn't proportional, upscale
			$upscale = $height_upscale && $image_atts[ 'width' ] < 9999 ? true : $upscale;
			
			// If we're upscaling, set crop to true
			$crop = $upscale ? true : $image_atts[ 'crop' ];
			
			// If one of our sizes is upscaling but the other is proportional, show the full image
			if ( $width_upscale && $image_atts[ 'height' ] == 9999 || $height_upscale && $image_atts[ 'width' ] == 9999 )
				$image_atts = array();
			
			if ( ! empty( $image_atts ) ) {
				// If there's no height or width, empty the array
				if ( 9999 == $image_atts[ 'width' ] && 9999 == $image_atts[ 'height' ] )
					$image_atts = array();
			}
			
			// Create a filter for the link target
			$link_target = apply_filters( 'generate_page_header_link_target','' );
			
			// If an image is set and no content is set
			if ( '' == $page_header_content && ! empty( $image_id ) ) :
				printf( 
					'<div class="%1$s">
						%2$s
							%4$s
						%3$s
					</div>',
					'post-image page-header-post-image',
					( ! empty( $page_header_image_link ) ) ? '<a href="' . esc_url( $page_header_image_link ) . '"' . $link_target . '>' : null,
					( ! empty( $page_header_image_link ) ) ? '</a>' : null,
					( ! empty( $image_atts ) && 'enable' == $page_header_crop && function_exists( 'GP_Resize' ) ) ? '<img src="' . GP_Resize( $image_url[0], $image_atts[ 'width' ], $image_atts[ 'height' ], $crop, true, $upscale ) . '" alt="' . esc_attr( get_the_title() ) . '" itemprop="image" />' : wp_get_attachment_image( $image_id, apply_filters( 'generate_page_header_default_size', 'full' ), '', array( 'itemprop' => 'image' ) )
				);
			endif;
			
			// If content is set, show it
			if ( '' !== $page_header_content && false !== $page_header_content ) :
				printf( 
					'<div class="%1$s">
						<div class="%2$s">
							%3$s
								%5$s
							%4$s
						</div>
					</div>',
					'post-image generate-page-header generate-post-content-header page-header-post-image',
					'inside-page-header-container inside-post-content-header grid-container grid-parent',
					( $page_header_content_padding == 'yes' ) ? '<div class="inside-page-header">' : null,
					( $page_header_content_padding == 'yes' ) ? '</div>' : null,
					( $page_header_content_autop == 'yes' ) ? do_shortcode( wpautop( $page_header_content ) ) : do_shortcode( $page_header_content )
				);
			endif;
		}
	}
endif;

if ( ! function_exists( 'generate_page_header' ) ) :
/**
 * Add page header above content
 * @since 0.3
 */
add_action('generate_after_header','generate_page_header', 10);
function generate_page_header()
{
	
	$generate_page_header_settings = wp_parse_args( 
		get_option( 'generate_page_header_settings', array() ), 
		generate_page_header_get_defaults() 
	);
	
	if ( '' == $generate_page_header_settings['page_header_position'] ) :
		$generate_page_header_settings['page_header_position'] = 'above-content';
	endif;

	if ( is_page() && 'above-content' == $generate_page_header_settings['page_header_position'] ) :
		
		generate_page_header_area('page-header-image', 'page-header-content');
	
	endif;
	
	if ( is_home() ) :
		
		generate_blog_page_header_area('page-header-image', 'page-header-content');
	
	endif;
}
endif;

if ( ! function_exists( 'generate_page_header_inside' ) ) :
/**
 * Add page header inside content
 * @since 0.3
 */
add_action('generate_before_content','generate_page_header_inside', 10);
function generate_page_header_inside()
{
		
	$generate_page_header_settings = wp_parse_args( 
		get_option( 'generate_page_header_settings', array() ), 
		generate_page_header_get_defaults() 
	);
	
	if ( '' == $generate_page_header_settings['page_header_position'] ) :
		$generate_page_header_settings['page_header_position'] = 'above-content';
	endif;

	if ( is_page() && 'inside-content' == $generate_page_header_settings['page_header_position'] ) :
		
		generate_page_header_area('page-header-image', 'page-header-content');
	
	endif;

}
endif;

if ( ! function_exists( 'generate_page_header_single' ) ) :
/**
 * Add post header inside content
 * @since 0.3
 */
add_action('generate_before_content','generate_page_header_single', 10);
function generate_page_header_single()
{
		
	$generate_page_header_settings = wp_parse_args( 
		get_option( 'generate_page_header_settings', array() ), 
		generate_page_header_get_defaults() 
	);
		
	if ( '' == $generate_page_header_settings['post_header_position'] ) :
		$generate_page_header_settings['post_header_position'] = 'inside-content';
	endif;

	if ( is_single() && 'inside-content' == $generate_page_header_settings['post_header_position'] ) :

		generate_page_header_area('page-header-image-single', 'page-header-content-single');
	
	endif;
}
endif;

if ( ! function_exists( 'generate_page_header_single_below_title' ) ) :
/**
 * Add post header below title
 * @since 0.3
 */
add_action('generate_after_entry_header','generate_page_header_single_below_title', 10);
function generate_page_header_single_below_title()
{
		
	$generate_page_header_settings = wp_parse_args( 
		get_option( 'generate_page_header_settings', array() ), 
		generate_page_header_get_defaults() 
	);

	if ( is_single() && 'below-title' == $generate_page_header_settings['post_header_position'] ) :
	
		generate_page_header_area('page-header-image-single page-header-below-title', 'page-header-content-single page-header-below-title');
	
	endif;
}
endif;

if ( ! function_exists( 'generate_page_header_single_above' ) ) :
/**
 * Add post header above content
 * @since 0.3
 */
add_action('generate_after_header','generate_page_header_single_above', 10);
function generate_page_header_single_above()
{
		
	$generate_page_header_settings = wp_parse_args( 
		get_option( 'generate_page_header_settings', array() ), 
		generate_page_header_get_defaults() 
	);
	
	
		
	if ( '' == $generate_page_header_settings['post_header_position'] ) :
		$generate_page_header_settings['post_header_position'] = 'inside-content';
	endif;

	if ( is_single() && 'above-content' == $generate_page_header_settings['post_header_position'] ) :
	
		generate_page_header_area('page-header-image-single', 'page-header-content-single');

	endif;
}
endif;

if ( ! function_exists( 'add_generate_page_header_meta_box' ) ) :
/**
 *
 *
 * Generate the page header metabox
 * @since 0.1
 *
 *
 */
add_action('add_meta_boxes', 'add_generate_page_header_meta_box');
function add_generate_page_header_meta_box() { 
	
	
	$post_types = get_post_types();
	foreach ($post_types as $type) {
		add_meta_box
		(  
			'generate_page_header_meta_box', // $id  
			__('Page Header','generate-page-header'), // $title   
			'show_generate_page_header_meta_box', // $callback  
			$type, // $page  
			'normal', // $context  
			'high' // $priority  
		); 
	}
} 
endif;

if ( ! function_exists( 'show_generate_page_header_meta_box' ) ) :
/**
 * Outputs the content of the metabox
 */
function show_generate_page_header_meta_box( $post ) {  

    wp_nonce_field( basename( __FILE__ ), 'generate_page_header_nonce' );
    $stored_meta = get_post_meta( $post->ID );
	
	// Set defaults to avoid PHP notices	
	$stored_meta['_meta-generate-page-header-image'][0] = ( isset( $stored_meta['_meta-generate-page-header-image'][0] ) ) ? $stored_meta['_meta-generate-page-header-image'][0] : '';
	$stored_meta['_meta-generate-page-header-image-id'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-id'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-id'][0] : '';
	$stored_meta['_meta-generate-page-header-image-link'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-link'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-link'][0] : '';	
	$stored_meta['_meta-generate-page-header-enable-image-crop'][0] = ( isset( $stored_meta['_meta-generate-page-header-enable-image-crop'][0] ) ) ? $stored_meta['_meta-generate-page-header-enable-image-crop'][0] : '';
	$stored_meta['_meta-generate-page-header-image-width'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-width'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-width'][0] : '';
	$stored_meta['_meta-generate-page-header-image-height'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-height'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-height'][0] : '';
	$stored_meta['_meta-generate-page-header-content'][0] = ( isset( $stored_meta['_meta-generate-page-header-content'][0] ) ) ? $stored_meta['_meta-generate-page-header-content'][0] : '';
	$stored_meta['_meta-generate-page-header-content-autop'][0] = ( isset( $stored_meta['_meta-generate-page-header-content-autop'][0] ) ) ? $stored_meta['_meta-generate-page-header-content-autop'][0] : '';
	$stored_meta['_meta-generate-page-header-content-padding'][0] = ( isset( $stored_meta['_meta-generate-page-header-content-padding'][0] ) ) ? $stored_meta['_meta-generate-page-header-content-padding'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-type'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-type'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-type'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-fixed'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-fixed'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-fixed'][0] : '';
	$stored_meta['_meta-generate-page-header-full-screen'][0] = ( isset( $stored_meta['_meta-generate-page-header-full-screen'][0] ) ) ? $stored_meta['_meta-generate-page-header-full-screen'][0] : '';
	$stored_meta['_meta-generate-page-header-vertical-center'][0] = ( isset( $stored_meta['_meta-generate-page-header-vertical-center'][0] ) ) ? $stored_meta['_meta-generate-page-header-vertical-center'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-alignment'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-alignment'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-alignment'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-spacing'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-spacing'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-spacing'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-text-color'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-text-color'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-text-color'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-color'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-color'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-color'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-link-color'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-link-color'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-link-color'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0] : '';
	$stored_meta['_meta-generate-page-header-combine'][0] = ( isset( $stored_meta['_meta-generate-page-header-combine'][0] ) ) ? $stored_meta['_meta-generate-page-header-combine'][0] : '';
	$stored_meta['_meta-generate-page-header-navigation-transparent-navigation'][0] = ( isset( $stored_meta['_meta-generate-page-header-navigation-transparent-navigation'][0] ) ) ? $stored_meta['_meta-generate-page-header-navigation-transparent-navigation'][0] : '';
	$stored_meta['_meta-generate-page-header-navigation-text'][0] = ( isset( $stored_meta['_meta-generate-page-header-navigation-text'][0] ) ) ? $stored_meta['_meta-generate-page-header-navigation-text'][0] : '';
	$stored_meta['_meta-generate-page-header-site-title'][0] = ( isset( $stored_meta['_meta-generate-page-header-site-title'][0] ) ) ? $stored_meta['_meta-generate-page-header-site-title'][0] : '';
	$stored_meta['_meta-generate-page-header-site-tagline'][0] = ( isset( $stored_meta['_meta-generate-page-header-site-tagline'][0] ) ) ? $stored_meta['_meta-generate-page-header-site-tagline'][0] : '';
	$stored_meta['_meta-generate-page-header-navigation-background-hover'][0] = ( isset( $stored_meta['_meta-generate-page-header-navigation-background-hover'][0] ) ) ? $stored_meta['_meta-generate-page-header-navigation-background-hover'][0] : '';
	$stored_meta['_meta-generate-page-header-navigation-text-hover'][0] = ( isset( $stored_meta['_meta-generate-page-header-navigation-text-hover'][0] ) ) ? $stored_meta['_meta-generate-page-header-navigation-text-hover'][0] : '';
	$stored_meta['_meta-generate-page-header-navigation-background-current'][0] = ( isset( $stored_meta['_meta-generate-page-header-navigation-background-current'][0] ) ) ? $stored_meta['_meta-generate-page-header-navigation-background-current'][0] : '';
	$stored_meta['_meta-generate-page-header-navigation-text-current'][0] = ( isset( $stored_meta['_meta-generate-page-header-navigation-text-current'][0] ) ) ? $stored_meta['_meta-generate-page-header-navigation-text-current'][0] : '';
	$stored_meta['_meta-generate-page-header-video'][0] = ( isset( $stored_meta['_meta-generate-page-header-video'][0] ) ) ? $stored_meta['_meta-generate-page-header-video'][0] : '';
	$stored_meta['_meta-generate-page-header-video-ogv'][0] = ( isset( $stored_meta['_meta-generate-page-header-video-ogv'][0] ) ) ? $stored_meta['_meta-generate-page-header-video-ogv'][0] : '';
	$stored_meta['_meta-generate-page-header-video-webm'][0] = ( isset( $stored_meta['_meta-generate-page-header-video-webm'][0] ) ) ? $stored_meta['_meta-generate-page-header-video-webm'][0] : '';
	$stored_meta['_meta-generate-page-header-video-overlay'][0] = ( isset( $stored_meta['_meta-generate-page-header-video-overlay'][0] ) ) ? $stored_meta['_meta-generate-page-header-video-overlay'][0] : '';
	if ( 'post' == get_post_type() && !is_single() ) {
		$stored_meta['_meta-generate-page-header-add-to-excerpt'][0] = ( isset( $stored_meta['_meta-generate-page-header-add-to-excerpt'][0] ) ) ? $stored_meta['_meta-generate-page-header-add-to-excerpt'][0] : '';
	}
	$stored_meta['_meta-generate-page-header-logo'][0] = ( isset( $stored_meta['_meta-generate-page-header-logo'][0] ) ) ? $stored_meta['_meta-generate-page-header-logo'][0] : '';
	$stored_meta['_meta-generate-page-header-logo-id'][0] = ( isset( $stored_meta['_meta-generate-page-header-logo-id'][0] ) ) ? $stored_meta['_meta-generate-page-header-logo-id'][0] : '';
    
	
	?>
	<div id="generate-tabs-container">
		<ul class="generate-tabs-menu">
			<li class="generate-current image-settings"><a class="button button-large" href="#generate-tab-1"><?php _e( 'Image Settings','generate-page-header' ); ?></a></li>
			<li class="video-settings generate-page-header-content-required"><a class="button button-large" href="#generate-tab-2"><?php _e( 'Video Settings','generate-page-header' ); ?></a></li>
			<li class="content-settings"><a class="button button-large" href="#generate-tab-3"><?php _e( 'Content Settings','generate-page-header' ); ?></a></li>
			<?php if ( generate_page_header_logo_exists() ) : ?>
				<li class="logo-settings"><a class="button button-large" href="#generate-tab-4"><?php _e( 'Logo Settings','generate-page-header' ); ?></a></li>
			<?php endif; ?>
			<li class="advanced-settings generate-page-header-content-required"><a class="button button-large" href="<?php if ( generate_page_header_logo_exists() ) : ?>#generate-tab-5<?php else : ?>#generate-tab-4<?php endif; ?>"><?php _e( 'Advanced Settings','generate-page-header' ); ?></a></li>
		</ul>
		<div class="generate-tab">
			<div id="generate-tab-1" class="generate-tab-content">
				<div id="preview-image">
					<?php if( $stored_meta['_meta-generate-page-header-image'][0] != "") { ?>
						<img class="saved-image" src="<?php echo $stored_meta['_meta-generate-page-header-image'][0];?>" width="300" />
					<?php } ?>
				</div>
				<label for="upload_image" class="example-row-title"><strong><?php _e('Page Header Image','generate-page-header');?></strong></label><br />
				<input style="width:350px" id="upload_image" type="text" name="_meta-generate-page-header-image" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-image'][0]); ?>" />			   
				<button class="generate-upload-file button" type="button" data-type="image" data-title="<?php _e( 'Page Header Image','generate-page-header' );?>" data-insert="<?php _e( 'Insert Image','generate-page-header'); ?>" data-prev="true">
					<?php _e('Add Image','generate-page-header') ;?>
				</button>
				<input id="_meta-generate-page-header-image-id" type="hidden" name="_meta-generate-page-header-image-id" value="<?php echo $stored_meta['_meta-generate-page-header-image-id'][0]; ?>" />
				
				<p>
					<label for="_meta-generate-page-header-image-link" class="example-row-title"><strong><?php _e('Page Header Link','generate-page-header');?></strong></label><br />
					<input style="width:350px" placeholder="http://" id="_meta-generate-page-header-image-link" type="text" name="_meta-generate-page-header-image-link" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-image-link'][0]); ?>" />
				</p>
				
				<p>
					<label for="_meta-generate-page-header-enable-image-crop" class="example-row-title"><strong><?php _e('Hard Crop','generate-page-header');?></strong></label><br />
					<select name="_meta-generate-page-header-enable-image-crop" id="_meta-generate-page-header-enable-image-crop">
						<option value="" <?php selected( $stored_meta['_meta-generate-page-header-enable-image-crop'][0], '' ); ?>><?php _e('Disable','generate-page-header');?></option>
						<option value="enable" <?php selected( $stored_meta['_meta-generate-page-header-enable-image-crop'][0], 'enable' ); ?>><?php _e('Enable','generate-page-header');?></option>
					</select>
				</p>
				
				<div id="crop-enabled" style="display:none">					
					<p>
						<label for="_meta-generate-page-header-image-width" class="example-row-title"><strong><?php _e('Image Width','generate-page-header');?></strong></label><br />
						<input style="width:45px" type="text" name="_meta-generate-page-header-image-width" id="_meta-generate-page-header-image-width" value="<?php echo intval( $stored_meta['_meta-generate-page-header-image-width'][0] ); ?>" /><label for="_meta-generate-page-header-image-width"><span class="pixels">px</span></label>
					</p>
					
					<p>
						<label for="_meta-generate-page-header-image-height" class="example-row-title"><strong><?php _e('Image Height','generate-page-header');?></strong></label><br />
						<input placeholder="" style="width:45px" type="text" name="_meta-generate-page-header-image-height" id="_meta-generate-page-header-image-height" value="<?php echo intval( $stored_meta['_meta-generate-page-header-image-height'][0] ); ?>" /><label for="_meta-generate-page-header-image-height"><span class="pixels">px</span></label>
						<span class="small"><?php _e('Use "0" or leave blank for proportional resizing.','generate-page-header');?></span>
					</p>
				</div>
			</div>
			<div id="generate-tab-2" class="generate-tab-content generate-video-tab generate-page-header-content-required">
				<p>
					<label for="_meta-generate-page-header-video" class="example-row-title"><strong><?php _e('Video background - MP4 file only','generate-page-header');?></strong></label><br />
					<input style="width:350px" id="_meta-generate-page-header-video" type="text" name="_meta-generate-page-header-video" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-video'][0]); ?>" />			   
					<button class="generate-upload-file button" type="button" data-type="video" data-title="<?php _e( 'Page Header Video','generate-page-header' );?>" data-insert="<?php _e( 'Insert Video','generate-page-header'); ?>" data-prev="false">
						<?php _e('Add Video','generate-page-header') ;?>
					</button>
				</p>
				<p>
					<label for="_meta-generate-page-header-video-ogv" class="example-row-title"><strong><?php _e('Video background - OGV file only','generate-page-header');?></strong></label><br />
					<input style="width:350px" id="_meta-generate-page-header-video-ogv" type="text" name="_meta-generate-page-header-video-ogv" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-video-ogv'][0]); ?>" />			   
					<button class="generate-upload-file button" type="button" data-type="video" data-title="<?php _e( 'Page Header Video','generate-page-header' );?>" data-insert="<?php _e( 'Insert Video','generate-page-header'); ?>" data-prev="false">
						<?php _e('Add Video','generate-page-header') ;?>
					</button>
				</p>
				<p>
					<label for="_meta-generate-page-header-video-webm" class="example-row-title"><strong><?php _e('Video background - WEBM file only','generate-page-header');?></strong></label><br />
					<input style="width:350px" id="_meta-generate-page-header-video-webm" type="text" name="_meta-generate-page-header-video-webm" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-video-webm'][0]); ?>" />			   
					<button class="generate-upload-file button" type="button" data-type="video" data-title="<?php _e( 'Page Header Video','generate-page-header' );?>" data-insert="<?php _e( 'Insert Video','generate-page-header'); ?>" data-prev="false">
						<?php _e('Add Video','generate-page-header') ;?>
					</button>
				</p>
				<p>
					<label for="_meta-generate-page-header-video-overlay" class="example-row-title"><strong><?php _e('Overlay color','generate-page-header');?></strong></label><br />
					<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-video-overlay" id="_meta-generate-page-header-video-overlay" value="<?php echo $stored_meta['_meta-generate-page-header-video-overlay'][0]; ?>" />
				</p>
			</div>
			<div id="generate-tab-3" class="generate-tab-content">
				<p>
					<label for="_meta-generate-page-header-content" class="example-row-title"><strong><?php _e('Content','generate-page-header');?></strong></label><br />
					<textarea style="width:100%;min-height:200px;" name="_meta-generate-page-header-content" id="_meta-generate-page-header-content"><?php echo esc_html($stored_meta['_meta-generate-page-header-content'][0]); ?></textarea>
					<span class="description"><?php _e('HTML and shortcodes allowed.','generate-page-header');?></span>
				</p>
				<div class="generate-page-header-content-required content-settings-area">
					<div class="page-header-column">
						<p>
							<input type="checkbox" name="_meta-generate-page-header-content-autop" id="_meta-generate-page-header-content-autop" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-content-autop'] ) ) checked( $stored_meta['_meta-generate-page-header-content-autop'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-content-autop"><?php _e('Automatically add paragraphs','generate-page-header');?></label>
						</p>
						<p>
							<input type="checkbox" name="_meta-generate-page-header-content-padding" id="_meta-generate-page-header-content-padding" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-content-padding'] ) ) checked( $stored_meta['_meta-generate-page-header-content-padding'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-content-padding"><?php _e('Add padding','generate-page-header');?></label>
						</p>
						<p>
							<input class="image-background" type="checkbox" name="_meta-generate-page-header-image-background" id="_meta-generate-page-header-image-background" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-image-background'] ) ) checked( $stored_meta['_meta-generate-page-header-image-background'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-image-background"><?php _e('Add background image','generate-page-header');?></label>
						</p>
						<p class="parallax">
							<input type="checkbox" name="_meta-generate-page-header-image-background-fixed" id="_meta-generate-page-header-image-background-fixed" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-image-background-fixed'] ) ) checked( $stored_meta['_meta-generate-page-header-image-background-fixed'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-image-background-fixed"><?php _e('Parallax effect','generate-page-header');?></label>
						</p>
						<p class="fullscreen">
							<input type="checkbox" name="_meta-generate-page-header-full-screen" id="_meta-generate-page-header-full-screen" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-full-screen'] ) ) checked( $stored_meta['_meta-generate-page-header-full-screen'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-full-screen"><?php _e('Fullscreen','generate-page-header');?></label>
						</p>
						<p class="vertical-center">
							<input type="checkbox" name="_meta-generate-page-header-vertical-center" id="_meta-generate-page-header-vertical-center" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-vertical-center'] ) ) checked( $stored_meta['_meta-generate-page-header-vertical-center'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-vertical-center"><?php _e('Vertical center content','generate-page-header');?></label>
						</p>
						<?php if ( 'post' == get_post_type() && !is_single() ) { ?>
							<div class="show-in-excerpt">
								<p>
									<input type="checkbox" name="_meta-generate-page-header-add-to-excerpt" id="_meta-generate-page-header-add-to-excerpt" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-add-to-excerpt'] ) ) checked( $stored_meta['_meta-generate-page-header-add-to-excerpt'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-add-to-excerpt"><?php _e('Add to blog excerpt','generate-page-header');?></label>
								</p>
							</div>
						<?php } ?>
					</div>
					<div class="page-header-column">
						<p>
							<label for="_meta-generate-page-header-image-background-type" class="example-row-title"><strong><?php _e('Container type','generate-page-header');?></strong></label><br />
							<select name="_meta-generate-page-header-image-background-type" id="_meta-generate-page-header-image-background-type">
								<option value="" <?php selected( $stored_meta['_meta-generate-page-header-image-background-type'][0], '' ); ?>><?php _e('Contained','generate-page-header');?></option>
								<option value="fluid" <?php selected( $stored_meta['_meta-generate-page-header-image-background-type'][0], 'fluid' ); ?>><?php _e('Fluid','generate-page-header');?></option>
							</select>
						</p>

						<p>
							<label for="_meta-generate-page-header-image-background-alignment" class="example-row-title"><strong><?php _e('Text alignment','generate-page-header');?></strong></label><br />
							<select name="_meta-generate-page-header-image-background-alignment" id="_meta-generate-page-header-image-background-alignment">
								<option value="" <?php selected( $stored_meta['_meta-generate-page-header-image-background-alignment'][0], '' ); ?>><?php _e('Left','generate-page-header');?></option>
								<option value="center" <?php selected( $stored_meta['_meta-generate-page-header-image-background-alignment'][0], 'center' ); ?>><?php _e('Center','generate-page-header');?></option>
								<option value="right" <?php selected( $stored_meta['_meta-generate-page-header-image-background-alignment'][0], 'right' ); ?>><?php _e('Right','generate-page-header');?></option>
							</select>
						</p>
						
						<p>
							<label for="_meta-generate-page-header-image-background-spacing" class="example-row-title"><strong><?php _e('Top/Bottom padding','generate-page-header');?></strong></label><br />
							<input placeholder="" style="width:45px" type="text" name="_meta-generate-page-header-image-background-spacing" id="_meta-generate-page-header-image-background-spacing" value="<?php echo intval( $stored_meta['_meta-generate-page-header-image-background-spacing'][0] ); ?>" /><label for="_meta-generate-page-header-image-background-spacing"><span class="pixels">px</span></label>
						</p>
					</div>
					<div class="page-header-column last">
						<p>
							<label for="_meta-generate-page-header-image-background-color" class="example-row-title"><strong><?php _e('Background color','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-color" id="_meta-generate-page-header-image-background-color" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-color'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-image-background-text-color" class="example-row-title"><strong><?php _e('Text color','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-text-color" id="_meta-generate-page-header-image-background-text-color" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-text-color'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-image-background-link-color" class="example-row-title"><strong><?php _e('Link color','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-link-color" id="_meta-generate-page-header-image-background-link-color" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-link-color'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-image-background-link-color-hover" class="example-row-title"><strong><?php _e('Link color hover','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-link-color-hover" id="_meta-generate-page-header-image-background-link-color-hover" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0]; ?>" />
						</p>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<?php if ( generate_page_header_logo_exists() ) : ?>
				<div id="generate-tab-4" class="generate-tab-content">
					<div id="preview-image">
						<?php if( $stored_meta['_meta-generate-page-header-logo'][0] != "") { ?>
							<img class="saved-image" src="<?php echo $stored_meta['_meta-generate-page-header-logo'][0];?>" width="100" />
						<?php } ?>
					</div>
					<label for="_meta-generate-page-header-logo" class="example-row-title"><strong><?php _e('Header / Logo','generate-page-header');?></strong></label><br />
					<input style="width:350px" id="_meta-generate-page-header-logo" type="text" name="_meta-generate-page-header-logo" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-logo'][0]); ?>" />			   
					<button class="generate-upload-file button" type="button" data-type="image" data-title="<?php _e( 'Header / Logo','generate-page-header' );?>" data-insert="<?php _e( 'Insert Image','generate-page-header'); ?>" data-prev="true">
						<?php _e('Add Image','generate-page-header') ;?>
					</button>
					<input id="_meta-generate-page-header-logo-id" type="hidden" name="_meta-generate-page-header-logo-id" value="<?php echo $stored_meta['_meta-generate-page-header-logo-id'][0]; ?>" />
				</div>
			<?php endif; ?>
			<div id="<?php if ( generate_page_header_logo_exists() ) : ?>generate-tab-5<?php else : ?>generate-tab-4<?php endif; ?>" class="generate-tab-content generate-page-header-content-required">
				<p>
					<input type="checkbox" name="_meta-generate-page-header-combine" id="_meta-generate-page-header-combine" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-combine'] ) ) checked( $stored_meta['_meta-generate-page-header-combine'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-combine"><?php _e('Merge with site header','generate-page-header');?></label>
				</p>
				
				<div class="combination-options">
					<p>
						<label for="_meta-generate-page-header-site-title" class="example-row-title"><strong><?php _e('Site title','generate-page-header');?></strong></label><br />
						<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-site-title" id="_meta-generate-page-header-site-title" value="<?php echo $stored_meta['_meta-generate-page-header-site-title'][0]; ?>" />
					</p>
					
					<p>
						<label for="_meta-generate-page-header-site-tagline" class="example-row-title"><strong><?php _e('Site tagline','generate-page-header');?></strong></label><br />
						<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-site-tagline" id="_meta-generate-page-header-site-tagline" value="<?php echo $stored_meta['_meta-generate-page-header-site-tagline'][0]; ?>" />
					</p>
					
					<p>
						<input type="checkbox" name="_meta-generate-page-header-transparent-navigation" id="_meta-generate-page-header-transparent-navigation" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-transparent-navigation'] ) ) checked( $stored_meta['_meta-generate-page-header-transparent-navigation'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-transparent-navigation"><?php _e('Transparent navigation','generate-page-header');?></label>
					</p>
					
					<div class="navigation-colors">
						<p>
							<label for="_meta-generate-page-header-navigation-text" class="example-row-title"><strong><?php _e('Navigation text','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-text" id="_meta-generate-page-header-navigation-text" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-text'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-navigation-background-hover" class="example-row-title"><strong><?php _e('Navigation background hover','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-background-hover" id="_meta-generate-page-header-navigation-background-hover" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-background-hover'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-navigation-text-hover" class="example-row-title"><strong><?php _e('Navigation text hover','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-text-hover" id="_meta-generate-page-header-navigation-text-hover" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-text-hover'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-navigation-background-current" class="example-row-title"><strong><?php _e('Navigation background current','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-background-current" id="_meta-generate-page-header-navigation-background-current" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-background-current'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-navigation-text-current" class="example-row-title"><strong><?php _e('Navigation text current','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-text-current" id="_meta-generate-page-header-navigation-text-current" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-text-current'][0]; ?>" />
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		(function(a){if("undefined"!=typeof a.fn.lc_switch)return!1;a.fn.lc_switch=function(d,f){a.fn.lcs_destroy=function(){a(this).each(function(){a(this).parents(".lcs_wrap").children().not("input").remove();a(this).unwrap()});return!0};a.fn.lcs_on=function(){a(this).each(function(){var b=a(this).parents(".lcs_wrap"),c=b.find("input");"function"==typeof a.fn.prop?b.find("input").prop("checked",!0):b.find("input").attr("checked",!0);b.find("input").trigger("lcs-on");b.find("input").trigger("lcs-statuschange");
b.find(".lcs_switch").removeClass("lcs_off").addClass("lcs_on");if(b.find(".lcs_switch").hasClass("lcs_radio_switch")){var d=c.attr("name");b.parents("form").find("input[name="+d+"]").not(c).lcs_off()}});return!0};a.fn.lcs_off=function(){a(this).each(function(){var b=a(this).parents(".lcs_wrap");"function"==typeof a.fn.prop?b.find("input").prop("checked",!1):b.find("input").attr("checked",!1);b.find("input").trigger("lcs-off");b.find("input").trigger("lcs-statuschange");b.find(".lcs_switch").removeClass("lcs_on").addClass("lcs_off")});
return!0};return this.each(function(){if(!a(this).parent().hasClass("lcs_wrap")){var b="undefined"==typeof d?"ON":d,c="undefined"==typeof f?"OFF":f,b=b?'<div class="lcs_label lcs_label_on">'+b+"</div>":"",c=c?'<div class="lcs_label lcs_label_off">'+c+"</div>":"",g=a(this).is(":disabled")?!0:!1,e=a(this).is(":checked")?!0:!1,e=""+(e?" lcs_on":" lcs_off");g&&(e+=" lcs_disabled");b='<div class="lcs_switch '+e+'"><div class="lcs_cursor"></div>'+b+c+"</div>";!a(this).is(":input")||"checkbox"!=a(this).attr("type")&&
"radio"!=a(this).attr("type")||(a(this).wrap('<div class="lcs_wrap"></div>'),a(this).parent().append(b),a(this).parent().find(".lcs_switch").addClass("lcs_"+a(this).attr("type")+"_switch"))}})};a(document).ready(function(){a(document).delegate(".lcs_switch:not(.lcs_disabled)","click tap",function(d){a(this).hasClass("lcs_on")?a(this).hasClass("lcs_radio_switch")||a(this).lcs_off():a(this).lcs_on()});a(document).delegate(".lcs_wrap input","change",function(){a(this).is(":checked")?a(this).lcs_on():
a(this).lcs_off()})})})(jQuery);

		jQuery(document).ready(function($) {
			$('.generate-tab-content input[type="checkbox"]').lc_switch('', '');
			$(".generate-tabs-menu a").click(function(event) {
				event.preventDefault();
				$(this).parent().addClass("generate-current");
				$(this).parent().siblings().removeClass("generate-current");
				var tab = $(this).attr("href");
				$(".generate-tab-content").not(tab).css("display", "none");
				$(tab).fadeIn();
			});
			
			$('#_meta-generate-page-header-content').bind('input change', function() {
				$("li.generate-page-header-content-required, .content-settings-area").hide();

				if ( this.value.length ) {
					$("li.generate-page-header-content-required, .content-settings-area").show();
				}
			});
		});
		jQuery(window).load(function($) {
			
			<?php if ( $stored_meta['_meta-generate-page-header-content'][0] == '' ) : ?>
				jQuery('#generate-tab-3').hide();
				jQuery('.generate-tabs-menu .image-settings').addClass('generate-current');
				jQuery('.generate-tabs-menu .content-settings').removeClass('generate-current');
				jQuery("li.generate-page-header-content-required, .content-settings-area").hide();
			<?php else : ?>
				jQuery('#generate-tab-1').hide();
				jQuery('#generate-tab-3').show();
				jQuery('.generate-tabs-menu .content-settings').addClass('generate-current');
				jQuery('.generate-tabs-menu .image-settings').removeClass('generate-current');
				jQuery("li.generate-page-header-content-required, .content-settings-area").show();
			<?php endif; ?>
			
			if ( jQuery('#_meta-generate-page-header-enable-image-crop').val() == 'enable' ) {
				jQuery('#crop-enabled').show();
			}
            jQuery('#_meta-generate-page-header-enable-image-crop').change(function () {
                if (jQuery(this).val() === 'enable') {
                    jQuery('#crop-enabled').show();
                } else {
                    jQuery('#crop-enabled').hide();
                }
            });
			
			if ( jQuery('#_meta-generate-page-header-image-background').is(':checked')) {
				jQuery('.parallax').show();
			} else {
				jQuery('.parallax').hide();
			}
			
			jQuery('body').delegate('.image-background', 'lcs-statuschange', function() {
				if (jQuery(this).is(":checked")) {
                    jQuery('.parallax').show();
                } else {
                    jQuery('.parallax').hide();
					jQuery('#_meta-generate-page-header-image-background-fixed').lcs_off();
                }
			});
			
			if ( jQuery('#_meta-generate-page-header-full-screen').is(':checked')) {
				jQuery('.vertical-center').show();
			} else {
				jQuery('.vertical-center').hide();
			}
			
			jQuery('body').delegate('#_meta-generate-page-header-full-screen', 'lcs-statuschange', function() {
				if (jQuery(this).is(":checked")) {
                    jQuery('.vertical-center').show();
                } else {
                    jQuery('.vertical-center').hide();
					jQuery('#_meta-generate-page-header-vertical-center').lcs_off();
                }
			});
			
			if ( jQuery('#_meta-generate-page-header-transparent-navigation').is(':checked')) {
				jQuery('.navigation-colors').show();
			} else {
				jQuery('.navigation-colors').hide();
			}
			
			jQuery('body').delegate('#_meta-generate-page-header-transparent-navigation', 'lcs-statuschange', function() {
				if (jQuery(this).is(":checked")) {
                    jQuery('.navigation-colors').show();
                } else {
                    jQuery('.navigation-colors').hide();
                }
			});
			
			if ( jQuery('#_meta-generate-page-header-combine').is(':checked')) {
				jQuery('.combination-options').show();
			} else {
				jQuery('.combination-options').hide();
			}
			
			jQuery('body').delegate('#_meta-generate-page-header-combine', 'lcs-statuschange', function() {
				if (jQuery(this).is(":checked")) {
                    jQuery('.combination-options').show();
                } else {
                    jQuery('.combination-options').hide();
                }
			});
			
			if ( jQuery('#_meta-generate-page-header-image-background-type').val() == '' ) {
				jQuery('.vertical-center').hide();
				jQuery('.fullscreen').hide();
			}
            jQuery('#_meta-generate-page-header-image-background-type').change(function () {
                if (jQuery(this).val() === '') {
                    jQuery('.vertical-center').hide();
					jQuery('#_meta-generate-page-header-vertical-center').lcs_off();
					jQuery('.fullscreen').hide();
					jQuery('#_meta-generate-page-header-full-screen').lcs_off();
                } else {
                    //jQuery('.vertical-center').show();
					jQuery('.fullscreen').show();
                }
            });
			
			var $set_button = jQuery('.generate-upload-file');
			/**
			 * open the media manager
			 */
			$set_button.click(function (e) {
				e.preventDefault();
				
				var $thisbutton = jQuery(this);
				var frame = wp.media({
					title : $thisbutton.data('title'),
					multiple : false,
					library : { type : $thisbutton.data('type') },
					button : { text : $thisbutton.data('insert') }
				});
				// close event media manager
				frame.on('select', function () {
					var attachment = frame.state().get('selection').first().toJSON();
					// set the file
					//set_dfi(attachment.url);
					$thisbutton.prev('input').val(attachment.url);
					$thisbutton.next('input').val(attachment.id);
					if ( $thisbutton.data('prev') === true ) {
						$thisbutton.prev('input').prev('#preview-image').children('.saved-image').remove();
						$thisbutton.prev('input').prev('#preview-image').append('<img src="' + attachment.url + '" width="100" class="saved-image" />');
					}
				});

				// everthing is set open the media manager
				frame.open();
			});
		});
		jQuery(document).ready(function($) {
			$('.color-picker').wpColorPicker();
		});
	</script>
	
	<style>
		@media (min-width: 769px) {
			.page-header-column {
				width: 30%;
				margin-right: 3%;
				float: left;
			}
			.page-header-column.last {
				margin-right: 0;
			}
		}
		.generate-tab {
			clear: both;
		}
		.generate-tabs-menu li {
			display: inline-block;
		}
		.generate-tab-content {
			display: none;
		}

		#generate-tab-1 {
			display: block;   
		}
		
		.generate-current a.button,
		.generate-tabs-menu li a.button:focus{
			background: #eee;
			border-color: #999;
			-webkit-box-shadow: inset 0 2px 5px -3px rgba(0,0,0,.5);
			box-shadow: inset 0 2px 5px -3px rgba(0,0,0,.5);
			-webkit-transform: translateY(1px);
			-ms-transform: translateY(1px);
			transform: translateY(1px);
		}
		
		.lcs_wrap {
			display: inline-block;	
			direction: ltr;
			height: 28px;
			vertical-align: middle;
		}
		.lcs_wrap input {
			display: none;	
		}

		.lcs_switch {
			display: inline-block;	
			position: relative;
			width: 73px;
			height: 28px;
			border-radius: 30px;
			background: #ddd;
			overflow: hidden;
			cursor: pointer;
			
			-webkit-transition: all .2s ease-in-out;  
			-ms-transition: 	all .2s ease-in-out; 
			transition: 		all .2s ease-in-out; 
		}
		.lcs_cursor {
			display: inline-block;
			position: absolute;
			top: 3px;	
			width: 22px;
			height: 22px;
			border-radius: 100%;
			background: #fff;
			box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2), 0 3px 4px 0 rgba(0, 0, 0, 0.1);
			z-index: 10;
			
			-webkit-transition: all .2s linear;  
			-ms-transition: 	all .2s linear; 
			transition: 		all .2s linear; 
		}
		.lcs_label {
			font-family: "Trebuchet MS", Helvetica, sans-serif;
			font-size: 12px;
			letter-spacing: 1px;
			line-height: 18px;
			color: #fff;
			font-weight: bold;
			position: absolute;
			width: 33px;
			top: 5px;
			overflow: hidden;
			text-align: center;
			opacity: 0;
			
			-webkit-transition: all .2s ease-in-out .1s;  
			-ms-transition: 	all .2s ease-in-out .1s;   
			transition: 		all .2s ease-in-out .1s;   
		}
		.lcs_label.lcs_label_on {
			left: -70px;
			z-index: 6;	
		}
		.lcs_label.lcs_label_off {
			right: -70px;
			z-index: 5;	
		}


		/* on */
		.lcs_switch.lcs_on {
			background: #75b936;
			box-shadow: 0 0 2px #579022 inset;
		}
		.lcs_switch.lcs_on .lcs_cursor {
			left: 48px;
		}
		.lcs_switch.lcs_on .lcs_label_on {
			left: 10px;	
			opacity: 1;
		}


		/* off */
		.lcs_switch.lcs_off {
			background: #b2b2b2;
			box-shadow: 0px 0px 2px #a4a4a4 inset; 	
		}
		.lcs_switch.lcs_off .lcs_cursor {
			left: 3px;
		}
		.lcs_switch.lcs_off .lcs_label_off {
			right: 10px;
			opacity: 1;	
		}


		/* disabled */
		.lcs_switch.lcs_disabled {
			opacity: 0.65;
			filter: alpha(opacity=65);	
			cursor: default;
		}
		
		.choose-content-options span {
			display:block;
			color:#222;
		}
		.choose-content-options div {
			margin-bottom:10px;
			border-bottom:1px solid #DDD;
			padding-bottom:10px;
		}
		.nav-tab.active {
			border-bottom:1px solid #fff;
			color:#124964;
			background:#FFF;
		}
		.nav-tab {
			margin-bottom: 0;
			position:relative;
			bottom: -1px;
		}
		#poststuff h2.nav-tab-wrapper {
			padding: 0;
		}
		.nav-tab:focus {
			outline: none;
		}
		h2.page-header .nav-tab {
			font-size:15px;
		}
		.small {
			display: block;
			font-size: 11px;
		}
	</style>
    <?php
}
endif;

if ( ! function_exists( 'save_generate_page_header_meta' ) ) :
// Save the Data  
add_action('save_post', 'save_generate_page_header_meta');
function save_generate_page_header_meta($post_id) {  
    
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'generate_page_header_nonce' ] ) && wp_verify_nonce( $_POST[ 'generate_page_header_nonce' ], basename( __FILE__ ) ) ) ? true : false;
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
	
	$options = array(
		'_meta-generate-page-header-content' => 'FILTER_DEFAULT',
		'_meta-generate-page-header-image' => 'FILTER_SANITIZE_URL',
		'_meta-generate-page-header-image-id' => 'FILTER_SANITIZE_NUMBER_INT',
		'_meta-generate-page-header-image-link' => 'FILTER_SANITIZE_URL',
		'_meta-generate-page-header-enable-image-crop' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-crop' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-width' => 'FILTER_SANITIZE_NUMBER_INT',
		'_meta-generate-page-header-image-height' => 'FILTER_SANITIZE_NUMBER_INT',
		'_meta-generate-page-header-image-background-type' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background-alignment' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background-spacing' => 'FILTER_SANITIZE_NUMBER_INT',
		'_meta-generate-page-header-image-background-color' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background-text-color' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background-link-color' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background-link-color-hover' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-navigation-text' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-navigation-background-hover' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-navigation-text-hover' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-navigation-background-current' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-navigation-text-current' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-site-title' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-site-tagline' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-video' => 'FILTER_SANITIZE_URL',
		'_meta-generate-page-header-video-ogv' => 'FILTER_SANITIZE_URL',
		'_meta-generate-page-header-video-webm' => 'FILTER_SANITIZE_URL',
		'_meta-generate-page-header-video-overlay' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-content-autop' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-content-padding' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-full-screen' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-vertical-center' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background-fixed' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-combine' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-transparent-navigation' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-add-to-excerpt' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-logo' => 'FILTER_SANITIZE_URL',
		'_meta-generate-page-header-logo-id' => 'FILTER_SANITIZE_NUMBER_INT',
	);

	foreach ( $options as $key => $sanitize ) {
		if ( 'FILTER_SANITIZE_STRING' == $sanitize ) {
			$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
		} elseif ( 'FILTER_SANITIZE_URL' == $sanitize ) {
			$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_URL );
		} elseif ( 'FILTER_SANITIZE_NUMBER_INT' == $sanitize ) {
			$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT );
		} else {
			$value = filter_input( INPUT_POST, $key, FILTER_DEFAULT );
		}
		
		if ( $value )
			update_post_meta( $post_id, $key, $value );
		else
			delete_post_meta( $post_id, $key );
	}
	
}  
endif;

if ( ! function_exists( 'generate_page_header_get_defaults' ) ) :
/**
 * Set default options
 */
function generate_page_header_get_defaults()
{
	$generate_page_header_defaults = array(
		'page_header_position' => 'above-content',
		'post_header_position' => 'inside-content',
		'page_header_image' => '',
		'page_header_logo' => '',
		'page_header_url' => '',
		'page_header_hard_crop' => 'disable',
		'page_header_image_width' => '1200',
		'page_header_image_height' => '0',
		'page_header_content' => '',
		'page_header_add_paragraphs' => '0',
		'page_header_add_padding' => '0',
		'page_header_image_background' => '0',
		'page_header_add_parallax' => '0',
		'page_header_full_screen' => '0',
		'page_header_vertical_center' => '0',
		'page_header_container_type' => '',
		'page_header_text_alignment' => 'left',
		'page_header_padding' => '',
		'page_header_background_color' => '',
		'page_header_text_color' => '',
		'page_header_link_color' => '',
		'page_header_link_color_hover' => '',
		'page_header_video' => '',
		'page_header_video_ogv' => '',
		'page_header_video_webm' => '',
		'page_header_video_overlay' => '',
		'page_header_combine' => '',
		'page_header_site_title' => '',
		'page_header_site_tagline' => '',
		'page_header_transparent_navigation' => '',
		'page_header_navigation_text' => '',
		'page_header_navigation_background_hover' => '',
		'page_header_navigation_text_hover' => '',
		'page_header_navigation_background_current' => '',
		'page_header_navigation_text_current' => ''
	);
	
	return apply_filters( 'generate_page_header_option_defaults', $generate_page_header_defaults );
}
endif;

if ( ! function_exists( 'generate_page_header_customize_register' ) ) :
add_action( 'customize_register', 'generate_page_header_customize_register' );
function generate_page_header_customize_register( $wp_customize ) {

	$defaults = generate_page_header_get_defaults();
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_page_header_settings[page_header_position]',
		// Arguments array
		array(
			'default' => $defaults['page_header_position'],
			'type' => 'option'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'page_header_control',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Page Header Position', 'generate-page-header' ),
			'section' => 'layout_section',
			'choices' => array(
				'above-content' => __( 'Above Content Area', 'generate-page-header' ),
				'inside-content' => __( 'Inside Content Area', 'generate-page-header' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_page_header_settings[page_header_position]',
			'priority' => 100
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_page_header_settings[post_header_position]',
		// Arguments array
		array(
			'default' => $defaults['post_header_position'],
			'type' => 'option'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'post_header_control',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Single Post Header Position', 'generate-page-header' ),
			'section' => 'layout_section',
			'choices' => array(
				'above-content' => __( 'Above Content Area', 'generate-page-header' ),
				'inside-content' => __( 'Inside Content Area', 'generate-page-header' ),
				'below-title' => __( 'Below Post Title', 'generate-page-header' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_page_header_settings[post_header_position]',
			'priority' => 101
		)
	);
}
endif;

if ( ! function_exists( 'generate_page_header_admin_style' ) ) :
	add_action( 'admin_head','generate_page_header_admin_style' );
	function generate_page_header_admin_style()
	{
		echo '<style>.appearance_page_page_header #footer-upgrade {display: none;}</style>';
	}
endif;

if ( ! function_exists( 'generate_get_attachment_id_by_url' ) ) :
/**
* Return an ID of an attachment by searching the database with the file URL.
*
* First checks to see if the $url is pointing to a file that exists in
* the wp-content directory. If so, then we search the database for a
* partial match consisting of the remaining path AFTER the wp-content
* directory. Finally, if a match is found the attachment ID will be
* returned.
*
* @param string $url The URL of the image (ex: http://mysite.com/wp-content/uploads/2013/05/test-image.jpg)
*
* @return int|null $attachment Returns an attachment ID, or null if no attachment is found
*/
function generate_get_attachment_id_by_url( $attachment_url = '' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}
endif;

if ( ! function_exists( 'generate_page_header_sanitize_choices' ) ) :
function generate_page_header_sanitize_choices( $input, $setting ) {
	
	// Ensure input is a slug
	$input = sanitize_key( $input );
	
	// Get list of choices from the control
	// associated with the setting
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it;
	// otherwise, return the default
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;

if ( ! function_exists( 'generate_page_header_sanitize_html' ) ) :
function generate_page_header_sanitize_html( $input ) 
{
	return wp_kses_post( $input );
}
endif;

if ( ! function_exists( 'generate_page_header_sanitize_hex_color' ) ) :
function generate_page_header_sanitize_hex_color( $color ) {
    if ( '' === $color )
        return '';
 
    // 3 or 6 hex digits, or the empty string.
    if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
        return $color;
 
    return '';
}
endif;

if ( ! function_exists( 'generate_page_header_sanitize_integer' ) ) :
function generate_page_header_sanitize_integer( $input ) {
	return absint( $input );
}
endif;

if ( ! function_exists( 'generate_page_header_hex2rgba' ) ) :
function generate_page_header_hex2rgba($color, $opacity = false) {
 
	$default = 'rgb(0,0,0)';
 
	//Return default if no color provided
	if(empty($color))
          return $default; 
 
	//Sanitize $color if "#" is provided 
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
			return $default;
	}

	//Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);

	//Check if opacity is set(rgba or rgb)
	if($opacity){
		if(abs($opacity) > 1)
			$opacity = 1.0;
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else {
		$output = 'rgb('.implode(",",$rgb).')';
	}

	//Return rgb(a) color string
	return $output;
}
endif;

if ( ! function_exists( 'generate_page_header_replace_logo' ) ) :
function generate_page_header_replace_logo()
{
	if ( generate_page_header_logo_exists() ) {
		if ( is_home() ) :
			$options = get_option( 'generate_page_header_options', '' );
			$logo = ( !empty( $options['page_header_logo'] ) ) ? $options['page_header_logo'] : '';
		else :
			global $post;
			$logo = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-logo', true ) : '';
		endif;
		
		return $logo;
	}
}
endif;

if ( ! function_exists( 'generate_page_header_setup' ) ) :
add_action( 'wp','generate_page_header_setup' );
function generate_page_header_setup()
{
	if ( is_home() ) :
		$options = get_option( 'generate_page_header_options', '' );
		$logo = ( !empty( $options['page_header_logo'] ) ) ? $options['page_header_logo'] : '';
	else :
		global $post;
		$logo = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-logo', true ) : '';
	endif;
	
	if ( generate_page_header_logo_exists() && '' !== $logo ) {
		add_filter( 'generate_logo', 'generate_page_header_replace_logo' );
	}
}
endif;

if ( ! function_exists( 'generate_page_header_logo_exists' ) ) :
function generate_page_header_logo_exists()
{
	if ( function_exists( 'generate_get_defaults' ) ) :
		$generate_settings = wp_parse_args( 
			get_option( 'generate_settings', array() ), 
			generate_get_defaults() 
		);
	endif;
	
	if ( function_exists( 'generate_construct_logo' ) && '' !== $generate_settings[ 'logo' ] )
		return true;
	
	return false;
}
endif;
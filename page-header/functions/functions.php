<?php
// Include our image resizer
if ( ! defined( 'GP_IMAGE_RESIZER' ) && ! class_exists( 'GP_Resize' ) )
	require plugin_dir_path( __FILE__ ) . 'aq_resizer.php';

// Include our Blog Page Header customizer options
require plugin_dir_path( __FILE__ ) . 'customizer.php';

// Include our metabox options
require plugin_dir_path( __FILE__ ) . 'metabox.php';

// Include our Page Header area
require plugin_dir_path( __FILE__ ) . 'page-header.php';

// Include our Blog Page Header area
require plugin_dir_path( __FILE__ ) . 'blog-page-header.php';

// Include our Post Image area
require plugin_dir_path( __FILE__ ) . 'post-image.php';

if ( ! function_exists( 'generate_page_header_admin_enqueue' ) ) :
add_action('admin_enqueue_scripts','generate_page_header_admin_enqueue');
function generate_page_header_admin_enqueue() {
	wp_enqueue_script('wp-color-picker');
    wp_enqueue_style( 'wp-color-picker' );
}
endif;

if ( ! function_exists( 'generate_combined_page_header_start' ) ) :
add_action( 'generate_inside_merged_page_header','generate_combined_page_header_start', 0 );
function generate_combined_page_header_start()
{
	if ( is_home() ) :
		$options = get_option( 'generate_page_header_options', '' );
		$combine = ( !empty( $options['page_header_combine'] ) ) ? $options['page_header_combine'] : '';
		$absolute = ( !empty( $options['page_header_absolute_position'] ) ) ? $options['page_header_absolute_position'] : '';
		$page_header_vertical_center = ( !empty( $options['page_header_vertical_center'] ) ) ? $options['page_header_vertical_center'] : '';
		$page_header_content = ( !empty( $options['page_header_content'] ) ) ? $options['page_header_content'] : '';
	else :
		global $post;
		$combine = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-combine', true ) : '';
		$absolute = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-absolute-position', true ) : '';
		$page_header_vertical_center = get_post_meta( get_the_ID(), '_meta-generate-page-header-vertical-center', true );
		$page_header_content = get_post_meta( get_the_ID(), '_meta-generate-page-header-content', true );
	endif;
	if ( '' == $combine || ! isset( $combine ) || '' == $page_header_content || '' == $absolute || ! isset( $absolute ) )
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
		$absolute = ( !empty( $options['page_header_absolute_position'] ) ) ? $options['page_header_absolute_position'] : '';
		//$page_header_vertical_center = ( !empty( $options['page_header_vertical_center'] ) ) ? $options['page_header_vertical_center'] : '';
		$page_header_content = ( !empty( $options['page_header_content'] ) ) ? $options['page_header_content'] : '';
	else :
		global $post;
		$combine = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-combine', true ) : '';
		$absolute = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-absolute-position', true ) : '';
		//$page_header_vertical_center = get_post_meta( get_the_ID(), '_meta-generate-page-header-vertical-center', true );
		$page_header_content = get_post_meta( get_the_ID(), '_meta-generate-page-header-content', true );
	endif;
	if ( '' == $combine || ! isset( $combine ) || '' == $page_header_content || '' == $absolute || ! isset( $absolute ) )
		return;
	
	echo '</div><!-- .generate-combined-header -->';
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
		$page_header_vertical_center = ( !empty( $options['page_header_vertical_center'] ) ) ? $options['page_header_vertical_center'] : '';
	else :
		$image_background_fixed = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-background-fixed', true );
		$fullscreen = get_post_meta( get_the_ID(), '_meta-generate-page-header-full-screen', true );
		$video = get_post_meta( get_the_ID(), '_meta-generate-page-header-video', true );
		$page_header_content = get_post_meta( get_the_ID(), '_meta-generate-page-header-content', true );
		$page_header_vertical_center = get_post_meta( get_the_ID(), '_meta-generate-page-header-vertical-center', true );
	endif;
	
	if ( ( '' !== $image_background_fixed || '' !== $fullscreen ) && '' !== $page_header_content ) :
		wp_enqueue_script( 'generate-page-header-parallax', plugin_dir_url( __FILE__ ) . 'js/parallax.min.js', array('jquery'), GENERATE_PAGE_HEADER_VERSION, true );
	endif;
	
	if ( '' !== $video && '' !== $page_header_content ) :
		wp_enqueue_script( 'generate-page-header-video', plugin_dir_url( __FILE__ ) . 'js/jquery.vide.min.js', array('jquery'), GENERATE_PAGE_HEADER_VERSION, true );
	endif;
	
	if ( '' !== $page_header_vertical_center && '' !== $page_header_content ) :
		wp_enqueue_script( 'generate-flexibility', plugin_dir_url( __FILE__ ) . 'js/flexibility.min.js', array(), GENERATE_PAGE_HEADER_VERSION, true );
		if ( function_exists( 'wp_script_add_data' ) ) :
			wp_script_add_data( 'generate-flexibility', 'conditional', 'lt IE 9' );
		endif;
	endif;
	if ( '' !== $page_header_content )
		wp_enqueue_style( 'generate-page-header', plugin_dir_url( __FILE__ ) . 'css/page-header-min.css', array(), GENERATE_PAGE_HEADER_VERSION );
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
		$absolute = ( !empty( $options['page_header_absolute_position'] ) ) ? $options['page_header_absolute_position'] : '';
		$fullscreen = ( !empty( $options['page_header_full_screen'] ) ) ? $options['page_header_full_screen'] : '';
		$navigation_background = ( !empty( $options['page_header_transparent_navigation'] ) ) ? $options['page_header_transparent_navigation'] : '';
		$navigation_text = ( '' !== $navigation_background ) ? $options['page_header_navigation_text'] : '';
		$navigation_background_hover = ( '' !== $navigation_background ) ? $options['page_header_navigation_background_hover'] : '';
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
		$absolute = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-absolute-position', true ) : '';
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
		
		'.inside-content-header' => array(
			'background-image' => ( 'fluid' !== $image_background_type && !empty( $image_background ) ) ? 'url(' . $page_header_image_custom . ')' : null,
			'background-color' => ( 'fluid' !== $image_background_type ) ? $background_color : null,
			'background-size' => ( 'fluid' !== $image_background_type && !empty( $image_background ) ) ? 'cover' : null,
			'background-attachment' => ( 'fluid' !== $image_background_type && !empty( $image_background ) && !empty( $image_background_fixed ) ) ? 'fixed' : null,
			'background-position' => ( 'fluid' !== $image_background_type && !empty( $image_background ) && !empty( $image_background_fixed ) ) ? 'center top' : null
		),
		
		'.generate-inside-combined-content, .generate-inside-page-header-content' => array(
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
		
		'.generate-merged-header .inside-header' => array(
			'-moz-box-sizing' => ( '' !== $combine && 'fluid' !== $image_background_type ) ? 'border-box' : null,
			'-webkit-box-sizing' => ( '' !== $combine && 'fluid' !== $image_background_type ) ? 'border-box' : null,
			'box-sizing' => ( '' !== $combine && 'fluid' !== $image_background_type ) ? 'border-box' : null
		),
		
		'.generate-merged-header .site-header' => array(
			'background' => ( '' !== $combine ) ? 'transparent' : null,
			
		),
		
		'.generate-merged-header .main-navigation:not(.is_stuck):not(.toggled):not(.mobile-header-navigation)' => array(
			'background' => ( '' !== $navigation_background ) ? 'transparent' : null
		),
		
		'.generate-merged-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > li > a, 
		.generate-merged-header .main-navigation:not(.is_stuck):not(.toggled):not(.mobile-header-navigation) .menu-toggle,
		.generate-merged-header .main-navigation:not(.is_stuck):not(.toggled):not(.mobile-header-navigation) .menu-toggle:hover,
		.generate-merged-header .main-navigation:not(.is_stuck):not(.toggled):not(.mobile-header-navigation) .menu-toggle:focus,
		.main-navigation .main-navigation:not(.is_stuck):not(.toggled) .mobile-bar-items a, 
		.main-navigation .main-navigation:not(.is_stuck):not(.toggled) .mobile-bar-items a:hover, 
		.main-navigation .main-navigation:not(.is_stuck):not(.toggled) .mobile-bar-items a:focus' => array(
			'color' => ( '' !== $navigation_text ) ? $navigation_text : null
		),
		
		'.generate-merged-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > li > a:hover, 
		.generate-merged-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > li > a:focus, 
		.generate-merged-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > li.sfHover > a' => array(
			'background' => ( '' == $navigation_background_hover && '' !== $navigation_background ) ? 'transparent' : $navigation_background_hover,
			'color' => ( '' !== $navigation_text_hover ) ? $navigation_text_hover : $navigation_text
		),
		
		'.generate-merged-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > .current-menu-item > a, 
		.generate-merged-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > .current-menu-item > a:hover,
		.generate-merged-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > .current-menu-parent > a, 
		.generate-merged-header .main-navigation:not(.is_stuck):not(.toggled) .main-nav > ul > .current-menu-parent > a:hover' => array(
			'background' => ( '' == $navigation_background_current && '' !== $navigation_background ) ? 'transparent' : $navigation_background_current,
			'color' => ( '' !== $navigation_text_current ) ? $navigation_text_current : $navigation_text
		),
		
		'.generate-merged-header .main-title a,
		.generate-merged-header .main-title a:hover,
		.generate-merged-header .main-title a:visited' => array(
			'color' => ( '' !== $site_title ) ? $site_title : null,
		),

		'.generate-merged-header .site-description' => array(
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

if ( ! function_exists( 'generate_page_header_combined' ) ) :
/**
 * Add the start to our page header containers if we're using a merged header
 */
add_action( 'generate_before_header','generate_page_header_combined', 5 );
function generate_page_header_combined()
{
	generate_page_header_area_start_container( 'page-header-image', 'page-header-content' );
	generate_blog_page_header_area_start_container( 'page-header-image', 'page-header-content' );
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
		'page_header_absolute_position' => '',
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
add_action( 'customize_register', 'generate_page_header_customize_register', 100 );
function generate_page_header_customize_register( $wp_customize ) {

	$defaults = generate_page_header_get_defaults();
	
	if ( $wp_customize->get_panel( 'generate_layout_panel' ) ) {
		$section = 'generate_layout_page_header';
		$wp_customize->add_section(
			'generate_layout_page_header',
			array(
				'title' => __( 'Page Header', 'generate-page-header' ),
				'capability' => 'edit_theme_options',
				'priority' => 35,
				'panel' => 'generate_layout_panel'
			)
		);
	} else {
		$section = 'layout_section';
	}
	
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
			'section' => $section,
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
			'section' => $section,
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
	
	if ( function_exists( 'generate_construct_logo' ) && ( '' !== $generate_settings[ 'logo' ] || '' !== get_theme_mod( 'custom_logo' ) ) )
		return true;
	
	return false;
}
endif;
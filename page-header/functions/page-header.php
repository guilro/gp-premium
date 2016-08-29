<?php
if ( ! function_exists( 'generate_page_header_area' ) ) :
function generate_page_header_area($image_class, $content_class)
{
	// Don't run the function unless we're on a page it applies to
	if ( ! is_singular() || is_attachment() )
		return;
	
	$featured_image = get_post_thumbnail_id( get_the_ID(), 'full' );
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
	
	do_action( 'generate_before_page_header' );
	
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
	
	$combine = get_post_meta( get_the_ID(), '_meta-generate-page-header-combine', true );
	
	// If content is set, show it - only if we're not using a combined header
	if ( '' !== $page_header_content && false !== $page_header_content && '' == $combine ) :
		printf( 
			'<div %1$s class="%2$s">
				<div %3$s class="inside-page-header-container inside-content-header grid-container grid-parent %4$s">
					<div class="generate-inside-page-header-content">
						%5$s
							%7$s
						%6$s
					</div>
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
	
	// If content is set, show it - only if we're using a combined header
	if ( '' !== $page_header_content && false !== $page_header_content && '' !== $combine ) :
		printf( 
					'<div class="generate-combined-content grid-container grid-parent">
						<div class="generate-inside-combined-content">
							%1$s
								%3$s
							%2$s
						</div>
					</div>
				</div>
			</div>',
			( $page_header_content_padding == 'yes' ) ? '<div class="inside-page-header">' : null,
			( $page_header_content_padding == 'yes' ) ? '</div>' : null,
			( $page_header_content_autop == 'yes' ) ? do_shortcode( wpautop( $page_header_content ) ) : do_shortcode( $page_header_content )
		);
	endif;
	
	do_action( 'generate_after_page_header' );
}
endif;

if ( ! function_exists( 'generate_page_header_area_start_container' ) ) :
function generate_page_header_area_start_container($image_class, $content_class)
{
	// Don't run the function unless we're on a page it applies to
	if ( ! is_singular() || is_attachment() )
		return;
	
	$combine = get_post_meta( get_the_ID(), '_meta-generate-page-header-combine', true );
	
	if ( '' == $combine )
		return;
	
	$page_header_content = get_post_meta( get_the_ID(), '_meta-generate-page-header-content', true );
	$page_header_image_custom = get_post_meta( get_the_ID(), '_meta-generate-page-header-image', true );
	$page_header_video = get_post_meta( get_the_ID(), '_meta-generate-page-header-video', true );
	$page_header_video_ogv = get_post_meta( get_the_ID(), '_meta-generate-page-header-video-ogv', true );
	$page_header_video_webm = get_post_meta( get_the_ID(), '_meta-generate-page-header-video-webm', true );
	
	// Get the other page header options
	$page_header_parallax = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-background-fixed', true );
	$page_header_full_screen = get_post_meta( get_the_ID(), '_meta-generate-page-header-full-screen', true );
	$page_header_vertical_center = get_post_meta( get_the_ID(), '_meta-generate-page-header-vertical-center', true );
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
	
	// If content is set, show it
	if ( '' !== $page_header_content && false !== $page_header_content ) :
		printf( 
			'<div %1$s class="%2$s">
				<div %3$s class="inside-page-header-container inside-content-header generate-merged-header %4$s %5$s">',
			( 'fluid' == $page_header_container_type ) ? $video : null,
			$content_class . $parallax . $full_screen . $vertical_center_container . ' generate-page-header generate-content-header',
			( 'fluid' !== $page_header_container_type ) ? $video : null,
			$vertical_center,
			( 'fluid' !== $page_header_container_type ) ? 'grid-container grid-parent' : ''
		);
	endif;
	
	do_action( 'generate_inside_merged_page_header' );
}
endif;
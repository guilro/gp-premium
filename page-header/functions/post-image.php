<?php
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
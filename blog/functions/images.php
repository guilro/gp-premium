<?php
/**
 * Load Image Resizer
 */
if ( ! defined( 'GP_IMAGE_RESIZER' ) && ! class_exists( 'GP_Resize' ) )
	require plugin_dir_path( __FILE__ ) . 'aq_resizer.php';

if ( ! function_exists( 'generate_get_blog_image_attributes' ) ) :
function generate_get_blog_image_attributes()
{
	$generate_settings = wp_parse_args( 
		get_option( 'generate_blog_settings', array() ), 
		generate_blog_get_defaults() 
	);
	
	$ignore_crop = array( '', '0', '9999' );
	
	$atts = array();
	
	$atts = array(
		'width' => ( in_array( $generate_settings['post_image_width'], $ignore_crop ) ) ? 9999 : intval( $generate_settings['post_image_width'] ),
		'height' => ( in_array( $generate_settings['post_image_height'], $ignore_crop ) ) ? 9999 : intval( $generate_settings['post_image_height'] ),
		'crop' => ( in_array( $generate_settings['post_image_width'], $ignore_crop ) || in_array( $generate_settings['post_image_height'], $ignore_crop ) ) ? false : true
	);
	
	// If there's no height or width, empty the array
	if ( 9999 == $atts[ 'width' ] && 9999 == $atts[ 'height' ] )
		$atts = array();
	
	return apply_filters( 'generate_blog_image_attributes', $atts );
}
endif;

if ( ! function_exists( 'generate_blog_setup' ) ) :
	add_action('wp','generate_blog_setup');
	function generate_blog_setup()
	{
		$generate_settings = wp_parse_args( 
			get_option( 'generate_blog_settings', array() ), 
			generate_blog_get_defaults() 
		);
		
		// Remove the default function and add our own
		remove_action( 'generate_after_entry_header', 'generate_post_image' );
		add_action( 'generate_after_entry_header', 'generate_blog_post_image' );
		
		if ( 'post-image-above-header' == $generate_settings['post_image_position'] ) :
			remove_action( 'generate_after_entry_header', 'generate_blog_post_image' );
			add_action( 'generate_before_content', 'generate_blog_post_image' );
			
			if ( function_exists('generate_page_header_post_image') ) :
				remove_action( 'generate_after_entry_header', 'generate_page_header_post_image' );
				add_action( 'generate_before_content', 'generate_page_header_post_image' );
			endif;
		endif;
	}
endif;

if ( ! function_exists( 'generate_blog_post_image' ) ) :
function generate_blog_post_image()
{
	if ( ! has_post_thumbnail() )
		return;
		
	if ( function_exists( 'is_woocommerce' ) ) :
		if ( is_woocommerce() )
			return;
	endif;
		
	$generate_settings = wp_parse_args( 
		get_option( 'generate_blog_settings', array() ), 
		generate_blog_get_defaults() 
	);
	
	$image_atts = generate_get_blog_image_attributes();
	$image_id = get_post_thumbnail_id( get_the_ID(), 'full' );
	$image_url = wp_get_attachment_image_src( $image_id, 'full', true );
	
	if ( !empty( $image_atts ) ) :
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
	endif;
	
	global $post;
	if ( ! is_singular() && ! is_404() ) {
	?>
		<div class="post-image">
			<a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
				<?php if ( $image_atts && function_exists( 'GP_Resize' ) ) : ?>
					<img src="<?php echo GP_Resize( $image_url[0], $image_atts[ 'width' ], $image_atts[ 'height' ], $crop, true, $upscale ); ?>" alt="<?php esc_attr( the_title() ); ?>" itemprop="image" />
				<?php else :
					the_post_thumbnail('full', array( 'itemprop' => 'image' ));
				endif; ?>
			</a>
		</div>
		<?php
	}
}
endif;
<?php
/**
 * Set default options
 */
if ( ! function_exists( 'generate_blog_get_defaults' ) ) :
function generate_blog_get_defaults()
{
	$generate_blog_defaults = array(
		'excerpt_length' => '55',
		'read_more' => __( 'Read more...','generate-blog' ),
		'masonry' => 'false',
		'masonry_width' => 'width2',
		'masonry_most_recent_width' => 'width4',
		'masonry_load_more' => __( '+ More','generate-blog' ),
		'masonry_loading' => __( 'Loading...','generate-blog' ),
		'post_image' => 'true',
		'post_image_position' => '',
		'post_image_alignment' => 'post-image-aligned-center',
		'post_image_width' => '',
		'post_image_height' => '',
		'date' => 'true',
		'author' => 'true',
		'categories' => 'true',
		'tags' => 'true',
		'comments' => 'true',
		'column_layout' => 0,
		'columns' => '50',
		'featured_column' => 0
	);
	
	return apply_filters( 'generate_blog_option_defaults', $generate_blog_defaults );
}
endif;
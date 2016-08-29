<?php
if ( ! function_exists( 'generate_blog_customize_register' ) ) :
add_action( 'customize_register', 'generate_blog_customize_register', 99 );
function generate_blog_customize_register( $wp_customize ) {

	$defaults = generate_blog_get_defaults();
	$dir = plugin_dir_path( __FILE__ );
	require_once $dir . 'controls.php';
	
	if ( class_exists( 'WP_Customize_Panel' ) ) :

		$wp_customize->add_panel( 'generate_blog_panel', array(
			'priority'       => 35,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Blog','generate' ),
			'description'    => ''
		) );
		
		if ( $wp_customize->get_control( 'blog_content_control' ) ) {
			$wp_customize->get_control( 'blog_content_control'  )->section   = 'blog_content_section';
			$wp_customize->get_control( 'blog_content_control'  )->priority   = 1;
		}
	
	endif;
	
	// Blog content
	$wp_customize->add_section(
		// ID
		'blog_content_section',
		// Arguments array
		array(
			'title' => __( 'Blog Content', 'generate-blog' ),
			'capability' => 'edit_theme_options',
			'priority' => 10,
			'panel' => 'generate_blog_panel',
			'active_callback' => 'generate_blog_is_posts_page_single'
		)
	);
	
	$wp_customize->add_setting(
		'generate_blog_settings[excerpt_length]', array(
			'default' => $defaults['excerpt_length'],
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'sanitize_callback' => 'absint'
		)
	);
		 
	$wp_customize->add_control(
		'blog_excerpt_length_control', array(
			'label' => __('Excerpt Length', 'generate-blog'),
			'section' => 'blog_content_section',
			'settings' => 'generate_blog_settings[excerpt_length]',
			'priority' => 10,
			'active_callback' => 'generate_blog_is_excerpt'
		)
	);
	
	$wp_customize->add_setting(
		'generate_blog_settings[read_more]', array(
			'default' => $defaults['read_more'],
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'sanitize_callback' => 'wp_kses_post'
		)
	);
		 
	$wp_customize->add_control(
		'blog_excerpt_more_control', array(
			'label' => __('Read more label', 'generate-blog'),
			'section' => 'blog_content_section',
			'settings' => 'generate_blog_settings[read_more]',
			'priority' => 20
		)
	);
	
	// Masonry
	$wp_customize->add_section(
		// ID
		'blog_masonry_section',
		// Arguments array
		array(
			'title' => __( 'Masonry', 'generate-blog' ),
			'capability' => 'edit_theme_options',
			'priority' => 20,
			'panel' => 'generate_blog_panel',
			'active_callback' => 'generate_blog_is_posts_page'
		)
	);
	
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[masonry]',
		// Arguments array
		array(
			'default' => $defaults['masonry'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[masonry]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Masonry', 'generate-blog' ),
			'section' => 'blog_masonry_section',
			'choices' => array(
				'true' => __( 'Enable', 'generate-blog' ),
				'false' => __( 'Disable', 'generate-blog' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[masonry]',
			'priority' => 30
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[masonry_width]',
		// Arguments array
		array(
			'default' => $defaults['masonry_width'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[masonry_width]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Masonry Block Width', 'generate-blog' ),
			'section' => 'blog_masonry_section',
			'choices' => array(
				'width2' => __( 'Small', 'generate-blog' ),
				'width4' => __( 'Medium', 'generate-blog' ),
				'width6' => __( 'Large', 'generate-blog' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[masonry_width]',
			'priority' => 35
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[masonry_most_recent_width]',
		// Arguments array
		array(
			'default' => $defaults['masonry_most_recent_width'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[masonry_most_recent_width]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Masonry Most Recent Width', 'generate-blog' ),
			'section' => 'blog_masonry_section',
			'choices' => array(
				'width2' => __( 'Small', 'generate-blog' ),
				'width4' => __( 'Medium', 'generate-blog' ),
				'width6' => __( 'Large', 'generate-blog' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[masonry_most_recent_width]',
			'priority' => 36
		)
	);
	
	$wp_customize->add_setting(
		'generate_blog_settings[masonry_load_more]', array(
			'default' => $defaults['masonry_load_more'],
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'sanitize_callback' => 'wp_kses_post'
		)
	);
		 
	$wp_customize->add_control(
		'blog_masonry_load_more_control', array(
			'label' => __('Masonry Load More Text', 'generate-blog'),
			'section' => 'blog_masonry_section',
			'settings' => 'generate_blog_settings[masonry_load_more]',
			'priority' => 40
		)
	);
	
	$wp_customize->add_setting(
		'generate_blog_settings[masonry_loading]', array(
			'default' => $defaults['masonry_loading'],
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'sanitize_callback' => 'wp_kses_post'
		)
	);
		 
	$wp_customize->add_control(
		'blog_masonry_loading_control', array(
			'label' => __('Masonry Loading Text', 'generate-blog'),
			'section' => 'blog_masonry_section',
			'settings' => 'generate_blog_settings[masonry_loading]',
			'priority' => 50
		)
	);
	
	// Post Image
	$wp_customize->add_section(
		// ID
		'blog_post_image_section',
		// Arguments array
		array(
			'title' => __( 'Post Image', 'generate-blog' ),
			'capability' => 'edit_theme_options',
			'priority' => 30,
			'panel' => 'generate_blog_panel',
			'active_callback' => 'generate_blog_is_posts_page'
		)
	);
	
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[post_image]',
		// Arguments array
		array(
			'default' => $defaults['post_image'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[post_image]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Post Image', 'generate-blog' ),
			'section' => 'blog_post_image_section',
			'choices' => array(
				'true' => __( 'Show', 'generate-blog' ),
				'false' => __( 'Hide', 'generate-blog' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[post_image]',
			'priority' => 60
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[post_image_position]',
		// Arguments array
		array(
			'default' => $defaults['post_image_position'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[post_image_position]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Post Image Position', 'generate-blog' ),
			'section' => 'blog_post_image_section',
			'choices' => array(
				'' => __( 'Below Header', 'generate-blog' ),
				'post-image-above-header' => __( 'Above Header', 'generate-blog' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[post_image_position]',
			'priority' => 65
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[post_image_alignment]',
		// Arguments array
		array(
			'default' => $defaults['post_image_alignment'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[post_image_alignment]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Post Image Alignment', 'generate-blog' ),
			'section' => 'blog_post_image_section',
			'choices' => array(
				'post-image-aligned-center' => __( 'Center', 'generate-blog' ),
				'post-image-aligned-left' => __( 'Left', 'generate-blog' ),
				'post-image-aligned-right' => __( 'Right', 'generate-blog' ),
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[post_image_alignment]',
			'priority' => 66
		)
	);
	
	$wp_customize->add_setting(
		'generate_blog_settings[post_image_width]', array(
			'default' => $defaults['post_image_width'],
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'transport' => 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
		 
	$wp_customize->add_control(
		new Generate_Blog_Customize_Control(
			$wp_customize,
			'post_image_width_control', array(
				'label' => __('Post Image Width', 'generate-blog'),
				'section' => 'blog_post_image_section',
				'settings' => 'generate_blog_settings[post_image_width]',
				'priority' => 67,
				'placeholder' => __('Auto','generate-blog')
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_blog_settings[post_image_height]', array(
			'default' => $defaults['post_image_height'],
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'transport' => 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
		 
	$wp_customize->add_control(
		new Generate_Blog_Customize_Control(
			$wp_customize,
			'post_image_height_control', array(
				'label' => __('Post Image Height', 'generate-blog'),
				'section' => 'blog_post_image_section',
				'settings' => 'generate_blog_settings[post_image_height]',
				'priority' => 68,
				'placeholder' => __('Auto','generate-blog')
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Post_Image_Save(
			$wp_customize,
			'post_image_apply_sizes',
			array(
				'section'     => 'blog_post_image_section',
				'label'			=> false,
				'priority'    => 69
			)
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[date]',
		// Arguments array
		array(
			'default' => $defaults['date'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[date]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Date', 'generate-blog' ),
			'section' => 'blog_content_section',
			'choices' => array(
				'true' => __( 'Show', 'generate-blog' ),
				'false' => __( 'Hide', 'generate-blog' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[date]',
			'priority' => 70
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[author]',
		// Arguments array
		array(
			'default' => $defaults['author'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[author]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Author', 'generate-blog' ),
			'section' => 'blog_content_section',
			'choices' => array(
				'true' => __( 'Show', 'generate-blog' ),
				'false' => __( 'Hide', 'generate-blog' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[author]',
			'priority' => 80
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[categories]',
		// Arguments array
		array(
			'default' => $defaults['categories'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[categories]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Categories', 'generate-blog' ),
			'section' => 'blog_content_section',
			'choices' => array(
				'true' => __( 'Show', 'generate-blog' ),
				'false' => __( 'Hide', 'generate-blog' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[categories]',
			'priority' => 90
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[tags]',
		// Arguments array
		array(
			'default' => $defaults['tags'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[tags]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Tags', 'generate-blog' ),
			'section' => 'blog_content_section',
			'choices' => array(
				'true' => __( 'Show', 'generate-blog' ),
				'false' => __( 'Hide', 'generate-blog' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[tags]',
			'priority' => 95
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[comments]',
		// Arguments array
		array(
			'default' => $defaults['comments'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[comments]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Comment Link', 'generate-blog' ),
			'section' => 'blog_content_section',
			'choices' => array(
				'true' => __( 'Show', 'generate-blog' ),
				'false' => __( 'Hide', 'generate-blog' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[comments]',
			'priority' => 100,
			'active_callback' => 'generate_blog_is_posts_page'
		)
	);
	
	// Blog content
	$wp_customize->add_section(
		// ID
		'blog_columns_section',
		// Arguments array
		array(
			'title' => __( 'Columns', 'generate-blog' ),
			'capability' => 'edit_theme_options',
			'priority' => 10,
			'panel' => 'generate_blog_panel',
			'active_callback' => 'generate_blog_is_posts_page'
		)
	);
	
	if ( class_exists( 'Generate_Customize_Misc_Control' ) ) :
	$wp_customize->add_control(
		new Generate_Customize_Misc_Control(
			$wp_customize,
			'columns_masonry_note',
			array(
				'section'     => 'blog_columns_section',
				'type'        => 'text',
				'description' => __( 'Masonry is enabled. These settings will be ignored.','generate-blog' ),
				'priority'    => 0,
				'active_callback' => 'generate_masonry_callback'
			)
		)
	);
	endif;
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[column_layout]',
		// Arguments array
		array(
			'default' => $defaults['column_layout'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[column_layout]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Column Layout', 'generate-blog' ),
			'section' => 'blog_columns_section',
			'choices' => array(
				1 => __( 'Enable', 'generate-blog' ),
				0 => __( 'Disable', 'generate-blog' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[column_layout]',
			'priority' => 20
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[columns]',
		// Arguments array
		array(
			'default' => $defaults['columns'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[columns]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Columns', 'generate-blog' ),
			'section' => 'blog_columns_section',
			'choices' => array(
				'50' => '2',
				'33' => '3',
				'25' => '4',
				'20' => '5'
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[columns]',
			'priority' => 25
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_blog_settings[featured_column]',
		// Arguments array
		array(
			'default' => $defaults['featured_column'],
			'type' => 'option',
			'sanitize_callback' => 'generate_blog_sanitize_choices'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_blog_settings[featured_column]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'First Post Full Width', 'generate-blog' ),
			'section' => 'blog_columns_section',
			'choices' => array(
				1 => __( 'Enable', 'generate-blog' ),
				0 => __( 'Disable', 'generate-blog' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_blog_settings[featured_column]',
			'priority' => 30
		)
	);
}
endif;

if ( ! function_exists( 'generate_masonry_callback' ) ) :
function generate_masonry_callback()
{
	$generate_blog_settings = wp_parse_args( 
		get_option( 'generate_blog_settings', array() ), 
		generate_blog_get_defaults() 
	);
	
	// If masonry is enabled, set to true
	return ( 'true' == $generate_blog_settings['masonry'] ) ? true : false;

}
endif;

if ( ! function_exists( 'generate_blog_sanitize_choices' ) ) :
/**
 * Sanitize choices
 */
function generate_blog_sanitize_choices( $input, $setting ) {
	
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

if ( ! function_exists( 'generate_blog_is_posts_page' ) ) :
function generate_blog_is_posts_page()
{
	$blog = ( is_home() || is_archive() || is_attachment() || is_tax() ) ? true : false;
	
	return $blog;
}
endif;

if ( ! function_exists( 'generate_blog_is_posts_page_single' ) ) :
function generate_blog_is_posts_page_single()
{
	$blog = ( is_home() || is_archive() || is_attachment() || is_tax() || is_single() ) ? true : false;
	
	return $blog;
}
endif;

if ( ! function_exists( 'generate_blog_is_excerpt' ) ) :
function generate_blog_is_excerpt()
{
	$generate_settings = wp_parse_args( 
		get_option( 'generate_settings', array() ), 
		generate_get_defaults() 
	);
	
	return ( 'excerpt' == $generate_settings['post_content'] && generate_blog_is_posts_page() ) ? true : false;
}
endif;

if ( ! function_exists( 'generate_blog_customizer_live_preview' ) ) :
add_action( 'customize_preview_init', 'generate_blog_customizer_live_preview' );
function generate_blog_customizer_live_preview()
{
	wp_enqueue_script( 
		  'generate-blog-themecustomizer',
		  plugin_dir_url( __FILE__ ) . '/js/customizer.js',
		  array( 'jquery','customize-preview' ),
		  GENERATE_BLOG_VERSION,
		  true
	);
}
endif;
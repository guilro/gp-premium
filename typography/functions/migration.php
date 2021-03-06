<?php
if ( ! function_exists( 'generate_typography_convert_values' ) ) :
add_action('admin_init', 'generate_typography_convert_values');
function generate_typography_convert_values()
{
	// If we've already ran this function, bail
	if ( 'true' == get_option( 'generate_update_premium_typography' ) )
		return;
	
	// Get all settings
	$generate_settings = wp_parse_args( 
		get_option( 'generate_settings', array() ), 
		generate_get_default_fonts() 
	);
	
	// Get our font family keys
	$font_settings = array(
		'font_body',
		'font_site_title',
		'font_site_tagline',
		'font_navigation',
		'font_widget_title',
		'font_heading_1',
		'font_heading_2',
		'font_heading_3'
	);
	
	// Create our new empty array
	$new_settings = array();
	
	// For each font family key
	foreach( $font_settings as $key ) {
			
		// Get the value of each key
		$value = $generate_settings[$key];
			
		// If our value has : in it and is not empty
		if ( strpos( $value, ':' ) !== false && ! empty( $value ) ) :
			
			// Remove the : and anything past it
			$value = current( explode( ':', $value ) );
			
			// Populate our new array with our new value
			$new_settings[ $key ] = $value;
			
		endif;
	}
	
	// If our new array isn't empty, update the options
	if ( ! empty( $new_settings ) ) :
		$generate_new_typography_settings = wp_parse_args( $new_settings, $generate_settings );
		update_option( 'generate_settings', $generate_new_typography_settings );
	endif;
	
	// All done, set an option so we don't have to do this again
	update_option( 'generate_update_premium_typography','true' );
}
endif;

if ( ! function_exists( 'generate_typography_convert_secondary_nav_values' ) ) :
/**
 * Take the old secondary navigation font value and strip it of variants
 * This should only run once
 * @since 1.3.0
 */
add_action('admin_init', 'generate_typography_convert_secondary_nav_values');
function generate_typography_convert_secondary_nav_values()
{
	
	// Bail if Secondary Nav isn't active
	if ( ! function_exists( 'generate_secondary_nav_get_defaults' ) )
		return;
	
	// If we've done this before, bail
	if ( 'true' == get_option( 'generate_update_secondary_typography' ) )
		return;
	
	// Get all settings
	$generate_secondary_nav_settings = wp_parse_args( 
		get_option( 'generate_secondary_nav_settings', array() ), 
		generate_secondary_nav_get_defaults() 
	);
	
	// Get our secondary nav font family setting
	$value = $generate_secondary_nav_settings[ 'font_secondary_navigation' ];
	
	// Create a new, empty array
	$new_settings = array();
	
	// If our value has : in it, and isn't empty
	if ( strpos( $value, ':' ) !== false && ! empty( $value ) ) :
		
		// Remove the : and anything past it
		$value = current( explode( ':', $value ) );
		
		// Populate our new array with our new, clean value
		$new_settings[ 'font_secondary_navigation' ] = $value;
		
	endif;
	
	// Update our options if our new array isn't empty
	if ( ! empty( $new_settings ) ) :
		$generate_new_typography_settings = wp_parse_args( $new_settings, $generate_secondary_nav_settings );
		update_option( 'generate_secondary_nav_settings', $generate_new_typography_settings );
	endif;
	
	// All done, set an option so we don't go through this again
	update_option( 'generate_update_secondary_typography','true' );
}
endif;

if ( ! function_exists( 'generate_add_to_font_customizer_list' ) ) :
/**
 * This function makes sure your selected typography option exists in the Customizer list
 * Why wouldn't it? Originally, all 800+ fonts were in each list. This has been reduced to 200.
 * This functions makes sure that if you were using a font that is now not included in the 200, you won't lose it.
 * @since 1.3.40
 */
add_filter( 'generate_typography_customize_list','generate_add_to_font_customizer_list' );
function generate_add_to_font_customizer_list( $fonts )
{
	$generate_settings = wp_parse_args( 
		get_option( 'generate_settings', array() ), 
		generate_get_default_fonts()
	);
	
	$font_settings = array(
		'font_body',
		'font_site_title',
		'font_site_tagline',
		'font_navigation',
		'font_widget_title',
		'font_heading_1',
		'font_heading_2',
		'font_heading_3'
	);
	
	foreach ( $font_settings as $setting ) {
		if ( ! in_array( $generate_settings[ $setting ], generate_typography_default_fonts() ) ) {
			$fonts[ strtolower( str_replace( ' ', '_', $generate_settings[ $setting ] ) ) ] = array( 'name' => $generate_settings[ $setting ] );
		}
	}
	
	if ( function_exists( 'generate_secondary_nav_get_defaults' ) ) :
		$generate_secondary_nav_settings = wp_parse_args( 
			get_option( 'generate_secondary_nav_settings', array() ), 
			generate_secondary_nav_get_defaults() 
		);
		if ( ! in_array( $generate_secondary_nav_settings[ 'font_secondary_navigation' ], generate_typography_default_fonts() ) ) {
			$fonts[ strtolower( str_replace( ' ', '_', $generate_secondary_nav_settings[ 'font_secondary_navigation' ] ) ) ] = array( 'name' => $generate_secondary_nav_settings[ 'font_secondary_navigation' ] );
		}
	endif;
	
	return $fonts;
}
endif;

if ( ! function_exists( 'generate_typography_set_font_data' ) ) :
/**
 * This function will check to see if your category and variants are saved
 * If not, it will set them for you, and won't run again
 * @since 1.2.90
 */
add_action( 'admin_init','generate_typography_set_font_data' );
function generate_typography_set_font_data() 
{
	// Get our defaults
	$defaults = generate_get_default_fonts();
	
	// Get our settings
	$generate_settings = wp_parse_args( 
		get_option( 'generate_settings', array() ), 
		generate_get_default_fonts()
	);
	
	// We need to loop through these settings
	$font_settings = array(
		'font_body',
		'font_site_title',
		'font_site_tagline',
		'font_navigation',
		'font_widget_title',
		'font_heading_1',
		'font_heading_2',
		'font_heading_3'
	);
	
	// Add secondary navigation to the array last if it exists
	if ( function_exists( 'generate_secondary_nav_get_defaults' ) ) {
		$font_settings[ 'font_secondary_navigation' ] = 'font_secondary_navigation';
	}
	
	// Start looping
	foreach( $font_settings as $setting ) {
		
		// Change our variables for the secondary navigation - this will run last
		if ( function_exists( 'generate_secondary_nav_get_defaults' ) && 'font_secondary_navigation' == $setting ) {
			$generate_settings = wp_parse_args( 
				get_option( 'generate_secondary_nav_settings', array() ), 
				generate_secondary_nav_get_defaults() 
			);
			$defaults = generate_secondary_nav_get_defaults();
		}
		
		// We don't need to do this if we're using the default font, as these values have defaults already
		if ( $defaults[ $setting ] == $generate_settings[ $setting ] )
			continue;
	
		// Don't need to continue if we're using a system font or our default font
		if ( in_array( $generate_settings[ $setting ], generate_typography_default_fonts() ) || 'Open Sans' == $generate_settings[ $setting ] )
			continue;
		
		// Don't continue if our category and variants are already set
		if ( get_theme_mod( $setting . '_category' ) && get_theme_mod( $setting . '_variants' ) )
			continue;
		
		// Get all of our fonts
		$fonts = generate_get_all_google_fonts();
	
		// Get the ID from our font
		$id = strtolower( str_replace( ' ', '_', $generate_settings[ $setting ] ) );
		
		// If the ID doesn't exist within our fonts, we can bail
		if ( ! array_key_exists( $id, $fonts ) )
			continue;
		
		// Let's grab our category to go with our font
		$category = ! empty( $fonts[$id]['category'] ) ? $fonts[$id]['category'] : '';
		
		// Grab all of the variants associated with our font
		$variants = $fonts[$id]['variants'];
		
		// Loop through our variants and put them into an array, then turn them into a comma separated list
		$output = array();
		if ( $variants ) :
			foreach ( $variants as $variant ) {
				$output[] = $variant;
			}
			$variants = implode(',', $output);
		endif;
		
		// Set our theme mods with our new settings
		if ( '' !== $category ) set_theme_mod( $setting . '_category', $category );
		if ( '' !== $variants ) set_theme_mod( $setting . '_variants', $variants );
	}
}
endif;
<?php
if ( ! function_exists( 'generate_copyright_customize_register' ) ) :
add_action( 'customize_register', 'generate_copyright_customize_register' );
function generate_copyright_customize_register( $wp_customize ) {
	require_once trailingslashit( dirname( __FILE__ ) ) . '/control.php';
	
	$wp_customize->add_section( 'generate_copyright' , array(
		'title' => __( 'Copyright', 'generate-copyright' ),
		'priority' => 60
	) );
	
	// Front page featured area editor
	$wp_customize->add_setting(
		// ID
		'generate_copyright',
		// Arguments array
		array(
			'default' => '',
			'type' => 'theme_mod',
			'sanitize_callback' => 'wp_kses_post',
			'transport' => 'postMessage'
		)
	);

	$wp_customize->add_control( 
		new Generate_Copyright_Textarea_Custom_Control( 
		$wp_customize, 
		'generate_copyright', 
		array(
			'label'      => '',
			'section'    => 'generate_copyright',
			'settings'   => 'generate_copyright'
		) ) 
	);
	
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'generate_copyright', array(
			'selector' => '.inside-site-info',
			'settings' => array( 'generate_copyright' ),
			'render_callback' => 'generate_copyright_selective_refresh',
		) );
	}
}
endif;

if ( ! function_exists( 'generate_copyright_selective_refresh' ) ) :
function generate_copyright_selective_refresh()
{
	$options = array(
		'%current_year%',
		'%copy%'
	);
	$replace = array(
		date('Y'),
		'&copy;'
	);
		
	$new_copyright = get_theme_mod( 'generate_copyright' );
	$new_copyright = str_replace( $options, $replace, get_theme_mod( 'generate_copyright' ) );
	
	return $new_copyright;
}
endif;

/**
 * Remove the default copyright
 * @since 0.1
 */
if ( ! function_exists( 'generate_copyright_remove_default' ) ) :
add_action('after_setup_theme','generate_copyright_remove_default');
function generate_copyright_remove_default()
{
	if ( get_theme_mod( 'generate_copyright' ) && '' !== get_theme_mod( 'generate_copyright' ) ) :
		remove_action( 'generate_credits', 'generate_add_footer_info' );
		remove_action( 'generate_copyright_line','generate_add_login_attribution' );
	endif;
}
endif;

/**
 * Add the custom copyright
 * @since 0.1
 */
if ( ! function_exists( 'generate_copyright_add_custom' ) ) :
add_action('generate_credits','generate_copyright_add_custom');
function generate_copyright_add_custom()
{
	
	$options = array(
		'%current_year%',
		'%copy%'
	);
	$replace = array(
		date('Y'),
		'&copy;'
	);
		
	$new_copyright = get_theme_mod( 'generate_copyright' );
	$new_copyright = str_replace( $options, $replace, get_theme_mod( 'generate_copyright' ) );
		
	if ( get_theme_mod( 'generate_copyright' ) && '' !== get_theme_mod( 'generate_copyright' ) ) :
		echo do_shortcode( $new_copyright );
	endif;

}
endif;

add_action( 'customize_preview_init', 'generate_copyright_customizer_live_preview' );
function generate_copyright_customizer_live_preview()
{
	wp_enqueue_script( 
		  'generate-copyright-customizer',
		  plugin_dir_url( __FILE__ ) . 'js/customizer.js',
		  array( 'jquery','customize-preview' ),
		  GENERATE_COPYRIGHT_VERSION,
		  true
	);
}

if ( ! function_exists( 'generate_update_copyright' ) ) :
add_action( 'after_setup_theme', 'generate_update_copyright' );
function generate_update_copyright() 
{
	// If we already have a custom logo, bail.
	if ( get_theme_mod( 'generate_copyright' ) )
		return;
	
	// Get the old logo value.
	$old_value = get_option( 'gen_custom_copyright' );
	
	// If there's no old value, bail.
	if ( empty( $old_value ) )
		return;
	
	// Now let's update the new logo setting with our ID.
	set_theme_mod( 'generate_copyright', $old_value );
	
	// Got our custom logo? Time to delete the old value
	if ( get_theme_mod( 'generate_copyright' ) ) :
		delete_option( 'gen_custom_copyright' );
	endif;
}
endif;
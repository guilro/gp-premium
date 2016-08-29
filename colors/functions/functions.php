<?php
/**
 * Set default options
 */
if ( !function_exists( 'generate_get_color_defaults' ) ) :
	function generate_get_color_defaults()
	{
		$generate_color_defaults = array(
			'header_background_color' => '#FFFFFF',
			'header_text_color' => '#3a3a3a',
			'header_link_color' => '#3a3a3a',
			'header_link_hover_color' => '',
			'site_title_color' => '#222222',
			'site_tagline_color' => '#999999',
			'navigation_background_color' => '#222222',
			'navigation_text_color' => '#FFFFFF',
			'navigation_background_hover_color' => '#3f3f3f',
			'navigation_text_hover_color' => '#FFFFFF',
			'navigation_background_current_color' => '#3f3f3f',
			'navigation_text_current_color' => '#FFFFFF',
			'subnavigation_background_color' => '#3f3f3f',
			'subnavigation_text_color' => '#FFFFFF',
			'subnavigation_background_hover_color' => '#4f4f4f',
			'subnavigation_text_hover_color' => '#FFFFFF',
			'subnavigation_background_current_color' => '#4f4f4f',
			'subnavigation_text_current_color' => '#FFFFFF',
			'content_background_color' => '#FFFFFF',
			'content_text_color' => '#3a3a3a',
			'content_link_color' => '',
			'content_link_hover_color' => '',
			'content_title_color' => '',
			'blog_post_title_color' => '',
			'blog_post_title_hover_color' => '',
			'entry_meta_text_color' => '#888888',
			'entry_meta_link_color' => '#666666',
			'entry_meta_link_color_hover' => '#1E73BE',
			'h1_color' => '',
			'h2_color' => '',
			'h3_color' => '',
			'sidebar_widget_background_color' => '#FFFFFF',
			'sidebar_widget_text_color' => '#3a3a3a',
			'sidebar_widget_link_color' => '',
			'sidebar_widget_link_hover_color' => '',
			'sidebar_widget_title_color' => '#000000',
			'footer_widget_background_color' => '#FFFFFF',
			'footer_widget_text_color' => '#3a3a3a',
			'footer_widget_link_color' => '#1e73be',
			'footer_widget_link_hover_color' => '#000000',
			'footer_widget_title_color' => '#000000',
			'footer_background_color' => '#222222',
			'footer_text_color' => '#ffffff',
			'footer_link_color' => '#ffffff',
			'footer_link_hover_color' => '#606060',
			'form_background_color' => '#FAFAFA',
			'form_text_color' => '#666666',
			'form_background_color_focus' => '#FFFFFF',
			'form_text_color_focus' => '#666666',
			'form_border_color' => '#CCCCCC',
			'form_border_color_focus' => '#BFBFBF',
			'form_button_background_color' => '#666666',
			'form_button_background_color_hover' => '#3F3F3F',
			'form_button_text_color' => '#FFFFFF',
			'form_button_text_color_hover' => '#FFFFFF'
		);
		
		return apply_filters( 'generate_color_option_defaults', $generate_color_defaults );
	}
endif;

if ( ! function_exists( 'generate_colors_customize_register' ) ) :
add_action( 'customize_register', 'generate_colors_customize_register' );
function generate_colors_customize_register( $wp_customize ) {
		
	$defaults = generate_get_color_defaults();
	
	if ( class_exists( 'WP_Customize_Panel' ) ) :
	
		$wp_customize->add_panel( 'generate_colors_panel', array(
			'priority'       => 30,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Colors','generate-colors' ),
			'description'    => '',
		) );
	
	endif;
	
	// Add Header Colors section
	$wp_customize->add_section(
		// ID
		'header_color_section',
		// Arguments array
		array(
			'title' => __( 'Header', 'generate-colors' ),
			'capability' => 'edit_theme_options',
			'priority' => 50,
			'panel' => 'generate_colors_panel'
		)
	);

	// Add color settings
	$header_colors = array();
	$header_colors[] = array(
		'slug' => 'header_background_color', 
		'default' => $defaults['header_background_color'],
		'label' => __('Background', 'generate-colors'),
		'priority' => 1
	);
	$header_colors[] = array(
		'slug' => 'header_text_color', 
		'default' => $defaults['header_text_color'],
		'label' => __('Text', 'generate-colors'),
		'priority' => 2
	);
	$header_colors[] = array(
		'slug' => 'header_link_color', 
		'default' => $defaults['header_link_color'],
		'label' => __('Link', 'generate-colors'),
		'priority' => 3
	);
	$header_colors[] = array(
		'slug' => 'header_link_hover_color', 
		'default' => $defaults['header_link_hover_color'],
		'label' => __('Link Hover', 'generate-colors'),
		'priority' => 4
	);
	$header_colors[] = array(
		'slug' => 'site_title_color', 
		'default' => $defaults['site_title_color'],
		'label' => __('Site Title', 'generate-colors'),
		'priority' => 5
	);
	$header_colors[] = array(
		'slug' => 'site_tagline_color', 
		'default' => $defaults['site_tagline_color'],
		'label' => __('Tagline', 'generate-colors'),
		'priority' => 6
	);
	
	foreach( $header_colors as $color ) {
		// SETTINGS
		$wp_customize->add_setting(
			'generate_settings[' . $color['slug'] . ']', array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'generate_colors_sanitize_hex_color'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'], 
				array(
					'label' => $color['label'], 
					'section' => 'header_color_section',
					'settings' => 'generate_settings[' . $color['slug'] . ']',
					'priority' => $color['priority']
				)
			)
		);
	}
	
	// Add Navigation section
	$wp_customize->add_section(
		// ID
		'navigation_color_section',
		// Arguments array
		array(
			'title' => __( 'Primary Navigation', 'generate-colors' ),
			'capability' => 'edit_theme_options',
			'priority' => 60,
			'panel' => 'generate_colors_panel'
		)
	);

	// Add color settings
	$navigation_colors = array();
	$navigation_colors[] = array(
		'slug'=>'navigation_background_color', 
		'default' => $defaults['navigation_background_color'],
		'label' => __('Background', 'generate-colors'),
		'priority' => 1
	);
	$navigation_colors[] = array(
		'slug'=>'navigation_text_color', 
		'default' => $defaults['navigation_text_color'],
		'label' => __('Text', 'generate-colors'),
		'priority' => 2
	);
	$navigation_colors[] = array(
		'slug'=>'navigation_background_hover_color', 
		'default' => $defaults['navigation_background_hover_color'],
		'label' => __('Background Hover', 'generate-colors'),
		'priority' => 3
	);
	$navigation_colors[] = array(
		'slug'=>'navigation_text_hover_color', 
		'default' => $defaults['navigation_text_hover_color'],
		'label' => __('Text Hover', 'generate-colors'),
		'priority' => 4
	);
	$navigation_colors[] = array(
		'slug'=>'navigation_background_current_color', 
		'default' => $defaults['navigation_background_current_color'],
		'label' => __('Background Current', 'generate-colors'),
		'priority' => 5
	);
	$navigation_colors[] = array(
		'slug'=>'navigation_text_current_color', 
		'default' => $defaults['navigation_text_current_color'],
		'label' => __('Text Current', 'generate-colors'),
		'priority' => 6
	);
	
	foreach( $navigation_colors as $color ) {
		// SETTINGS
		$wp_customize->add_setting(
			'generate_settings[' . $color['slug'] . ']', array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'generate_colors_sanitize_hex_color'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'], 
				array(
					'label' => $color['label'], 
					'section' => 'navigation_color_section',
					'settings' => 'generate_settings[' . $color['slug'] . ']',
					'priority' => $color['priority']
				)
			)
		);
	}
	
	// Add Sub-Navigation section
	$wp_customize->add_section(
		// ID
		'subnavigation_color_section',
		// Arguments array
		array(
			'title' => __( 'Primary Sub-Navigation', 'generate-colors' ),
			'capability' => 'edit_theme_options',
			'priority' => 70,
			'panel' => 'generate_colors_panel'
		)
	);

	// Add color settings
	$subnavigation_colors = array();
	$subnavigation_colors[] = array(
		'slug'=>'subnavigation_background_color', 
		'default' => $defaults['subnavigation_background_color'],
		'label' => __('Background', 'generate-colors'),
		'priority' => 1
	);
	$subnavigation_colors[] = array(
		'slug'=>'subnavigation_text_color', 
		'default' => $defaults['subnavigation_text_color'],
		'label' => __('Text', 'generate-colors'),
		'priority' => 2
	);
	$subnavigation_colors[] = array(
		'slug'=>'subnavigation_background_hover_color', 
		'default' => $defaults['subnavigation_background_hover_color'],
		'label' => __('Background Hover', 'generate-colors'),
		'priority' => 3
	);
	$subnavigation_colors[] = array(
		'slug'=>'subnavigation_text_hover_color', 
		'default' => $defaults['subnavigation_text_hover_color'],
		'label' => __('Text Hover', 'generate-colors'),
		'priority' => 4
	);
	$subnavigation_colors[] = array(
		'slug'=>'subnavigation_background_current_color', 
		'default' => $defaults['subnavigation_background_current_color'],
		'label' => __('Background Current', 'generate-colors'),
		'priority' => 5
	);
	$subnavigation_colors[] = array(
		'slug'=>'subnavigation_text_current_color', 
		'default' => $defaults['subnavigation_text_current_color'],
		'label' => __('Text Current', 'generate-colors'),
		'priority' => 6
	);
	foreach( $subnavigation_colors as $color ) {
		// SETTINGS
		$wp_customize->add_setting(
			'generate_settings[' . $color['slug'] . ']', array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'generate_colors_sanitize_hex_color'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'], 
				array(
					'label' => $color['label'], 
					'section' => 'subnavigation_color_section',
					'settings' => 'generate_settings[' . $color['slug'] . ']',
					'priority' => $color['priority']
				)
			)
		);
	}
	
	// Add Content Colors section
	$wp_customize->add_section(
		// ID
		'content_color_section',
		// Arguments array
		array(
			'title' => __( 'Content', 'generate-colors' ),
			'capability' => 'edit_theme_options',
			'priority' => 80,
			'panel' => 'generate_colors_panel'
		)
	);

	// Add color settings
	$content_colors = array();
	$content_colors[] = array(
		'slug' => 'content_background_color', 
		'default' => $defaults['content_background_color'],
		'label' => __('Background', 'generate-colors'),
		'priority' => 1
	);
	$content_colors[] = array(
		'slug' => 'content_text_color', 
		'default' => $defaults['content_text_color'],
		'label' => __('Text', 'generate-colors'),
		'priority' => 2
	);
	$content_colors[] = array(
		'slug' => 'content_link_color', 
		'default' => $defaults['content_link_color'],
		'label' => __('Link', 'generate-colors'),
		'priority' => 3
	);
	$content_colors[] = array(
		'slug' => 'content_link_hover_color', 
		'default' => $defaults['content_link_hover_color'],
		'label' => __('Link Hover', 'generate-colors'),
		'priority' => 4
	);
	$content_colors[] = array(
		'slug' => 'content_title_color', 
		'default' => $defaults['content_title_color'],
		'label' => __('Content Title', 'generate-colors'),
		'priority' => 5
	);
	$content_colors[] = array(
		'slug' => 'blog_post_title_color', 
		'default' => $defaults['blog_post_title_color'],
		'label' => __('Blog Post Title', 'generate-colors'),
		'priority' => 6
	);
	$content_colors[] = array(
		'slug' => 'blog_post_title_hover_color', 
		'default' => $defaults['blog_post_title_hover_color'],
		'label' => __('Blog Post Title Hover', 'generate-colors'),
		'priority' => 7
	);
	$content_colors[] = array(
		'slug' => 'entry_meta_text_color', 
		'default' => $defaults['entry_meta_text_color'],
		'label' => __('Entry Meta Text', 'generate-colors'),
		'priority' => 8
	);
	$content_colors[] = array(
		'slug' => 'entry_meta_link_color', 
		'default' => $defaults['entry_meta_link_color'],
		'label' => __('Entry Meta Links', 'generate-colors'),
		'priority' => 9
	);
	$content_colors[] = array(
		'slug' => 'entry_meta_link_color_hover', 
		'default' => $defaults['entry_meta_link_color_hover'],
		'label' => __('Entry Meta Links Hover', 'generate-colors'),
		'priority' => 10
	);
	$content_colors[] = array(
		'slug' => 'h1_color', 
		'default' => $defaults['h1_color'],
		'label' => __('Heading 1 (H1) Color', 'generate-colors'),
		'priority' => 11
	);
	$content_colors[] = array(
		'slug' => 'h2_color', 
		'default' => $defaults['h2_color'],
		'label' => __('Heading 2 (H2) Color', 'generate-colors'),
		'priority' => 12
	);
	$content_colors[] = array(
		'slug' => 'h3_color', 
		'default' => $defaults['h3_color'],
		'label' => __('Heading 3 (H3) Color', 'generate-colors'),
		'priority' => 13
	);
	
	foreach( $content_colors as $color ) {
		// SETTINGS
		$wp_customize->add_setting(
			'generate_settings[' . $color['slug'] . ']', array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'generate_colors_sanitize_hex_color'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'], 
				array(
					'label' => $color['label'], 
					'section' => 'content_color_section',
					'settings' => 'generate_settings[' . $color['slug'] . ']',
					'priority' => $color['priority']
				)
			)
		);
	}
	
	// Add Sidebar Widget colors
	$wp_customize->add_section(
		// ID
		'sidebar_widget_color_section',
		// Arguments array
		array(
			'title' => __( 'Sidebar Widgets', 'generate-colors' ),
			'capability' => 'edit_theme_options',
			'priority' => 90,
			'panel' => 'generate_colors_panel'
		)
	);

	// Add color settings
	$sidebar_widget_colors = array();
	$sidebar_widget_colors[] = array(
		'slug' => 'sidebar_widget_background_color', 
		'default' => $defaults['sidebar_widget_background_color'],
		'label' => __('Background', 'generate-colors'),
		'priority' => 1
	);
	$sidebar_widget_colors[] = array(
		'slug' => 'sidebar_widget_text_color', 
		'default' => $defaults['sidebar_widget_text_color'],
		'label' => __('Text', 'generate-colors'),
		'priority' => 2
	);
	$sidebar_widget_colors[] = array(
		'slug' => 'sidebar_widget_link_color', 
		'default' => $defaults['sidebar_widget_link_color'],
		'label' => __('Link', 'generate-colors'),
		'priority' => 3
	);
	$sidebar_widget_colors[] = array(
		'slug' => 'sidebar_widget_link_hover_color', 
		'default' => $defaults['sidebar_widget_link_hover_color'],
		'label' => __('Link Hover', 'generate-colors'),
		'priority' => 4
	);
	$sidebar_widget_colors[] = array(
		'slug' => 'sidebar_widget_title_color', 
		'default' => $defaults['sidebar_widget_title_color'],
		'label' => __('Widget Title', 'generate-colors'),
		'priority' => 5
	);
	
	foreach( $sidebar_widget_colors as $color ) {
		// SETTINGS
		$wp_customize->add_setting(
			'generate_settings[' . $color['slug'] . ']', array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'generate_colors_sanitize_hex_color'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'], 
				array(
					'label' => $color['label'], 
					'section' => 'sidebar_widget_color_section',
					'settings' => 'generate_settings[' . $color['slug'] . ']',
					'priority' => $color['priority']
				)
			)
		);
	}
	
	// Add Footer widget colors
	$wp_customize->add_section(
		// ID
		'footer_widget_color_section',
		// Arguments array
		array(
			'title' => __( 'Footer Widgets', 'generate-colors' ),
			'capability' => 'edit_theme_options',
			'priority' => 100,
			'panel' => 'generate_colors_panel'
		)
	);

	// Add color settings
	$footer_widget_colors = array();
	$footer_widget_colors[] = array(
		'slug' => 'footer_widget_background_color', 
		'default' => $defaults['footer_widget_background_color'],
		'label' => __('Background', 'generate-colors'),
		'priority' => 1
	);
	$footer_widget_colors[] = array(
		'slug' => 'footer_widget_text_color', 
		'default' => $defaults['footer_widget_text_color'],
		'label' => __('Text', 'generate-colors'),
		'priority' => 2
	);
	$footer_widget_colors[] = array(
		'slug' => 'footer_widget_link_color', 
		'default' => $defaults['footer_widget_link_color'],
		'label' => __('Link', 'generate-colors'),
		'priority' => 3
	);
	$footer_widget_colors[] = array(
		'slug' => 'footer_widget_link_hover_color', 
		'default' => $defaults['footer_widget_link_hover_color'],
		'label' => __('Link Hover', 'generate-colors'),
		'priority' => 4
	);
	$footer_widget_colors[] = array(
		'slug' => 'footer_widget_title_color', 
		'default' => $defaults['footer_widget_title_color'],
		'label' => __('Widget Title', 'generate-colors'),
		'priority' => 5
	);
	
	foreach( $footer_widget_colors as $color ) {
		// SETTINGS
		$wp_customize->add_setting(
			'generate_settings[' . $color['slug'] . ']', array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'generate_colors_sanitize_hex_color'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'], 
				array(
					'label' => $color['label'], 
					'section' => 'footer_widget_color_section',
					'settings' => 'generate_settings[' . $color['slug'] . ']',
					'priority' => $color['priority']
				)
			)
		);
	}
	
	// Add Form colors
	$wp_customize->add_section(
		// ID
		'form_color_section',
		// Arguments array
		array(
			'title' => __( 'Forms', 'generate-colors' ),
			'capability' => 'edit_theme_options',
			'priority' => 130,
			'panel' => 'generate_colors_panel'
		)
	);

	// Add color settings
	$form_colors = array();
	$form_colors[] = array(
		'slug' => 'form_background_color', 
		'default' => $defaults['form_background_color'],
		'label' => __('Form Background', 'generate-colors'),
		'priority' => 1
	);
	$form_colors[] = array(
		'slug' => 'form_text_color', 
		'default' => $defaults['form_text_color'],
		'label' => __('Form Text', 'generate-colors'),
		'priority' => 2
	);
	$form_colors[] = array(
		'slug' => 'form_background_color_focus', 
		'default' => $defaults['form_background_color_focus'],
		'label' => __('Form Background Focus/Hover', 'generate-colors'),
		'priority' => 3
	);
	$form_colors[] = array(
		'slug' => 'form_text_color_focus', 
		'default' => $defaults['form_text_color_focus'],
		'label' => __('Form Text Focus/Hover', 'generate-colors'),
		'priority' => 4
	);
	$form_colors[] = array(
		'slug' => 'form_border_color', 
		'default' => $defaults['form_border_color'],
		'label' => __('Form Border', 'generate-colors'),
		'priority' => 5
	);
	$form_colors[] = array(
		'slug' => 'form_border_color_focus', 
		'default' => $defaults['form_border_color_focus'],
		'label' => __('Form Border Focus/Hover', 'generate-colors'),
		'priority' => 6
	);
	$form_colors[] = array(
		'slug' => 'form_button_background_color', 
		'default' => $defaults['form_button_background_color'],
		'label' => __('Form Button', 'generate-colors'),
		'priority' => 7
	);
	$form_colors[] = array(
		'slug' => 'form_button_background_color_hover', 
		'default' => $defaults['form_button_background_color_hover'],
		'label' => __('Form Button Focus/Hover', 'generate-colors'),
		'priority' => 8
	);
	$form_colors[] = array(
		'slug' => 'form_button_text_color', 
		'default' => $defaults['form_button_text_color'],
		'label' => __('Form Button Text', 'generate-colors'),
		'priority' => 9
	);
	$form_colors[] = array(
		'slug' => 'form_button_text_color_hover', 
		'default' => $defaults['form_button_text_color_hover'],
		'label' => __('Form Button Text Focus/Hover', 'generate-colors'),
		'priority' => 10
	);
	
	foreach( $form_colors as $color ) {
		// SETTINGS
		$wp_customize->add_setting(
			'generate_settings[' . $color['slug'] . ']', array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'generate_colors_sanitize_hex_color'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'], 
				array(
					'label' => $color['label'], 
					'section' => 'form_color_section',
					'settings' => 'generate_settings[' . $color['slug'] . ']',
					'priority' => $color['priority']
				)
			)
		);
	}
	
	// Add Footer colors
	$wp_customize->add_section(
		// ID
		'footer_color_section',
		// Arguments array
		array(
			'title' => __( 'Footer', 'generate-colors' ),
			'capability' => 'edit_theme_options',
			'priority' => 150,
			'panel' => 'generate_colors_panel'
		)
	);

	// Add color settings
	$footer_colors = array();
	$footer_colors[] = array(
		'slug' => 'footer_background_color', 
		'default' => $defaults['footer_background_color'],
		'label' => __('Background', 'generate-colors'),
		'priority' => 1
	);
	$footer_colors[] = array(
		'slug' => 'footer_text_color', 
		'default' => $defaults['footer_text_color'],
		'label' => __('Text', 'generate-colors'),
		'priority' => 2
	);
	$footer_colors[] = array(
		'slug' => 'footer_link_color', 
		'default' => $defaults['footer_link_color'],
		'label' => __('Link', 'generate-colors'),
		'priority' => 3
	);
	$footer_colors[] = array(
		'slug' => 'footer_link_hover_color', 
		'default' => $defaults['footer_link_hover_color'],
		'label' => __('Link Hover', 'generate-colors'),
		'priority' => 4
	);
	
	foreach( $footer_colors as $color ) {
		// SETTINGS
		$wp_customize->add_setting(
			'generate_settings[' . $color['slug'] . ']', array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'generate_colors_sanitize_hex_color'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'], 
				array(
					'label' => $color['label'], 
					'section' => 'footer_color_section',
					'settings' => 'generate_settings[' . $color['slug'] . ']',
					'priority' => $color['priority']
				)
			)
		);
	}
}
endif;

if ( ! function_exists( 'generate_customize_default_swatch_colors' ) ) :
add_action( 'customize_controls_print_footer_scripts', 'generate_customize_default_swatch_colors' );
function generate_customize_default_swatch_colors()
{
	?>
	<script>

    jQuery(document).ready(function($){

      $.wp.wpColorPicker.prototype.options = {

        palettes: ['#000', '#FFF', '#1E72BD', '#847f67', '#222', '#7d9666', '#de3', '#f0f']

      };         
    });   

  </script>
	<?php
}
endif;

/**
 * Generate the CSS in the <head> section using the Theme Customizer
 * @since 0.1
 */
if ( !function_exists( 'generate_advanced_css' ) ) :
	function generate_advanced_css()
	{
		
		$generate_settings = wp_parse_args( 
			get_option( 'generate_settings', array() ), 
			generate_get_color_defaults() 
		);
		$space = ' ';

		// Start the magic
		$visual_css = array (
		
			// Header
			'.site-header' => array(
				'background-color' => $generate_settings['header_background_color'],
				'color' => $generate_settings['header_text_color']
			),
			
			// Header link
			'.site-header a' => array(
				'color' => $generate_settings['header_link_color']
			),
			
			// Header link hover
			'.site-header a:hover' => array(
				'color' => $generate_settings['header_link_hover_color']
			),
			
			// Site title color
			'.main-title a,
			.main-title a:hover,
			.main-title a:visited' => array(
				'color' => $generate_settings['site_title_color']
			),
			
			// Site description
			'.site-description' => array(
				'color' => $generate_settings['site_tagline_color']
			),
			
			// Navigation background
			'.main-navigation,  
			.main-navigation ul ul' => array(
				'background-color' => $generate_settings['navigation_background_color']
			),
			
			// Navigation search input
			'.navigation-search input[type="search"],
			.navigation-search input[type="search"]:active' => array(
				'color' => $generate_settings['navigation_text_hover_color'],
				'background-color' => $generate_settings['navigation_background_hover_color']
			),
			
			// Navigation search input on focus
			'.navigation-search input[type="search"]:focus' => array(
				'color' => $generate_settings['navigation_text_hover_color'],
				'background-color' => $generate_settings['navigation_background_hover_color']
			),
			
			// Sub-Navigation background
			'.main-navigation ul ul' => array(
				'background-color' => $generate_settings['subnavigation_background_color']
			),
			
			// Navigation text
			'.main-navigation .main-nav ul li a,
			.menu-toggle' => array(
				'color' => $generate_settings['navigation_text_color']
			),
			
			// Mobile menu text on hover
			'button.menu-toggle:hover,
			button.menu-toggle:focus,
			.main-navigation .mobile-bar-items a,
			.main-navigation .mobile-bar-items a:hover,
			.main-navigation .mobile-bar-items a:focus' => array(
				'color' => $generate_settings['navigation_text_color']
			),
			
			// Sub-Navigation text
			'.main-navigation .main-nav ul ul li a' => array(
				'color' => $generate_settings['subnavigation_text_color']
			),
			
			// Navigation background/text on hover
			'.main-navigation .main-nav ul li > a:hover,
			.main-navigation .main-nav ul li > a:focus,
			.main-navigation .main-nav ul li.sfHover > a' => array(
				'color' => $generate_settings['navigation_text_hover_color'],
				'background-color' => $generate_settings['navigation_background_hover_color']
			),
			
			// Sub-Navigation background/text on hover
			'.main-navigation .main-nav ul ul li > a:hover,
			.main-navigation .main-nav ul ul li > a:focus,
			.main-navigation .main-nav ul ul li.sfHover > a' => array(
				'color' => $generate_settings['subnavigation_text_hover_color'],
				'background-color' => $generate_settings['subnavigation_background_hover_color']
			),
			
			// Navigation background / text current
			'.main-navigation .main-nav ul .current-menu-item > a, 
			.main-navigation .main-nav ul .current-menu-parent > a, 
			.main-navigation .main-nav ul .current-menu-ancestor > a' => array(
				'color' => $generate_settings['navigation_text_current_color'],
				'background-color' => $generate_settings['navigation_background_current_color']
			),
			
			// Navigation background text current text hover
			'.main-navigation .main-nav ul .current-menu-item > a:hover, 
			.main-navigation .main-nav ul .current-menu-parent > a:hover, 
			.main-navigation .main-nav ul .current-menu-ancestor > a:hover, 
			.main-navigation .main-nav ul .current-menu-item.sfHover > a, 
			.main-navigation .main-nav ul .current-menu-parent.sfHover > a, 
			.main-navigation .main-nav ul .current-menu-ancestor.sfHover > a' => array(
				'color' => $generate_settings['navigation_text_current_color'],
				'background-color' => $generate_settings['navigation_background_current_color']
			),
			
			// Sub-Navigation background / text current
			'.main-navigation .main-nav ul ul .current-menu-item > a, 
			.main-navigation .main-nav ul ul .current-menu-parent > a, 
			.main-navigation .main-nav ul ul .current-menu-ancestor > a' => array(
				'color' => $generate_settings['subnavigation_text_current_color'],
				'background-color' => $generate_settings['subnavigation_background_current_color']
			),
			
			// Sub-Navigation current background / text current
			'.main-navigation .main-nav ul ul .current-menu-item > a:hover, 
			.main-navigation .main-nav ul ul .current-menu-parent > a:hover, 
			.main-navigation .main-nav ul ul .current-menu-ancestor > a:hover,
			.main-navigation .main-nav ul ul .current-menu-item.sfHover > a, 
			.main-navigation .main-nav ul ul .current-menu-parent.sfHover > a, 
			.main-navigation .main-nav ul ul .current-menu-ancestor.sfHover > a' => array(
				'color' => $generate_settings['subnavigation_text_current_color'],
				'background-color' => $generate_settings['subnavigation_background_current_color']
			),
			
			// Content
			'.separate-containers .inside-article, 
			.separate-containers .comments-area, 
			.separate-containers .page-header,
			.one-container .container,
			.separate-containers .paging-navigation,
			.inside-page-header' => array(
				'background-color' => $generate_settings['content_background_color'],
				'color' => $generate_settings['content_text_color']
			),
			
			// Content links
			'.inside-article a, 
			.inside-article a:visited,
			.paging-navigation a,
			.paging-navigation a:visited,
			.comments-area a,
			.comments-area a:visited,
			.page-header a,
			.page-header a:visited' => array(
				'color' => $generate_settings['content_link_color']
			),
			
			// Content link hover
			'.inside-article a:hover,
			.paging-navigation a:hover,
			.comments-area a:hover,
			.page-header a:hover' => array(
				'color' => $generate_settings['content_link_hover_color']
			),
			
			// Entry header
			'.entry-header h1,
			.page-header h1' => array(
				'color' => $generate_settings['content_title_color']
			),
			
			// Blog post title
			'.entry-title a,
			.entry-title a:visited' => array(
				'color' => $generate_settings['blog_post_title_color']
			),
			
			// Blog post title hover
			'.entry-title a:hover' => array(
				'color' => $generate_settings['blog_post_title_hover_color']
			),
			
			// Entry meta text
			'.entry-meta' => array(
				'color' => $generate_settings['entry_meta_text_color']
			),
			
			// Entry meta links
			'.entry-meta a, 
			.entry-meta a:visited' => array(
				'color' => $generate_settings['entry_meta_link_color']
			),
			
			// Entry meta links hover
			'.entry-meta a:hover' => array(
				'color' => $generate_settings['entry_meta_link_color_hover']
			),
			
			// Heading 1 (H1) color
			'h1' => array(
				'color' => $generate_settings['h1_color']
			),
			
			// Heading 2 (H2) color
			'h2' => array(
				'color' => $generate_settings['h2_color']
			),
			
			// Heading 3 (H3) color
			'h3' => array(
				'color' => $generate_settings['h3_color']
			),
			
			// Sidebar widget
			'.sidebar .widget' => array(
				'background-color' => $generate_settings['sidebar_widget_background_color'],
				'color' => $generate_settings['sidebar_widget_text_color']
			),
			
			// Sidebar widget links
			'.sidebar .widget a, 
			.sidebar .widget a:visited' => array(
				'color' => $generate_settings['sidebar_widget_link_color']
			),
			
			// Sidebar widget link hover
			'.sidebar .widget a:hover' => array(
				'color' => $generate_settings['sidebar_widget_link_hover_color']
			),
			
			// Sidebar widget title
			'.sidebar .widget .widget-title' => array(
				'color' => $generate_settings['sidebar_widget_title_color']
			),
			
			// Footer widget
			'.footer-widgets' => array(
				'background-color' => $generate_settings['footer_widget_background_color'],
				'color' => $generate_settings['footer_widget_text_color']
			),
			
			// Footer widget links
			'.footer-widgets a, 
			.footer-widgets a:visited' => array(
				'color' => $generate_settings['footer_widget_link_color']
			),
			
			// Footer widget link hover
			'.footer-widgets a:hover' => array(
				'color' => $generate_settings['footer_widget_link_hover_color']
			),
			
			// Sidebar widget title
			'.footer-widgets .widget-title' => array(
				'color' => $generate_settings['footer_widget_title_color']
			),
			
			// Footer
			'.site-info' => array(
				'background-color' => $generate_settings['footer_background_color'],
				'color' => $generate_settings['footer_text_color']
			),
			
			// Footer links
			'.site-info a, 
			.site-info a:visited' => array(
				'color' => $generate_settings['footer_link_color']
			),
			
			// Footer link hover
			'.site-info a:hover' => array(
				'color' => $generate_settings['footer_link_hover_color']
			),
			
			// Form input
			'input[type="text"], 
			input[type="email"], 
			input[type="url"], 
			input[type="password"], 
			input[type="search"], 
			input[type="tel"], 
			textarea' => array(
				'background-color' => $generate_settings['form_background_color'],
				'border-color' => $generate_settings['form_border_color'],
				'color' => $generate_settings['form_text_color']
			),
			
			// Form input focus
			'input[type="text"]:focus, 
			input[type="email"]:focus, 
			input[type="url"]:focus, 
			input[type="password"]:focus, 
			input[type="search"]:focus, 
			input[type="tel"]:focus, 
			textarea:focus' => array(
				'background-color' => $generate_settings['form_background_color_focus'],
				'color' => $generate_settings['form_text_color_focus'],
				'border-color' => $generate_settings['form_border_color_focus']
			),
			
			
			// Placeholder text
			'::-webkit-input-placeholder' => array(
				'color' => $generate_settings['form_text_color']
			),
			
			':-moz-placeholder' => array(
				'color' => $generate_settings['form_text_color']
			),
			
			'::-moz-placeholder' => array(
				'color' => $generate_settings['form_text_color']
			),
			
			':-ms-input-placeholder' => array(
				'color' => $generate_settings['form_text_color']
			),
			
			// Form button
			'button, 
			html input[type="button"], 
			input[type="reset"], 
			input[type="submit"],
			.button,
			.button:visited' => array(
				'background-color' => $generate_settings['form_button_background_color'],
				'color' => $generate_settings['form_button_text_color']
			),
			
			// Form button hover
			'button:hover, 
			html input[type="button"]:hover, 
			input[type="reset"]:hover, 
			input[type="submit"]:hover,
			.button:hover,
			button:focus, 
			html input[type="button"]:focus, 
			input[type="reset"]:focus, 
			input[type="submit"]:focus,
			.button:focus' => array(
				'background-color' => $generate_settings['form_button_background_color_hover'],
				'color' => $generate_settings['form_button_text_color_hover']
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
		
		$widget_padding = '';
		if ( $generate_settings['sidebar_widget_background_color'] !== $generate_settings['content_background_color'] && ! function_exists( 'generate_spacing_get_defaults' ) ) :
			$widget_padding = '.one-container .sidebar .widget{padding:30px;}';
		endif;
		
		$output = str_replace(array("\r", "\n", "\t"), '', $output);
		return $output . $widget_padding;
	}
	
	/**
	 * Enqueue scripts and styles
	 */
	add_action( 'wp_enqueue_scripts', 'generate_color_scripts', 50 );
	function generate_color_scripts() {

		wp_add_inline_style( 'generate-style', generate_advanced_css() );
	
	}
endif;

if ( ! function_exists( 'generate_colors_sanitize_hex_color' ) ) :
function generate_colors_sanitize_hex_color( $color ) {
    if ( '' === $color )
        return '';
 
    // 3 or 6 hex digits, or the empty string.
    if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
        return $color;
 
    return '';
}
endif;
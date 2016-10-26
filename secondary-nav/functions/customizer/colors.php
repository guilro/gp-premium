<?php
if ( defined( 'GENERATE_COLORS_VERSION' ) ) :
	
	if ( $wp_customize->get_panel( 'generate_colors_panel' ) ) {
		$colors_panel = 'generate_colors_panel';
	} else {
		$colors_panel = 'secondary_navigation_panel';
	}

	// Add Navigation section
	$wp_customize->add_section(
		// ID
		'secondary_navigation_color_section',
		// Arguments array
		array(
			'title' => __( 'Secondary Navigation', 'generate-secondary-nav' ),
			'capability' => 'edit_theme_options',
			'priority' => 71,
			'panel' => $colors_panel
		)
	);
	
	// Add color settings
	$secondary_navigation_colors = array();
	$secondary_navigation_colors[] = array(
		'slug'=>'navigation_background_color', 
		'default' => $defaults['navigation_background_color'],
		'label' => __('Background', 'generate-secondary-nav'),
		'priority' => 1
	);
	$secondary_navigation_colors[] = array(
		'slug'=>'navigation_text_color', 
		'default' => $defaults['navigation_text_color'],
		'label' => __('Text', 'generate-secondary-nav'),
		'priority' => 2
	);
	$secondary_navigation_colors[] = array(
		'slug'=>'navigation_background_hover_color', 
		'default' => $defaults['navigation_background_hover_color'],
		'label' => __('Background Hover', 'generate-secondary-nav'),
		'priority' => 3
	);
	$secondary_navigation_colors[] = array(
		'slug'=>'navigation_text_hover_color', 
		'default' => $defaults['navigation_text_hover_color'],
		'label' => __('Text Hover', 'generate-secondary-nav'),
		'priority' => 4
	);
	$secondary_navigation_colors[] = array(
		'slug'=>'navigation_background_current_color', 
		'default' => $defaults['navigation_background_current_color'],
		'label' => __('Background Current', 'generate-secondary-nav'),
		'priority' => 5
	);
	$secondary_navigation_colors[] = array(
		'slug'=>'navigation_text_current_color', 
		'default' => $defaults['navigation_text_current_color'],
		'label' => __('Text Current', 'generate-secondary-nav'),
		'priority' => 6
	);
	
	foreach( $secondary_navigation_colors as $color ) {
		// SETTINGS
		$wp_customize->add_setting(
			'generate_secondary_nav_settings[' . $color['slug'] . ']', array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'generate_colors_sanitize_hex_color',
				'transport' => 'postMessage'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'secondary_' . $color['slug'], 
				array(
					'label' => $color['label'], 
					'section' => 'secondary_navigation_color_section',
					'settings' => 'generate_secondary_nav_settings[' . $color['slug'] . ']',
					'priority' => $color['priority']
				)
			)
		);
	}



	// Add Sub-Navigation section
	$wp_customize->add_section(
		// ID
		'secondary_subnavigation_color_section',
		// Arguments array
		array(
			'title' => __( 'Secondary Sub-Navigation', 'generate-secondary-nav' ),
			'capability' => 'edit_theme_options',
			'priority' => 72,
			'panel' => $colors_panel
		)
	);

	// Add color settings
	$subsecondary_navigation_colors = array();
	$subsecondary_navigation_colors[] = array(
		'slug'=>'subnavigation_background_color', 
		'default' => $defaults['subnavigation_background_color'],
		'label' => __('Background', 'generate-secondary-nav'),
		'priority' => 1
	);
	$subsecondary_navigation_colors[] = array(
		'slug'=>'subnavigation_text_color', 
		'default' => $defaults['subnavigation_text_color'],
		'label' => __('Text', 'generate-secondary-nav'),
		'priority' => 2
	);
	$subsecondary_navigation_colors[] = array(
		'slug'=>'subnavigation_background_hover_color', 
		'default' => $defaults['subnavigation_background_hover_color'],
		'label' => __('Background Hover', 'generate-secondary-nav'),
		'priority' => 3
	);
	$subsecondary_navigation_colors[] = array(
		'slug'=>'subnavigation_text_hover_color', 
		'default' => $defaults['subnavigation_text_hover_color'],
		'label' => __('Text Hover', 'generate-secondary-nav'),
		'priority' => 4
	);
	$subsecondary_navigation_colors[] = array(
		'slug'=>'subnavigation_background_current_color', 
		'default' => $defaults['subnavigation_background_current_color'],
		'label' => __('Background Current', 'generate-secondary-nav'),
		'priority' => 5
	);
	$subsecondary_navigation_colors[] = array(
		'slug'=>'subnavigation_text_current_color', 
		'default' => $defaults['subnavigation_text_current_color'],
		'label' => __('Text Current', 'generate-secondary-nav'),
		'priority' => 6
	);
	foreach( $subsecondary_navigation_colors as $color ) {
		// SETTINGS
		$wp_customize->add_setting(
			'generate_secondary_nav_settings[' . $color['slug'] . ']', array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'generate_colors_sanitize_hex_color',
				'transport' => 'postMessage'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'secondary_' . $color['slug'], 
				array(
					'label' => $color['label'], 
					'section' => 'secondary_subnavigation_color_section',
					'settings' => 'generate_secondary_nav_settings[' . $color['slug'] . ']',
					'priority' => $color['priority']
				)
			)
		);
	}

endif;
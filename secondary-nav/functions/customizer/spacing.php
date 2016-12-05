<?php
if ( class_exists( 'Generate_Spacing_Customize_Control' ) ) :
	
	if ( $wp_customize->get_panel( 'generate_spacing_panel' ) ) {
		$spacing_panel = 'generate_spacing_panel';
	} else {
		$spacing_panel = 'secondary_navigation_panel';
	}

	// Add Navigation section
	$wp_customize->add_section(
		// ID
		'secondary_navigation_spacing_section',
		// Arguments array
		array(
			'title' => __( 'Secondary Navigation','secondary-nav' ),
			'capability' => 'edit_theme_options',
			'priority' => 16,
			'panel' => $spacing_panel
		)
	);
	
	if ( $wp_customize->get_panel( 'generate_layout_panel' ) ) {
		$secondary_navigation_section = 'secondary_nav_section';
	} else {
		$secondary_navigation_section = 'secondary_navigation_spacing_section';
	}
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_secondary_navigation_spacing_title',
			array(
				'section'  => $secondary_navigation_section,
				'description'    => __( 'Secondary Menu Items','secondary-nav' ),
				'type'     => 'text',
				'priority' => 200,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[secondary_menu_item]', array(
			'default' => $defaults['secondary_menu_item'],
			'type' => 'option', 
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Control(
			$wp_customize,
			'generate_secondary_nav_settings[secondary_menu_item]', 
			array(
				'description' => __('Left/Right Spacing','secondary-nav' ), 
				'section' => $secondary_navigation_section,
				'settings' => 'generate_secondary_nav_settings[secondary_menu_item]',
				'priority' => 220
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[secondary_menu_item_height]', array(
			'default' => $defaults['secondary_menu_item_height'],
			'type' => 'option', 
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Control(
			$wp_customize,
			'generate_secondary_nav_settings[secondary_menu_item_height]', 
			array(
				'description' => __('Height','secondary-nav' ), 
				'section' => $secondary_navigation_section,
				'settings' => 'generate_secondary_nav_settings[secondary_menu_item_height]',
				'priority' => 240
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[secondary_sub_menu_item_height]', array(
			'default' => $defaults['secondary_sub_menu_item_height'],
			'type' => 'option', 
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Control(
			$wp_customize,
			'generate_secondary_nav_settings[secondary_sub_menu_item_height]', 
			array(
				'label' => __( 'Sub-Menu Item Height','secondary-nav' ),
				'secondary_description' => __( 'The top and bottom spacing of sub-menu items.','secondary-nav' ), 
				'section' => $secondary_navigation_section,
				'settings' => 'generate_secondary_nav_settings[secondary_sub_menu_item_height]',
				'priority' => 260
			)
		)
	);

endif;
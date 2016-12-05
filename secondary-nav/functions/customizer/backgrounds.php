<?php
if ( defined( 'GENERATE_BACKGROUNDS_VERSION' ) ) :
		
	if ( $wp_customize->get_panel( 'generate_backgrounds_panel' ) ) {
		$backgrounds_panel = 'generate_backgrounds_panel';
	} else {
		$backgrounds_panel = 'secondary_navigation_panel';
	}

	$wp_customize->add_section(
		// ID
		'secondary_bg_images_section',
		// Arguments array
		array(
			'title' => __( 'Secondary Navigation','secondary-nav' ),
			'capability' => 'edit_theme_options',
			'description' => '',
			'panel' => $backgrounds_panel,
			'priority' => 21
		)
	);

	/**
	 * Navigation background
	 */
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[nav_image]', array(
			'default' => $defaults['nav_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	
	$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'generate_secondary_backgrounds-nav-image', 
			array(
				'section'    => 'secondary_bg_images_section',
				'settings'   => 'generate_secondary_nav_settings[nav_image]',
				'priority' => 750,
				'label' => __( 'Navigation','secondary-nav' ), 
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[nav_repeat]',
		array(
			'default' => $defaults['nav_repeat'],
			'type' => 'option',
			'sanitize_callback' => 'generate_secondary_nav_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_secondary_nav_settings[nav_repeat]',
		array(
			'type' => 'select',
			'section' => 'secondary_bg_images_section',
			'choices' => array(
				'' => __( 'Repeat','secondary-nav' ),
				'repeat-x' => __( 'Repeat x','secondary-nav' ),
				'repeat-y' => __( 'Repeat y','secondary-nav' ),
				'no-repeat' => __( 'No Repeat','secondary-nav' )
			),
			'settings' => 'generate_secondary_nav_settings[nav_repeat]',
			'priority' => 800
		)
	);
	
	/**
	 * Navigation item background
	 */
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[nav_item_image]', array(
			'default' => $defaults['nav_item_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	
	$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'generate_secondary_backgrounds-nav-item-image', 
			array(
				'section'    => 'secondary_bg_images_section',
				'settings'   => 'generate_secondary_nav_settings[nav_item_image]',
				'priority' => 950,
				'label' => __( 'Navigation Item','secondary-nav' ),
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[nav_item_repeat]',
		array(
			'default' => $defaults['nav_item_repeat'],
			'type' => 'option',
			'sanitize_callback' => 'generate_secondary_nav_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_secondary_nav_settings[nav_item_repeat]',
		array(
			'type' => 'select',
			'section' => 'secondary_bg_images_section',
			'choices' => array(
				'' => __( 'Repeat','secondary-nav' ),
				'repeat-x' => __( 'Repeat x','secondary-nav' ),
				'repeat-y' => __( 'Repeat y','secondary-nav' ),
				'no-repeat' => __( 'No Repeat','secondary-nav' )
			),
			'settings' => 'generate_secondary_nav_settings[nav_item_repeat]',
			'priority' => 1000
		)
	);
	
	/**
	 * Navigation item hover background
	 */
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[nav_item_hover_image]', array(
			'default' => $defaults['nav_item_hover_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	
	$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'generate_secondary_backgrounds-nav-item-hover-image', 
			array(
				'section'    => 'secondary_bg_images_section',
				'settings'   => 'generate_secondary_nav_settings[nav_item_hover_image]',
				'priority' => 1150,
				'label' => __( 'Navigation Item Hover','secondary-nav' ), 
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[nav_item_hover_repeat]',
		array(
			'default' => $defaults['nav_item_hover_repeat'],
			'type' => 'option',
			'sanitize_callback' => 'generate_secondary_nav_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_secondary_nav_settings[nav_item_hover_repeat]',
		array(
			'type' => 'select',
			'section' => 'secondary_bg_images_section',
			'choices' => array(
				'' => __( 'Repeat','secondary-nav' ),
				'repeat-x' => __( 'Repeat x','secondary-nav' ),
				'repeat-y' => __( 'Repeat y','secondary-nav' ),
				'no-repeat' => __( 'No Repeat','secondary-nav' )
			),
			'settings' => 'generate_secondary_nav_settings[nav_item_hover_repeat]',
			'priority' => 1200
		)
	);
	
	/**
	 * Navigation item current background
	 */
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[nav_item_current_image]', array(
			'default' => $defaults['nav_item_current_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	
	$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'generate_secondary_backgrounds-nav-item-current-image', 
			array(
				'section'    => 'secondary_bg_images_section',
				'settings'   => 'generate_secondary_nav_settings[nav_item_current_image]',
				'priority' => 1350,
				'label' => __( 'Navigation Item Current','secondary-nav' ), 
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[nav_item_current_repeat]',
		array(
			'default' => $defaults['nav_item_current_repeat'],
			'type' => 'option',
			'sanitize_callback' => 'generate_secondary_nav_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_secondary_nav_settings[nav_item_current_repeat]',
		array(
			'type' => 'select',
			'section' => 'secondary_bg_images_section',
			'choices' => array(
				'' => __( 'Repeat','secondary-nav' ),
				'repeat-x' => __( 'Repeat x','secondary-nav' ),
				'repeat-y' => __( 'Repeat y','secondary-nav' ),
				'no-repeat' => __( 'No Repeat','secondary-nav' )
			),
			'settings' => 'generate_secondary_nav_settings[nav_item_current_repeat]',
			'priority' => 1400
		)
	);
	
	$wp_customize->add_section(
		// ID
		'secondary_subnav_bg_images_section',
		// Arguments array
		array(
			'title' => __( 'Secondary Sub-Navigation','secondary-nav' ),
			'capability' => 'edit_theme_options',
			'description' => '',
			'panel' => $backgrounds_panel,
			'priority' => 22
		)
	);
	
	/**
	 * Sub-Navigation item background
	 */
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[sub_nav_item_image]', array(
			'default' => $defaults['sub_nav_item_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	
	$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'generate_secondary_backgrounds-sub-nav-item-image', 
			array(
				'section'    => 'secondary_subnav_bg_images_section',
				'settings'   => 'generate_secondary_nav_settings[sub_nav_item_image]',
				'priority' => 1700,
				'label' => __( 'Sub-Navigation Item','secondary-nav' ), 
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[sub_nav_item_repeat]',
		array(
			'default' => $defaults['sub_nav_item_repeat'],
			'type' => 'option',
			'sanitize_callback' => 'generate_secondary_nav_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_secondary_nav_settings[sub_nav_item_repeat]',
		array(
			'type' => 'select',
			'section' => 'secondary_subnav_bg_images_section',
			'choices' => array(
				'' => __( 'Repeat','secondary-nav' ),
				'repeat-x' => __( 'Repeat x','secondary-nav' ),
				'repeat-y' => __( 'Repeat y','secondary-nav' ),
				'no-repeat' => __( 'No Repeat','secondary-nav' )
			),
			'settings' => 'generate_secondary_nav_settings[sub_nav_item_repeat]',
			'priority' => 1800
		)
	);
	
	/**
	 * Sub-Navigation item hover background
	 */
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[sub_nav_item_hover_image]', array(
			'default' => $defaults['sub_nav_item_hover_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	
	$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'generate_secondary_backgrounds-sub-nav-item-hover-image', 
			array(
				'section'    => 'secondary_subnav_bg_images_section',
				'settings'   => 'generate_secondary_nav_settings[sub_nav_item_hover_image]',
				'priority' => 2000,
				'label' => __( 'Sub-Navigation Item Hover','secondary-nav' ), 
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[sub_nav_item_hover_repeat]',
		array(
			'default' => $defaults['sub_nav_item_hover_repeat'],
			'type' => 'option',
			'sanitize_callback' => 'generate_secondary_nav_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_secondary_nav_settings[sub_nav_item_hover_repeat]',
		array(
			'type' => 'select',
			'section' => 'secondary_subnav_bg_images_section',
			'choices' => array(
				'' => __( 'Repeat','secondary-nav' ),
				'repeat-x' => __( 'Repeat x','secondary-nav' ),
				'repeat-y' => __( 'Repeat y','secondary-nav' ),
				'no-repeat' => __( 'No Repeat','secondary-nav' )
			),
			'settings' => 'generate_secondary_nav_settings[sub_nav_item_hover_repeat]',
			'priority' => 2100
		)
	);
	
	/**
	 * Sub-Navigation item current background
	 */
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[sub_nav_item_current_image]', array(
			'default' => $defaults['sub_nav_item_current_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	
	$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'generate_secondary_backgrounds-sub-nav-item-current-image', 
			array(
				'section'    => 'secondary_subnav_bg_images_section',
				'settings'   => 'generate_secondary_nav_settings[sub_nav_item_current_image]',
				'priority' => 2300,
				'label' => __( 'Sub-Navigation Item Current','secondary-nav' ), 
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_secondary_nav_settings[sub_nav_item_current_repeat]',
		array(
			'default' => $defaults['sub_nav_item_current_repeat'],
			'type' => 'option',
			'sanitize_callback' => 'generate_secondary_nav_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_secondary_nav_settings[sub_nav_item_current_repeat]',
		array(
			'type' => 'select',
			'section' => 'secondary_subnav_bg_images_section',
			'choices' => array(
				'' => __( 'Repeat','secondary-nav' ),
				'repeat-x' => __( 'Repeat x','secondary-nav' ),
				'repeat-y' => __( 'Repeat y','secondary-nav' ),
				'no-repeat' => __( 'No Repeat','secondary-nav' )
			),
			'settings' => 'generate_secondary_nav_settings[sub_nav_item_current_repeat]',
			'priority' => 2400
		)
	);
	
endif;
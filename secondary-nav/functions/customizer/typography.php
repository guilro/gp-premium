<?php
if ( defined( 'GENERATE_FONT_VERSION' ) && class_exists( 'Generate_Google_Font_Dropdown_Custom_Control' ) && function_exists( 'generate_premium_sanitize_typography' ) ) :
	
	if ( $wp_customize->get_panel( 'generate_typography_panel' ) ) {
		$typography_panel = 'generate_typography_panel';
	} else {
		$typography_panel = 'secondary_navigation_panel';
	}
	
	$wp_customize->add_section(
		// ID
		'secondary_font_section',
		// Arguments array
		array(
			'title' => __( 'Secondary Navigation','secondary-nav' ),
			'capability' => 'edit_theme_options',
			'description' => '',
			'priority' => 51,
			'panel' => $typography_panel
		)
	);
	
	// Add site navigation fonts
	$wp_customize->add_setting( 
		'generate_secondary_nav_settings[font_secondary_navigation]', 
		array(
			'default' => $defaults['font_secondary_navigation'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_typography'
		)
	);
			
	$wp_customize->add_control( 
		new Generate_Google_Font_Dropdown_Custom_Control( 
			$wp_customize, 
			'google_font_site_secondary_navigation_control', 
			array(
				'label' => __('Secondary navigation','secondary-nav'),
				'section' => 'secondary_font_section',
				'settings' => 'generate_secondary_nav_settings[font_secondary_navigation]',
				'priority' => 120
			)
		)
	);
	if ( class_exists( 'Generate_Hidden_Input_Control' ) ) :
		$wp_customize->add_setting( 
			'font_secondary_navigation_category', 
			array(
				'default' => '',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);
			
		$wp_customize->add_control( 
			new Generate_Hidden_Input_Control( 
				$wp_customize, 
				'font_secondary_navigation_category', 
				array(
					'section' => 'secondary_font_section',
					'settings' => 'font_secondary_navigation_category',
					'type' => 'gp-hidden-input',
					'priority' => 120
				)
			)
		);
		
		$wp_customize->add_setting( 
			'font_secondary_navigation_variants', 
			array(
				'default' => '',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);
			
		$wp_customize->add_control( 
			new Generate_Hidden_Input_Control( 
				$wp_customize, 
				'font_secondary_navigation_variants', 
				array(
					'section' => 'secondary_font_section',
					'settings' => 'font_secondary_navigation_variants',
					'type' => 'gp-hidden-input',
					'priority' => 120
				)
			)
		);
	endif;
		
	$wp_customize->add_setting( 
		'generate_secondary_nav_settings[secondary_navigation_font_weight]', 
		array(
			'default' => $defaults['secondary_navigation_font_weight'],
			'type' => 'option',
			'sanitize_callback' => ( class_exists( 'Generate_Select_Control' ) ) ? 'generate_secondary_nav_sanitize_choices' : 'generate_sanitize_font_weight',
			'transport' => 'postMessage'
		)
	);
	
	if ( class_exists( 'Generate_Select_Control' ) ) {
		$wp_customize->add_control( 
			new Generate_Select_Control( 
				$wp_customize, 
				'generate_secondary_nav_settings[secondary_navigation_font_weight]', 
				array(
					'label' => __('Font weight','secondary-nav'),
					'section' => 'secondary_font_section',
					'settings' => 'generate_secondary_nav_settings[secondary_navigation_font_weight]',
					'priority' => 140,
					'type' => 'gp-typography-select',
					'choices' => array(
						'normal' => 'normal',
						'bold' => 'bold',
						'100' => '100',
						'200' => '200',
						'300' => '300',
						'400' => '400',
						'500' => '500',
						'600' => '600',
						'700' => '700',
						'800' => '800',
						'900' => '900'
					)
				)
			)
		);
	} else {
		$wp_customize->add_control( 
			new Generate_Font_Weight_Custom_Control( 
				$wp_customize, 
				'secondary_navigation_font_weight_control', 
				array(
					'label' => __('Font weight','secondary-nav'),
					'section' => 'secondary_font_section',
					'settings' => 'generate_secondary_nav_settings[secondary_navigation_font_weight]',
					'priority' => 140,
					'type' => 'weight'
				)
			)
		);
	}
		
	$wp_customize->add_setting( 
		'generate_secondary_nav_settings[secondary_navigation_font_transform]', 
		array(
			'default' => $defaults['secondary_navigation_font_transform'],
			'type' => 'option',
			'sanitize_callback' => ( class_exists( 'Generate_Select_Control' ) ) ? 'generate_secondary_nav_sanitize_choices' : 'generate_sanitize_text_transform',
			'transport' => 'postMessage'
		)
	);
	
	if ( class_exists( 'Generate_Select_Control' ) ) {
		$wp_customize->add_control( 
			new Generate_Select_Control( 
				$wp_customize, 
				'generate_secondary_nav_settings[secondary_navigation_font_transform]', 
				array(
					'label' => __('Text transform','secondary-nav'),
					'section' => 'secondary_font_section',
					'settings' => 'generate_secondary_nav_settings[secondary_navigation_font_transform]',
					'priority' => 160,
					'type' => 'gp-typography-select',
					'choices' => array(
						'none' => 'none',
						'capitalize' => 'capitalize',
						'uppercase' => 'uppercase',
						'lowercase' => 'lowercase'
					)
				)
			)
		);
	} else {
		$wp_customize->add_control( 
			new Generate_Text_Transform_Custom_Control( 
				$wp_customize, 
				'secondary_navigation_font_transform_control', 
				array(
					'label' => __('Text transform','secondary-nav'),
					'section' => 'secondary_font_section',
					'settings' => 'generate_secondary_nav_settings[secondary_navigation_font_transform]',
					'priority' => 160,
						'type' => 'transform'
				)
			)
		);
	}
	
	if ( class_exists( 'Generate_Customize_Slider_Control' ) ) :
		$wp_customize->add_setting( 
			'generate_secondary_nav_settings[secondary_navigation_font_size]', 
			array(
				'default' => $defaults['secondary_navigation_font_size'],
				'type' => 'option',
				'sanitize_callback' => 'absint',
				'transport' => 'postMessage'
			)
		);
				
		$wp_customize->add_control( 
			new Generate_Customize_Slider_Control( 
				$wp_customize, 
				'generate_secondary_nav_settings[secondary_navigation_font_size]', 
				array(
					'label' => __('Font size','secondary-nav'),
					'section' => 'secondary_font_section',
					'settings' => 'generate_secondary_nav_settings[secondary_navigation_font_size]',
					'priority' => 165,
					'type' => 'gp-typography-slider',
					'default_value' => $defaults['secondary_navigation_font_size'],
					'unit' => 'px'
				)
			)
		);
	endif;
	
endif;
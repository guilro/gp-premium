<?php
$wp_customize->add_section(
	// ID
	'generate_spacing_footer',
	// Arguments array
	array(
		'title' => __( 'Footer', 'generate-spacing' ),
		'capability' => 'edit_theme_options',
		'priority' => 20,
		'panel' => 'generate_spacing_panel'
	)
);

if ( $wp_customize->get_panel( 'generate_layout_panel' ) ) {
	$footer_section = 'generate_layout_footer';
} else {
	$footer_section = 'generate_spacing_footer';
}

$wp_customize->add_control(
	new Generate_Spacing_Customize_Misc_Control(
		$wp_customize,
		'generate_footer_widget_spacing_title',
		array(
			'section'  => $footer_section,
			'description'    => __( 'Footer Widget Area Padding', 'generate-spacing' ),
			'type'     => 'text',
			'priority' => 99,
		)
	)
);

// Header top
$wp_customize->add_setting(
	'generate_spacing_settings[footer_widget_container_top]', array(
		'default' => $defaults['footer_widget_container_top'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[footer_widget_container_top]', 
		array(
			'description' => __('Top', 'generate-spacing' ), 
			'section' => $footer_section,
			'settings' => 'generate_spacing_settings[footer_widget_container_top]',
			'priority' => 100
		)
	)
);

// Header right
$wp_customize->add_setting(
	'generate_spacing_settings[footer_widget_container_right]', array(
		'default' => $defaults['footer_widget_container_right'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[footer_widget_container_right]', 
		array(
			'description' => __('Right', 'generate-spacing' ), 
			'section' => $footer_section,
			'settings' => 'generate_spacing_settings[footer_widget_container_right]',
			'priority' => 105
		)
	)
);

// Header bottom
$wp_customize->add_setting(
	'generate_spacing_settings[footer_widget_container_bottom]', array(
		'default' => $defaults['footer_widget_container_bottom'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[footer_widget_container_bottom]', 
		array(
			'description' => __('Bottom', 'generate-spacing' ), 
			'section' => $footer_section,
			'settings' => 'generate_spacing_settings[footer_widget_container_bottom]',
			'priority' => 110
		)
	)
);

// Header left
$wp_customize->add_setting(
	'generate_spacing_settings[footer_widget_container_left]', array(
		'default' => $defaults['footer_widget_container_left'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[footer_widget_container_left]', 
		array(
			'description' => __('Left', 'generate-spacing' ), 
			'section' => $footer_section,
			'settings' => 'generate_spacing_settings[footer_widget_container_left]',
			'priority' => 115
		)
	)
);

///

$wp_customize->add_control(
	new Generate_Spacing_Customize_Misc_Control(
		$wp_customize,
		'generate_footer_spacing_title',
		array(
			'section'  => $footer_section,
			'description'    => __( 'Footer Padding', 'generate-spacing' ),
			'type'     => 'text',
			'priority' => 125,
		)
	)
);

// Header top
$wp_customize->add_setting(
	'generate_spacing_settings[footer_top]', array(
		'default' => $defaults['footer_top'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[footer_top]', 
		array(
			'description' => __('Top', 'generate-spacing' ), 
			'section' => $footer_section,
			'settings' => 'generate_spacing_settings[footer_top]',
			'priority' => 135
		)
	)
);

// Header right
$wp_customize->add_setting(
	'generate_spacing_settings[footer_right]', array(
		'default' => $defaults['footer_right'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[footer_right]', 
		array(
			'description' => __('Right', 'generate-spacing' ), 
			'section' => $footer_section,
			'settings' => 'generate_spacing_settings[footer_right]',
			'priority' => 145
		)
	)
);

// Header bottom
$wp_customize->add_setting(
	'generate_spacing_settings[footer_bottom]', array(
		'default' => $defaults['footer_bottom'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[footer_bottom]', 
		array(
			'description' => __('Bottom', 'generate-spacing' ), 
			'section' => $footer_section,
			'settings' => 'generate_spacing_settings[footer_bottom]',
			'priority' => 155
		)
	)
);

// Header left
$wp_customize->add_setting(
	'generate_spacing_settings[footer_left]', array(
		'default' => $defaults['footer_left'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[footer_left]', 
		array(
			'description' => __('Left', 'generate-spacing' ), 
			'section' => $footer_section,
			'settings' => 'generate_spacing_settings[footer_left]',
			'priority' => 165
		)
	)
);
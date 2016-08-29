<?php
// Add Header section
$wp_customize->add_section(
	'generate_spacing_header',
	array(
		'title' => __( 'Header', 'generate-spacing' ),
		'capability' => 'edit_theme_options',
		'priority' => 5,
		'panel' => 'generate_spacing_panel'
	)
);

if ( $wp_customize->get_panel( 'generate_layout_panel' ) ) {
	$header_section = 'generate_layout_header';
} else {
	$header_section = 'generate_spacing_header';
}

$wp_customize->add_control(
	new Generate_Spacing_Customize_Misc_Control(
		$wp_customize,
		'generate_header_spacing_title',
		array(
			'section'  => $header_section,
			'description'    => __( 'Header Padding', 'generate-spacing' ),
			'type'     => 'text',
			'priority' => 99,
		)
	)
);
	
// Header top
$wp_customize->add_setting(
	'generate_spacing_settings[header_top]', array(
		'default' => $defaults['header_top'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[header_top]', 
		array(
			'description' => __('Top', 'generate-spacing' ), 
			'section' => $header_section,
			'settings' => 'generate_spacing_settings[header_top]',
			'priority' => 100
		)
	)
);

// Header right
$wp_customize->add_setting(
	'generate_spacing_settings[header_right]', array(
		'default' => $defaults['header_right'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[header_right]', 
		array(
			'description' => __('Right', 'generate-spacing' ), 
			'section' => $header_section,
			'settings' => 'generate_spacing_settings[header_right]',
			'priority' => 105
		)
	)
);

// Header bottom
$wp_customize->add_setting(
	'generate_spacing_settings[header_bottom]', array(
		'default' => $defaults['header_bottom'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[header_bottom]', 
		array(
			'description' => __('Bottom', 'generate-spacing' ), 
			'section' => $header_section,
			'settings' => 'generate_spacing_settings[header_bottom]',
			'priority' => 110
		)
	)
);

// Header left
$wp_customize->add_setting(
	'generate_spacing_settings[header_left]', array(
		'default' => $defaults['header_left'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[header_left]', 
		array(
			'description' => __('Left', 'generate-spacing' ), 
			'section' => $header_section,
			'settings' => 'generate_spacing_settings[header_left]',
			'priority' => 115
		)
	)
);
<?php
$wp_customize->add_section(
	// ID
	'generate_spacing_sidebar',
	// Arguments array
	array(
		'title' => __( 'Sidebars', 'generate-spacing' ),
		'capability' => 'edit_theme_options',
		'priority' => 15,
		'panel' => 'generate_spacing_panel'
	)
);

if ( $wp_customize->get_panel( 'generate_layout_panel' ) ) {
	$widget_section = 'generate_layout_sidebars';
} else {
	$widget_section = 'generate_spacing_sidebar';
}

$wp_customize->add_control(
	new Generate_Spacing_Customize_Misc_Control(
		$wp_customize,
		'generate_widget_spacing_title',
		array(
			'section'  => $widget_section,
			'description' => __( 'Widget Padding', 'generate-spacing' ),
			'type'     => 'text',
			'priority' => 99,
		)
	)
);
	
// Header top
$wp_customize->add_setting(
	'generate_spacing_settings[widget_top]', array(
		'default' => $defaults['widget_top'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[widget_top]', 
		array(
			'description' => __('Top', 'generate-spacing' ), 
			'section' => $widget_section,
			'settings' => 'generate_spacing_settings[widget_top]',
			'priority' => 100
		)
	)
);

// Header right
$wp_customize->add_setting(
	'generate_spacing_settings[widget_right]', array(
		'default' => $defaults['widget_right'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[widget_right]', 
		array(
			'description' => __('Right', 'generate-spacing' ), 
			'section' => $widget_section,
			'settings' => 'generate_spacing_settings[widget_right]',
			'priority' => 105
		)
	)
);

// Header bottom
$wp_customize->add_setting(
	'generate_spacing_settings[widget_bottom]', array(
		'default' => $defaults['widget_bottom'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[widget_bottom]', 
		array(
			'description' => __('Bottom', 'generate-spacing' ), 
			'section' => $widget_section,
			'settings' => 'generate_spacing_settings[widget_bottom]',
			'priority' => 110
		)
	)
);

// Header left
$wp_customize->add_setting(
	'generate_spacing_settings[widget_left]', array(
		'default' => $defaults['widget_left'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);

$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[widget_left]', 
		array(
			'description' => __('Left', 'generate-spacing' ), 
			'section' => $widget_section,
			'settings' => 'generate_spacing_settings[widget_left]',
			'priority' => 115
		)
	)
);

// Add Layout setting
$wp_customize->add_setting(
	// ID
	'generate_spacing_settings[left_sidebar_width]',
	// Arguments array
	array(
		'default' => $defaults['left_sidebar_width'],
		'type' => 'option',
		'sanitize_callback' => 'generate_spacing_sanitize_choices'
	)
);



// Add Layout control
$wp_customize->add_control(
	// ID
	'generate_spacing_settings[left_sidebar_width]',
	// Arguments array
	array(
		'type' => 'select',
		'label' => __( 'Left Sidebar Width', 'generate-spacing' ),
		'section' => $widget_section,
		'choices' => array(
			'15' => __( '15%', 'generate-spacing' ),
			'20' => __( '20%', 'generate-spacing' ),
			'25' => __( '25%', 'generate-spacing' ),
			'30' => __( '30%', 'generate-spacing' ),
			'35' => __( '35%', 'generate-spacing' ),
			'40' => __( '40%', 'generate-spacing' ),
			'45' => __( '45%', 'generate-spacing' ),
			'50' => __( '50%', 'generate-spacing' )
		),
		// This last one must match setting ID from above
		'settings' => 'generate_spacing_settings[left_sidebar_width]',
		'priority' => 125
	)
);

// Add Layout setting
$wp_customize->add_setting(
	// ID
	'generate_spacing_settings[right_sidebar_width]',
	// Arguments array
	array(
		'default' => $defaults['right_sidebar_width'],
		'type' => 'option',
		'sanitize_callback' => 'generate_spacing_sanitize_choices'
	)
);

// Add Layout control
$wp_customize->add_control(
	// ID
	'generate_spacing_settings[right_sidebar_width]',
	// Arguments array
	array(
		'type' => 'select',
		'label' => __( 'Right Sidebar Width', 'generate-spacing' ),
		'section' => $widget_section,
		'choices' => array(
			'15' => __( '15%', 'generate-spacing' ),
			'20' => __( '20%', 'generate-spacing' ),
			'25' => __( '25%', 'generate-spacing' ),
			'30' => __( '30%', 'generate-spacing' ),
			'35' => __( '35%', 'generate-spacing' ),
			'40' => __( '40%', 'generate-spacing' ),
			'45' => __( '45%', 'generate-spacing' ),
			'50' => __( '50%', 'generate-spacing' )
		),
		// This last one must match setting ID from above
		'settings' => 'generate_spacing_settings[right_sidebar_width]',
		'priority' => 130
	)
);
<?php
$wp_customize->add_section(
	// ID
	'generate_spacing_navigation',
	// Arguments array
	array(
		'title' => __( 'Primary Navigation', 'generate-spacing' ),
		'capability' => 'edit_theme_options',
		'priority' => 15,
		'panel' => 'generate_spacing_panel'
	)
);

if ( $wp_customize->get_panel( 'generate_layout_panel' ) ) {
	$navigation_section = 'generate_layout_navigation';
} else {
	$navigation_section = 'generate_spacing_navigation';
}

$wp_customize->add_control(
	new Generate_Spacing_Customize_Misc_Control(
		$wp_customize,
		'generate_navigation_spacing_title',
		array(
			'section'  => $navigation_section,
			'description'    => __( 'Primary Menu Items', 'generate-spacing' ),
			'type'     => 'text',
			'priority' => 200,
		)
	)
);

$wp_customize->add_setting(
	'generate_spacing_settings[menu_item]', array(
		'default' => $defaults['menu_item'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);
// CONTROLS
$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[menu_item]', 
		array(
			'description' => __('Left/Right Spacing', 'generate-spacing' ), 
			'section' => $navigation_section,
			'settings' => 'generate_spacing_settings[menu_item]',
			'priority' => 220
		)
	)
);

$wp_customize->add_setting(
	'generate_spacing_settings[menu_item_height]', array(
		'default' => $defaults['menu_item_height'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);
// CONTROLS
$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[menu_item_height]', 
		array(
			'description' => __('Height', 'generate-spacing' ), 
			'section' => $navigation_section,
			'settings' => 'generate_spacing_settings[menu_item_height]',
			'priority' => 240
		)
	)
);

$wp_customize->add_setting(
	'generate_spacing_settings[sub_menu_item_height]', array(
		'default' => $defaults['sub_menu_item_height'],
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	)
);
// CONTROLS
$wp_customize->add_control(
	new Generate_Spacing_Customize_Control(
		$wp_customize,
		'generate_spacing_settings[sub_menu_item_height]', 
		array(
			'label' => __( 'Sub-Menu Item Height', 'generate-spacing' ),
			'secondary_description' => __( 'The top and bottom spacing of sub-menu items.', 'generate-spacing' ), 
			'section' => $navigation_section,
			'settings' => 'generate_spacing_settings[sub_menu_item_height]',
			'priority' => 260
		)
	)
);
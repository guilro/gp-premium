<?php
/**
 * Set default options
 */
if ( !function_exists( 'generate_get_background_defaults' ) ) :
	function generate_get_background_defaults()
	{
		$generate_background_defaults = array(
			'body_image' => '',
			'body_repeat' => '',
			'body_size' => '',
			'body_attachment' => '',
			'body_position' => '',
			'header_image' => '',
			'header_repeat' => '',
			'header_size' => '',
			'header_attachment' => '',
			'header_position' => '',
			'nav_image' => '',
			'nav_repeat' => '',
			'nav_item_image' => '',
			'nav_item_repeat' => '',
			'nav_item_hover_image' => '',
			'nav_item_hover_repeat' => '',
			'nav_item_current_image' => '',
			'nav_item_current_repeat' => '',
			'sub_nav_image' => '',
			'sub_nav_repeat' => '',
			'sub_nav_item_image' => '',
			'sub_nav_item_repeat' => '',
			'sub_nav_item_hover_image' => '',
			'sub_nav_item_hover_repeat' => '',
			'sub_nav_item_current_image' => '',
			'sub_nav_item_current_repeat' => '',
			'content_image' => '',
			'content_repeat' => '',
			'content_size' => '',
			'content_attachment' => '',
			'content_position' => '',
			'sidebar_widget_image' => '',
			'sidebar_widget_repeat' => '',
			'sidebar_widget_size' => '',
			'sidebar_widget_attachment' => '',
			'sidebar_widget_position' => '',
			'footer_widget_image' => '',
			'footer_widget_repeat' => '',
			'footer_widget_size' => '',
			'footer_widget_attachment' => '',
			'footer_widget_position' => '',
			'footer_image' => '',
			'footer_repeat' => '',
			'footer_size' => '',
			'footer_attachment' => '',
			'footer_position' => '',
		);
		
		return apply_filters( 'generate_background_option_defaults', $generate_background_defaults );
	}
endif;

if ( ! function_exists( 'generate_backgrounds_customize' ) ) :
add_action( 'customize_register', 'generate_backgrounds_customize', 999 );
function generate_backgrounds_customize( $wp_customize )
{
		
	$defaults = generate_get_background_defaults();
	$wp_customize->add_setting('generate_backgrounds_misc');
	$dir = plugin_dir_path( __FILE__ );
	require_once $dir . 'controls.php';
	
	$wp_customize->add_section(
		'backgrounds_section',
		array(
			'title' => __( 'Background Images', 'generate-backgrounds' ),
			'capability' => 'edit_theme_options',
			'priority' => 50
		)
	);
	
	/**
	 * Body background
	 */
	 
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-header',
			array( 'section'  => 'backgrounds_section', 'label' => __( 'Body', 'generate-backgrounds' ), 'type' => 'backgrounds-heading','priority' => 1 )
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[body_image]', array(
			'default' => $defaults['body_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Background_Upload_Control( 
			$wp_customize, 
			'generate_backgrounds-body-image', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[body_image]',
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[body_repeat]',
		array(
			'default' => $defaults['body_repeat'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-body-repeat',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Repeat', 'generate-backgrounds' ),
				'repeat-x' => __( 'Repeat x', 'generate-backgrounds' ),
				'repeat-y' => __( 'Repeat y', 'generate-backgrounds' ),
				'no-repeat' => __( 'No Repeat', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[body_repeat]',
			'priority' => 50
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[body_size]',
		array(
			'default' => $defaults['body_size'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-body-size',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Size (Auto)', 'generate-backgrounds' ),
				'100%' => __( '100% Width', 'generate-backgrounds' ),
				'cover' => __( 'Cover', 'generate-backgrounds' ),
				'contain' => __( 'Contain', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[body_size]',
			'priority' => 100
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[body_attachment]',
		array(
			'default' => $defaults['body_attachment'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-body-attachment',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Attachment', 'generate-backgrounds' ),
				'fixed' => __( 'Fixed', 'generate-backgrounds' ),
				'local' => __( 'Local', 'generate-backgrounds' ),
				'inherit' => __( 'Inherit', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[body_attachment]',
			'priority' => 150
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[body_position]', array(
			'default' => $defaults['body_position'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Backgrounds_Customize_Control( 
			$wp_customize, 
			'generate_backgrounds-body-position', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[body_position]',
				'priority' => 200,
				'label' => 'left top, x% y%, xpos ypos (px)',
				'placeholder' => __('Position','generate-backgrounds')
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-body-line',
			array(
				'section'  => 'backgrounds_section',
				'type'     => 'line',
				'priority' => 250,
			)
		)
	);
	
	/**
	 * Header background
	 */
	 
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-header-heading',
			array( 
				'section'  => 'backgrounds_section', 
				'label' => __( 'Header', 'generate-backgrounds' ), 
				'type' => 'backgrounds-heading',
				'priority' => 300 
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[header_image]', array(
			'default' => $defaults['header_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Background_Upload_Control( 
			$wp_customize, 
			'generate_backgrounds-header-image', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[header_image]',
				'priority' => 350,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[header_repeat]',
		array(
			'default' => $defaults['header_repeat'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-header-repeat',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Repeat', 'generate-backgrounds' ),
				'repeat-x' => __( 'Repeat x', 'generate-backgrounds' ),
				'repeat-y' => __( 'Repeat y', 'generate-backgrounds' ),
				'no-repeat' => __( 'No Repeat', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[header_repeat]',
			'priority' => 400
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[header_size]',
		array(
			'default' => $defaults['header_size'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-header-size',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Size (Auto)', 'generate-backgrounds' ),
				'100%' => __( '100% Width', 'generate-backgrounds' ),
				'cover' => __( 'Cover', 'generate-backgrounds' ),
				'contain' => __( 'Contain', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[header_size]',
			'priority' => 450
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[header_attachment]',
		array(
			'default' => $defaults['header_attachment'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-header-attachment',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Attachment', 'generate-backgrounds' ),
				'fixed' => __( 'Fixed', 'generate-backgrounds' ),
				'local' => __( 'Local', 'generate-backgrounds' ),
				'inherit' => __( 'Inherit', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[header_attachment]',
			'priority' => 500
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[header_position]', array(
			'default' => $defaults['header_position'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Backgrounds_Customize_Control( 
			$wp_customize, 
			'generate_backgrounds-header-position', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[header_position]',
				'priority' => 550,
				'label' => 'left top, x% y%, xpos ypos (px)',
				'placeholder' => __('Position','generate-backgrounds')
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-header-line',
			array(
				'section'  => 'backgrounds_section',
				'type'     => 'line',
				'priority' => 600,
			)
		)
	);
	
	/**
	 * Navigation background
	 */
	 
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-nav-heading',
			array( 
				'section'  => 'backgrounds_section', 
				'label' => __( 'Navigation', 'generate-backgrounds' ), 
				'type' => 'backgrounds-heading',
				'priority' => 700 
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[nav_image]', array(
			'default' => $defaults['nav_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Background_Upload_Control( 
			$wp_customize, 
			'generate_backgrounds-nav-image', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[nav_image]',
				'priority' => 750,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[nav_repeat]',
		array(
			'default' => $defaults['nav_repeat'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-nav-repeat',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Repeat', 'generate-backgrounds' ),
				'repeat-x' => __( 'Repeat x', 'generate-backgrounds' ),
				'repeat-y' => __( 'Repeat y', 'generate-backgrounds' ),
				'no-repeat' => __( 'No Repeat', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[nav_repeat]',
			'priority' => 800
		)
	);
	
	/**
	 * Navigation item background
	 */
	 
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-nav-item-heading',
			array( 
				'section'  => 'backgrounds_section', 
				'label' => __( 'Navigation Item', 'generate-backgrounds' ), 
				'type' => 'backgrounds-heading',
				'priority' => 900 
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[nav_item_image]', array(
			'default' => $defaults['nav_item_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Background_Upload_Control( 
			$wp_customize, 
			'generate_backgrounds-nav-item-image', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[nav_item_image]',
				'priority' => 950,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[nav_item_repeat]',
		array(
			'default' => $defaults['nav_item_repeat'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-nav-item-repeat',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Repeat', 'generate-backgrounds' ),
				'repeat-x' => __( 'Repeat x', 'generate-backgrounds' ),
				'repeat-y' => __( 'Repeat y', 'generate-backgrounds' ),
				'no-repeat' => __( 'No Repeat', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[nav_item_repeat]',
			'priority' => 1000
		)
	);
	
	/**
	 * Navigation item hover background
	 */
	 
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-nav-item-hover-heading',
			array( 
				'section'  => 'backgrounds_section', 
				'label' => __( 'Navigation Item Hover', 'generate-backgrounds' ), 
				'type' => 'backgrounds-heading',
				'priority' => 1100
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[nav_item_hover_image]', array(
			'default' => $defaults['nav_item_hover_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Background_Upload_Control( 
			$wp_customize, 
			'generate_backgrounds-nav-item-hover-image', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[nav_item_hover_image]',
				'priority' => 1150,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[nav_item_hover_repeat]',
		array(
			'default' => $defaults['nav_item_hover_repeat'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-nav-item-hover-repeat',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Repeat', 'generate-backgrounds' ),
				'repeat-x' => __( 'Repeat x', 'generate-backgrounds' ),
				'repeat-y' => __( 'Repeat y', 'generate-backgrounds' ),
				'no-repeat' => __( 'No Repeat', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[nav_item_hover_repeat]',
			'priority' => 1200
		)
	);
	
	/**
	 * Navigation item current background
	 */
	 
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-nav-item-current-heading',
			array( 
				'section'  => 'backgrounds_section', 
				'label' => __( 'Navigation Item Current', 'generate-backgrounds' ), 
				'type' => 'backgrounds-heading',
				'priority' => 1300
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[nav_item_current_image]', array(
			'default' => $defaults['nav_item_current_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Background_Upload_Control( 
			$wp_customize, 
			'generate_backgrounds-nav-item-current-image', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[nav_item_current_image]',
				'priority' => 1350,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[nav_item_current_repeat]',
		array(
			'default' => $defaults['nav_item_current_repeat'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-nav-item-current-repeat',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Repeat', 'generate-backgrounds' ),
				'repeat-x' => __( 'Repeat x', 'generate-backgrounds' ),
				'repeat-y' => __( 'Repeat y', 'generate-backgrounds' ),
				'no-repeat' => __( 'No Repeat', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[nav_item_current_repeat]',
			'priority' => 1400
		)
	);
	
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-nav-line',
			array(
				'section'  => 'backgrounds_section',
				'type'     => 'line',
				'priority' => 1500,
			)
		)
	);
	
	/**
	 * Sub-Navigation item background
	 */
	 
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-sub-nav-item-heading',
			array( 
				'section'  => 'backgrounds_section', 
				'label' => __( 'Sub-Navigation Item', 'generate-backgrounds' ), 
				'type' => 'backgrounds-heading',
				'priority' => 1600 
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[sub_nav_item_image]', array(
			'default' => $defaults['sub_nav_item_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Background_Upload_Control( 
			$wp_customize, 
			'generate_backgrounds-sub-nav-item-image', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[sub_nav_item_image]',
				'priority' => 1700,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[sub_nav_item_repeat]',
		array(
			'default' => $defaults['sub_nav_item_repeat'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-sub-nav-item-repeat',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Repeat', 'generate-backgrounds' ),
				'repeat-x' => __( 'Repeat x', 'generate-backgrounds' ),
				'repeat-y' => __( 'Repeat y', 'generate-backgrounds' ),
				'no-repeat' => __( 'No Repeat', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[sub_nav_item_repeat]',
			'priority' => 1800
		)
	);
	
	/**
	 * Sub-Navigation item hover background
	 */
	 
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-sub-nav-item-hover-heading',
			array( 
				'section'  => 'backgrounds_section', 
				'label' => __( 'Sub-Navigation Item Hover', 'generate-backgrounds' ), 
				'type' => 'backgrounds-heading',
				'priority' => 1900
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[sub_nav_item_hover_image]', array(
			'default' => $defaults['sub_nav_item_hover_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Background_Upload_Control( 
			$wp_customize, 
			'generate_backgrounds-sub-nav-item-hover-image', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[sub_nav_item_hover_image]',
				'priority' => 2000,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[sub_nav_item_hover_repeat]',
		array(
			'default' => $defaults['sub_nav_item_hover_repeat'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-sub-nav-item-hover-repeat',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Repeat', 'generate-backgrounds' ),
				'repeat-x' => __( 'Repeat x', 'generate-backgrounds' ),
				'repeat-y' => __( 'Repeat y', 'generate-backgrounds' ),
				'no-repeat' => __( 'No Repeat', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[sub_nav_item_hover_repeat]',
			'priority' => 2100
		)
	);
	
	/**
	 * Sub-Navigation item current background
	 */
	 
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-sub-nav-item-current-heading',
			array( 
				'section'  => 'backgrounds_section', 
				'label' => __( 'Sub-Navigation Item Current', 'generate-backgrounds' ), 
				'type' => 'backgrounds-heading',
				'priority' => 2200
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[sub_nav_item_current_image]', array(
			'default' => $defaults['sub_nav_item_current_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Background_Upload_Control( 
			$wp_customize, 
			'generate_backgrounds-sub-nav-item-current-image', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[sub_nav_item_current_image]',
				'priority' => 2300,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[sub_nav_item_current_repeat]',
		array(
			'default' => $defaults['sub_nav_item_current_repeat'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-sub-nav-item-current-repeat',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Repeat', 'generate-backgrounds' ),
				'repeat-x' => __( 'Repeat x', 'generate-backgrounds' ),
				'repeat-y' => __( 'Repeat y', 'generate-backgrounds' ),
				'no-repeat' => __( 'No Repeat', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[sub_nav_item_current_repeat]',
			'priority' => 2400
		)
	);
	
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-sub-nav-line',
			array(
				'section'  => 'backgrounds_section',
				'type'     => 'line',
				'priority' => 2500,
			)
		)
	);
	
	/**
	 * Content background
	 */
	 
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-content-heading',
			array( 
				'section'  => 'backgrounds_section', 
				'label' => __( 'Content', 'generate-backgrounds' ), 
				'type' => 'backgrounds-heading',
				'priority' => 2600
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[content_image]', array(
			'default' => $defaults['content_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Background_Upload_Control( 
			$wp_customize, 
			'generate_backgrounds-content-image', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[content_image]',
				'priority' => 2700,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[content_repeat]',
		array(
			'default' => $defaults['content_repeat'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-content-repeat',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Repeat', 'generate-backgrounds' ),
				'repeat-x' => __( 'Repeat x', 'generate-backgrounds' ),
				'repeat-y' => __( 'Repeat y', 'generate-backgrounds' ),
				'no-repeat' => __( 'No Repeat', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[content_repeat]',
			'priority' => 2800
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[content_size]',
		array(
			'default' => $defaults['content_size'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-content-size',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Size (Auto)', 'generate-backgrounds' ),
				'100%' => __( '100% Width', 'generate-backgrounds' ),
				'cover' => __( 'Cover', 'generate-backgrounds' ),
				'contain' => __( 'Contain', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[content_size]',
			'priority' => 2900
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[content_attachment]',
		array(
			'default' => $defaults['content_attachment'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-content-attachment',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Attachment', 'generate-backgrounds' ),
				'fixed' => __( 'Fixed', 'generate-backgrounds' ),
				'local' => __( 'Local', 'generate-backgrounds' ),
				'inherit' => __( 'Inherit', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[content_attachment]',
			'priority' => 3000
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[content_position]', array(
			'default' => $defaults['content_position'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Backgrounds_Customize_Control( 
			$wp_customize, 
			'generate_backgrounds-content-position', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[content_position]',
				'priority' => 3100,
				'label' => 'left top, x% y%, xpos ypos (px)',
				'placeholder' => __('Position','generate-backgrounds')
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-content-line',
			array(
				'section'  => 'backgrounds_section',
				'type'     => 'line',
				'priority' => 3200,
			)
		)
	);
	
	/**
	 * Sidebar widget background
	 */
	 
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-sidebar-widget-heading',
			array( 
				'section'  => 'backgrounds_section', 
				'label' => __( 'Sidebar Widgets', 'generate-backgrounds' ), 
				'type' => 'backgrounds-heading',
				'priority' => 3300
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[sidebar_widget_image]', array(
			'default' => $defaults['sidebar_widget_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Background_Upload_Control( 
			$wp_customize, 
			'generate_backgrounds-sidebar-widget-image', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[sidebar_widget_image]',
				'priority' => 3400,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[sidebar_widget_repeat]',
		array(
			'default' => $defaults['sidebar_widget_repeat'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-sidebar-widget-repeat',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Repeat', 'generate-backgrounds' ),
				'repeat-x' => __( 'Repeat x', 'generate-backgrounds' ),
				'repeat-y' => __( 'Repeat y', 'generate-backgrounds' ),
				'no-repeat' => __( 'No Repeat', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[sidebar_widget_repeat]',
			'priority' => 3500
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[sidebar_widget_size]',
		array(
			'default' => $defaults['sidebar_widget_size'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-sidebar-widget-size',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Size (Auto)', 'generate-backgrounds' ),
				'100%' => __( '100% Width', 'generate-backgrounds' ),
				'cover' => __( 'Cover', 'generate-backgrounds' ),
				'contain' => __( 'Contain', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[sidebar_widget_size]',
			'priority' => 3600
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[sidebar_widget_attachment]',
		array(
			'default' => $defaults['sidebar_widget_attachment'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-sidebar-widget-attachment',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Attachment', 'generate-backgrounds' ),
				'fixed' => __( 'Fixed', 'generate-backgrounds' ),
				'local' => __( 'Local', 'generate-backgrounds' ),
				'inherit' => __( 'Inherit', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[sidebar_widget_attachment]',
			'priority' => 3700
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[sidebar_widget_position]', array(
			'default' => $defaults['sidebar_widget_position'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Backgrounds_Customize_Control( 
			$wp_customize, 
			'generate_backgrounds-sidebar-widget-position', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[sidebar_widget_position]',
				'priority' => 3800,
				'label' => 'left top, x% y%, xpos ypos (px)',
				'placeholder' => __('Position','generate-backgrounds')
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-sidebar-widget-line',
			array(
				'section'  => 'backgrounds_section',
				'type'     => 'line',
				'priority' => 3900,
			)
		)
	);
	
	/**
	 * Footer widget background
	 */
	 
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-footer-widget-heading',
			array( 
				'section'  => 'backgrounds_section', 
				'label' => __( 'Footer Widget Area', 'generate-backgrounds' ), 
				'type' => 'backgrounds-heading',
				'priority' => 4000
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[footer_widget_image]', array(
			'default' => $defaults['footer_widget_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Background_Upload_Control( 
			$wp_customize, 
			'generate_backgrounds-footer-widget-image', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[footer_widget_image]',
				'priority' => 4100,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[footer_widget_repeat]',
		array(
			'default' => $defaults['footer_widget_repeat'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-footer-widget-repeat',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Repeat', 'generate-backgrounds' ),
				'repeat-x' => __( 'Repeat x', 'generate-backgrounds' ),
				'repeat-y' => __( 'Repeat y', 'generate-backgrounds' ),
				'no-repeat' => __( 'No Repeat', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[footer_widget_repeat]',
			'priority' => 4200
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[footer_widget_size]',
		array(
			'default' => $defaults['footer_widget_size'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-footer-widget-size',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Size (Auto)', 'generate-backgrounds' ),
				'100%' => __( '100% Width', 'generate-backgrounds' ),
				'cover' => __( 'Cover', 'generate-backgrounds' ),
				'contain' => __( 'Contain', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[footer_widget_size]',
			'priority' => 4300
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[footer_widget_attachment]',
		array(
			'default' => $defaults['footer_widget_attachment'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-footer-widget-attachment',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Attachment', 'generate-backgrounds' ),
				'fixed' => __( 'Fixed', 'generate-backgrounds' ),
				'local' => __( 'Local', 'generate-backgrounds' ),
				'inherit' => __( 'Inherit', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[footer_widget_attachment]',
			'priority' => 4400
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[footer_widget_position]', array(
			'default' => $defaults['footer_widget_position'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Backgrounds_Customize_Control( 
			$wp_customize, 
			'generate_backgrounds-footer-widget-position', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[footer_widget_position]',
				'priority' => 4500,
				'label' => 'left top, x% y%, xpos ypos (px)',
				'placeholder' => __('Position','generate-backgrounds')
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-footer-widget-line',
			array(
				'section'  => 'backgrounds_section',
				'type'     => 'line',
				'priority' => 4600,
			)
		)
	);
	
	/**
	 * Footer background
	 */
	 
	$wp_customize->add_control(
		new Generate_Backgrounds_Customize_Misc_Control(
			$wp_customize,
			'generate_backgrounds-footer-heading',
			array( 
				'section'  => 'backgrounds_section', 
				'label' => __( 'Footer Area', 'generate-backgrounds' ), 
				'type' => 'backgrounds-heading',
				'priority' => 4700
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[footer_image]', array(
			'default' => $defaults['footer_image'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Background_Upload_Control( 
			$wp_customize, 
			'generate_backgrounds-footer-image', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[footer_image]',
				'priority' => 4800,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[footer_repeat]',
		array(
			'default' => $defaults['footer_repeat'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-footer-repeat',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Repeat', 'generate-backgrounds' ),
				'repeat-x' => __( 'Repeat x', 'generate-backgrounds' ),
				'repeat-y' => __( 'Repeat y', 'generate-backgrounds' ),
				'no-repeat' => __( 'No Repeat', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[footer_repeat]',
			'priority' => 4900
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[footer_size]',
		array(
			'default' => $defaults['footer_size'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-footer-size',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Size (Auto)', 'generate-backgrounds' ),
				'100%' => __( '100% Width', 'generate-backgrounds' ),
				'cover' => __( 'Cover', 'generate-backgrounds' ),
				'contain' => __( 'Contain', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[footer_size]',
			'priority' => 5000
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[footer_attachment]',
		array(
			'default' => $defaults['footer_attachment'],
			'type' => 'option',
			//'sanitize_callback' => 'generate_sanitize_header_layout'
		)
	);
	
	$wp_customize->add_control(
		'generate_backgrounds-footer-attachment',
		array(
			'type' => 'select',
			'section' => 'backgrounds_section',
			'choices' => array(
				'' => __( 'Attachment', 'generate-backgrounds' ),
				'fixed' => __( 'Fixed', 'generate-backgrounds' ),
				'local' => __( 'Local', 'generate-backgrounds' ),
				'inherit' => __( 'Inherit', 'generate-backgrounds' )
			),
			'settings' => 'generate_background_settings[footer_attachment]',
			'priority' => 5100
		)
	);
	
	$wp_customize->add_setting(
		'generate_background_settings[footer_position]', array(
			'default' => $defaults['footer_position'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	
	$wp_customize->add_control( 
		new Generate_Backgrounds_Customize_Control( 
			$wp_customize, 
			'generate_backgrounds-footer-position', 
			array(
				'section'    => 'backgrounds_section',
				'settings'   => 'generate_background_settings[footer_position]',
				'priority' => 5200,
				'label' => 'left top, x% y%, xpos ypos (px)',
				'placeholder' => __('Position','generate-backgrounds')
			)
		)
	);
	
}
endif;

if ( ! function_exists( 'generate_backgrounds_customize_preview_css' ) ) :
add_action('customize_controls_print_styles', 'generate_backgrounds_customize_preview_css');
function generate_backgrounds_customize_preview_css() {
	//if ( get_option( 'gen_spacing_license_key_status' ) !== 'valid' )
		//return;
	?>
	<style>
		#accordion-section-backgrounds_section li {float:left;width:45%;clear:none;}
		#accordion-section-backgrounds_section li.customize-control-backgrounds-heading,
		#accordion-section-backgrounds_section li.customize-control-position,
		#accordion-section-backgrounds_section li.customize-control-line		{display:block;width:100%;clear:both;text-align:center;}
		#accordion-section-backgrounds_section .generate-upload .remove {font-size:10px;display: inline;}
		#accordion-section-backgrounds_section li.customize-control-position .small-customize-label {display:block;text-align:center;}
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-body-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-body-attachment,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-header-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-header-attachment,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-nav-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-nav-item-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-nav-item-hover-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-nav-item-current-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-sub-nav-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-sub-nav-item-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-sub-nav-item-hover-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-sub-nav-item-current-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-content-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-content-attachment,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-sidebar-widget-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-sidebar-widget-attachment,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-footer-widget-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-footer-widget-attachment,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-footer-repeat,
		#accordion-section-backgrounds_section li#customize-control-generate_backgrounds-footer-attachment {
			float:right;
		}
		
		#accordion-section-backgrounds_section .customize-section-description-container {
			width: 100%;
			float: none;
		}
		
		.customize-control-backgrounds-heading {
			border-top: 1px solid #ddd;
			padding-top: 15px;
			margin-top: 15px;
		}
		
		#customize-control-generate_backgrounds-header.customize-control-backgrounds-heading {
			border: 0;
			padding: 0;
			margin: 0;
		}
	</style>
	<?php
}
endif;
/**
 * Generate the CSS in the <head> section using the Theme Customizer
 * @since 0.1
 */
if ( !function_exists( 'generate_backgrounds_css' ) ) :
	function generate_backgrounds_css()
	{
		
		$generate_settings = wp_parse_args( 
			get_option( 'generate_background_settings', array() ), 
			generate_get_background_defaults() 
		);
		$space = ' ';

		// Start the magic
		$visual_css = array (
		
			// Body
			'body' => array(
				'background-image' => !empty( $generate_settings['body_image'] ) ? 'url(' . $generate_settings['body_image'] . ')' : '',
				'background-repeat' => $generate_settings['body_repeat'],
				'background-size' => $generate_settings['body_size'],
				'background-attachment' => $generate_settings['body_attachment'],
				'background-position' => $generate_settings['body_position']
			),
			
			// Header
			'.site-header' => array(
				'background-image' => !empty( $generate_settings['header_image'] ) ? 'url(' . $generate_settings['header_image'] . ')' : '',
				'background-repeat' => $generate_settings['header_repeat'],
				'background-size' => $generate_settings['header_size'],
				'background-attachment' => $generate_settings['header_attachment'],
				'background-position' => $generate_settings['header_position']
			),
			
			// Navigation background
			'.main-navigation,
			.menu-toggle' => array(
				'background-image' => !empty( $generate_settings['nav_image'] ) ? 'url(' . $generate_settings['nav_image'] . ')' : '',
				'background-repeat' => $generate_settings['nav_repeat']
			),
			
			// Navigation item background
			'.main-navigation .main-nav > ul > li > a' => array(
				'background-image' => !empty( $generate_settings['nav_item_image'] ) ? 'url(' . $generate_settings['nav_item_image'] . ')' : '',
				'background-repeat' => $generate_settings['nav_item_repeat']
			),
			
			// Navigation background/text on hover
			'.main-navigation .main-nav > ul > li > a:hover, 
			.main-navigation .main-nav > ul > li.sfHover > a' => array(
				'background-image' => !empty( $generate_settings['nav_item_hover_image'] ) ? 'url(' . $generate_settings['nav_item_hover_image'] . ')' : '',
				'background-repeat' => $generate_settings['nav_item_hover_repeat']
			),
			
			// Navigation background / text current
			'.main-navigation .main-nav > ul > .current-menu-item > a, 
			.main-navigation .main-nav > ul > .current-menu-parent > a, 
			.main-navigation .main-nav > ul > .current-menu-ancestor > a' => array(
				'background-image' => !empty( $generate_settings['nav_item_current_image'] ) ? 'url(' . $generate_settings['nav_item_current_image'] . ')' : '',
				'background-repeat' => $generate_settings['nav_item_current_repeat']
			),
			
			// Navigation background text current text hover
			'.main-navigation .main-nav > ul > .current-menu-item > a:hover, 
			.main-navigation .main-nav > ul > .current-menu-parent > a:hover, 
			.main-navigation .main-nav > ul > .current-menu-ancestor > a:hover, 
			.main-navigation .main-nav > ul > .current-menu-item.sfHover > a, 
			.main-navigation .main-nav > ul > .current-menu-parent.sfHover > a, 
			.main-navigation .main-nav > ul > .current-menu-ancestor.sfHover > a' => array(
				'background-image' => !empty( $generate_settings['nav_item_current_image'] ) ? 'url(' . $generate_settings['nav_item_current_image'] . ')' : '',
				'background-repeat' => $generate_settings['nav_item_current_repeat']
			),
			
			// Sub-Navigation text
			'.main-navigation ul ul li a' => array(
				'background-image' => !empty( $generate_settings['sub_nav_item_image'] ) ? 'url(' . $generate_settings['sub_nav_item_image'] . ')' : '',
				'background-repeat' => $generate_settings['sub_nav_item_repeat']
			),
			
			// Sub-Navigation background/text on hover
			'.main-navigation ul ul li > a:hover, 
			.main-navigation ul ul li.sfHover > a' => array(
				'background-image' => !empty( $generate_settings['sub_nav_item_hover_image'] ) ? 'url(' . $generate_settings['sub_nav_item_hover_image'] . ')' : '',
				'background-repeat' => $generate_settings['sub_nav_item_hover_repeat']
			),
			
			// Sub-Navigation background / text current
			'.main-navigation ul ul .current-menu-item > a, 
			.main-navigation ul ul .current-menu-parent > a, 
			.main-navigation ul ul .current-menu-ancestor > a' => array(
				'background-image' => !empty( $generate_settings['sub_nav_item_current_image'] ) ? 'url(' . $generate_settings['sub_nav_item_current_image'] . ')' : '',
				'background-repeat' => $generate_settings['sub_nav_item_current_repeat']
			),
			
			// Sub-Navigation current background / text current
			'.main-navigation ul ul .current-menu-item > a:hover, 
			.main-navigation ul ul .current-menu-parent > a:hover, 
			.main-navigation ul ul .current-menu-ancestor > a:hover,
			.main-navigation ul ul .current-menu-item.sfHover > a, 
			.main-navigation ul ul .current-menu-parent.sfHover > a, 
			.main-navigation ul ul .current-menu-ancestor.sfHover > a' => array(
				'background-image' => !empty( $generate_settings['sub_nav_item_current_image'] ) ? 'url(' . $generate_settings['sub_nav_item_current_image'] . ')' : '',
				'background-repeat' => $generate_settings['sub_nav_item_current_repeat']
			),

			// Content
			'.separate-containers .inside-article, 
			.separate-containers .comments-area, 
			.separate-containers .page-header,
			.one-container .container,
			.separate-containers .paging-navigation,
			.separate-containers .inside-page-header' => array(
				'background-image' => !empty( $generate_settings['content_image'] ) ? 'url(' . $generate_settings['content_image'] . ')' : '',
				'background-repeat' => $generate_settings['content_repeat'],
				'background-size' => $generate_settings['content_size'],
				'background-attachment' => $generate_settings['content_attachment'],
				'background-position' => $generate_settings['content_position']
			),
			
			// Sidebar widget
			'.sidebar .widget' => array(
				'background-image' => !empty( $generate_settings['sidebar_widget_image'] ) ? 'url(' . $generate_settings['sidebar_widget_image'] . ')' : '',
				'background-repeat' => $generate_settings['sidebar_widget_repeat'],
				'background-size' => $generate_settings['sidebar_widget_size'],
				'background-attachment' => $generate_settings['sidebar_widget_attachment'],
				'background-position' => $generate_settings['sidebar_widget_position']
			),
			
			// Footer widget
			'.footer-widgets' => array(
				'background-image' => !empty( $generate_settings['footer_widget_image'] ) ? 'url(' . $generate_settings['footer_widget_image'] . ')' : '',
				'background-repeat' => $generate_settings['footer_widget_repeat'],
				'background-size' => $generate_settings['footer_widget_size'],
				'background-attachment' => $generate_settings['footer_widget_attachment'],
				'background-position' => $generate_settings['footer_widget_position']
			),
			
			// Footer
			'.site-info' => array(
				'background-image' => !empty( $generate_settings['footer_image'] ) ? 'url(' . $generate_settings['footer_image'] . ')' : '',
				'background-repeat' => $generate_settings['footer_repeat'],
				'background-size' => $generate_settings['footer_size'],
				'background-attachment' => $generate_settings['footer_attachment'],
				'background-position' => $generate_settings['footer_position']
			),
			
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
		
		$output = str_replace(array("\r", "\n", "\t"), '', $output);
		return $output;
	}
	
	/**
	 * Enqueue scripts and styles
	 */
	add_action( 'wp_enqueue_scripts', 'generate_background_scripts', 70 );
	function generate_background_scripts() {

		wp_add_inline_style( 'generate-style', generate_backgrounds_css() );
	
	}
endif;
<?php
/**
 * Set default options
 */
if ( !function_exists('generate_spacing_get_defaults') ) :
	function generate_spacing_get_defaults()
	{
		$generate_spacing_defaults = array(
			'header_top' => '40',
			'header_right' => '40',
			'header_bottom' => '40',
			'header_left' => '40',
			'menu_item' => '20',
			'menu_item_height' => '60',
			'sub_menu_item_height' => '10',
			'content_top' => '40',
			'content_right' => '40',
			'content_bottom' => '40',
			'content_left' => '40',
			'separator' => '20',
			'left_sidebar_width' => '25',
			'right_sidebar_width' => '25',
			'widget_top' => '40',
			'widget_right' => '40',
			'widget_bottom' => '40',
			'widget_left' => '40',
			'footer_widget_container_top' => '40',
			'footer_widget_container_right' => '0',
			'footer_widget_container_bottom' => '40',
			'footer_widget_container_left' => '0',
			'footer_top' => '20',
			'footer_right' => '0',
			'footer_bottom' => '20',
			'footer_left' => '0',
		);
		
		return apply_filters( 'generate_spacing_option_defaults', $generate_spacing_defaults );
	}
endif;

if ( ! function_exists( 'generate_spacing_customize_register' ) ) :
add_action( 'customize_register', 'generate_spacing_customize_register', 99 );
function generate_spacing_customize_register( $wp_customize ) {

	$wp_customize->add_setting('generate_spacing_headings');

	$dir = plugin_dir_path( __FILE__ );
	require_once $dir . 'controls.php';

	$defaults = generate_spacing_get_defaults();

	// Add Header Colors section
	$wp_customize->add_section(
		// ID
		'spacing_section',
		// Arguments array
		array(
			'title' => __( 'Element Spacing', 'generate-spacing' ),
			'capability' => 'edit_theme_options',
			'priority' => 50,
			'description' => __( 'Change the spacing for various elements using pixels.', 'generate-spacing' )
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_spacing-top-line',
			array(
				'section'  => 'spacing_section',
				'type'     => 'line',
				'priority' => 0,
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_header-heading',
			array(
				'section'  => 'spacing_section',
				'label'    => __( 'Header', 'generate-spacing' ),
				'areas'  => array(
					'top'  => __('Top', 'generate-spacing' ),
					'right' => __('Right', 'generate-spacing' ),
					'bottom' => __('Bottom', 'generate-spacing' ),
					'left' => __('Left', 'generate-spacing' ),
				),
				'type'     => 'spacing-heading',
				'priority' => 1,
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_content_line-heading',
			array(
				'section'  => 'spacing_section',
				'type'     => 'line',
				'priority' => 69,
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_content-heading',
			array(
				'section'  => 'spacing_section',
				'label'    => __( 'Content', 'generate-spacing' ),
				'areas'  => array(
					'top'  => __('Top', 'generate-spacing' ),
					'right' => __('Right', 'generate-spacing' ),
					'bottom' => __('Bottom', 'generate-spacing' ),
					'left' => __('Left', 'generate-spacing' ),
				),
				'type'     => 'spacing-heading',
				'priority' => 70,
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_widget_line-heading',
			array(
				'section'  => 'spacing_section',
				'type'     => 'line',
				'priority' => 149,
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_widget-heading',
			array(
				'section'  => 'spacing_section',
				'label'    => __( 'Sidebar Widgets', 'generate-spacing' ),
				'areas'  => array(
					'top'  => __('Top', 'generate-spacing' ),
					'right' => __('Right', 'generate-spacing' ),
					'bottom' => __('Bottom', 'generate-spacing' ),
					'left' => __('Left', 'generate-spacing' ),
				),
				'type'     => 'spacing-heading',
				'priority' => 153,
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_footer_widget_line-heading',
			array(
				'section'  => 'spacing_section',
				'type'     => 'line',
				'priority' => 229,
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_footer_widget-heading',
			array(
				'section'  => 'spacing_section',
				'label'    => __( 'Footer Widget Area', 'generate-spacing' ),
				'areas'  => array(
					'top'  => __('Top', 'generate-spacing' ),
					'right' => __('Right', 'generate-spacing' ),
					'bottom' => __('Bottom', 'generate-spacing' ),
					'left' => __('Left', 'generate-spacing' ),
				),
				'type'     => 'spacing-heading',
				'priority' => 230,
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_footer_line-heading',
			array(
				'section'  => 'spacing_section',
				'type'     => 'line',
				'priority' => 309,
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_footer-heading',
			array(
				'section'  => 'spacing_section',
				'label'    => __( 'Footer', 'generate-spacing' ),
				'areas'  => array(
					'top'  => __('Top', 'generate-spacing' ),
					'right' => __('Right', 'generate-spacing' ),
					'bottom' => __('Bottom', 'generate-spacing' ),
					'left' => __('Left', 'generate-spacing' ),
				),
				'type'     => 'spacing-heading',
				'priority' => 310,
			)
		)
	);

	$spacing = array();
	$spacing[] = array(
		'slug' => 'header_top', 
		'default' => $defaults['header_top'],
		//'label' => __('Background', 'generate_spacing'),
		'priority' => 2
	);
	$spacing[] = array(
		'slug' => 'header_right', 
		'default' => $defaults['header_right'],
		//'label' => __('Text', 'generate_spacing'),
		'priority' => 20
	);
	$spacing[] = array(
		'slug' => 'header_bottom', 
		'default' => $defaults['header_bottom'],
		//'label' => __('Link', 'generate_spacing'),
		'priority' => 40
	);
	$spacing[] = array(
		'slug' => 'header_left', 
		'default' => $defaults['header_left'],
		//'label' => __('Link Hover', 'generate_spacing'),
		'priority' => 60
	);
	$spacing[] = array(
		'slug' => 'content_top', 
		'default' => $defaults['content_top'],
		//'label' => __('Site Title', 'generate_spacing'),
		'priority' => 80
	);
	$spacing[] = array(
		'slug' => 'content_right', 
		'default' => $defaults['content_right'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 100
	);
	$spacing[] = array(
		'slug' => 'content_bottom', 
		'default' => $defaults['content_bottom'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 120
	);
	$spacing[] = array(
		'slug' => 'content_left', 
		'default' => $defaults['content_left'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 140
	);
	$spacing[] = array(
		'slug' => 'widget_top', 
		'default' => $defaults['widget_top'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 160
	);
	$spacing[] = array(
		'slug' => 'widget_right', 
		'default' => $defaults['widget_right'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 180
	);
	$spacing[] = array(
		'slug' => 'widget_bottom', 
		'default' => $defaults['widget_bottom'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 200
	);
	$spacing[] = array(
		'slug' => 'widget_left', 
		'default' => $defaults['widget_left'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 220
	);
	$spacing[] = array(
		'slug' => 'footer_widget_container_top', 
		'default' => $defaults['footer_widget_container_top'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 240
	);
	$spacing[] = array(
		'slug' => 'footer_widget_container_right', 
		'default' => $defaults['footer_widget_container_right'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 260
	);
	$spacing[] = array(
		'slug' => 'footer_widget_container_bottom', 
		'default' => $defaults['footer_widget_container_bottom'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 280
	);
	$spacing[] = array(
		'slug' => 'footer_widget_container_left', 
		'default' => $defaults['footer_widget_container_left'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 300
	);
	$spacing[] = array(
		'slug' => 'footer_top', 
		'default' => $defaults['footer_top'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 320
	);
	$spacing[] = array(
		'slug' => 'footer_right', 
		'default' => $defaults['footer_right'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 340
	);
	$spacing[] = array(
		'slug' => 'footer_bottom', 
		'default' => $defaults['footer_bottom'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 360
	);
	$spacing[] = array(
		'slug' => 'footer_left', 
		'default' => $defaults['footer_left'],
		//'label' => __('Tagline', 'generate_spacing'),
		'priority' => 380
	);
	
	foreach( $spacing as $pad ) {
		// SETTINGS
		$wp_customize->add_setting(
			'generate_spacing_settings[' . $pad['slug'] . ']', array(
				'default' => $pad['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new Generate_Spacing_Customize_Control(
				$wp_customize,
				'generate_spacing_settings[' . $pad['slug'] . ']', 
				array(
					'label' => '', 
					'section' => 'spacing_section',
					'settings' => 'generate_spacing_settings[' . $pad['slug'] . ']',
					'priority' => $pad['priority']
				)
			)
		);
	}
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_separator_line-heading',
			array(
				'section'  => 'spacing_section',
				'type'     => 'line',
				'priority' => 142,
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_separator-heading',
			array(
				'section'  => 'spacing_section',
				'label'    => __( 'Separating Space', 'generate-spacing' ),
				'description' => __( 'The spacing between elements when "Content Layout" is set to "Separate Containers".', 'generate-spacing' ),
				'type'     => 'spacing-heading',
				'priority' => 143,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_spacing_settings[separator]', array(
			'default' => $defaults['separator'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	// CONTROLS
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Control(
			$wp_customize,
			'generate_spacing_settings[separator]', 
			array(
				'label' => '', 
				'section' => 'spacing_section',
				'settings' => 'generate_spacing_settings[separator]',
				'priority' => 144
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_menu_item_line-heading',
			array(
				'section'  => 'spacing_section',
				'type'     => 'line',
				'priority' => 145,
			)
		)
	);
	
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_menu_item-heading',
			array(
				'section'  => 'spacing_section',
				'label'    => __( 'Primary Menu Items', 'generate-spacing' ),
				'description' => __( 'These options control the size of your menu items.', 'generate-spacing' ),
				'type'     => 'spacing-heading',
				'priority' => 146,
				'areas'  => array(
					'left_right'  => __('Left/Right Spacing', 'generate-spacing' ),
					'height' => __('Height', 'generate-spacing' )
				),
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_spacing_settings[menu_item]', array(
			'default' => $defaults['menu_item'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	// CONTROLS
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Control(
			$wp_customize,
			'generate_spacing_settings[menu_item]', 
			array(
				'label' => '', 
				'section' => 'spacing_section',
				'settings' => 'generate_spacing_settings[menu_item]',
				'priority' => 147
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_spacing_settings[menu_item_height]', array(
			'default' => $defaults['menu_item_height'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	// CONTROLS
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Control(
			$wp_customize,
			'generate_spacing_settings[menu_item_height]', 
			array(
				'label' => '', 
				'section' => 'spacing_section',
				'settings' => 'generate_spacing_settings[menu_item_height]',
				'priority' => 148
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_submenu-spacing_line-heading',
			array(
				'section'  => 'spacing_section',
				'type'     => 'line',
				'priority' => 152,
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_submenu-spacing-heading',
			array(
				'section'  => 'spacing_section',
				'label'    => __( 'Sub-menu Item Height', 'generate-spacing' ),
				'description' => __( 'The top and bottom spacing of sub-menu items.', 'generate-spacing' ),
				'type'     => 'spacing-heading',
				'priority' => 150,
			)
		)
	);
	
	$wp_customize->add_setting(
		'generate_spacing_settings[sub_menu_item_height]', array(
			'default' => $defaults['sub_menu_item_height'],
			'type' => 'option', 
			'capability' => 'edit_theme_options'
		)
	);
	// CONTROLS
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Control(
			$wp_customize,
			'generate_spacing_settings[sub_menu_item_height]', 
			array(
				'label' => '', 
				'section' => 'spacing_section',
				'settings' => 'generate_spacing_settings[sub_menu_item_height]',
				'priority' => 151
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_spacing-sidebar-line',
			array(
				'section'  => 'spacing_section',
				'type'     => 'line',
				'priority' => 480,
			)
		)
	);
	
	$wp_customize->add_control(
		new Generate_Spacing_Customize_Misc_Control(
			$wp_customize,
			'generate_sidebar-heading',
			array(
				'section'  => 'spacing_section',
				'label'    => __( 'Sidebar Widths', 'generate-spacing' ),
				'type'     => 'spacing-heading',
				'priority' => 485,
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
			'type' => 'option'
		)
	);
	
	
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_spacing_settings[left_sidebar_width]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Left Sidebar', 'generate-spacing' ),
			'section' => 'spacing_section',
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
			'priority' => 490
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_spacing_settings[right_sidebar_width]',
		// Arguments array
		array(
			'default' => $defaults['right_sidebar_width'],
			'type' => 'option'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'generate_spacing_settings[right_sidebar_width]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Right Sidebar', 'generate-spacing' ),
			'section' => 'spacing_section',
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
			'priority' => 500
		)
	);
	

}
endif;

if ( ! function_exists( 'generate_spacing_customize_preview_css' ) ) :
add_action('customize_controls_print_styles', 'generate_spacing_customize_preview_css');
function generate_spacing_customize_preview_css() {

	?>
	<style>
		.customize-control.customize-control-spacing {display: inline-block;width:25%;clear:none;text-align:center}
		.spacing-area {display: inline-block;width:25%;clear:none;text-align:center;position:relative;bottom:-5px;font-size:11px;font-weight:bold;}
		.customize-control-title.spacing-title {margin-bottom:0;}
		.customize-control.customize-control-spacing-heading {margin-bottom:0px;text-align:center;}
		.customize-control.customize-control-line {margin:8px 0;}
		#customize-control-generate_spacing_settings-separator,
		#customize-control-generate_spacing_settings-sub_menu_item_height {width:100%;}
		#customize-control-generate_spacing_settings-menu_item,
		#customize-control-generate_spacing_settings-menu_item_height,
		#customize-control-generate_menu_item-heading .spacing-area
		{
			width: 50%;
		}
		#customize-control-generate_spacing_settings-left_sidebar_width,
		#customize-control-generate_spacing_settings-right_sidebar_width {
			width: 49%;
			float: left;
			clear: none;
		}
		#customize-control-generate_spacing_settings-left_sidebar_width select,
		#customize-control-generate_spacing_settings-right_sidebar_width select {
			width: 90%;
		}
		
		#customize-control-generate_sidebar-heading {
			margin-bottom:10px;
		}
		#customize-control-generate_spacing_settings-right_sidebar_width {
			text-align:right;
		}
		
		.customize-control-title.spacing-title {
			border-top: 1px solid #ddd;
			padding-top: 15px;
			margin-top: 15px;
		}
	</style>
	<?php
}
endif;

/**
 * Generate the CSS in the <head> section using the Theme Customizer
 * @since 0.1
 */
if ( !function_exists('generate_spacing_css') ) :
	function generate_spacing_css()
	{
		
		$spacing_settings = wp_parse_args( 
			get_option( 'generate_spacing_settings', array() ), 
			generate_spacing_get_defaults() 
		);
		$space = ' ';
		// Start the magic
		$spacing_css = array (
		
			'.inside-header' => array(
				'padding' => generate_padding_css( $spacing_settings[ 'header_top' ], $spacing_settings[ 'header_right' ], $spacing_settings[ 'header_bottom' ], $spacing_settings[ 'header_left' ] )
			),
			
			'.separate-containers .inside-article, .separate-containers .comments-area, .separate-containers .page-header, .separate-containers .paging-navigation, .one-container .site-content' => array(
				'padding' => generate_padding_css( $spacing_settings[ 'content_top' ], $spacing_settings[ 'content_right' ], $spacing_settings[ 'content_bottom' ], $spacing_settings[ 'content_left' ] )
			),
			
			'.one-container.right-sidebar .site-main,
			.one-container.both-right .site-main' => array(
				'margin-right' => ( isset( $spacing_settings['content_right'] ) ) ? $spacing_settings['content_right'] . 'px' : null,
			),
			
			'.one-container.left-sidebar .site-main,
			.one-container.both-left .site-main' => array(
				'margin-left' => ( isset( $spacing_settings['content_left'] ) ) ? $spacing_settings['content_left'] . 'px' : null,
			),
			
			'.one-container.both-sidebars .site-main' => array(
				'margin' => generate_padding_css( '0', $spacing_settings[ 'content_right' ], '0', $spacing_settings[ 'content_left' ] )
			),
			
			'.ignore-x-spacing' => array(
				'margin-right' => ( isset( $spacing_settings['content_right'] ) ) ? '-' . $spacing_settings['content_right'] . 'px' : null,
				'margin-bottom' => ( isset( $spacing_settings['content_bottom'] ) ) ? $spacing_settings['content_bottom'] . 'px' : null,
				'margin-left' => ( isset( $spacing_settings['content_left'] ) ) ? '-' . $spacing_settings['content_left'] . 'px' : null,
			),
			
			'.ignore-xy-spacing' => array(
				'margin' => generate_padding_css( '-' . $spacing_settings[ 'content_top' ], '-' . $spacing_settings[ 'content_right' ], $spacing_settings[ 'content_bottom' ], '-' . $spacing_settings[ 'content_left' ] )
			),
			
			'.main-navigation .main-nav ul li a,
			.menu-toggle,
			.main-navigation .mobile-bar-items a' => array(
				'padding-left' => ( isset( $spacing_settings['menu_item'] ) ) ? $spacing_settings['menu_item'] . 'px' : null,
				'padding-right' => ( isset( $spacing_settings['menu_item'] ) ) ? $spacing_settings['menu_item'] . 'px' : null,
				'line-height' => ( isset( $spacing_settings['menu_item_height'] ) ) ? $spacing_settings['menu_item_height'] . 'px' : null,
			),
			
			'.nav-float-right .main-navigation .main-nav ul li a' => array(
				'line-height' => ( isset( $spacing_settings['menu_item_height'] ) ) ? $spacing_settings['menu_item_height'] . 'px' : null,
			),
			
			'.main-navigation .main-nav ul ul li a' => array(
				'padding' => generate_padding_css( $spacing_settings[ 'sub_menu_item_height' ], $spacing_settings[ 'menu_item' ], $spacing_settings[ 'sub_menu_item_height' ], $spacing_settings[ 'menu_item' ] )
			),
			
			'.main-navigation ul ul' => array(
				'top' => ( isset( $spacing_settings['menu_item_height'] ) ) ? $spacing_settings['menu_item_height'] . 'px' : null
			),
			
			'.navigation-search' => array(
				'height' => ( isset( $spacing_settings['menu_item_height'] ) ) ? $spacing_settings['menu_item_height'] . 'px' : null,
				'line-height' => '0px'
			),
			
			'.navigation-search input' => array(
				'height' => ( isset( $spacing_settings['menu_item_height'] ) ) ? $spacing_settings['menu_item_height'] . 'px' : null,
				'line-height' => '0px'
			),
			
			'.widget-area .widget' => array(
				'padding' => generate_padding_css( $spacing_settings[ 'widget_top' ], $spacing_settings[ 'widget_right' ], $spacing_settings[ 'widget_bottom' ], $spacing_settings[ 'widget_left' ] )
			),
			
			'.footer-widgets' => array(
				'padding' => generate_padding_css( $spacing_settings[ 'footer_widget_container_top' ], $spacing_settings[ 'footer_widget_container_right' ], $spacing_settings[ 'footer_widget_container_bottom' ], $spacing_settings[ 'footer_widget_container_left' ] )
			),
			
			'.site-info' => array(
				'padding' => generate_padding_css( $spacing_settings[ 'footer_top' ], $spacing_settings[ 'footer_right' ], $spacing_settings[ 'footer_bottom' ], $spacing_settings[ 'footer_left' ] )
			),
			
			'.right-sidebar.separate-containers .site-main' => array(
				'margin' => generate_padding_css( $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ], '0' ),
			),
			
			'.left-sidebar.separate-containers .site-main' => array(
				'margin' => generate_padding_css( $spacing_settings[ 'separator' ], '0', $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ] ),
			),
			
			'.both-sidebars.separate-containers .site-main' => array(
				'margin' => ( isset( $spacing_settings['separator'] ) ) ? $spacing_settings['separator'] . 'px' : null,
			),
			
			'.both-right.separate-containers .site-main' => array(
				'margin' => generate_padding_css( $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ], '0' ),
			),
			
			'.separate-containers .site-main' => array(
				'margin-top' => ( isset( $spacing_settings['separator'] ) ) ? $spacing_settings['separator'] . 'px' : null,
				'margin-bottom' => ( isset( $spacing_settings['separator'] ) ) ? $spacing_settings['separator'] . 'px' : null,
			),
			
			'.separate-containers .page-header-image, .separate-containers .page-header-content, .separate-containers .page-header-image-single, .separate-containers .page-header-content-single' => array(
				'margin-top' => ( isset( $spacing_settings['separator'] ) ) ? $spacing_settings['separator'] . 'px' : null,
			),
			
			'.both-left.separate-containers .site-main' => array(
				'margin' => generate_padding_css( $spacing_settings[ 'separator' ], '0', $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ] ),
			),
			
			'.separate-containers .inside-right-sidebar, .inside-left-sidebar' => array(
				'margin-top' => ( isset( $spacing_settings['separator'] ) ) ? $spacing_settings['separator'] . 'px' : null,
				'margin-bottom' => ( isset( $spacing_settings['separator'] ) ) ? $spacing_settings['separator'] . 'px' : null,
			),
			
			'.separate-containers .widget, .separate-containers .hentry, .separate-containers .page-header, .widget-area .main-navigation' => array(
				'margin-bottom' => ( isset( $spacing_settings['separator'] ) ) ? $spacing_settings['separator'] . 'px' : null,
			),
			
			'.both-left.separate-containers .inside-left-sidebar' => array(
				'margin-right' => ( isset( $spacing_settings['separator'] ) ) ? $spacing_settings['separator'] / 2 . 'px' : null,
			),
			
			'.both-left.separate-containers .inside-right-sidebar' => array(
				'margin-left' => ( isset( $spacing_settings['separator'] ) ) ? $spacing_settings['separator'] / 2 . 'px' : null,
			),
			
			'.both-right.separate-containers .inside-left-sidebar' => array(
				'margin-right' => ( isset( $spacing_settings['separator'] ) ) ? $spacing_settings['separator'] / 2 . 'px' : null,
			),

			'.both-right.separate-containers .inside-right-sidebar' => array(
				'margin-left' => ( isset( $spacing_settings['separator'] ) ) ? $spacing_settings['separator'] / 2 . 'px' : null,
			),
			
			'.menu-item-has-children ul .dropdown-menu-toggle' => array (
				'padding-top' => ( isset( $spacing_settings[ 'sub_menu_item_height' ] ) ) ? $spacing_settings[ 'sub_menu_item_height' ] . 'px' : null,
				'padding-bottom' => ( isset( $spacing_settings[ 'sub_menu_item_height' ] ) ) ? $spacing_settings[ 'sub_menu_item_height' ] . 'px' : null,
				'margin-top' => ( isset( $spacing_settings[ 'sub_menu_item_height' ] ) ) ? '-' . $spacing_settings[ 'sub_menu_item_height' ] . 'px' : null,
			),
			
			'.menu-item-has-children .dropdown-menu-toggle' => array(
				'padding-right' => ( isset( $spacing_settings['menu_item'] ) ) ? $spacing_settings['menu_item'] . 'px' : null,
			)
			
		);
		
		// Output the above CSS
		$output = '';
		foreach($spacing_css as $k => $properties) {
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
		
		// Set up defaults in case they deactivate GeneratePress
		if ( function_exists( 'generate_get_color_defaults' ) ) :
			$generate_settings = wp_parse_args( 
				get_option( 'generate_settings', array() ), 
				generate_get_color_defaults() 
			);
		else :
			$generate_settings['sidebar_widget_background_color'] = '#FFFFFF';
			$generate_settings['content_background_color'] = '#FFFFFF';
		endif;
		
		// Find out if the content background color and sidebar widget background color is the same
		$colors_match = false;
		$sidebar = strtoupper( $generate_settings['sidebar_widget_background_color'] );
		$content = strtoupper( $generate_settings['content_background_color'] );
		if ( ( $sidebar == $content ) || '' == $sidebar ) :
			$colors_match = true;
		endif;
		
		// Put all of our widget padding into an array
		$widget_padding = array(
			$spacing_settings[ 'widget_top' ], 
			$spacing_settings[ 'widget_right' ], 
			$spacing_settings[ 'widget_bottom' ], 
			$spacing_settings[ 'widget_left' ]
		);
		
		// If they're all 40 (default), remove the padding when one container is set
		// This way, the user can still adjust the padding and it will work (unless they want 40px padding)
		// We'll also remove the padding if there's no color difference between the widgets and content background color
		if ( count( array_unique( $widget_padding ) ) === 1 && end( $widget_padding ) === '40' && $colors_match ) {
			$output .= '.one-container .sidebar .widget{padding:0px;}';
		}

		$output = str_replace(array("\r", "\n", "\t"), '', $output);
		return $output; 
	}
	
	/**
	 * Enqueue scripts and styles
	 */
	add_action( 'wp_enqueue_scripts', 'generate_spacing_scripts', 50 );
	function generate_spacing_scripts() {

		wp_add_inline_style( 'generate-style', generate_spacing_css() );
	
	}
endif;

if ( ! function_exists( 'generate_right_sidebar_width' ) ) :
	add_filter( 'generate_right_sidebar_width', 'generate_right_sidebar_width' );
	function generate_right_sidebar_width()
	{
		$spacing_settings = wp_parse_args( 
			get_option( 'generate_spacing_settings', array() ), 
			generate_spacing_get_defaults() 
		);
		
		return $spacing_settings['right_sidebar_width'];
	}
endif;

if ( ! function_exists( 'generate_left_sidebar_width' ) ) :
	add_filter( 'generate_left_sidebar_width', 'generate_left_sidebar_width' );
	function generate_left_sidebar_width()
	{
		$spacing_settings = wp_parse_args( 
			get_option( 'generate_spacing_settings', array() ), 
			generate_spacing_get_defaults() 
		);
		
		return $spacing_settings['left_sidebar_width'];
	}
endif;

if ( ! function_exists( 'generate_padding_css' ) ) :
function generate_padding_css( $top, $right, $bottom, $left )
{
	$padding_top = ( isset( $top ) && '' !== $top ) ? $top . 'px ' : '0px ';
	$padding_right = ( isset( $right ) && '' !== $right ) ? $right . 'px ' : '0px ';
	$padding_bottom = ( isset( $bottom ) && '' !== $bottom ) ? $bottom . 'px ' : '0px ';
	$padding_left = ( isset( $left ) && '' !== $left ) ? $left . 'px' : '0px';
	
	return $padding_top . $padding_right . $padding_bottom . $padding_left;
}
endif;
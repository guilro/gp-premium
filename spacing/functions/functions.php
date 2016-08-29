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

	require_once plugin_dir_path( __FILE__ ) . 'controls.php';

	$defaults = generate_spacing_get_defaults();
	
	if ( class_exists( 'WP_Customize_Panel' ) ) :
		if ( ! $wp_customize->get_panel( 'generate_spacing_panel' ) ) {
			$wp_customize->add_panel( 'generate_spacing_panel', array(
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Spacing','generate-spacing' ),
				'description'    => __( 'Change the spacing for various elements using pixels.', 'generate-spacing' ),
				'priority'		 => 35
			) );
		}
	endif;
	
	
	// Include header spacing
	require_once plugin_dir_path( __FILE__ ) . 'header-spacing.php';
	
	// Include content spacing
	require_once plugin_dir_path( __FILE__ ) . 'content-spacing.php';
	
	// Include widget spacing
	require_once plugin_dir_path( __FILE__ ) . 'sidebar-spacing.php';
	
	// Include navigation spacing
	require_once plugin_dir_path( __FILE__ ) . 'navigation-spacing.php';
	
	// Include footer spacing
	require_once plugin_dir_path( __FILE__ ) . 'footer-spacing.php';
	
}
endif;

if ( ! function_exists( 'generate_spacing_customize_preview_css' ) ) :
add_action('customize_controls_print_styles', 'generate_spacing_customize_preview_css');
function generate_spacing_customize_preview_css() {

	?>
	<style>
		.customize-control.customize-control-spacing {display: inline-block;width:25%;clear:none;text-align:center}
		.customize-control.customize-control-spacing label {text-align:left}
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
		
		#customize-control-generate_sidebar-heading {
			margin-bottom:10px;
		}
		
		/*.customize-control-title.spacing-title {
			border-top: 1px solid #ddd;
			padding-top: 15px;
			margin-top: 15px;
		}*/
		
		#customize-control-generate_widget-heading .spacing-title,
		#customize-control-generate_header-heading .spacing-title,
		#customize-control-generate_content-heading .spacing-title, 
		#customize-control-generate_menu_item-heading .spacing-title, 
		#customize-control-generate_footer_widget-heading .spacing-title,
		#customize-control-generate_secondary_menu_item-heading .spacing-title {
			margin-top: 0;
			padding-top: 0;
			border: 0;
		}
		
		#customize-control-generate_header_spacing_title,
		#customize-control-generate_content_spacing_title,
		#customize-control-generate_widget_spacing_title,
		#customize-control-generate_content_separating_space,
		#customize-control-generate_navigation_spacing_title,
		#customize-control-generate_sub_navigation_spacing_title,
		#customize-control-generate_secondary_navigation_spacing_title,
		#customize-control-generate_footer_widget_spacing_title, 
		#customize-control-generate_footer_spacing_title {
			margin-bottom: 0;
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
				'padding-right' => ( isset( $spacing_settings['menu_item'] ) && ! is_rtl() ) ? $spacing_settings['menu_item'] . 'px' : null,
				'padding-right' => ( isset( $spacing_settings['menu_item'] ) && is_rtl() ) ? $spacing_settings['menu_item'] . 'px' : null,
			),
			
			'.main-navigation .main-nav ul li.menu-item-has-children > a' => array(
				'padding-right' => ( is_rtl() ) ? $spacing_settings['menu_item'] . 'px' : null
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

if ( ! function_exists( 'generate_spacing_sanitize_choices' ) ) :
/**
 * Sanitize choices
 */
function generate_spacing_sanitize_choices( $input, $setting ) {
	
	// Ensure input is a slug
	$input = sanitize_key( $input );
	
	// Get list of choices from the control
	// associated with the setting
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it;
	// otherwise, return the default
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;
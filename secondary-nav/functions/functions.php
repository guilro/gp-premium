<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'after_setup_theme', 'generate_secondary_nav_setup' );
if ( ! function_exists( 'generate_secondary_nav_setup' ) ) :
	function generate_secondary_nav_setup() {

		register_nav_menus( array(
			'secondary' => __( 'Secondary Menu','secondary-nav' ),
		) );

	}
endif; // generate_secondary_nav_setup

if ( ! function_exists( 'generate_secondary_nav_enqueue_scripts' ) ) :
add_action( 'wp_enqueue_scripts','generate_secondary_nav_enqueue_scripts', 100 );
function generate_secondary_nav_enqueue_scripts() {
	
	wp_enqueue_style( 'generate-secondary-nav', plugin_dir_url( __FILE__ ) . 'css/style.min.css', GENERATE_SECONDARY_NAV_VERSION );
	if ( ! defined( 'GENERATE_DISABLE_MOBILE' ) ) :
		wp_enqueue_script( 'generate-secondary-nav', plugin_dir_url( __FILE__ ) . 'js/navigation.min.js', array(), GENERATE_SECONDARY_NAV_VERSION, true );
		wp_enqueue_style( 'generate-secondary-nav-mobile', plugin_dir_url( __FILE__ ) . 'css/mobile.min.css', false, GENERATE_SECONDARY_NAV_VERSION, 'all' );
	endif;
}	
endif;

if ( ! function_exists( 'generate_secondary_nav_enqueue_customizer_scripts' ) ) :
add_action( 'customize_preview_init', 'generate_secondary_nav_enqueue_customizer_scripts' );
function generate_secondary_nav_enqueue_customizer_scripts()
{
    wp_enqueue_script( 'generate-secondary-nav-customizer', plugin_dir_url( __FILE__ ) . 'js/customizer.js', array( 'jquery', 'customize-preview' ), GENERATE_SECONDARY_NAV_VERSION, true );
}
endif;

if ( ! function_exists( 'generate_secondary_nav_get_defaults' ) ) :
/**
 * Set default options
 */
function generate_secondary_nav_get_defaults()
{
	$generate_defaults = array(
		'secondary_nav_mobile_label' => 'Menu',
		'secondary_nav_layout_setting' => 'secondary-fluid-nav',
		'secondary_nav_inner_width' => 'contained',
		'secondary_nav_position_setting' => 'secondary-nav-above-header',
		'secondary_nav_alignment' => 'right',
		'navigation_background_color' => '#636363',
		'navigation_text_color' => '#FFFFFF',
		'navigation_background_hover_color' => '#303030',
		'navigation_text_hover_color' => '#FFFFFF',
		'navigation_background_current_color' => '#ffffff',
		'navigation_text_current_color' => '#222222',
		'subnavigation_background_color' => '#303030',
		'subnavigation_text_color' => '#FFFFFF',
		'subnavigation_background_hover_color' => '#474747',
		'subnavigation_text_hover_color' => '#FFFFFF',
		'subnavigation_background_current_color' => '#474747',
		'subnavigation_text_current_color' => '#FFFFFF',
		'secondary_menu_item' => '20',
		'secondary_menu_item_height' => '40',
		'secondary_sub_menu_item_height' => '10',
		'font_secondary_navigation' => 'inherit',
		'secondary_navigation_font_weight' => 'normal',
		'secondary_navigation_font_transform' => 'none',
		'secondary_navigation_font_size' => '13',
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
	);
	
	return apply_filters( 'generate_secondary_nav_option_defaults', $generate_defaults );
}
endif;

if ( ! function_exists( 'generate_secondary_nav_customize_register' ) ) :
add_action( 'customize_register', 'generate_secondary_nav_customize_register', 999 );
function generate_secondary_nav_customize_register( $wp_customize ) {
	$defaults = generate_secondary_nav_get_defaults();
	
	if ( $wp_customize->get_panel( 'generate_layout_panel' ) ) {
		$layout_panel = 'generate_layout_panel';
	} else {
		$layout_panel = 'secondary_navigation_panel';
	}
	
	if ( class_exists( 'WP_Customize_Panel' ) ) :
	
		$wp_customize->add_panel( 'secondary_navigation_panel', array(
			'priority'       => 100,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Secondary Navigation','secondary-nav' ),
			'description'    => '',
		) );
	
	endif;
	
	// Add Header Colors section
	$wp_customize->add_section(
		// ID
		'secondary_nav_section',
		// Arguments array
		array(
			'title' => __( 'Secondary Navigation','secondary-nav' ),
			'capability' => 'edit_theme_options',
			'priority' => 31,
			'panel' => $layout_panel
		)
	);
	
	 $wp_customize->add_setting(
		'generate_secondary_nav_settings[secondary_nav_mobile_label]', 
		array(
			'default' => $defaults['secondary_nav_mobile_label'],
			'type' => 'option',
			'sanitize_callback' => 'wp_kses_post'
		)
	);
		 
	$wp_customize->add_control(
		'secondary_nav_mobile_label_control', array(
			'label' => __('Mobile Menu Label','secondary-nav'),
			'section' => 'secondary_nav_section',
			'settings' => 'generate_secondary_nav_settings[secondary_nav_mobile_label]',
			'priority' => 10
		)
	);
	
	// Add navigation setting
	$wp_customize->add_setting(
		// ID
		'generate_secondary_nav_settings[secondary_nav_layout_setting]',
		// Arguments array
		array(
			'default' => $defaults['secondary_nav_layout_setting'],
			'type' => 'option',
			'sanitize_callback' => 'generate_secondary_nav_sanitize_choices',
			'transport' => 'postMessage'
		)
	);
	
	// Add navigation control
	$wp_customize->add_control(
		// ID
		'generate_secondary_nav_settings[secondary_nav_layout_setting]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Navigation Width','secondary-nav' ),
			'section' => 'secondary_nav_section',
			'choices' => array(
				'secondary-fluid-nav' => __( 'Full','secondary-nav' ),
				'secondary-contained-nav' => __( 'Contained','secondary-nav' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_secondary_nav_settings[secondary_nav_layout_setting]',
			'priority' => 15
		)
	);
	
	// Add navigation setting
	$wp_customize->add_setting(
		// ID
		'generate_secondary_nav_settings[secondary_nav_inner_width]',
		// Arguments array
		array(
			'default' => $defaults['secondary_nav_inner_width'],
			'type' => 'option',
			'sanitize_callback' => 'generate_secondary_nav_sanitize_choices',
			'transport' => 'postMessage'
		)
	);
	
	// Add navigation control
	$wp_customize->add_control(
		// ID
		'generate_secondary_nav_settings[secondary_nav_inner_width]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Inner Navigation Width','secondary-nav' ),
			'section' => 'secondary_nav_section',
			'choices' => array(
				'full-width' => __( 'Full','secondary-nav' ),
				'contained' => __( 'Contained','secondary-nav' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_secondary_nav_settings[secondary_nav_inner_width]',
			'priority' => 15
		)
	);
	
	// Add navigation setting
	$wp_customize->add_setting(
		// ID
		'generate_secondary_nav_settings[secondary_nav_position_setting]',
		// Arguments array
		array(
			'default' => $defaults['secondary_nav_position_setting'],
			'type' => 'option',
			'sanitize_callback' => 'generate_secondary_nav_sanitize_choices',
			'transport' => 'postMessage'
		)
	);
	
	// Add navigation control
	$wp_customize->add_control(
		// ID
		'generate_secondary_nav_settings[secondary_nav_position_setting]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Navigation Position','secondary-nav' ),
			'section' => 'secondary_nav_section',
			'choices' => array(
				'secondary-nav-below-header' => __( 'Below Header','secondary-nav' ),
				'secondary-nav-above-header' => __( 'Above Header','secondary-nav' ),
				'secondary-nav-float-right' => __( 'Float Right','secondary-nav' ),
				'secondary-nav-left-sidebar' => __( 'Left Sidebar','secondary-nav' ),
				'secondary-nav-right-sidebar' => __( 'Right Sidebar','secondary-nav' ),
				'' => __( 'No Navigation','secondary-nav' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_secondary_nav_settings[secondary_nav_position_setting]',
			'priority' => 20
		)
	);
	
	// Add navigation setting
	$wp_customize->add_setting(
		// ID
		'generate_secondary_nav_settings[secondary_nav_alignment]',
		// Arguments array
		array(
			'default' => $defaults['secondary_nav_alignment'],
			'type' => 'option',
			'sanitize_callback' => 'generate_secondary_nav_sanitize_choices',
			'transport' => 'postMessage'
		)
	);
	
	// Add navigation control
	$wp_customize->add_control(
		// ID
		'generate_secondary_nav_settings[secondary_nav_alignment]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Navigation Alignment','secondary-nav' ),
			'section' => 'secondary_nav_section',
			'choices' => array(
				'left' => __( 'Left','secondary-nav' ),
				'center' => __( 'Center','secondary-nav' ),
				'right' => __( 'Right','secondary-nav' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_secondary_nav_settings[secondary_nav_alignment]',
			'priority' => 30
		)
	);
	
	require_once trailingslashit( dirname(__FILE__) ) . 'customizer/spacing.php';
	require_once trailingslashit( dirname(__FILE__) ) . 'customizer/colors.php';
	require_once trailingslashit( dirname(__FILE__) ) . 'customizer/typography.php';
	require_once trailingslashit( dirname(__FILE__) ) . 'customizer/backgrounds.php';
	
}
endif;

/** 
 * Add Google Fonts to wp_head if needed
 * @since 0.1
 */
if ( ! function_exists( 'generate_display_secondary_google_fonts' ) ) :
add_filter('generate_typography_google_fonts','generate_display_secondary_google_fonts', 50);
function generate_display_secondary_google_fonts($google_fonts) {
	
	if ( is_admin() )
		return;
		
	$generate_secondary_nav_settings = wp_parse_args( 
		get_option( 'generate_secondary_nav_settings', array() ), 
		generate_secondary_nav_get_defaults() 
	);
	
	// List our non-Google fonts
	if ( function_exists( 'generate_typography_default_fonts' ) ) {
		$not_google = str_replace( ' ', '+', generate_typography_default_fonts() );
	} else {
		$not_google = array(
			'inherit',
			'Arial,+Helvetica,+sans-serif',
			'Century+Gothic',
			'Comic+Sans+MS',
			'Courier+New',
			'Georgia,+Times+New+Roman,+Times,+serif',
			'Helvetica',
			'Impact',
			'Lucida+Console',
			'Lucida+Sans+Unicode',
			'Palatino+Linotype',
			'Tahoma,+Geneva,+sans-serif',
			'Trebuchet+MS,+Helvetica,+sans-serif',
			'Verdana,+Geneva,+sans-serif'
		);
	}
	
	// Create our Google Fonts array
	$secondary_google_fonts = array();
	
	if ( function_exists( 'generate_get_google_font_variants' ) ) :
	
		// If our value is still using the old format, fix it
		if ( strpos( $generate_secondary_nav_settings[ 'font_secondary_navigation' ], ':' ) !== false )
			$generate_secondary_nav_settings[ 'font_secondary_navigation' ] = current( explode( ':', $generate_secondary_nav_settings[ 'font_secondary_navigation' ] ) );
		
		// Grab the variants using the plain name
		$variants = generate_get_google_font_variants( $generate_secondary_nav_settings[ 'font_secondary_navigation' ], 'font_secondary_navigation', generate_secondary_nav_get_defaults() );
	
	else :
		$variants = '';
	endif;
	
	// Replace the spaces in the names with a plus
	$value = str_replace( ' ', '+', $generate_secondary_nav_settings[ 'font_secondary_navigation' ] );
			
	// If we have variants, add them to our value
	$value = ! empty( $variants ) ? $value . ':' . $variants : $value;
			
	// Add our value to the array
	$secondary_google_fonts[] = $value;
	
	// Ignore any non-Google fonts
	$secondary_google_fonts = array_diff($secondary_google_fonts, $not_google);
	
	// Separate each different font with a bar
	$secondary_google_fonts = implode('|', $secondary_google_fonts);
	
	if ( !empty( $secondary_google_fonts ) ) :
		$print_secondary_fonts = '|' . $secondary_google_fonts;
	else : 
		$print_secondary_fonts = '';
	endif;
	
	// Remove any duplicates
	$return = $google_fonts . $print_secondary_fonts;
	$return = implode('|',array_unique(explode('|', $return)));
	return $return;
	
}
endif;

if ( ! function_exists( 'generate_secondary_navigation_customize_preview_css' ) ) :
add_action('customize_controls_print_styles', 'generate_secondary_navigation_customize_preview_css');
function generate_secondary_navigation_customize_preview_css() {

	?>
	<style>
		.customize-control.customize-control-spacing {display: inline-block;width:25%;clear:none;text-align:center}
		.spacing-area {display: inline-block;width:25%;clear:none;text-align:center;position:relative;bottom:-5px;font-size:11px;font-weight:bold;}
		.customize-control-title.spacing-title {margin-bottom:0;}
		.customize-control.customize-control-spacing-heading {margin-bottom:0px;text-align:center;}
		.customize-control.customize-control-line {margin:8px 0;}
		#customize-control-generate_spacing_settings-separator,
		#customize-control-generate_secondary_nav_settings-secondary_sub_menu_item_height {width:100%;}
		#customize-control-generate_secondary_nav_settings-secondary_menu_item,
		#customize-control-generate_secondary_nav_settings-secondary_menu_item_height,
		#accordion-section-secondary_navigation_spacing_section .customize-control-spacing-heading .spacing-area
		{
			width: 50%;
		}
		
		#accordion-section-secondary_bg_images_section li.customize-control-upload .remove {font-size:10px;}
		#accordion-section-secondary_bg_images_section li.customize-control-position .small-customize-label {display:block;}
		#accordion-section-secondary_bg_images_section .generate-upload .remove {font-size:10px;position:relative;bottom:-5px}
	
		#customize-control-generate_secondary_backgrounds-nav-heading,
		#customize-control-generate_secondary_backgrounds-sub-nav-item-heading {
			padding: 0;
			border: 0;
			margin-top: 0;
		}
	</style>
	<?php
}
endif;

if ( ! function_exists( 'generate_add_secondary_navigation_after_header' ) ) :
/**
 * Generate the navigation based on settings
 * @since 0.1
 */
add_action( 'generate_after_header', 'generate_add_secondary_navigation_after_header', 7 );
function generate_add_secondary_navigation_after_header()
{
	$generate_settings = wp_parse_args( 
		get_option( 'generate_secondary_nav_settings', array() ), 
		generate_secondary_nav_get_defaults() 
	);
	
	if ( 'secondary-nav-below-header' == $generate_settings['secondary_nav_position_setting'] ) :
		generate_secondary_navigation_position();
	endif;
	
}
endif;

if ( ! function_exists( 'generate_add_secondary_navigation_before_header' ) ) :
add_action( 'generate_before_header', 'generate_add_secondary_navigation_before_header', 7 );
function generate_add_secondary_navigation_before_header()
{
	$generate_settings = wp_parse_args( 
		get_option( 'generate_secondary_nav_settings', array() ), 
		generate_secondary_nav_get_defaults() 
	);
	
	if ( 'secondary-nav-above-header' == $generate_settings['secondary_nav_position_setting'] ) :
		generate_secondary_navigation_position();
	endif;
	
}
endif;

if ( ! function_exists( 'generate_add_secondary_navigation_float_right' ) ) :
add_action( 'generate_before_header_content', 'generate_add_secondary_navigation_float_right', 7 );
function generate_add_secondary_navigation_float_right()
{
	$generate_settings = wp_parse_args( 
		get_option( 'generate_secondary_nav_settings', array() ), 
		generate_secondary_nav_get_defaults() 
	);
	
	if ( 'secondary-nav-float-right' == $generate_settings['secondary_nav_position_setting'] ) :
		generate_secondary_navigation_position();
	endif;
	
}
endif;

if ( ! function_exists( 'generate_add_secondary_navigation_before_right_sidebar' ) ) :
add_action( 'generate_before_right_sidebar_content', 'generate_add_secondary_navigation_before_right_sidebar', 7 );
function generate_add_secondary_navigation_before_right_sidebar()
{
	$generate_settings = wp_parse_args( 
		get_option( 'generate_secondary_nav_settings', array() ), 
		generate_secondary_nav_get_defaults() 
	);
	
	if ( 'secondary-nav-right-sidebar' == $generate_settings['secondary_nav_position_setting'] ) :
		echo '<div class="gen-sidebar-secondary-nav">';
			generate_secondary_navigation_position();
		echo '</div><!-- .gen-sidebar-secondary-nav -->';
	endif;
	
}
endif;

if ( ! function_exists( 'generate_add_secondary_navigation_before_left_sidebar' ) ) :
add_action( 'generate_before_left_sidebar_content', 'generate_add_secondary_navigation_before_left_sidebar', 7 );
function generate_add_secondary_navigation_before_left_sidebar()
{
	$generate_settings = wp_parse_args( 
		get_option( 'generate_secondary_nav_settings', array() ), 
		generate_secondary_nav_get_defaults() 
	);
	
	if ( 'secondary-nav-left-sidebar' == $generate_settings['secondary_nav_position_setting'] ) :
		echo '<div class="gen-sidebar-secondary-nav">';
			generate_secondary_navigation_position();
		echo '</div><!-- .gen-sidebar-secondary-nav -->';
	endif;
	
}
endif;

if ( ! function_exists( 'generate_secondary_navigation_position' ) ) :
function generate_secondary_navigation_position()
{
	$generate_settings = wp_parse_args( 
		get_option( 'generate_secondary_nav_settings', array() ), 
		generate_secondary_nav_get_defaults() 
	);
	if ( has_nav_menu( 'secondary' ) ) :
		?>
		<nav itemtype="http://schema.org/SiteNavigationElement" itemscope="itemscope" id="secondary-navigation" <?php generate_secondary_navigation_class(); ?>>
			<div <?php generate_inside_secondary_navigation_class(); ?>>
				<?php do_action('generate_inside_secondary_navigation'); ?>
				<button class="menu-toggle secondary-menu-toggle">
					<?php do_action( 'generate_inside_secondary_mobile_menu' ); ?>
					<span class="mobile-menu"><?php echo $generate_settings['secondary_nav_mobile_label']; ?></span>
				</button>
				<?php 
				
					wp_nav_menu( 
						array( 
							'theme_location' => 'secondary',
							'container' => 'div',
							'container_class' => 'main-nav',
							'menu_class' => '',
							'fallback_cb' => 'generate_secondary_menu_fallback',
							'items_wrap' => '<ul id="%1$s" class="%2$s ' . join( ' ', generate_get_secondary_menu_class() ) . '">%3$s</ul>'
						) 
					);
				
				?>
			</div><!-- .inside-navigation -->
		</nav><!-- #secondary-navigation -->
		<?php
	endif;
}
endif;

if ( ! function_exists( 'generate_secondary_menu_fallback' ) ) :
/**
 * Menu fallback. 
 *
 * @param  array $args
 * @return string
 * @since 1.1.4
 */
function generate_secondary_menu_fallback( $args )
{ 
?>
	<div class="main-nav">
		<ul <?php generate_secondary_menu_class(); ?>>
			<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
		</ul>
	</div><!-- .main-nav -->
<?php 
}
endif;

if ( ! function_exists( 'generate_secondary_nav_body_classes' ) ) :
/**
 * Adds custom classes to the array of body classes.
 * @since 0.1
 */
add_filter( 'body_class', 'generate_secondary_nav_body_classes' );
function generate_secondary_nav_body_classes( $classes ) {
	
	// Get theme options
	global $post;
	$generate_settings = wp_parse_args( 
		get_option( 'generate_secondary_nav_settings', array() ), 
		generate_secondary_nav_get_defaults() 
	);

	$classes[] = ( $generate_settings['secondary_nav_position_setting'] ) ? $generate_settings['secondary_nav_position_setting'] : 'secondary-nav-below-header';
	
	// Navigation alignment class
	if ( $generate_settings['secondary_nav_alignment'] == 'left' ) :
		$classes[] = 'secondary-nav-aligned-left';
	elseif ( $generate_settings['secondary_nav_alignment'] == 'center' ) :
		$classes[] = 'secondary-nav-aligned-center';
	elseif ( $generate_settings['secondary_nav_alignment'] == 'right' ) :
		$classes[] = 'secondary-nav-aligned-right';
	else :
		$classes[] = 'secondary-nav-aligned-left';
	endif;

	return $classes;
}
endif;

if ( ! function_exists( 'generate_secondary_menu_classes' ) ) :
/**
 * Adds custom classes to the menu
 * @since 0.1
 */
add_filter( 'generate_secondary_menu_class', 'generate_secondary_menu_classes');
function generate_secondary_menu_classes( $classes )
{
	
	$classes[] = 'secondary-menu';
	$classes[] = 'sf-menu';

	// Get theme options
	$generate_settings = wp_parse_args( 
		get_option( 'generate_secondary_nav_settings', array() ), 
		generate_secondary_nav_get_defaults() 
	);

	return $classes;
	
}
endif;

if ( ! function_exists( 'generate_secondary_navigation_classes' ) ) :
/**
 * Adds custom classes to the navigation
 * @since 0.1
 */
add_filter( 'generate_secondary_navigation_class', 'generate_secondary_navigation_classes');
function generate_secondary_navigation_classes( $classes )
{
	
	$classes[] = 'secondary-navigation';

	// Get theme options
	$generate_settings = wp_parse_args( 
		get_option( 'generate_secondary_nav_settings', array() ), 
		generate_secondary_nav_get_defaults() 
	);
	$nav_layout = $generate_settings['secondary_nav_layout_setting'];
	
	if ( $nav_layout == 'secondary-contained-nav' ) :
		$classes[] = 'grid-container';
		$classes[] = 'grid-parent';
	endif;

	return $classes;
	
}
endif;

if ( ! function_exists( 'generate_inside_secondary_navigation_classes' ) ) :
/**
 * Adds custom classes to the inner navigation
 * @since 1.3.41
 */
add_filter( 'generate_inside_secondary_navigation_class', 'generate_inside_secondary_navigation_classes');
function generate_inside_secondary_navigation_classes( $classes )
{
	
	$classes[] = 'inside-navigation';
	// Get theme options
	$generate_settings = wp_parse_args( 
		get_option( 'generate_secondary_nav_settings', array() ), 
		generate_secondary_nav_get_defaults() 
	);
	$inner_nav_width = $generate_settings['secondary_nav_inner_width'];
	
	if ( $inner_nav_width !== 'full-width' ) :
		$classes[] = 'grid-container';
		$classes[] = 'grid-parent';
	endif;

	return $classes;
	
}
endif;
/**
 * Generate the CSS in the <head> section using the Theme Customizer
 * @since 0.1
 */
if ( !function_exists( 'generate_secondary_nav_css' ) ) :
function generate_secondary_nav_css()
{
	
	$generate_settings = wp_parse_args( 
		get_option( 'generate_secondary_nav_settings', array() ), 
		generate_secondary_nav_get_defaults() 
	);
	
	if ( function_exists( 'generate_spacing_get_defaults' ) ) {
		$spacing_settings = wp_parse_args( 
			get_option( 'generate_spacing_settings', array() ), 
			generate_spacing_get_defaults() 
		);
	}

	if ( function_exists( 'generate_get_font_family_css' ) ) :
		$secondary_nav_family = generate_get_font_family_css( 'font_secondary_navigation', 'generate_secondary_nav_settings', generate_secondary_nav_get_defaults() );
	else : 
		$secondary_nav_family = current(explode(':', $generate_settings['font_secondary_navigation']));
	endif;
	
	if ( '""' == $secondary_nav_family ) {
		$secondary_nav_family = 'inherit';
	}
	
	// Start the magic
	$visual_css = array (
		
		// Navigation background
		'.secondary-navigation' => array(
			'background-color' => $generate_settings['navigation_background_color'],
			'background-image' => !empty( $generate_settings['nav_image'] ) ? 'url(' . $generate_settings['nav_image'] . ')' : '',
			'background-repeat' => $generate_settings['nav_repeat']
		),
		
		'.widget-area .secondary-navigation' => array(
			'margin-bottom' => ( isset( $spacing_settings['separator'] ) ) ? $spacing_settings['separator'] . 'px' : null,
		),
		
		// Sub-Navigation background
		'.secondary-navigation ul ul' => array(
			'background-color' => $generate_settings['subnavigation_background_color'],
			'top' => ( isset( $generate_settings['secondary_menu_item_height'] ) ) ? $generate_settings['secondary_menu_item_height'] . 'px' : null,
		),
		
		// Navigation text
		'.secondary-navigation .main-nav ul li a,
		.secondary-navigation .menu-toggle' => array(
			'color' => $generate_settings['navigation_text_color'],
			'font-family' => $secondary_nav_family,
			'font-weight' => $generate_settings['secondary_navigation_font_weight'],
			'text-transform' => $generate_settings['secondary_navigation_font_transform'],
			'font-size' => $generate_settings['secondary_navigation_font_size'] . 'px',
			'padding-left' => ( isset( $generate_settings['secondary_menu_item'] ) ) ? $generate_settings['secondary_menu_item'] . 'px' : null,
			'padding-right' => ( isset( $generate_settings['secondary_menu_item'] ) ) ? $generate_settings['secondary_menu_item'] . 'px' : null,
			'line-height' => ( isset( $generate_settings['secondary_menu_item_height'] ) ) ? $generate_settings['secondary_menu_item_height'] . 'px' : null,
			'background-image' => !empty( $generate_settings['nav_item_image'] ) ? 'url(' . $generate_settings['nav_item_image'] . ')' : '',
			'background-repeat' => $generate_settings['nav_item_repeat']
		),
		
		// Mobile menu text
		'button.secondary-menu-toggle:hover,
		button.secondary-menu-toggle:focus' => array(
			'color' => $generate_settings['navigation_text_color']
		),
		
		// Sub-Navigation text
		'.secondary-navigation .main-nav ul ul li a' => array(
			'color' => $generate_settings['subnavigation_text_color'],
			'font-size' => $generate_settings['secondary_navigation_font_size'] - 1 . 'px',
			'padding-left' => ( isset( $generate_settings['secondary_menu_item'] ) ) ? $generate_settings['secondary_menu_item'] . 'px' : null,
			'padding-right' => ( isset( $generate_settings['secondary_menu_item'] ) ) ? $generate_settings['secondary_menu_item'] . 'px' : null,
			'padding-top' => ( isset( $generate_settings['secondary_sub_menu_item_height'] ) ) ? $generate_settings['secondary_sub_menu_item_height'] . 'px' : null,
			'padding-bottom' => ( isset( $generate_settings['secondary_sub_menu_item_height'] ) ) ? $generate_settings['secondary_sub_menu_item_height'] . 'px' : null,
			'background-image' => !empty( $generate_settings['sub_nav_item_image'] ) ? 'url(' . $generate_settings['sub_nav_item_image'] . ')' : '',
			'background-repeat' => $generate_settings['sub_nav_item_repeat']
		),
		
		'nav.secondary-navigation .main-nav ul li.menu-item-has-children > a' => array(
			'padding-right' => ( isset( $generate_settings['secondary_menu_item'] ) && is_rtl() ) ? $generate_settings['secondary_menu_item'] . 'px' : null
		),
		
		'.secondary-navigation .menu-item-has-children ul .dropdown-menu-toggle' => array (
			'padding-top' => ( isset( $generate_settings[ 'secondary_sub_menu_item_height' ] ) ) ? $generate_settings[ 'secondary_sub_menu_item_height' ] . 'px' : null,
			'padding-bottom' => ( isset( $generate_settings[ 'secondary_sub_menu_item_height' ] ) ) ? $generate_settings[ 'secondary_sub_menu_item_height' ] . 'px' : null,
			'margin-top' => ( isset( $generate_settings[ 'secondary_sub_menu_item_height' ] ) ) ? '-' . $generate_settings[ 'secondary_sub_menu_item_height' ] . 'px' : null,
		),
		
		'.secondary-navigation .menu-item-has-children .dropdown-menu-toggle' => array(
			'padding-right' => ( isset( $generate_settings['secondary_menu_item'] ) ) ? $generate_settings['secondary_menu_item'] . 'px' : null,
		),
		
		// Navigation background/text on hover
		'.secondary-navigation .main-nav ul li > a:hover, 
		.secondary-navigation .main-nav ul li > a:focus, 
		.secondary-navigation .main-nav ul li.sfHover > a' => array(
			'color' => $generate_settings['navigation_text_hover_color'],
			'background-color' => $generate_settings['navigation_background_hover_color'],
			'background-image' => !empty( $generate_settings['nav_item_hover_image'] ) ? 'url(' . $generate_settings['nav_item_hover_image'] . ')' : '',
			'background-repeat' => $generate_settings['nav_item_hover_repeat']
		),
		
		// Sub-Navigation background/text on hover
		'.secondary-navigation .main-nav ul ul li > a:hover,
		.secondary-navigation .main-nav ul ul li > a:focus,
		.secondary-navigation .main-nav ul ul li.sfHover > a' => array(
			'color' => $generate_settings['subnavigation_text_hover_color'],
			'background-color' => $generate_settings['subnavigation_background_hover_color'],
			'background-image' => !empty( $generate_settings['sub_nav_item_hover_image'] ) ? 'url(' . $generate_settings['sub_nav_item_hover_image'] . ')' : '',
			'background-repeat' => $generate_settings['sub_nav_item_hover_repeat']
		),
		
		// Navigation background / text current
		'.secondary-navigation .main-nav ul .current-menu-item > a, 
		.secondary-navigation .main-nav ul .current-menu-parent > a, 
		.secondary-navigation .main-nav ul .current-menu-ancestor > a' => array(
			'color' => $generate_settings['navigation_text_current_color'],
			'background-color' => $generate_settings['navigation_background_current_color'],
			'background-image' => !empty( $generate_settings['nav_item_current_image'] ) ? 'url(' . $generate_settings['nav_item_current_image'] . ')' : '',
			'background-repeat' => $generate_settings['nav_item_current_repeat']
		),
		
		// Navigation background text current text hover
		'.secondary-navigation .main-nav ul .current-menu-item > a:hover, 
		.secondary-navigation .main-nav ul .current-menu-parent > a:hover, 
		.secondary-navigation .main-nav ul .current-menu-ancestor > a:hover, 
		.secondary-navigation .main-nav ul .current-menu-item.sfHover > a, 
		.secondary-navigation .main-nav ul .current-menu-parent.sfHover > a, 
		.secondary-navigation .main-nav ul .current-menu-ancestor.sfHover > a' => array(
			'color' => $generate_settings['navigation_text_current_color'],
			'background-color' => $generate_settings['navigation_background_current_color'],
			'background-image' => !empty( $generate_settings['nav_item_current_image'] ) ? 'url(' . $generate_settings['nav_item_current_image'] . ')' : '',
			'background-repeat' => $generate_settings['nav_item_current_repeat']
		),
		
		// Sub-Navigation background / text current
		'.secondary-navigation .main-nav ul ul .current-menu-item > a, 
		.secondary-navigation .main-nav ul ul .current-menu-parent > a, 
		.secondary-navigation .main-nav ul ul .current-menu-ancestor > a' => array(
			'color' => $generate_settings['subnavigation_text_current_color'],
			'background-color' => $generate_settings['subnavigation_background_current_color'],
			'background-image' => !empty( $generate_settings['sub_nav_item_current_image'] ) ? 'url(' . $generate_settings['sub_nav_item_current_image'] . ')' : '',
			'background-repeat' => $generate_settings['sub_nav_item_current_repeat']
		),
		
		// Sub-Navigation current background / text current
		'.secondary-navigation .main-nav ul ul .current-menu-item > a:hover, 
		.secondary-navigation .main-nav ul ul .current-menu-parent > a:hover, 
		.secondary-navigation .main-nav ul ul .current-menu-ancestor > a:hover,
		.secondary-navigation .main-nav ul ul .current-menu-item.sfHover > a, 
		.secondary-navigation .main-nav ul ul .current-menu-parent.sfHover > a, 
		.secondary-navigation .main-nav ul ul .current-menu-ancestor.sfHover > a' => array(
			'color' => $generate_settings['subnavigation_text_current_color'],
			'background-color' => $generate_settings['subnavigation_background_current_color'],
			'background-image' => !empty( $generate_settings['sub_nav_item_current_image'] ) ? 'url(' . $generate_settings['sub_nav_item_current_image'] . ')' : '',
			'background-repeat' => $generate_settings['sub_nav_item_current_repeat']
		)
		
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
endif;

if ( ! function_exists( 'generate_secondary_color_scripts' ) ) :
/**
 * Enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'generate_secondary_color_scripts', 80 );
function generate_secondary_color_scripts() {

	wp_add_inline_style( 'generate-style', generate_secondary_nav_css() );

}
endif;

if ( ! function_exists( 'generate_secondary_navigation_class' ) ) :
/**
 * Display the classes for the secondary navigation.
 *
 * @since 0.1
 * @param string|array $class One or more classes to add to the class list.
 */
function generate_secondary_navigation_class( $class = '' ) {
	// Separates classes with a single space, collates classes for post DIV
	echo 'class="' . join( ' ', generate_get_secondary_navigation_class( $class ) ) . '"';
}
endif;

if ( ! function_exists( 'generate_get_secondary_navigation_class' ) ) :
/**
 * Retrieve the classes for the secondary navigation.
 *
 * @since 0.1
 * @param string|array $class One or more classes to add to the class list.
 * @return array Array of classes.
 */
function generate_get_secondary_navigation_class( $class = '' ) {

	$classes = array();

	if ( !empty($class) ) {
		if ( !is_array( $class ) )
			$class = preg_split('#\s+#', $class);
		$classes = array_merge($classes, $class);
	}

	$classes = array_map('esc_attr', $classes);

	return apply_filters('generate_secondary_navigation_class', $classes, $class);
}
endif;

if ( ! function_exists( 'generate_secondary_menu_class' ) ) :
/**
 * Display the classes for the secondary navigation.
 *
 * @since 0.1
 * @param string|array $class One or more classes to add to the class list.
 */
function generate_secondary_menu_class( $class = '' ) {
	// Separates classes with a single space, collates classes for post DIV
	echo 'class="' . join( ' ', generate_get_secondary_menu_class( $class ) ) . '"';
}
endif;

if ( ! function_exists( 'generate_get_secondary_menu_class' ) ) :
/**
 * Retrieve the classes for the secondary navigation.
 *
 * @since 0.1
 * @param string|array $class One or more classes to add to the class list.
 * @return array Array of classes.
 */
function generate_get_secondary_menu_class( $class = '' ) {

	$classes = array();

	if ( !empty($class) ) {
		if ( !is_array( $class ) )
			$class = preg_split('#\s+#', $class);
		$classes = array_merge($classes, $class);
	}

	$classes = array_map('esc_attr', $classes);

	return apply_filters('generate_secondary_menu_class', $classes, $class);
}
endif;

if ( ! function_exists( 'generate_inside_secondary_navigation_class' ) ) :
/**
 * Display the classes for the inner navigation.
 *
 * @since 0.1
 * @param string|array $class One or more classes to add to the class list.
 */
function generate_inside_secondary_navigation_class( $class = '' ) {
	$classes = array();

	if ( !empty($class) ) {
		if ( !is_array( $class ) )
			$class = preg_split('#\s+#', $class);
		$classes = array_merge($classes, $class);
	}

	$classes = array_map('esc_attr', $classes);

	$return = apply_filters('generate_inside_secondary_navigation_class', $classes, $class);
	
	// Separates classes with a single space, collates classes for post DIV
	echo 'class="' . join( ' ', $return ) . '"';
}
endif;

if ( ! function_exists( 'generate_secondary_nav_sanitize_choices' ) ) :
/**
 * Sanitize choices
 */
function generate_secondary_nav_sanitize_choices( $input, $setting ) {
	
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

if ( ! function_exists( 'generate_hidden_secondary_navigation' ) && function_exists( 'is_customize_preview' ) ) :
/**
 * Adds a hidden navigation if no navigation is set
 * This allows us to use postMessage to position the navigation when it doesn't exist
 */
add_action( 'wp_footer','generate_hidden_secondary_navigation' );
function generate_hidden_secondary_navigation()
{
	if ( is_customize_preview() && function_exists( 'generate_secondary_navigation_position' ) ) {
		?>
		<div style="display:none;">
			<?php generate_secondary_navigation_position(); ?>
		</div>
		<?php
	}
}
endif;
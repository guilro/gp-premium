<?php
if ( ! function_exists( 'generate_menu_plus_setup' ) ) :
add_action( 'after_setup_theme','generate_menu_plus_setup' );
function generate_menu_plus_setup()
{
	register_nav_menus( array(
		'slideout' => __( 'Slideout Menu', 'generate-menu-plus' ),
	) );
	
}
endif;
if ( ! function_exists( 'generate_menu_plus_get_defaults' ) ) :
/**
 * Set default options
 */
function generate_menu_plus_get_defaults()
{
	$generate_menu_plus_get_defaults = array(
		'mobile_menu_label' => __( 'Menu','generate-menu-plus' ),
		'sticky_menu' => 'false',
		'sticky_menu_effect' => 'fade',
		'sticky_menu_logo' => '',
		'sticky_menu_logo_position' => 'sticky-menu',
		'mobile_header' => 'disable',
		'mobile_header_logo' => '',
		'mobile_header_sticky' => 'disable',
		'slideout_menu' => 'false',
	);
	
	return apply_filters( 'generate_menu_plus_option_defaults', $generate_menu_plus_get_defaults );
}
endif;

if ( ! function_exists( 'generate_menu_plus_customize_register' ) ) :
/**
 * Initiate Customizer controls
 */
add_action( 'customize_register', 'generate_menu_plus_customize_register', 100 );
function generate_menu_plus_customize_register( $wp_customize ) {

	$defaults = generate_menu_plus_get_defaults();
	
	if ( class_exists( 'WP_Customize_Panel' ) ) :
		if ( ! $wp_customize->get_panel( 'generate_menu_plus' ) ) {
			$wp_customize->add_panel( 'generate_menu_plus', array(
				'priority'       => 50,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Menu Plus','generate' ),
				'description'    => '',
			) );
		}
	endif;
	
	if ( $wp_customize->get_panel( 'generate_layout_panel' ) ) {
		$panel = 'generate_layout_panel';
		$navigation_section = 'generate_layout_navigation';
		$header_section = 'generate_layout_header';
		$sticky_menu_section = 'generate_layout_navigation';
	} else {
		$panel = 'generate_menu_plus';
		$navigation_section = 'menu_plus_section';
		$header_section = 'menu_plus_mobile_header';
		$sticky_menu_section = 'menu_plus_sticky_menu';
	}
	
	// Add Menu Extended section
	$wp_customize->add_section(
		// ID
		'menu_plus_section',
		// Arguments array
		array(
			'title' => __( 'General Settings', 'generate-menu-plus' ),
			'capability' => 'edit_theme_options',
			'panel' => 'generate_menu_plus'
		)
	);
	
	// Add mobile menu label setting
	$wp_customize->add_setting(
		'generate_menu_plus_settings[mobile_menu_label]', 
		array(
			'default' => $defaults['mobile_menu_label'],
			'type' => 'option',
			'sanitize_callback' => 'wp_kses_post'
		)
	);
		 
	$wp_customize->add_control(
		'mobile_menu_label_control', array(
			'label' => __('Mobile Menu Label', 'generate-menu-plus'),
			'section' => $navigation_section,
			'settings' => 'generate_menu_plus_settings[mobile_menu_label]'
		)
	);
	
	// Add Menu Extended section
	$wp_customize->add_section(
		// ID
		'menu_plus_sticky_menu',
		// Arguments array
		array(
			'title' => __( 'Sticky Menu', 'generate-menu-plus' ),
			'capability' => 'edit_theme_options',
			'panel' => $panel,
			'priority' => 17
		)
	);
	
	// Add sticky nav setting
	$wp_customize->add_setting(
		// ID
		'generate_menu_plus_settings[sticky_menu]',
		// Arguments array
		array(
			'default' => $defaults['sticky_menu'],
			'type' => 'option',
			'sanitize_callback' => 'generate_menu_plus_sanitize_choices'
		)
	);
	
	// Add sticky nav control
	$wp_customize->add_control(
		// ID
		'generate_menu_plus_settings[sticky_menu]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Sticky Navigation', 'generate-menu-plus' ),
			'section' => $sticky_menu_section,
			'choices' => array(
				'mobile' => __( 'Mobile only', 'generate-menu-plus' ),
				'desktop' => __( 'Desktop only', 'generate-menu-plus' ),
				'true' => __( 'Both', 'generate-menu-plus' ),
				'false' => __( 'Disable', 'generate-menu-plus' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_menu_plus_settings[sticky_menu]',
			'priority' => 105
		)
	);
	
	// Add sticky nav setting
	$wp_customize->add_setting(
		// ID
		'generate_menu_plus_settings[sticky_menu_effect]',
		// Arguments array
		array(
			'default' => $defaults['sticky_menu_effect'],
			'type' => 'option',
			'sanitize_callback' => 'generate_menu_plus_sanitize_choices'
		)
	);
	
	// Add sticky nav control
	$wp_customize->add_control(
		// ID
		'generate_menu_plus_settings[sticky_menu_effect]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Sticky Navigation Effect', 'generate-menu-plus' ),
			'section' => $sticky_menu_section,
			'choices' => array(
				'fade' => __( 'Fade', 'generate-menu-plus' ),
				'slide' => __( 'Slide', 'generate-menu-plus' ),
				'none' => __( 'None', 'generate-menu-plus' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_menu_plus_settings[sticky_menu_effect]',
			'active_callback' => 'generate_sticky_navigation_activated',
			'priority' => 110
		)
	);
	
	$wp_customize->add_setting( 
		'generate_menu_plus_settings[sticky_menu_logo]', 
		array(
			'default' => $defaults['sticky_menu_logo'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
 
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'generate_menu_plus_settings[sticky_menu_logo]',
			array(
				'label' => __('Sticky Navigation Logo','generate'),
				'section' => $sticky_menu_section,
				'settings' => 'generate_menu_plus_settings[sticky_menu_logo]',
				'active_callback' => 'generate_sticky_navigation_activated',
				'priority' => 115
			)
		)
	);
	
	// Add sticky nav setting
	$wp_customize->add_setting(
		// ID
		'generate_menu_plus_settings[sticky_menu_logo_position]',
		// Arguments array
		array(
			'default' => $defaults['sticky_menu_logo_position'],
			'type' => 'option',
			'sanitize_callback' => 'generate_menu_plus_sanitize_choices'
		)
	);
	
	// Add sticky nav control
	$wp_customize->add_control(
		// ID
		'generate_menu_plus_settings[sticky_menu_logo_position]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Sticky Navigation Logo Position', 'generate-menu-plus' ),
			'section' => $sticky_menu_section,
			'choices' => array(
				'sticky-menu' => __( 'Sticky Only', 'generate-menu-plus' ),
				'menu' => __( 'Sticky + Regular', 'generate-menu-plus' ),
				'regular-menu' => __( 'Regular Only', 'generate-menu-plus' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_menu_plus_settings[sticky_menu_logo_position]',
			'active_callback' => 'generate_sticky_navigation_activated',
			'priority' => 120
		)
	);
	
	// Add Menu Extended section
	$wp_customize->add_section(
		// ID
		'menu_plus_mobile_header',
		// Arguments array
		array(
			'title' => __( 'Mobile Header', 'generate-menu-plus' ),
			'capability' => 'edit_theme_options',
			'panel' => $panel,
			'priority' => 11
		)
	);
	
	// Add sticky nav setting
	$wp_customize->add_setting(
		// ID
		'generate_menu_plus_settings[mobile_header]',
		// Arguments array
		array(
			'default' => $defaults['mobile_header'],
			'type' => 'option',
			'sanitize_callback' => 'generate_menu_plus_sanitize_choices'
		)
	);
	
	// Add sticky nav control
	$wp_customize->add_control(
		// ID
		'generate_menu_plus_settings[mobile_header]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Mobile Header', 'generate-menu-plus' ),
			'section' => $header_section,
			'choices' => array(
				'disable' => __( 'Disable', 'generate-menu-plus' ),
				'enable' => __( 'Enable', 'generate-menu-plus' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_menu_plus_settings[mobile_header]',
		)
	);
	
	$wp_customize->add_setting( 
		'generate_menu_plus_settings[mobile_header_logo]', 
		array(
			'default' => $defaults['mobile_header_logo'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
 
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'generate_menu_plus_settings[mobile_header_logo]',
			array(
				'label' => __('Mobile Header Logo','generate'),
				'section' => $header_section,
				'settings' => 'generate_menu_plus_settings[mobile_header_logo]',
				'active_callback' => 'generate_mobile_header_activated'
			)
		)
	);
	
	// Add sticky nav setting
	$wp_customize->add_setting(
		// ID
		'generate_menu_plus_settings[mobile_header_sticky]',
		// Arguments array
		array(
			'default' => $defaults['mobile_header_sticky'],
			'type' => 'option',
			'sanitize_callback' => 'generate_menu_plus_sanitize_choices'
		)
	);
	
	// Add sticky nav control
	$wp_customize->add_control(
		// ID
		'generate_menu_plus_settings[mobile_header_sticky]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Sticky Mobile Header', 'generate-menu-plus' ),
			'section' => $header_section,
			'choices' => array(
				'enable' => __( 'Enable', 'generate-menu-plus' ),
				'disable' => __( 'Disable', 'generate-menu-plus' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_menu_plus_settings[mobile_header_sticky]',
			'active_callback' => 'generate_mobile_header_activated'
		)
	);
	
	// Add Menu Extended section
	$wp_customize->add_section(
		// ID
		'menu_plus_slideout_menu',
		// Arguments array
		array(
			'title' => __( 'Slideout Menu', 'generate-menu-plus' ),
			'capability' => 'edit_theme_options',
			'panel' => $panel,
			'priority' => 19
		)
	);
	
	// Add slideout nav setting
	$wp_customize->add_setting(
		// ID
		'generate_menu_plus_settings[slideout_menu]',
		// Arguments array
		array(
			'default' => $defaults['slideout_menu'],
			'type' => 'option',
			'sanitize_callback' => 'generate_menu_plus_sanitize_choices'
		)
	);
	
	// Add sticky nav control
	$wp_customize->add_control(
		// ID
		'generate_menu_plus_settings[slideout_menu]',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Slideout Navigation', 'generate-menu-plus' ),
			'section' => $navigation_section,
			'choices' => array(
				'mobile' => __( 'Mobile only', 'generate-menu-plus' ),
				'desktop' => __( 'Desktop only', 'generate-menu-plus' ),
				'both' => __( 'Both', 'generate-menu-plus' ),
				'false' => __( 'Disable', 'generate-menu-plus' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_menu_plus_settings[slideout_menu]',
			'priority' => 150
		)
	);
}
endif;

if ( ! function_exists( 'generate_menu_plus_customizer_live_preview' ) ) :
add_action( 'customize_preview_init', 'generate_menu_plus_customizer_live_preview' );
function generate_menu_plus_customizer_live_preview()
{
	wp_enqueue_script( 
		  'generate-menu-plus-themecustomizer',
		  plugin_dir_url( __FILE__ ) . '/js/customizer.js',
		  array( 'jquery','customize-preview' ),
		  GENERATE_MENU_PLUS_VERSION,
		  true
	);
}
endif;

if ( ! function_exists( 'generate_menu_plus_enqueue_css' ) ) :
/**
 * Enqueue scripts
 */
add_action( 'wp_enqueue_scripts','generate_menu_plus_enqueue_css', 100 );
function generate_menu_plus_enqueue_css()
{
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	// Add sticky menu script
	if ( 'false' !== $generate_menu_plus_settings['sticky_menu'] && 'none' !== $generate_menu_plus_settings['sticky_menu_effect'] ) :
		wp_enqueue_style( 'generate-advanced-sticky', plugin_dir_url( __FILE__ ) . 'css/advanced-sticky.min.css', array(), GENERATE_MENU_PLUS_VERSION );
	endif;
	
	// Add sticky menu script
	if ( 'false' !== $generate_menu_plus_settings['sticky_menu'] && 'none' == $generate_menu_plus_settings['sticky_menu_effect'] ) :
		wp_enqueue_style( 'generate-sticky', plugin_dir_url( __FILE__ ) . 'css/sticky.min.css', array(), GENERATE_MENU_PLUS_VERSION );
	endif;
	
	// Add slideout menu script
	if ( 'false' !== $generate_menu_plus_settings['slideout_menu'] ) :
		wp_enqueue_style( 'generate-sliiide', plugin_dir_url( __FILE__ ) . 'css/sliiide.min.css', array(), GENERATE_MENU_PLUS_VERSION );
	endif;
	
	if ( 'mobile' == $generate_menu_plus_settings['slideout_menu'] || 'both' == $generate_menu_plus_settings['slideout_menu'] ) :
		wp_dequeue_script( 'generate-navigation' );
	endif;
	
	// Add regular menu logo styling
	if ( '' !== $generate_menu_plus_settings['sticky_menu_logo'] && 'regular-menu' == $generate_menu_plus_settings['sticky_menu_logo_position'] ) :
		wp_enqueue_style( 'generate-menu-logo', plugin_dir_url( __FILE__ ) . 'css/menu-logo.min.css', array(), GENERATE_MENU_PLUS_VERSION );
	endif;
	
	// Add mobile header CSS
	if ( 'enable' == $generate_menu_plus_settings['mobile_header'] ) :
		wp_enqueue_style( 'generate-mobile-header', plugin_dir_url( __FILE__ ) . 'css/mobile-header.min.css', array(), GENERATE_MENU_PLUS_VERSION );
	endif;
	
	// Add inline CSS
	wp_add_inline_style( 'generate-style', generate_menu_plus_inline_css() );
	
}
endif;

if ( ! function_exists( 'generate_menu_plus_enqueue_js' ) ) :
/**
 * Enqueue scripts
 */
add_action( 'wp_enqueue_scripts','generate_menu_plus_enqueue_js', 0 );
function generate_menu_plus_enqueue_js()
{
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	if ( function_exists( 'generate_get_defaults' ) ) :
	$generate_settings = wp_parse_args( 
		get_option( 'generate_settings', array() ), 
		generate_get_defaults() 
	);
	endif;
	
	// Add sticky menu script
	if ( 'false' !== $generate_menu_plus_settings['sticky_menu'] && 'none' !== $generate_menu_plus_settings['sticky_menu_effect'] ) :
		if ( 'enable' == $generate_settings['nav_search'] ) {
			$array = array( 'generate-classie', 'generate-navigation-search' );
		} else {
			$array = array( 'generate-classie' );
		}
		wp_enqueue_script( 'generate-classie', plugin_dir_url( __FILE__ ) . 'js/classie.min.js', array(), GENERATE_MENU_PLUS_VERSION, true );
		wp_enqueue_script( 'generate-advanced-sticky', plugin_dir_url( __FILE__ ) . 'js/advanced-sticky.min.js', $array, GENERATE_MENU_PLUS_VERSION, true );
	endif;
	
	// Add sticky menu script
	if ( ( 'false' !== $generate_menu_plus_settings['sticky_menu'] && 'none' == $generate_menu_plus_settings['sticky_menu_effect'] ) || 'enable' == $generate_menu_plus_settings['mobile_header_sticky'] ) :
		wp_enqueue_script( 'generate-sticky', plugin_dir_url( __FILE__ ) . 'js/sticky.min.js', array(), GENERATE_MENU_PLUS_VERSION, true );
		if ( function_exists( 'wp_script_add_data' ) ) :
			wp_enqueue_script( 'generate-sticky-matchMedia', plugin_dir_url( __FILE__ ) . 'js/matchMedia.min.js', array(), GENERATE_MENU_PLUS_VERSION, true );
			wp_script_add_data( 'generate-sticky-matchMedia', 'conditional', 'lt IE 10' );
		endif;
	endif;
	
	// Add slideout menu script
	if ( 'false' !== $generate_menu_plus_settings['slideout_menu'] ) :
		wp_enqueue_script( 'generate-sliiide', plugin_dir_url( __FILE__ ) . 'js/sliiide.min.js', array( 'jquery' ), GENERATE_MENU_PLUS_VERSION, true );
	endif;
	
	if ( 'mobile' == $generate_menu_plus_settings['slideout_menu'] || 'both' == $generate_menu_plus_settings['slideout_menu'] ) :
		wp_enqueue_script( 'generate-sliiide-navigation', plugin_dir_url( __FILE__ ) . 'js/navigation.min.js', array(), GENERATE_MENU_PLUS_VERSION, true );
	endif;
	
}
endif;

if ( ! function_exists( 'generate_menu_plus_inline_css' ) ) :
/**
 * Enqueue inline CSS
 */
function generate_menu_plus_inline_css()
{
	// Set up defaults in case they deactivate GeneratePress
	if ( function_exists( 'generate_get_defaults' ) ) :
		$default_settings = generate_get_defaults();
	else :
		$default_settings['container_width'] = 1200;
		$default_settings['nav_layout_setting'] = 'fluid-nav';
		$default_settings['background_color'] = '#EFEFEF';
	endif;
	
	// Set up defaults in case they deactivate GeneratePress
	if ( function_exists( 'generate_get_color_defaults' ) ) :
		$default_colors = generate_get_color_defaults();
	else :
		$default_colors['navigation_background_color'] = '#222222';
	endif;
	
	// Merge all of our defaults into $generate_settings
	$all_settings = array_merge( $default_settings, $default_colors );
	$generate_settings = wp_parse_args( 
		get_option( 'generate_settings', array() ), 
		$all_settings
	);
	
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	if ( function_exists( 'generate_spacing_get_defaults' ) ) :
		
		$spacing_settings = wp_parse_args( 
			get_option( 'generate_spacing_settings', array() ), 
			generate_spacing_get_defaults() 
		);
			
	endif;
	
	$menu_height = ( function_exists('generate_spacing_get_defaults') ) ? $spacing_settings['menu_item_height'] : 60;
	
	$return = '';
	$return .= '@media (max-width: ' . ( $generate_settings['container_width'] + 10 ) . 'px) {.main-navigation .sticky-logo {margin-left: 10px;}}';
	$return .= '.sidebar .navigation-clone .grid-container {max-width: ' . $generate_settings['container_width'] . 'px;}';
	
	if ( 'contained-nav' == $generate_settings['nav_layout_setting'] && 'false' !== $generate_menu_plus_settings['sticky_menu'] ) :
		$return .= '@media (min-width: ' . $generate_settings['container_width'] . 'px) { .nav-below-header .navigation-clone.main-navigation, .nav-above-header .navigation-clone.main-navigation, .nav-below-header .main-navigation.is_stuck, .nav-above-header .main-navigation.is_stuck { left: 50%; width: 100%; max-width: ' . $generate_settings['container_width'] . 'px; margin-left: -' . $generate_settings['container_width'] / 2 . 'px; } }';
		$return .= '@media (min-width: 768px) and (max-width: ' . ($generate_settings['container_width'] - 1) . 'px) {.nav-below-header .navigation-clone.main-navigation, .nav-above-header .navigation-clone.main-navigation { width: 100%; } }';
		$return .= '@media (min-width: ' . $generate_settings['container_width'] . 'px) { .nav-float-right .navigation-clone.main-navigation, .nav-float-right .main-navigation.is_stuck, .nav-float-left .navigation-clone.main-navigation, .nav-float-left .main-navigation.is_stuck { float: none;left: 50%; width: 100%; max-width: ' . $generate_settings['container_width'] . 'px; margin-left: -' . $generate_settings['container_width'] / 2 . 'px; } }';
		$return .= '@media (min-width: 768px) and (max-width: ' . ($generate_settings['container_width'] - 1) . 'px) {.nav-float-right .navigation-clone.main-navigation, .nav-float-left .navigation-clone.main-navigation { width: 100%; } }';
	endif;
	
	if ( '' !== $generate_menu_plus_settings['sticky_menu_logo'] ) :
		$logo_height = $menu_height - 20;
		$return .= '.main-navigation .sticky-logo, .main-navigation .sticky-logo img {height:' . $logo_height . 'px;}';
	endif;
	
	if ( '' !== $generate_menu_plus_settings['mobile_header_logo'] ) :
		$logo_height = $menu_height - 20;
		$return .= '.mobile-header-navigation .mobile-header-logo, .mobile-header-navigation .mobile-header-logo img {height:' . $logo_height . 'px;}';
	endif;
	
	return $return;
}
endif;

if ( ! function_exists( 'generate_menu_plus_mobile_menu_script' ) ) :
add_action( 'wp_footer','generate_menu_plus_mobile_menu_script' );
function generate_menu_plus_mobile_menu_script()
{
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	if ( 'desktop' == $generate_menu_plus_settings[ 'slideout_menu' ] || 'false' == $generate_menu_plus_settings[ 'slideout_menu' ] ) { ?>
		<script>
			jQuery( document ).ready( function( $ ) {
				$( '#mobile-header .menu-toggle' ).GenerateMobileMenu();
			});
		</script>
	<?php }
	
	if ( 'enable' == $generate_menu_plus_settings[ 'mobile_header_sticky' ] ) { ?>
		<script>
			jQuery( document ).ready( function( $ ) {
				
				jQuery( '#mobile-header' ).GenerateSimpleSticky({
					query: '(min-width: 783px)',
					disable: true
				});
					
				jQuery( '#mobile-header' ).GenerateSimpleSticky({
					query: '(min-width: 769px) and (max-width: 782px)',
					disable: true
				});
				
				jQuery( '#mobile-header' ).GenerateSimpleSticky({
					query: '(min-width: 601px) and (max-width: 768px)'
				});
				
				jQuery( '#mobile-header' ).GenerateSimpleSticky({
					query: '(max-width: 600px)',
					offset: 0
				});
			});
		</script>
	<?php }
}
endif;

if ( ! function_exists( 'generate_menu_plus_mobile_header' ) ) :
add_action( 'generate_after_header', 'generate_menu_plus_mobile_header', 5 );
add_action( 'generate_inside_mobile_header','generate_navigation_search');
add_action( 'generate_inside_mobile_header','generate_mobile_menu_search_icon' );
function generate_menu_plus_mobile_header()
{
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	if ( 'disable' == $generate_menu_plus_settings[ 'mobile_header' ] )
		return;
	
	?>
	<nav itemtype="http://schema.org/SiteNavigationElement" itemscope="itemscope" id="mobile-header" <?php generate_navigation_class( 'mobile-header-navigation' ); ?>>
		<div class="inside-navigation grid-container grid-parent">
			<?php do_action( 'generate_inside_mobile_header' ); ?>
			<button class="menu-toggle" aria-controls="mobile-menu" aria-expanded="false">
				<?php do_action( 'generate_inside_mobile_header_menu' ); ?>
				<span class="mobile-menu"><?php echo apply_filters('generate_mobile_menu_label', __( 'Menu', 'generate' ) ); ?></span>
			</button>
			<?php 
			wp_nav_menu( 
				array( 
					'theme_location' => apply_filters( 'generate_mobile_header_theme_location', 'primary' ),
					'container' => 'div',
					'container_class' => 'main-nav',
					'container_id' => 'mobile-menu',
					'menu_class' => '',
					'fallback_cb' => 'generate_menu_fallback',
					'items_wrap' => '<ul id="%1$s" class="%2$s ' . join( ' ', generate_get_menu_class() ) . '">%3$s</ul>'
				) 
			);
			?>
		</div><!-- .inside-navigation -->
	</nav><!-- #site-navigation -->
	<?php
}
endif;

if ( ! function_exists( 'generate_slideout_navigation' ) ) :
/**
 *
 * Build the navigation
 * @since 0.1
 *
 */
add_action( 'wp_footer','generate_slideout_navigation', 0 );
function generate_slideout_navigation()
{
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	if ( 'false' == $generate_menu_plus_settings['slideout_menu'] )
		return;
	
	?>
	<nav itemtype="http://schema.org/SiteNavigationElement" itemscope="itemscope" id="generate-slideout-menu" <?php generate_slideout_navigation_class(); ?>>
		<div class="inside-navigation grid-container grid-parent">
			<?php do_action( 'generate_inside_slideout_navigation' ); ?>
			<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'generate' ); ?>"><?php _e( 'Skip to content', 'generate' ); ?></a></div>
			<?php 
			wp_nav_menu( 
				array( 
					'theme_location' => 'slideout',
					'container' => 'div',
					'container_class' => 'main-nav',
					'menu_class' => '',
					'fallback_cb' => 'generate_slideout_menu_fallback',
					'items_wrap' => '<ul id="%1$s" class="%2$s ' . join( ' ', generate_get_slideout_menu_class() ) . '">%3$s</ul>'
				) 
			);
			?>
			<?php do_action( 'generate_after_slideout_navigation' ); ?>
		</div><!-- .inside-navigation -->
	</nav><!-- #site-navigation -->
	<div class="slideout-overlay" style="display: none;"></div>
	<?php
}
endif;

if ( ! function_exists( 'generate_slideout_menu_fallback' ) ) :
/**
 * Menu fallback. 
 *
 * @param  array $args
 * @return string
 * @since 1.1.4
 */
function generate_slideout_menu_fallback( $args )
{ 
	$generate_settings = wp_parse_args( 
		get_option( 'generate_settings', array() ), 
		generate_get_defaults() 
	);
	?>
	<div class="main-nav">
		<ul <?php generate_slideout_menu_class(); ?>>
			<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
		</ul>
	</div><!-- .main-nav -->
	<?php 
}
endif;

if ( ! function_exists( 'generate_slideout_navigation_class' ) ) :
/**
 * Display the classes for the slideout navigation.
 *
 * @since 0.1
 * @param string|array $class One or more classes to add to the class list.
 */
function generate_slideout_navigation_class( $class = '' ) {
	// Separates classes with a single space, collates classes for post DIV
	echo 'class="' . join( ' ', generate_get_slideout_navigation_class( $class ) ) . '"';
}
endif;

if ( ! function_exists( 'generate_get_slideout_navigation_class' ) ) :
/**
 * Retrieve the classes for the slideout navigation.
 *
 * @since 0.1
 * @param string|array $class One or more classes to add to the class list.
 * @return array Array of classes.
 */
function generate_get_slideout_navigation_class( $class = '' ) {

	$classes = array();

	if ( !empty($class) ) {
		if ( !is_array( $class ) )
			$class = preg_split('#\s+#', $class);
		$classes = array_merge($classes, $class);
	}

	$classes = array_map('esc_attr', $classes);

	return apply_filters('generate_slideout_navigation_class', $classes, $class);
}
endif;

if ( ! function_exists( 'generate_slideout_menu_class' ) ) :
/**
 * Display the classes for the slideout navigation.
 *
 * @since 0.1
 * @param string|array $class One or more classes to add to the class list.
 */
function generate_slideout_menu_class( $class = '' ) {
	// Separates classes with a single space, collates classes for post DIV
	echo 'class="' . join( ' ', generate_get_slideout_menu_class( $class ) ) . '"';
}
endif;

if ( ! function_exists( 'generate_get_slideout_menu_class' ) ) :
/**
 * Retrieve the classes for the slideout navigation.
 *
 * @since 0.1
 * @param string|array $class One or more classes to add to the class list.
 * @return array Array of classes.
 */
function generate_get_slideout_menu_class( $class = '' ) {

	$classes = array();

	if ( !empty($class) ) {
		if ( !is_array( $class ) )
			$class = preg_split('#\s+#', $class);
		$classes = array_merge($classes, $class);
	}

	$classes = array_map('esc_attr', $classes);

	return apply_filters('generate_slideout_menu_class', $classes, $class);
}
endif;

if ( ! function_exists( 'generate_slideout_menu_classes' ) ) :
/**
 * Adds custom classes to the menu
 * @since 0.1
 */
add_filter( 'generate_slideout_menu_class', 'generate_slideout_menu_classes');
function generate_slideout_menu_classes( $classes )
{
	
	$classes[] = 'slideout-menu';
	return $classes;
	
}
endif;

if ( ! function_exists( 'generate_slideout_navigation_classes' ) ) :
/**
 * Adds custom classes to the navigation
 * @since 0.1
 */
add_filter( 'generate_slideout_navigation_class', 'generate_slideout_navigation_classes');
function generate_slideout_navigation_classes( $classes )
{

	$slideout_effect = apply_filters( 'generate_menu_slideout_effect','overlay' );
	$slideout_position = apply_filters( 'generate_menu_slideout_position','left' );
	
	$classes[] = 'main-navigation';
	$classes[] = 'slideout-navigation';

	return $classes;
	
}
endif;

if ( ! function_exists( 'generate_slideout_body_classes' ) ) :
/**
 * Adds custom classes to body
 * @since 0.1
 */
add_filter( 'body_class', 'generate_slideout_body_classes');
function generate_slideout_body_classes( $classes )
{
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	if ( 'false' !== $generate_menu_plus_settings['slideout_menu'] ) :
		$classes[] = 'slideout-enabled';
	endif;
	
	if ( 'mobile' == $generate_menu_plus_settings['slideout_menu'] ) :
		$classes[] = 'slideout-mobile';
	endif;
	
	if ( 'desktop' == $generate_menu_plus_settings['slideout_menu'] ) :
		$classes[] = 'slideout-desktop';
	endif;
	
	if ( 'both' == $generate_menu_plus_settings['slideout_menu'] ) :
		$classes[] = 'slideout-both';
	endif;
	
	if ( 'slide' == $generate_menu_plus_settings['sticky_menu_effect'] ) :
		$classes[] = 'sticky-menu-slide';
	endif;
	
	if ( 'fade' == $generate_menu_plus_settings['sticky_menu_effect'] ) :
		$classes[] = 'sticky-menu-fade';
	endif;
	
	if ( 'none' == $generate_menu_plus_settings['sticky_menu_effect'] ) :
		$classes[] = 'sticky-menu-no-transition';
	endif;
	
	if ( 'sticky-menu' == $generate_menu_plus_settings['sticky_menu_logo_position'] ) :
		$classes[] = 'navigation-logo-sticky';
	elseif ( 'menu' == $generate_menu_plus_settings['sticky_menu_logo_position'] ) :
		$classes[] = 'navigation-logo';
	elseif ( 'regular-menu' == $generate_menu_plus_settings['sticky_menu_logo_position'] ) :
		$classes[] = 'navigation-logo-regular';
	endif;
	
	if ( 'false' !== $generate_menu_plus_settings['sticky_menu'] ) :
		$classes[] = 'sticky-enabled';
	endif;
	
	if ( '' !== $generate_menu_plus_settings['sticky_menu_logo'] ) :
		if ( 'sticky-menu' == $generate_menu_plus_settings['sticky_menu_logo_position'] ) :
			$classes[] = 'sticky-menu-logo';
		elseif ( 'menu' == $generate_menu_plus_settings['sticky_menu_logo_position'] ) :
			$classes[] = 'menu-logo';
		elseif ( 'regular-menu' == $generate_menu_plus_settings['sticky_menu_logo_position'] ) :
			$classes[] = 'regular-menu-logo';
		endif;
		$classes[] = 'menu-logo-enabled';
	endif;
	
	if ( 'mobile' == $generate_menu_plus_settings['sticky_menu'] ) :
		$classes[] = 'mobile-sticky-menu';
	endif;
	
	if ( 'desktop' == $generate_menu_plus_settings['sticky_menu'] ) :
		$classes[] = 'desktop-sticky-menu';
	endif;
	
	if ( 'enable' == $generate_menu_plus_settings['mobile_header'] ) :
		$classes[] = 'mobile-header';
	endif;
	
	if ( '' !== $generate_menu_plus_settings['mobile_header_logo'] ) :
		$classes[] = 'mobile-header-logo';
	endif;
	
	if ( 'enable' == $generate_menu_plus_settings['mobile_header_sticky'] ) :
		$classes[] = 'mobile-header-sticky';
	endif;
	
	return $classes;
	
}
endif;

if ( ! function_exists( 'generate_menu_plus_slidebar_icon' ) ) :
/**
 * Add slidebar icon to primary menu if set
 *
 * @since 0.1
 */
add_filter( 'wp_nav_menu_items','generate_menu_plus_slidebar_icon', 10, 2 );
function generate_menu_plus_slidebar_icon( $nav, $args ) 
{
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	// If the search icon isn't enabled, return the regular nav
	if ( 'desktop' !== $generate_menu_plus_settings['slideout_menu'] && 'both' !== $generate_menu_plus_settings['slideout_menu'] )
		return $nav;
	
	// If our primary menu is set, add the search icon
    if( $args->theme_location == 'primary' )
        return $nav . '<li class="slideout-toggle"><a href="#generate-slideout-menu" data-transition="overlay"></a></li>';
	
	// Our primary menu isn't set, return the regular nav
	// In this case, the search icon is added to the generate_menu_fallback() function in navigation.php
    return $nav;
}
endif;

if ( ! function_exists( 'generate_menu_plus_label' ) ) :
/**
 * Add mobile menu label
 *
 * @since 0.1
 */
add_filter( 'generate_mobile_menu_label','generate_menu_plus_label' );
function generate_menu_plus_label()
{
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	return $generate_menu_plus_settings['mobile_menu_label'];
}
endif;

if ( ! function_exists( 'generate_menu_plus_sticky_logo' ) ) :
/**
 * Add logo to sticky menu
 *
 * @since 0.1
 */
add_action( 'generate_inside_navigation','generate_menu_plus_sticky_logo' );
function generate_menu_plus_sticky_logo()
{
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	if ( '' == $generate_menu_plus_settings['sticky_menu_logo'] )
		return;
	
	if ( 'false' == $generate_menu_plus_settings['sticky_menu'] && 'regular-menu' !== $generate_menu_plus_settings['sticky_menu_logo_position'] )
		return;
		 
	?>
	<div class="site-logo sticky-logo">
		<a href="<?php echo apply_filters( 'generate_logo_href' , esc_url( home_url( '/' ) ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img class="header-image" src="<?php echo $generate_menu_plus_settings['sticky_menu_logo']; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'generate_menu_plus_mobile_header_logo' ) ) :
/**
 * Add logo to mobile header
 *
 * @since 0.1
 */
add_action( 'generate_inside_mobile_header','generate_menu_plus_mobile_header_logo' );
function generate_menu_plus_mobile_header_logo()
{
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	if ( '' == $generate_menu_plus_settings['mobile_header_logo'] )
		return;
		 
	?>
	<div class="site-logo mobile-header-logo">
		<a href="<?php echo apply_filters( 'generate_logo_href' , esc_url( home_url( '/' ) ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img class="header-image" src="<?php echo $generate_menu_plus_settings['mobile_header_logo']; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'generate_sticky_menu_js_new' ) ) :
add_action( 'wp_footer','generate_sticky_menu_js_new' );
function generate_sticky_menu_js_new()
{
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	if ( function_exists( 'generate_get_defaults' ) ) :
		$generate_settings = wp_parse_args( 
			get_option( 'generate_settings', array() ), 
			generate_get_defaults() 
		);
	endif;
	
	if ( 'false' == $generate_menu_plus_settings[ 'sticky_menu' ] )
		return;
		
	if ( 'none' !== $generate_menu_plus_settings[ 'sticky_menu_effect' ] )
		return;
		
?>
	
<script type="text/javascript">		
	jQuery( window ).load( function( $ ) {
		<?php if ( 'nav-right-sidebar' == $generate_settings[ 'nav_position_setting' ] || 'nav-left-sidebar' == $generate_settings[ 'nav_position_setting' ] ) : ?>
			var navigation = jQuery( ".gen-sidebar-nav" );
		<?php else : ?>
			var navigation = jQuery( "#site-navigation" );
		<?php endif; ?>
		

		<?php if ( 'mobile' == $generate_menu_plus_settings['sticky_menu'] ) : ?>				
			jQuery( navigation ).GenerateSimpleSticky({
				query: '(min-width: 783px)',
				disable: true
			});
				
			jQuery( navigation ).GenerateSimpleSticky({
				query: '(min-width: 768px) and (max-width: 782px)',
				disable: true
			});
			
			jQuery( navigation ).GenerateSimpleSticky({
				query: '(min-width: 601px) and (max-width: 767px)'
			});
			
			jQuery( navigation ).GenerateSimpleSticky({
				query: '(max-width: 600px)',
				offset: 0
			});
		<?php endif;
		
		if ( 'desktop' == $generate_menu_plus_settings['sticky_menu'] ) : ?>
			jQuery( navigation ).GenerateSimpleSticky({
				query: '(min-width: 783px)'
			});
			
			jQuery( navigation ).GenerateSimpleSticky({
				query: '(min-width: 768px) and (max-width: 782px)'
			});
			
			jQuery( navigation ).GenerateSimpleSticky({
				query: '(max-width: 767px)',
				disable: true
			});
		<?php endif;
		
		if ( 'true' == $generate_menu_plus_settings['sticky_menu'] ) : ?>
			jQuery( navigation ).GenerateSimpleSticky({
				query: '(min-width: 783px)'
			});
			
			jQuery( navigation ).GenerateSimpleSticky({
				query: '(min-width: 768px) and (max-width: 782px)'
			});
			
			jQuery( navigation ).GenerateSimpleSticky({
				query: '(min-width: 601px) and (max-width: 767px)'
			});
			
			jQuery( navigation ).GenerateSimpleSticky({
				query: '(max-width: 600px)',
				offset: 0
			});
		<?php endif; ?>
			
		jQuery( document ).ready( function( $ ) {
			if ( navigator.userAgent.match( /(iPod|iPhone|iPad)/ ) ) {
				/* cache dom references */ 
				var $body = jQuery('body'); 

				/* bind events */
				jQuery(document)
				.on('focus', '.is_stuck .search-field', function() {
					$body.addClass('fixfixed');
					navigation.trigger("sticky_kit:detach");
					
				})
				.on('blur', '.search-field', function() {
					$body.removeClass('fixfixed');
					navigation.stick_in_parent({
						offset_top: 0
					});
				});
			}
		});
	});
</script>
<?php
}
endif;

if ( ! function_exists( 'generate_menu_plus_sanitize_choices' ) ) :
/**
 * Sanitize choices
 */
function generate_menu_plus_sanitize_choices( $input, $setting ) {
	
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

if ( ! function_exists( 'generate_mobile_header_activated' ) ) :
function generate_mobile_header_activated()
{
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	return ( 'enable' == $generate_menu_plus_settings[ 'mobile_header' ] ) ? true : false;
}
endif;

if ( ! function_exists( 'generate_sticky_navigation_activated' ) ) :
function generate_sticky_navigation_activated()
{
	$generate_menu_plus_settings = wp_parse_args( 
		get_option( 'generate_menu_plus_settings', array() ), 
		generate_menu_plus_get_defaults() 
	);
	
	return ( 'false' !== $generate_menu_plus_settings[ 'sticky_menu' ] ) ? true : false;
}
endif;
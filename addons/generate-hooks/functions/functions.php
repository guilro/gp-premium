<?php
/**
 * Insert Hooks
 */
require plugin_dir_path( __FILE__ ) . 'hooks.php';

if ( ! function_exists( 'generate_hooks_setup' ) ) :
function generate_hooks_setup()
{
	// Just to verify that we're activated.
}
endif;

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Generate_Hooks_Settings' ) ) :
class Generate_Hooks_Settings {
    private $dir;
	private $file;
	private $assets_dir;
	private $assets_url;
	private $settings_base;
	private $settings;

	public function __construct( $file ) {
		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );
		$this->settings_base = '';

		// Initialise settings
		add_action( 'admin_init', array( $this, 'init' ) );

		// Register plugin settings
		add_action( 'admin_init' , array( $this, 'register_settings' ) );

		// Add settings page to menu
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

		// Add settings link to plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->file ) , array( $this, 'add_settings_link' ) );
	}

	/**
	 * Initialise settings
	 * @return void
	 */
	public function init() {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item() {
		$page = add_theme_page( __( 'GP Hooks', 'generate-hooks' ) , __( 'GP Hooks', 'generate-hooks' ) , 'manage_options' , 'gp_hooks_settings' ,  array( $this, 'settings_page' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
	}

	/**
	 * Load settings JS & CSS
	 * @return void
	 */
	public function settings_assets() {
		
		wp_register_script( 'gp-hooks', $this->assets_url . 'js/admin.js', array( 'jquery' ), GENERATE_HOOKS_VERSION );
		wp_enqueue_script( 'gp-hooks' );
		
		wp_register_script( 'gp-cookie', $this->assets_url . 'js/jquery.cookie.js', array( 'jquery' ), GENERATE_HOOKS_VERSION );
		wp_enqueue_script( 'gp-cookie' );
	
		wp_enqueue_style( 'gp-hooks', $this->assets_url . 'css/hooks.css' );
	}

	/**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function add_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=gp_hooks_settings">' . __( 'GP Hooks', 'generate-hooks' ) . '</a>';
  		array_push( $links, $settings_link );
  		return $links;
	}

	/**
	 * Build settings fields
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields() {

		$settings['standard'] = array(
			'title'					=> '',
			'description'			=> '',
			'fields'				=> array(
				array(
					"name" => __('wp_head', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_wp_head',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('Before Header', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_before_header',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('Before Header Content', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_before_header_content',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('After Header Content', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_after_header_content',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('After Header', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_after_header',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('Inside Content Container', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_before_main_content',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('Before Content', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_before_content',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('After Entry Title', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_after_entry_header',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('After Content', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_after_content',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('Before Right Sidebar Content', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_before_right_sidebar_content',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('After Right Sidebar Content', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_after_right_sidebar_content',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('Before Left Sidebar Content', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_before_left_sidebar_content',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('After Left Sidebar Content', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_after_left_sidebar_content',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('Before Footer', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_before_footer',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('After Footer Widgets', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_after_footer_widgets',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('Before Footer Content', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_before_footer_content',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('After Footer Content', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_after_footer_content',
					"type" => 'textarea',
					"placeholder" => ''
				),
				
				array(
					"name" => __('wp_footer', 'generate-hooks'),
					"description" => "",
					"id" => 'generate_wp_footer',
					"type" => 'textarea',
					"placeholder" => ''
				)
			)
		);

		$settings = apply_filters( 'gp_hooks_settings_fields', $settings );

		return $settings;
	}

	/**
	 * Register plugin settings
	 * @return void
	 */
	public function register_settings() {
		if( is_array( $this->settings ) ) {
			foreach( $this->settings as $section => $data ) {

				// Add section to page
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), 'gp_hooks_settings' );

				foreach( $data['fields'] as $field ) {

					// Validation callback for field
					$validation = '';
					if( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}

					// Register field
					$option_name = $this->settings_base . $field['id'];
					register_setting( 'gp_hooks_settings', 'generate_hooks', $validation );

					// Add field to page
					add_settings_field( 'generate_hooks[' . $field['id'] . ']', $field['name'], array( $this, 'display_field' ), 'gp_hooks_settings', $section, array( 'field' => $field ) );
				}
			}
		}
	}

	public function settings_section( $section ) {
		$html = '';
		echo $html;
	}

	/**
	 * Generate HTML for displaying fields
	 * @param  array $args Field data
	 * @return void
	 */
	public function display_field( $args ) {

		$field = $args['field'];

		$html = '';

		$option_name = $this->settings_base . $field['id'];
		$option = get_option( 'generate_hooks' );

		$data = '';
		if( isset( $option[$option_name] ) ) {
			$data = $option[$option_name];
		} elseif( isset( $field['default'] ) ) {
			$data = $field['default'];
		}
		

		switch( $field['type'] ) {

			case 'textarea':
				$checked = '';
				$checked2 = '';
				if( isset( $option[$field['id'] . '_php'] ) && 'true' == $option[$field['id'] . '_php'] ){
					$checked = 'checked="checked"';
				}
				if( isset( $option[$field['id'] . '_disable'] ) && 'true' == $option[$field['id'] . '_disable'] ){
					$checked2 = 'checked="checked"';
				}
				$html .= '<textarea id="generate_hooks[' . esc_attr( $field['id'] ) . ']" name="generate_hooks[' . esc_attr( $field['id'] ) . ']" style="width:100%;height:200px;" placeholder="' . esc_attr( $field['description'] ) . '" type="checkbox" cols="" rows="">' . $data . '</textarea>';
				$html .= '<div class="execute"><input type="checkbox" name="generate_hooks[' . esc_attr( $field['id'] ) . '_php]" id="generate_hooks[' . esc_attr( $field['id'] ) . '_php]" value="true" ' . $checked . ' /> <label for="generate_hooks[' . esc_attr( $field['id'] ) . '_php]">' . __('Execute PHP', 'generate-hooks') . '</label></div>';
				$html .= '<div class="disable"><input type="checkbox" name="generate_hooks[' . esc_attr( $field['id'] ) . '_disable]" id="generate_hooks[' . esc_attr( $field['id'] ) . '_disable]" value="true" ' . $checked2 . ' /> <label for="generate_hooks[' . esc_attr( $field['id'] ) . '_disable]" class="disable">' . __('Disable Hook', 'generate-hooks') . '</label></div>';
			break;
			
			case 'checkbox':
				
				
			break;

		}

		echo $html;
	}

	/**
	 * Validate individual settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
	public function validate_field( $data ) {
		if( $data && strlen( $data ) > 0 && $data != '' ) {
			$data = urlencode( strtolower( str_replace( ' ' , '-' , $data ) ) );
		}
		return $data;
	}

	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page() {

		// Build page HTML
		$html = '<div class="wrap" id="gp_hooks_settings">';
			$html .= '<div id="poststuff">';
			$html .= '<div class="metabox-holder columns-2" id="post-body">';
			$html .= '<form method="post" action="options.php" enctype="multipart/form-data">';
				$html .= '<div id="post-body-content">';
					// Get settings fields
					ob_start();
						settings_fields( 'gp_hooks_settings' );
						do_settings_sections( 'gp_hooks_settings' );
					$html .= ob_get_clean();
				$html .= '</div>';
				
				$html .= '<div id="postbox-container-1">';
					$html .= '<div class="postbox sticky-scroll-box">';
						$html .= '<h3 class="hndle">' . __( 'GP Hooks','generate-hooks' ) . '</h3>';
						$html .= '<div class="inside">';
							$html .= '<p>' . __( 'Use these fields to insert anything you like throughout GeneratePress. Shortcodes are allowed, and you can even use PHP if you check the Execute PHP checkboxes.','generate-hooks' ) . '</p>';
							$html .= '<select id="hook-dropdown" style="margin-top:20px;">';
								$html .= '<option value="all">' . __('Show all','generate-hooks') . '</option>';
								if( is_array( $this->settings ) ) {
									foreach( $this->settings as $section => $data ) {
										$count = 0;
										foreach( $data['fields'] as $field ) {
											$html .= '<option id="' . $count++ . '">' . $field['name'] . '</option>';
										}
									}
								}
							$html .= '</select>';
							$html .= '<p style="padding:0;margin:13px 0 0 0;" class="submit">';
								$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Hooks' , 'generate-hooks' ) ) . '" />';
							$html .= '</p>';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</div>';
			$html .= '</form>';
			$html .= '</div>';
			$html .= '<br class="clear" />';
		$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}

}
$settings = new Generate_Hooks_Settings( __FILE__ );
endif;

if ( ! function_exists( 'generate_update_hooks' ) ) :
/** 
 * Moving standalone db entries to generate_hooks db entry
 */
add_action('admin_init', 'generate_update_hooks');
function generate_update_hooks() 
{	
	$generate_hooks = get_option( 'generate_hooks' );

	// If we've done this before, bail
	if( ! empty( $generate_hooks ) )
		return;
		
	// One last check
	if ( 'true' == $generate_hooks['updated'] )
		return;
		
	$hooks = generate_hooks_get_hooks();
	$generate_new_hooks = array();
	foreach ( $hooks as $hook ) {
	
		$current_hook = get_option( $hook );
		
		if ( isset( $current_hook ) && '' !== $current_hook ) :
			
			$generate_new_hooks[ $hook ] = get_option( $hook );
			$generate_new_hooks[ 'updated' ] = 'true';
			// Let's not delete the old options yet, just in case
			//delete_option( $hook );
			
		endif;

	}
	
	$generate_new_hook_settings = wp_parse_args( $generate_new_hooks, $generate_hooks );
	update_option( 'generate_hooks', $generate_new_hook_settings );

}
endif;

if ( ! function_exists( 'generate_hooks_admin_errors' ) ) :
/**
 * Add our admin notices
 */
add_action( 'admin_notices', 'generate_hooks_admin_errors' );
function generate_hooks_admin_errors() 
{
	$screen = get_current_screen();
	if ( 'appearance_page_gp_hooks_settings' !== $screen->base )
		return;
		
	if ( isset( $_GET['settings-updated'] ) && 'true' == $_GET['settings-updated'] ) {
		 add_settings_error( 'generate-hook-notices', 'true', __( 'Hooks saved.', 'generate-hooks' ), 'updated' );
	}

	settings_errors( 'generate-hook-notices' );
}
endif;
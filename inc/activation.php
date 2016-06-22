<?php
if ( ! function_exists( 'generate_license_errors' ) ) :
/*
* Set up errors and messages
*/
add_action( 'admin_notices', 'generate_premium_notices' );
function generate_premium_notices() 
{

	if ( isset( $_GET['generate-message'] ) && 'addon_deactivated' == $_GET['generate-message'] ) {
		 add_settings_error( 'generate-premium-notices', 'addon_deactivated', __( 'Add-on deactivated.', 'gp-premium' ), 'updated' );
	}
	
	if ( isset( $_GET['generate-message'] ) && 'addon_activated' == $_GET['generate-message'] ) {
		 add_settings_error( 'generate-premium-notices', 'addon_activated', __( 'Add-on activated.', 'gp-premium' ), 'updated' );
	}

	settings_errors( 'generate-premium-notices' );
}
endif;

/***********************************************
* Add the plugin activate button
***********************************************/
if ( ! function_exists( 'generate_super_package_addons' ) ) :
	add_action('generate_inside_options_form','generate_super_package_addons', 5); 
	function generate_super_package_addons()
	{
		
		$addons = array(
			'Typography' => 'generate_package_typography',
			'Colors' => 'generate_package_colors',
			'Backgrounds' => 'generate_package_backgrounds',
			'Page Header' => 'generate_package_page_header',
			'Sections' => 'generate_package_sections',
			'Import / Export' => 'generate_package_import_export',
			'Copyright' => 'generate_package_copyright',
			'Disable Elements' => 'generate_package_disable_elements',
			'Blog' => 'generate_package_blog',
			'Hooks' => 'generate_package_hooks',
			'Spacing' => 'generate_package_spacing',
			'Secondary Nav' => 'generate_package_secondary_nav',
			'Menu Plus' => 'generate_package_menu_plus'
		);
		
		$customizer = array(
			'Typography',
			'Colors',
			'Backgrounds',
			'Page Header',
			'Blog',
			'Spacing',
			'Secondary Nav',
			'Menu Plus'
		);
		
		$addon_count = 0;
		foreach ( $addons as $k => $v ) {
			if ( 'activated' == get_option( $v ) )
				$addon_count++;
		}
		
		$key = get_option( 'gen_premium_license_key_status', 'deactivated' );
		$email_status = get_option( 'generate_customer_email_status', '' );
		$downloads = get_option( 'generate_purchased_products', '' );
		$download = 'GP Premium';
		( defined('GP_PREMIUM_VERSION') ) ? $version = GP_PREMIUM_VERSION  : $version = '';
		
		?>
		<div class="postbox generate-metabox">
			<h3 class="hndle"><?php _e('GP Premium','gp-premium'); ?> <?php echo $version; ?></h3>
			<div class="inside">
				<div class="premium-addons">
					<form method="post">
						<div class="add-on gp-clear addon-container grid-parent" style="background:#EFEFEF;border-left:5px solid #DDD;padding-left:10px !important;">
							<div class="addon-name column-addon-name">
								<input type="checkbox" id="generate-select-all" />
								<select name="generate_mass_activate" class="mass-activate-select">
									<option value=""><?php _e( 'Bulk Actions' ) ;?></option>
									<option value="activate-selected"><?php _e( 'Activate' ) ;?></option>
									<option value="deactivate-selected"><?php _e( 'Deactivate' ) ;?></option>
								</select>
								<input type="submit" style="font-weight:bold;" name="generate_multi_activate" class="mass-activate-button" value="<?php _e( 'Apply' ); ?>" />
							</div>
						</div>
						<?php
						
						foreach ( $addons as $k => $v ) :
							
							$key = get_option( $v );
							
							if( $key == 'activated' ) { ?>
								<div class="add-on activated gp-clear addon-container grid-parent">
									<div class="addon-name column-addon-name" style="">
										<input type="checkbox" class="addon-checkbox" name="generate_addon_checkbox[]" value="<?php echo $v; ?>" />
										<?php echo $k;?>
									</div>
									<div class="addon-action addon-addon-action" style="text-align:right;">
										<!--<?php // if ( in_array( $k, $customizer ) && 'hidden' !== get_option( $v . '_visibility', '' ) ) : ?>
											<?php // wp_nonce_field( $v . '_hide_customizer_nonce', $v . '_hide_customizer_nonce' ); ?>
											<input type="submit" class="hide-customizer-button" name="<?php // echo $v;?>_hide_customizer" value="<?php // _e('Hide Customizer Options','generate');?>" title="<?php // _e('Done customizing with this add-on? Hide the options to speed up the Customizer.','generate');?>" />
										<?php // endif; ?>
										<?php // if ( in_array( $k, $customizer ) && 'hidden' == get_option( $v . '_visibility', '' ) ) : ?>
											<?php // wp_nonce_field( $v . '_show_customizer_nonce', $v . '_show_customizer_nonce' ); ?>
											<input type="submit" class="hide-customizer-button" name="<?php // echo $v;?>_show_customizer" value="<?php // _e('Show Customizer Options','generate');?>" title="<?php // _e('Need to use the Customizer options for this add-on? Show the options.','generate');?>" />
										<?php // endif; ?>-->
										<?php wp_nonce_field( $v . '_deactivate_nonce', $v . '_deactivate_nonce' ); ?>
										<input type="submit" name="<?php echo $v;?>_deactivate_package" value="<?php _e( 'Deactivate' );?>"/>
									</div>
								</div>
							<?php } else { ?>
								<div class="add-on gp-clear addon-container grid-parent">
									
									<div class="addon-name column-addon-name">
										<input type="checkbox" class="addon-checkbox" name="generate_addon_checkbox[]" value="<?php echo $v; ?>" />
										<?php echo $k;?>
									</div>
									
									<div class="addon-action addon-addon-action" style="text-align:right;">
										<?php wp_nonce_field( $v . '_activate_nonce', $v . '_activate_nonce' ); ?>
										<input type="submit" name="<?php echo $v;?>_activate_package" value="<?php _e( 'Activate' );?>"/>
									</div>
									
								</div>
							<?php }
							echo '<div class="gp-clear"></div>';
						endforeach;
						?>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery( document ).ready(function( $ ) {
				$( '#generate-select-all' ).click( function( event ) {  //on click 
					if( this.checked ) { // check select status
						$( '.addon-checkbox' ).each( function() { //loop through each checkbox
							this.checked = true;  //select all checkboxes with class "checkbox1"               
						});
					}else{
						$( '.addon-checkbox' ).each( function() { //loop through each checkbox
							this.checked = false; //deselect all checkboxes with class "checkbox1"                       
						});
					}
				});
				
			});
		</script>
		<style type="text/css">
			.mass-activate-select {
				padding: 5px !important;
				height: 35px !important;
			}
			.mass-activate-button,
			.mass-activate-button:visited {
				background:#FFF !important;
				border-bottom: 2px solid #ddd !important;
				height: 35px !important;
				position: relative;
				bottom: -1px;
				padding: 0 15px !important;
			}
			.mass-activate-button:hover {
				color:#000 !important;
				border-color: #ccc !important;
			}
			input#generate-select-all,
			.addon-checkbox {
				margin-right: 15px !important;
			}
			.gp-premium-version,
			.gp-addon-count {
				display: block;
				color:#ccc;
			}
		</style>
		<?php

	}
endif;

if ( ! function_exists( 'generate_multi_activate' ) ) :
add_action( 'admin_init','generate_multi_activate' );
function generate_multi_activate()
{
	// Deactivate selected
	if ( isset( $_POST['generate_multi_activate'] ) ) {
		$name = ( isset( $_POST['generate_addon_checkbox'] ) ) ? $_POST['generate_addon_checkbox'] : '';
		$option = ( isset( $_POST['generate_addon_checkbox'] ) ) ? $_POST['generate_mass_activate'] : '';

		if ( isset( $_POST['generate_addon_checkbox'] ) ) {
			
			if ( 'deactivate-selected' == $option ) :
				foreach ( $name as $id ) {
					if ( 'activated' == get_option( $id ) )
						update_option( $id, '' );
				}
			endif;
					
			if ( 'activate-selected' == $option ) :
				
				foreach ( $name as $id ) {
					if ( 'activated' !== get_option( $id ) ) :
						update_option( $id, 'activated' );
					endif;
				}
			endif;
			
			wp_safe_redirect( admin_url('themes.php?page=generate-options' ) );
			exit;
		}
	}
}
endif;

/***********************************************
* Activate the add-on
***********************************************/
if ( ! function_exists( 'generate_activate_super_package_addons' ) ) :
	add_action('admin_init', 'generate_activate_super_package_addons');
	function generate_activate_super_package_addons()
	{
		$addons = array(
			'Typography' => 'generate_package_typography',
			'Colors' => 'generate_package_colors',
			'Backgrounds' => 'generate_package_backgrounds',
			'Page Header' => 'generate_package_page_header',
			'Sections' => 'generate_package_sections',
			'Import / Export' => 'generate_package_import_export',
			'Copyright' => 'generate_package_copyright',
			'Disable Elements' => 'generate_package_disable_elements',
			'Blog' => 'generate_package_blog',
			'Hooks' => 'generate_package_hooks',
			'Spacing' => 'generate_package_spacing',
			'Secondary Nav' => 'generate_package_secondary_nav',
			'Menu Plus' => 'generate_package_menu_plus'
		);
		
		foreach( $addons as $k => $v ) :
		
			if( isset( $_POST[$v . '_activate_package'] ) ) {
		
				if( ! check_admin_referer( $v . '_activate_nonce', $v . '_activate_nonce' ) ) 	
					return; // get out if we didn't click the Activate button
				
				update_option( $v, 'activated' );
				wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=addon_activated' ) );
				exit;
			}
		
		endforeach;
	}
endif;

/***********************************************
* Hide from Customizer
***********************************************/
if ( ! function_exists( 'generate_hide_from_customizer' ) ) :
	//add_action('admin_init', 'generate_hide_from_customizer');
	function generate_hide_from_customizer()
	{
		// Add-ons that have Customizer options
		$addons = array(
			'Typography' => 'generate_package_typography',
			'Colors' => 'generate_package_colors',
			'Backgrounds' => 'generate_package_backgrounds',
			'Page Header' => 'generate_package_page_header',
			'Blog' => 'generate_package_blog',
			'Spacing' => 'generate_package_spacing',
			'Secondary Nav' => 'generate_package_secondary_nav',
			'Menu Plus' => 'generate_package_menu_plus'
		);
		
		foreach( $addons as $k => $v ) :
		
			if( isset( $_POST[$v . '_hide_customizer'] ) ) {
		
				if( ! check_admin_referer( $v . '_hide_customizer_nonce', $v . '_hide_customizer_nonce' ) ) 	
					return; // get out if we didn't click the Activate button
				
				update_option( $v . '_visibility', 'hidden' );
				wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=addon_hidden' ) );
				exit;
			}
		
		endforeach;
	}
endif;

/***********************************************
* Show in Customizer
***********************************************/
if ( ! function_exists( 'generate_show_in_customizer' ) ) :
	//add_action('admin_init', 'generate_show_in_customizer');
	function generate_show_in_customizer()
	{
		// Add-ons that have Customizer options
		$addons = array(
			'Typography' => 'generate_package_typography',
			'Colors' => 'generate_package_colors',
			'Backgrounds' => 'generate_package_backgrounds',
			'Page Header' => 'generate_package_page_header',
			'Blog' => 'generate_package_blog',
			'Spacing' => 'generate_package_spacing',
			'Secondary Nav' => 'generate_package_secondary_nav',
			'Menu Plus' => 'generate_package_menu_plus'
		);
		
		foreach( $addons as $k => $v ) :
		
			if( isset( $_POST[$v . '_show_customizer'] ) ) {
		
				if( ! check_admin_referer( $v . '_show_customizer_nonce', $v . '_show_customizer_nonce' ) ) 	
					return; // get out if we didn't click the Activate button
				
				update_option( $v . '_visibility', '' );
				wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=addon_shown' ) );
				exit;
			}
		
		endforeach;
	}
endif;

//add_action( 'customize_register', 'generate_remove_customizer_options', 1000 );
function generate_remove_customizer_options( $wp_customize )
{
	// Remove Blog sections
	if ( 'hidden' == get_option( 'generate_package_blog_visibility' ) ) :
		$wp_customize->remove_section('blog_content_section');
		$wp_customize->remove_section('blog_masonry_section');
		$wp_customize->remove_section('blog_post_image_section');
	endif;
		
	// Remove Background sections
	if ( 'hidden' == get_option( 'generate_package_backgrounds_visibility' ) )
		$wp_customize->remove_section('backgrounds_section');
		
	// Remove Spacing sections
	if ( 'hidden' == get_option( 'generate_package_spacing_visibility' ) )
		$wp_customize->remove_section('spacing_section');
		
	// Remove Secondary Nav sections
	if ( 'hidden' == get_option( 'generate_package_secondary_nav_visibility' ) ) :
		$wp_customize->remove_section('secondary_nav_section');
		$wp_customize->remove_section('secondary_navigation_spacing_section');
		$wp_customize->remove_section('secondary_navigation_color_section');
		$wp_customize->remove_section('secondary_subnavigation_color_section');
		$wp_customize->remove_section('secondary_font_section');
		$wp_customize->remove_section('secondary_bg_images_section');
	endif;
	
	// Remove Generate Colors sections
	if ( 'hidden' == get_option( 'generate_package_colors_visibility' ) ) :
		$wp_customize->remove_section('body_section');
		$wp_customize->remove_section('header_color_section');
		$wp_customize->remove_section('navigation_color_section');
		$wp_customize->remove_section('subnavigation_color_section');
		$wp_customize->remove_section('content_color_section');
		$wp_customize->remove_section('sidebar_widget_color_section');
		$wp_customize->remove_section('footer_widget_color_section');
		$wp_customize->remove_section('footer_color_section');
		$wp_customize->remove_section('form_color_section');
	endif;
	
	// Remove Generate Typography sections
	if ( 'hidden' == get_option( 'generate_package_typography_visibility' ) ) :
		$wp_customize->remove_section('font_section');
		$wp_customize->remove_section('font_header_section');
		$wp_customize->remove_section('font_navigation_section');
		$wp_customize->remove_section('font_content_section');
	endif;
	
	// Remove Page Header sections
	if ( 'hidden' == get_option( 'generate_package_page_header_visibility' ) )
		$wp_customize->remove_section('page_header_section');
} 

/***********************************************
* Deactivate the plugin
***********************************************/
if ( ! function_exists( 'generate_deactivate_super_package_addons' ) ) :
	add_action('admin_init', 'generate_deactivate_super_package_addons');
	function generate_deactivate_super_package_addons()
	{
		$addons = array(
			'Typography' => 'generate_package_typography',
			'Colors' => 'generate_package_colors',
			'Backgrounds' => 'generate_package_backgrounds',
			'Page Header' => 'generate_package_page_header',
			'Sections' => 'generate_package_sections',
			'Import / Export' => 'generate_package_import_export',
			'Copyright' => 'generate_package_copyright',
			'Disable Elements' => 'generate_package_disable_elements',
			'Blog' => 'generate_package_blog',
			'Hooks' => 'generate_package_hooks',
			'Spacing' => 'generate_package_spacing',
			'Secondary Nav' => 'generate_package_secondary_nav',
			'Menu Plus' => 'generate_package_menu_plus'
		);
		
		foreach( $addons as $k => $v ) :
		
			if( isset( $_POST[$v . '_deactivate_package'] ) ) {
		
				if( ! check_admin_referer( $v . '_deactivate_nonce', $v . '_deactivate_nonce' ) ) 	
					return; // get out if we didn't click the deactivate button
				
				update_option( $v, 'deactivated' );
				wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=addon_deactivated' ) );
				exit;
			}
		
		endforeach;
		
		
	}
endif;

if ( ! function_exists( 'generate_activation_styles' ) ) :
add_action('admin_print_styles','generate_activation_styles');
function generate_activation_styles() 
{

	$css = '.addon-container:before,
			.addon-container:after {
				content: ".";
				display: block;
				overflow: hidden;
				visibility: hidden;
				font-size: 0;
				line-height: 0;
				width: 0;
				height: 0;
			}
			.addon-container:after {
				clear: both;
			}
			.premium-addons .gp-clear {
				margin: 0 !important;
				border: 0;
				padding: 0 !important;
			}
			.premium-addons .add-on.gp-clear {
				padding: 15px !important;
				margin: 0 !important;
				-moz-box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.1) inset;
				-webkit-box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.1) inset;
				box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.1) inset;
			}
			.premium-addons .add-on:last-child {
				border: 0 !important;
			}
			.addon-action {
				float: right;
				clear: right;
			}
			.addon-name {
				float: left;
			}
			.premium-addons .add-on.gp-clear.activated {
				background-color:#F7FCFE !important;
				border-left: 5px solid #2EA2CC !important;
				font-weight: bold;
				padding-left: 10px !important;
			}
			.premium-addons input[type="submit"],
			.premium-addons input[type="submit"]:visited {
				background: none;
				border: 0;
				color: #0d72b2;
				padding: 0;
				font-size: inherit;
				cursor: pointer;
				-moz-box-shadow: 0 0 0 transparent;
				-webkit-box-shadow: 0 0 0 transparent;
				box-shadow: 0 0 0 transparent;
			}
			.premium-addons input[type="submit"]:hover,
			.premium-addons input[type="submit"]:focus {
				background: none;
				border: 0;
				color: #0f92e5;
				padding: 0;
				font-size: inherit;
				-moz-box-shadow: 0 0 0 transparent;
				-webkit-box-shadow: 0 0 0 transparent;
				box-shadow: 0 0 0 transparent;
			}
			.premium-addons input[type="submit"].hide-customizer-button,
			.premium-addons input[type="submit"]:visited.hide-customizer-button {
				color: #a00;
				font-weight: normal;
			}
			.premium-addons input[type="submit"]:hover.hide-customizer-button,
			.premium-addons input[type="submit"]:focus.hide-customizer-button {
				color: red;
				font-weight: normal;
			}
			.premium-addons input[type="submit"].hide-customizer-button {
				display: none;
			}
			.premium-addons .add-on.activated:hover input[type="submit"].hide-customizer-button {
				display: inline;
			}
			.gp_premium input[name="generate_activate_all"] {
				display: none;
			}
			.email-container .addon-name {
				width: 75%;
				min-width: 150px;
			}';
			
    wp_add_inline_style( 'generate-options', $css );
}
endif;

if ( ! function_exists( 'generate_premium_body_class' ) ) :
/**
 * Add a class or many to the body in the dashboard
 */
add_filter( 'admin_body_class', 'generate_premium_body_class' );
function generate_premium_body_class( $classes ) {
    return "$classes gp_premium";
}
endif;

/***********************************************
* Start the licese key/activation function
***********************************************/
$new_updater = apply_filters( 'generate_new_updater', true );

if ( $new_updater ) :
	require plugin_dir_path( __FILE__ ) . 'verify.php';
	/** 
	 * New updater
	 */
	if ( ! function_exists( 'generate_premium_license_key' ) ) :
	/**
	 * Add the license key field
	 */
	add_action('generate_license_keys','generate_premium_license_key', 1);
	function generate_premium_license_key() {
		return generate_add_license_key_field( 'gp_premium', 'GP Premium', 'gen_premium_license_key_status', 'gen_premium_license_key', GP_PREMIUM_VERSION );
	}
	endif;

	if ( ! function_exists( 'generate_save_premium_license_key' ) ) :
	/**
	 * Save/activate license keys
	 */
	add_action('admin_init','generate_save_premium_license_key', 5);
	function generate_save_premium_license_key() {
		return generate_process_license_key( 'gp_premium', 'GP Premium', 'gen_premium_license_key_status', 'gen_premium_license_key' );
	}
	endif;
endif;

/***********************************************
* Start the old email activation
* Left this in for now just in case
***********************************************/
if ( ! $new_updater ) :
	require plugin_dir_path( __FILE__ ) . 'verification.php';
	/**
	 * Old updater
	 */
	if ( ! function_exists( 'generate_add_premium_button' ) ) :
	/*
	* Add GP Premium button
	*/
	add_action('generate_product_table','generate_add_premium_button', 5);
	function generate_add_premium_button() {
		return generate_add_activate_button( 'package', 'GP Premium', 'gen_premium_license_key_status', GP_PREMIUM_VERSION );
	}
	endif;

	if ( ! function_exists( 'generate_activate_premium' ) ) :
	/*
	* Activate GP Premium
	*/
	add_action('admin_init','generate_activate_premium');
	function generate_activate_premium() {
		return generate_activate_package( 'package', 'GP Premium', 'gen_premium_license_key_status', 'gen_premium_license_key' );
	}
	endif;

	if ( ! function_exists( 'generate_deactivate_premium' ) ) :
	/*
	* Deactivate GP Premium
	*/
	add_action('admin_init','generate_deactivate_premium');
	function generate_deactivate_premium() {
		return generate_deactivate_package( 'package', 'GP Premium', 'gen_premium_license_key_status', 'gen_premium_license_key' );
	}
	endif;

	if ( ! function_exists( 'generate_apply_premium_key' ) ) :
	/*
	* Apply license key to database if it doesn't exist
	*/
	add_action('admin_init','generate_apply_premium_key');
	function generate_apply_premium_key() {
		return generate_apply_license_key( 'package', 'GP Premium', 'gen_premium_license_key_status', 'gen_premium_license_key' );
	}
	endif;
endif;
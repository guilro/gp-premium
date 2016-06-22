<?php
/**
 * These functions are needed for product activation
 * The functions below are the same throughout all addons
 */
 
if ( ! function_exists( 'generate_verify_enqueue' ) ) :
add_action( 'admin_enqueue_scripts', 'generate_verify_enqueue' );
function generate_verify_enqueue($hook) {
    if ( get_current_screen()->base !== 'appearance_page_generate-options' )
        return;
	
	wp_enqueue_style( 
		'generate-style-grid', 
		get_template_directory_uri() . '/css/unsemantic-grid.css', 
		false, 
		GENERATE_VERSION, 
		'all' 
	);
}
endif;

if ( ! function_exists( 'generate_verify_styles' ) ) :
add_action('admin_print_styles','generate_verify_styles');
function generate_verify_styles() 
{	
	$css = '';
	
	// If the old email activation isn't present, we can hide the old metabox
	if ( ! function_exists( 'generate_verify_email' ) ) :
		$css = '#gen-license-keys{display:none;}';
	endif;
	
	$css .= '.license-key-container {
				margin-bottom:15px;
			}
			.license-key-container:last-child {
				margin:0;
			}
			.update-help {
				float: right;
				text-decoration: none;
			}
			.license-key-container label {
				font-size: 11px;
				font-weight: normal;
				color: #777;
				display: inline-block;
				margin-bottom: 0;
			}
			.status {
				position: absolute;
				right:10px;
				top:-1px;
				background:rgba(255,255,255,0.9);
			}
			.license-key-input {
				width:100%;
				box-sizing:border-box;
				padding:10px;
			}
			.license-key-button {
				position:relative;
				top:1px;
				width:100%;
				box-sizing:border-box;
				padding: 10px !important;
				height:auto !important;
				line-height:normal !important;
			}';
			
    wp_add_inline_style( 'generate-options', $css );
}
endif;

if ( ! function_exists( 'generate_license_errors' ) ) :
/*
* Set up errors and messages
*/
add_action( 'admin_notices', 'generate_license_errors' );
function generate_license_errors() 
{
	if ( isset( $_GET['generate-message'] ) && 'license_failed' == $_GET['generate-message'] ) {
		 add_settings_error( 'generate-license-notices', 'license_failed', __( 'License failed.', 'generate' ), 'error' );
	}
	
	if ( isset( $_GET['generate-message'] ) && 'license_activated' == $_GET['generate-message'] ) {
		 add_settings_error( 'generate-license-notices', 'license_activated', __( 'License activated.', 'generate' ), 'updated' );
	}
	
	if ( isset( $_GET['generate-message'] ) && 'deactivation_passed' == $_GET['generate-message'] ) {
		 add_settings_error( 'generate-license-notices', 'deactivation_passed', __( 'License deactivated.', 'generate' ), 'updated' );
	}

	settings_errors( 'generate-license-notices' );
}
endif;

if ( ! function_exists( 'generate_activation_area' ) ) :
add_action( 'generate_admin_right_panel', 'generate_activation_area' );
function generate_activation_area()
{
?>
	
	<form method="post" action="options.php">
		<?php settings_fields( 'generate-license-group' ); ?>
		<?php do_settings_sections( 'generate-license-group' ); ?>
		<div class="postbox generate-metabox" id="generate-license-keys">
			<h3 class="hndle"><?php printf( __( 'Updates %s' ), '' );?> <a class="update-help" title="<?php _e( 'Help' ); ?>" href="https://generatepress.com/knowledgebase/updating-add-ons/" target="_blank"><span class="dashicons dashicons-sos"></span></a></h3>
			<div class="inside" style="margin-bottom:0;">
				<?php do_action( 'generate_license_keys' ); ?>
			</div>
		</div>

	</form>
<?php
}
endif;

if ( ! function_exists( 'generate_add_license_key_field' ) ) :
function generate_add_license_key_field( $id, $download, $license_key_status, $license_key, $version )
{
	$license = get_option( $license_key );
	$key = get_option( $license_key_status, 'deactivated' );
	?>
	<div class="license-key-container" style="position:relative;">
		<div class="grid-70 grid-parent">
			<span style="position:relative;">
				<?php if ( 'valid' == $key ) : ?>
					<span class="dashicons dashicons-yes status" style="color:green;"></span>
				<?php else : ?>
					<span class="dashicons dashicons-no status" style="color:red;"></span>
				<?php endif; ?>
				<input spellcheck="false" class="license-key-input" id="generate_license_key_<?php echo $id;?>" name="generate_license_key_<?php echo $id;?>" type="text" value="<?php echo $license; ?>" placeholder="<?php _e( 'License Key', 'generate' ); ?>" title="<?php echo $download;?> <?php _e( 'License Key', 'generate' ); ?>" />
			</span>
		</div>
		<div class="grid-30 grid-parent">
			<?php wp_nonce_field( 'generate_license_key_' . $id . '_nonce', 'generate_license_key_' . $id . '_nonce' ); ?>
			<input type="submit" id="submit" class="button button-primary license-key-button" name="<?php echo $id;?>_license_key" value="<?php _e( 'Update' );?>" />
		</div>
		<label for="generate_license_key_<?php echo $id;?>"><?php echo $download; ?> <?php echo $version; ?></label>
		<div class="clear" style="padding:0;margin:0;border:0;"></div>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'generate_process_license_key' ) ) :
/***********************************************
* Activate and deactivate license keys
***********************************************/
function generate_process_license_key( $id, $download, $license_key_status, $license_key)
{
	// Has our button been clicked?
	if( isset( $_POST[ $id . '_license_key' ] ) ) {
		
		// Get out if we didn't click the button
		if( ! check_admin_referer( 'generate_license_key_' . $id . '_nonce', 'generate_license_key_' . $id . '_nonce' ) ) 	
			return;
		
		// Grab the value being saved
		$new = $_POST['generate_license_key_' . $id];
		
		// Get the previously saved value
		$old = get_option( $license_key );
		
		// If nothing has changed, bail
		if ( $new == $old ) :
			wp_safe_redirect( admin_url('themes.php?page=generate-options' ) );
			exit;
		endif;
		
		// Still here? Update our option with the new license key
		update_option( $license_key, $new );
		
		// If we have a value, run activation.
		if ( '' !== $new ) :
			$api_params = array( 
				'edd_action' => 'activate_license', 
				'license' => $new, 
				'item_name' => urlencode( $download ),
				'url' => home_url()
			);
		endif;
		
		// If we don't have a value (it's been cleared), run deactivation.
		if ( '' == $new & 'valid' == get_option( $license_key_status ) ) :
			$api_params = array( 
				'edd_action' => 'deactivate_license', 
				'license' => $old, 
				'item_name' => urlencode( $download ),
				'url' => home_url()
			);
		endif;
		
		// Nothing? Get out of here.
		if ( ! $api_params ) :
			wp_safe_redirect( admin_url('themes.php?page=generate-options' ) );
			exit;
		endif;
		
		// Phone home.
		$license_response = wp_remote_post( 'https://generatepress.com', array(
			'timeout'   => 60,
			'sslverify' => false,
			'body'      => $api_params
		) );
		
		// Error? Exit and give them a message.
		if ( is_wp_error( $license_response ) ) {
			wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=license_failed' ) );
			exit;
		}
		
		// Still here? Decode our response.
		$license_data = json_decode( wp_remote_retrieve_body( $license_response ) );
		
		// Update our license key status
		update_option( $license_key_status, $license_data->license );
		
		if ( 'valid' == $license_data->license ) {
			// Validated, go tell them
			wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=license_activated' ) );
			exit;
		} elseif ( 'deactivated' == $license_data->license ) {
			// Deactivated, go tell them
			wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=deactivation_passed' ) );
			exit;
		} else {
			// Failed, go tell them
			wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=license_failed' ) );
			exit;
		}
	}
}
endif;
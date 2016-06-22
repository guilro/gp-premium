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
 
if ( ! function_exists( 'generate_verify_email' ) ) :
	add_action('generate_license_key_items','generate_verify_email', 0);
	function generate_verify_email()
	{
		$generate_customer_email = get_option( 'generate_customer_email', '' );
		$generate_customer_email_status = get_option( 'generate_customer_email_status', '' );
		
		if ( $generate_customer_email_status == 'valid' ) :
			$email = true;
		else :
			$email = false;
		endif;
		?>
		
		<?php if ( false == $email ) : ?>
			<p>
				Want updates served directly to your Dashboard? Activate the email you purchased your add-ons with here.
			</p>
		<?php endif; ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'generate-settings-group' ); ?>
			<?php do_settings_sections( 'generate-settings-group' ); ?>
			<div class="premium-addons">
				<div class="email-container grid-container grid-parent">
					
					<?php if ( true == $email ) : ?>
						<div class="add-on activated gp-clear grid-container" style="border-left:5px solid #2ea2cc !important">
							<div class="addon-name" style="position: relative;">
								<input placeholder="Email" id="generate_customer_email" name="generate_customer_email" type="email" class="regular-text" value="<?php echo $generate_customer_email; ?>" style="display:none"  />
								<strong><?php echo $generate_customer_email;?></strong>
								<span class="dashicons dashicons-yes" style="color:green;"></span>
							</div>
							<div class="addon-action" style="text-align:right;">
								
								<?php wp_nonce_field( 'generate_customer_email_nonce', 'generate_customer_email_nonce' ); ?>
								<input type="submit" class="deactivate-button" name="generate_customer_email_deactivate" value="Deactivate Email"/>
							</div>
						</div>
					<?php else : ?>
						<div class="add-on gp-clear grid-container" style="background-color:#fafafa;">
							<div class="addon-name" style="position:relative;">
								<span class="dashicons dashicons-no" style="color:red;position:absolute;right:5px;top:5px;"></span>
								<input placeholder="Email" id="generate_customer_email" name="generate_customer_email" type="email" class="regular-text" value="<?php echo $generate_customer_email; ?>" style="width:100%" />
							</div>
							<?php if ( '' !== $generate_customer_email ) : ?>
								<div class="addon-action" style="text-align:right;">
									<?php wp_nonce_field( 'generate_customer_email_nonce', 'generate_customer_email_nonce' ); ?>
									<input type="submit" class="activate-button" name="generate_customer_email_activate" value="Activate Email" style="line-height:28px"/>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			
			<?php 
			if ( false == $email ) : ?>
				<div style="margin-top: 10px;">
					<?php
					submit_button( 
						'Save Email',
						'primary',
						'submit',
						false
					); 
					?>
				</div>
			<?php endif; ?>
			
			<?php if ( true == $email ) : ?>
				<?php wp_nonce_field( 'generate_activate_all_nonce', 'generate_activate_all_nonce' ); ?>
				<input type="submit" class="button" name="generate_activate_all" value="Enable All Updates" style="margin:10px 0;"/>
				
				<?php do_action('generate_product_table');?>
			<?php endif; ?>
		</form>
		<?php
	}
endif;

if ( ! function_exists( 'generate_register_customer_email' ) ) :
	add_action('admin_init', 'generate_register_customer_email');
	function generate_register_customer_email() {
		// creates our settings in the options table
		register_setting('generate-settings-group', 'generate_customer_email', 'generate_sanitize_customer_email' );
	}
endif;

/***********************************************
* Gets rid of the local license status option
* when adding a new one
***********************************************/
if ( ! function_exists( 'generate_sanitize_customer_email' ) ) :
	function generate_sanitize_customer_email( $new ) {
		$generate_customer_email = get_option( 'generate_customer_email' );
		$old = $generate_customer_email;
		if( $old && $old != $new ) {
			update_option( 'generate_customer_email_status', 'invalid' ); // new license has been entered, so must reactivate
		}
		return $new;
	}
endif;

/***********************************************
* Add the plugin activate button
***********************************************/
if ( ! function_exists( 'generate_add_activate_button' ) ) :
	function generate_add_activate_button( $id, $download, $license_key_status, $version)
	{
		$key = get_option( $license_key_status, 'deactivated' );
		$email_status = get_option( 'generate_customer_email_status', '' );
		$downloads = get_option( 'generate_purchased_products', '' );
		
		if ( 'valid' !== $email_status )
			return;
					
		if ( '' == $downloads )
			return;
	
		if ( !in_array( $download, $downloads ) )
			return;

		echo '<div class="premium-addons premium-activate"><form method="post">';
		
		if ( $key == 'valid' && $email_status == 'valid' ) { ?>
			<div class="add-on activated gp-clear grid-container" style="border-left:5px solid #2ea2cc !important">
				<div class="addon-name">
					<strong><?php echo $download;?></strong> <?php echo $version;?> <span class="dashicons dashicons-yes" style="color:green;"></span>
				</div>
				<div class="addon-action" style="text-align:right;">
					<?php wp_nonce_field( 'generate_deactivate_' . $id . '_nonce', 'generate_deactivate_' . $id . '_nonce' ); ?>
					<input type="submit" name="generate_deactivate_<?php echo $id;?>" value="Disable Updates"/>
				</div>
			</div>
		<?php } elseif ( $key !== 'valid' && $email_status == 'valid' ) { ?>
			<div class="add-on gp-clear grid-container">
				<div class="addon-name">
					<strong><?php echo $download;?></strong> <?php echo $version;?> <span class="dashicons dashicons-no" style="color:red;"></span>
				</div>
				<div class="addon-action" style="text-align:right;">
					<?php wp_nonce_field( 'generate_activate_' . $id . '_nonce', 'generate_activate_' . $id . '_nonce' ); ?>
					<input type="submit" name="generate_activate_<?php echo $id;?>" value="Enable Updates"/>
				</div>
			</div>
		<?php }
		
		echo '</form></div>';
	}
endif;

/***********************************************
* Activate the customer's email
* Check the email with the database and populate purchased downloads and license keys
***********************************************/
if ( ! function_exists( 'generate_activate_customer_email' ) ) :
	add_action('admin_init', 'generate_activate_customer_email');
	function generate_activate_customer_email() {

		if( isset( $_POST['generate_customer_email_activate'] ) ) {
		
			
			if( ! check_admin_referer( 'generate_customer_email_nonce', 'generate_customer_email_nonce' ) ) 	
				return; // get out if we didn't click the Activate button

			$generate_customer_email = get_option( 'generate_customer_email' );
			
			if ( empty($generate_customer_email) )
				return;
			
			global $wp_version;
			
			// First, let's find the products associated with the email
			$response = wp_remote_post(
				'http://generatepress.com/api/licenses/check-email.php',
				array(
					'body' => 
					array(
						'generate_action' => 'get_license',
						'email' => $generate_customer_email,
					)
				)
			);

			// make sure the response came back okay
			if ( is_wp_error( $response ) )
				return false;

			// Now we have our associated downloads
			$downloads = json_decode(wp_remote_retrieve_body( $response ), true);
				
			if ( !empty( $downloads ) ) :
				$products = array();
				$licenses = array();
				$data = array();
				foreach ( $downloads as $key ) {
						
					// Populate purchased products array
					$products[] = $key['name'];
						
					// Add our license keys for future usage
					$licenses[ $key['name'] ] = $key['license'];
						
					// Get all data
					$data[] = array(
						'id' => $key['id'],
						'name' => $key['name'],
						'license' => $key['license']
					);
						
				}
				// Add purchased products
				update_option( 'generate_purchased_products', $products );
					
				// Add license keys
				update_option( 'generate_purchased_keys', $licenses );
					
				// Add all product info
				update_option( 'generate_product_info', $data );
					
				// Our email is valid
				update_option( 'generate_customer_email_status', 'valid' );
					
				// We're done
				wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=email_verified' ) );
				exit;
			else :
				update_option( 'generate_purchased_products', '' );
				update_option( 'generate_customer_email_status', 'false' );
				update_option( 'generate_product_info', '' );
				wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=email_failed' ) );
				exit;
			endif;
				
		}
	}
endif;

/***********************************************
* Deactivate the customer's email
* This will deactivate all license keys
* This will descrease the site count
***********************************************/
if ( !function_exists( 'generate_deactivate_customer_email' ) ) :
	add_action('admin_init', 'generate_deactivate_customer_email');
	function generate_deactivate_customer_email() {

		// listen for our activate button to be clicked
		if( isset( $_POST['generate_customer_email_deactivate'] ) ) {

			// run a quick security check 
			if( ! check_admin_referer( 'generate_customer_email_nonce', 'generate_customer_email_nonce' ) ) 	
				return; // get out if we didn't click the Activate button
			
			// Start new deactivate
			$generate_customer_email = get_option( 'generate_customer_email' );
			
			$email_status = get_option( 'generate_customer_email_status', '' );
			
			if ( 'valid' !== $email_status )
				return;
				
			$downloads = get_option( 'generate_product_info', '' );
			
			global $wp_version;
			
			// If we don't have any downloads added, add them
			if ( empty( $downloads ) ) :
				// First, let's find the products associated with the email
				$response = wp_remote_post(
					'http://generatepress.com/api/licenses/check-email.php',
					array(
						'body' => 
						array(
							'generate_action' => 'get_license',
							'email' => $generate_customer_email,
						)
					)
				);
				
				// make sure the response came back okay
				if ( is_wp_error( $response ) )
					return false;

				// Now we have our associated downloads
				$downloads = json_decode( wp_remote_retrieve_body( $response ), true );
			endif;
				
			foreach ( $downloads as $key ) {
				
				if ( 'valid' == get_option( $key['id'] . '_status' ) ) :

					$api_params = array( 
						'edd_action' => 'deactivate_license', 
						'license' => $key['license'], 
						'item_name' => urlencode( $key['name'] ),
						'url' => home_url()
					);
					
					// Call the custom API.
					$license_response = wp_remote_post( 'http://generatepress.com', array(
						'timeout'   => 60,
						'sslverify' => false,
						'body'      => $api_params
					) );

					//$license_response = wp_remote_get( add_query_arg( $api_params, 'http://generatepress.com' ), array( 'timeout' => 60, 'sslverify' => false ) );

					if ( is_wp_error( $license_response ) )
						return false;

					$license_data = json_decode( wp_remote_retrieve_body( $license_response ) );
					delete_option( $key['id'] . '_status', $license_data->license );
					delete_option( $key['id'], $license_data->license );
						
				endif;

			}

			delete_option( 'generate_customer_email_status' );
			wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=email_deactivated' ) );
			exit;
		}
	}
endif;

/***********************************************
* Activate all addons
* This will activate all license keys
* This will increase the site count
***********************************************/
if ( !function_exists( 'generate_activate_all' ) ) :
	add_action('admin_init', 'generate_activate_all');
	function generate_activate_all() {

		// listen for our activate button to be clicked
		if( isset( $_POST['generate_activate_all'] ) ) {

			// run a quick security check 
			if( ! check_admin_referer( 'generate_activate_all_nonce', 'generate_activate_all_nonce' ) ) 	
				return; // get out if we didn't click the Activate button
			
			// Start new deactivate
			$generate_customer_email = get_option( 'generate_customer_email' );
			
			$email_status = get_option( 'generate_customer_email_status', '' );
			
			if ( 'valid' !== $email_status )
				return;
			
			global $wp_version;
			
			$downloads = get_option( 'generate_product_info', '' );
			
			if ( empty( $downloads ) ) :
				// First, let's find the products associated with the email
				$response = wp_remote_post(
					'http://generatepress.com/api/licenses/check-email.php',
					array(
						'body' => 
						array(
							'generate_action' => 'get_license',
							'email' => $generate_customer_email,
						)
					)
				);
				
				// make sure the response came back okay
				if ( is_wp_error( $response ) )
					return false;

				// Now we have our associated downloads
				$downloads = json_decode( wp_remote_retrieve_body( $response ), true );
			endif;
			
			foreach ( $downloads as $key ) {

				if ( 'valid' !== get_option( $key['id'] . '_status' ) ) :

					$api_params = array( 
						'edd_action' => 'activate_license', 
						'license' => $key['license'], 
						'item_name' => urlencode( $key['name'] ),
						'url' => home_url()
					);
					
					// Call the custom API.
					$license_response = wp_remote_post( 'http://generatepress.com', array(
						'timeout'   => 60,
						'sslverify' => false,
						'body'      => $api_params
					) );

					//$license_response = wp_remote_get( add_query_arg( $api_params, 'http://generatepress.com' ), array( 'timeout' => 60, 'sslverify' => false ) );

					if ( is_wp_error( $license_response ) )
						return false;

					$license_data = json_decode( wp_remote_retrieve_body( $license_response ) );
						
						
					update_option( $key['id'] . '_status', $license_data->license );
					update_option( $key['id'], $key['license'] );
						
				endif;

			}

			wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=licenses_activated' ) );
			exit;		
		}
	}
endif;

/***********************************************
* Activate the plugin
***********************************************/
if ( ! function_exists( 'generate_activate_package' ) ) :
	function generate_activate_package( $id, $download, $license_key_status, $license_key)
	{
		
		if( isset( $_POST['generate_activate_' . $id] ) ) {
		
			if( ! check_admin_referer( 'generate_activate_' . $id . '_nonce', 'generate_activate_' . $id . '_nonce' ) ) 	
				return; // get out if we didn't click the Activate button
				
			$downloads = get_option( 'generate_purchased_products', '' );
			$email_status = get_option( 'generate_customer_email_status', '' );
			$licenses = get_option( 'generate_purchased_keys' );
			$license = $licenses[ $download ];
			
			if ( 'valid' !== $email_status )
				return;
				
			if ( '' == $downloads )
				return;
				
			if ( !in_array( $download, $downloads ) )
				return;
				
			$generate_customer_email = get_option( 'generate_customer_email' );
			
			if ( empty($generate_customer_email) )
				return;
			
			// If we don't have a license (we should), get one
			if ( empty( $license ) ) :
				// Let's give the server the email and download and get the license for each download back
				$response_get_license = wp_remote_post(
					'http://generatepress.com/api/licenses/check-email.php',
					array(
						'body' => 
						array(
							'generate_action' => 'get_single_license',
							'email' => $generate_customer_email,
							'download' => $download
						)
					)
				);
								
				if ( is_wp_error( $response_get_license ) ) {
					// Fail, go tell them
					wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=license_failed' ) );
					exit;
				}
								
				// Got our license - time to turn it into a string and send to server to activation
				$licenses = json_decode(wp_remote_retrieve_body( $response_get_license ), true);
				
				// Turn licenses arrow into string
				$license = implode($licenses,',');
			endif;

			$api_params = array( 
				'edd_action' => 'activate_license', 
				'license' => $license, 
				'item_name' => urlencode( $download ),
				'url' => home_url()
			);
			
			// Call the custom API.
			$license_response = wp_remote_post( 'http://generatepress.com', array(
				'timeout'   => 60,
				'sslverify' => false,
				'body'      => $api_params
			) );

			//$license_response = wp_remote_get( add_query_arg( $api_params, 'http://generatepress.com' ), array( 'timeout' => 30, 'sslverify' => false ) );

			if ( is_wp_error( $license_response ) ) {
				// Fail, go tell them
				wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=license_failed' ) );
				exit;
			}

			$license_data = json_decode( wp_remote_retrieve_body( $license_response ) );
			update_option( $license_key_status, $license_data->license );
			update_option( $license_key, $license );
			
			if ( 'valid' == $license_data->license ) {
			
				// Success, go tell them
				wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=license_activated' ) );
				exit;
				
			} else {
			
				// Fail, go tell them
				wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=license_failed' ) );
				exit;
				
			}

		}
	}
endif;

/***********************************************
* Deactivate the plugin
***********************************************/
if ( ! function_exists( 'generate_deactivate_package' ) ) :
	function generate_deactivate_package( $id, $download, $license_key_status, $license_key)
	{
			
		if( isset( $_POST['generate_deactivate_' . $id] ) ) {
		
			if( ! check_admin_referer( 'generate_deactivate_' . $id . '_nonce', 'generate_deactivate_' . $id . '_nonce' ) ) 	
				return; // get out if we didn't click the Activate button
				
			$downloads = get_option( 'generate_purchased_products', '' );
			$email_status = get_option( 'generate_customer_email_status', '' );
			$license = get_option( $license_key, '' );
			
			if ( 'valid' !== $email_status )
				return;
				
			if ( '' == $downloads )
				return;
				
			if ( !in_array( $download, $downloads ) )
				return;
				
			$generate_customer_email = get_option( 'generate_customer_email' );
			
			if ( empty($generate_customer_email) )
				return;
				
			// If no license exists, try to find it
			if ( empty( $license ) ) :
				$response_get_license = wp_remote_post(
					'http://generatepress.com/api/licenses/check-email.php',
					array(
						'body' => 
						array(
							'generate_action' => 'get_single_license',
							'email' => $generate_customer_email,
							'download' => $download
						)
					)
				);
								
				if ( is_wp_error( $response_get_license ) )
					return false;
								
				// Got our license - time to turn it into a string and send to server to activation
				$licenses = json_decode(wp_remote_retrieve_body( $response_get_license ), true);
				$license = implode($licenses,',');
			
			endif;
							
			$api_params = array( 
				'edd_action' => 'deactivate_license', 
				'license' => $license, 
				'item_name' => urlencode( $download ),
				'url' => home_url()
			);
			
			// Call the custom API.
			$license_response = wp_remote_post( 'http://generatepress.com', array(
				'timeout'   => 60,
				'sslverify' => false,
				'body'      => $api_params
			) );

			//$license_response = wp_remote_get( add_query_arg( $api_params, 'http://generatepress.com' ), array( 'timeout' => 15, 'sslverify' => false ) );
			
			if ( is_wp_error( $license_response ) ) {
				wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=deactivation_failed' ) );
				exit;
			}

			$license_data = json_decode( wp_remote_retrieve_body( $license_response ) );
			update_option( $license_key_status, $license_data->license );
			update_option( $license_key, '' );
			
			if ( 'deactivated' !== $license_data->license ) {
				wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=deactivation_failed' ) );
				exit;
			} elseif ( 'deactivated' == $license_data->license ) {
				wp_safe_redirect( admin_url('themes.php?page=generate-options&generate-message=deactivation_passed' ) );
				exit;
			}

		}
	}
endif;

/***********************************************
* Apply the license key to the database
***********************************************/
if ( ! function_exists( 'generate_apply_license_key' ) ) :
	function generate_apply_license_key( $id, $download, $license_key_status, $license_key)
	{
	
			$status = get_option( $license_key_status, '' );
			$generate_customer_email = get_option( 'generate_customer_email', '' );
			$license_key = get_option( $license_key, '' );

			// If we already have a license key, stop
			if ( ! empty( $license_key ) )
				return;
			
			// If the license status isn't valid, stop
			if ( 'valid' !== $status )
				return;
			
			$response_get_license = wp_remote_post(
				'http://generatepress.com/api/licenses/check-email.php',
				array(
					'body' => 
					array(
						'generate_action' => 'get_single_license',
						'email' => $generate_customer_email,
						'download' => $download
					)
				)
			);
							
			if ( is_wp_error( $response_get_license ) )
				return false;
							
			// Got our license - time to turn it into a string and send to server to activation
			$licenses = json_decode(wp_remote_retrieve_body( $response_get_license ), true);
			$license = implode($licenses,',');

			update_option( $license_key, $license );

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
			.activated {
				background-color:#F7FCFE !important;
				border-left: 5px solid #2EA2CC !important;
				font-weight: bold;
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

if ( ! function_exists( 'generate_license_errors' ) ) :
/*
* Set up errors and messages
*/
add_action( 'admin_notices', 'generate_license_errors' );
function generate_license_errors() 
{

	if ( isset( $_GET['generate-message'] ) && 'email_failed' == $_GET['generate-message'] ) {
		 add_settings_error( 'generate-license-notices', 'email_failed', 'Email activation failed. This email does not exist in our records.', 'error' );
	}
	
	if ( isset( $_GET['generate-message'] ) && 'email_verified' == $_GET['generate-message'] ) {
		 add_settings_error( 'generate-license-notices', 'email_verified', 'Email activated.', 'updated' );
	}
	
	if ( isset( $_GET['generate-message'] ) && 'email_deactivated' == $_GET['generate-message'] ) {
		 add_settings_error( 'generate-license-notices', 'email_deactivated', 'Email deactivated.', 'updated' );
	}
	
	if ( isset( $_GET['generate-message'] ) && 'license_failed' == $_GET['generate-message'] ) {
		 add_settings_error( 'generate-license-notices', 'license_failed', 'License failed.', 'error' );
	}
	
	if ( isset( $_GET['generate-message'] ) && 'license_activated' == $_GET['generate-message'] ) {
		 add_settings_error( 'generate-license-notices', 'license_activated', 'License activated.', 'updated' );
	}
	
	if ( isset( $_GET['generate-message'] ) && 'licenses_activated' == $_GET['generate-message'] ) {
		 add_settings_error( 'generate-license-notices', 'licenses_activated', 'Licenses activated.', 'updated' );
	}
	
	if ( isset( $_GET['generate-message'] ) && 'deactivation_failed' == $_GET['generate-message'] ) {
		 add_settings_error( 'generate-license-notices', 'deactivation_failed', 'Deactivation failed.', 'error' );
	}
	
	if ( isset( $_GET['generate-message'] ) && 'deactivation_passed' == $_GET['generate-message'] ) {
		 add_settings_error( 'generate-license-notices', 'deactivation_passed', 'License deactivated.', 'updated' );
	}

	settings_errors( 'generate-license-notices' );
}
endif;
<?php
if ( ! function_exists( 'generate_menu_plus_reset_settings' ) ) :
/**
 * Reset customizer settings
 */
add_action( 'generate_delete_settings_form','generate_menu_plus_reset_settings');
function generate_menu_plus_reset_settings()
{
	?>
	<form method="post">
		<p><input type="hidden" name="generate_menu_plus_reset_customizer" value="generate_menu_plus_reset_customizer_settings" /></p>
		<p>
			<?php 
			$warning = 'return confirm("' . __( 'Warning: This will delete your settings.','generate-menu-plus' ) . '")';
			wp_nonce_field( 'generate_menu_plus_reset_customizer_nonce', 'generate_menu_plus_reset_customizer_nonce' );
			submit_button( __( 'Delete Menu Plus Customizer Settings', 'generate-menu-plus' ), 'menu-plus-button', 'menu-plus-submit', false, array( 'onclick' => $warning ) ); 
			?>
		</p>
	</form>
	<?php
}
endif;

if ( ! function_exists( 'generate_menu_plus_reset_customizer_settings' ) ) :
add_action( 'admin_init', 'generate_menu_plus_reset_customizer_settings' );
function generate_menu_plus_reset_customizer_settings() {

	if( empty( $_POST['generate_menu_plus_reset_customizer'] ) || 'generate_menu_plus_reset_customizer_settings' != $_POST['generate_menu_plus_reset_customizer'] )
		return;

	if( ! wp_verify_nonce( $_POST['generate_menu_plus_reset_customizer_nonce'], 'generate_menu_plus_reset_customizer_nonce' ) )
		return;

	if( ! current_user_can( 'manage_options' ) )
		return;

	delete_option('generate_menu_plus_settings');
	
	wp_safe_redirect( admin_url( 'themes.php?page=generate-options&status=reset' ) ); exit;

}
endif;

if ( ! function_exists( 'generate_menu_plus_add_export' ) ) :
	add_action('generate_add_export_items','generate_menu_plus_add_export');
	function generate_menu_plus_add_export()
	{
		?>
		<form method="post">
			<p><input type="hidden" name="generate_menu_plus_export_action" value="export_menu_plus_settings" /></p>
			<p>
				<?php wp_nonce_field( 'generate_menu_plus_export_nonce', 'generate_menu_plus_export_nonce' ); ?>
				<?php submit_button( __( 'Export Menu Plus Customizer Settings', 'generate-menu-plus' ), 'button-primary', 'submit', false ); ?>
			</p>
		</form>
		<?php
	}
endif;

if ( ! function_exists( 'generate_menu_plus_process_settings_export' ) ) :
	/**
	 * Process a settings export that generates a .json file of the shop settings
	 */
	add_action( 'admin_init', 'generate_menu_plus_process_settings_export' );
	function generate_menu_plus_process_settings_export() {

		if( empty( $_POST['generate_menu_plus_export_action'] ) || 'export_menu_plus_settings' != $_POST['generate_menu_plus_export_action'] )
			return;

		if( ! wp_verify_nonce( $_POST['generate_menu_plus_export_nonce'], 'generate_menu_plus_export_nonce' ) )
			return;

		if( ! current_user_can( 'manage_options' ) )
			return;
		
		$settings = get_option( 'generate_menu_plus_settings' );

		ignore_user_abort( true );

		nocache_headers();
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=generate-menu-plus-settings-export-' . date( 'm-d-Y' ) . '.json' );
		header( "Expires: 0" );

		echo json_encode( $settings );
		exit;
	}
endif;
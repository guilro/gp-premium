<?php
if ( ! function_exists( 'generate_hooks_get_hooks' ) ) :
	function generate_hooks_get_hooks()
	{
		$hooks = array(
			'generate_wp_head_php',
			'generate_wp_head',
			'generate_before_header_php',
			'generate_before_header',
			'generate_before_header_content_php',
			'generate_before_header_content',
			'generate_after_header_content_php',
			'generate_after_header_content',
			'generate_after_header_php',
			'generate_after_header',
			'generate_before_main_content_php',
			'generate_before_main_content',
			'generate_before_content_php',
			'generate_before_content',
			'generate_after_entry_header_php',
			'generate_after_entry_header',
			'generate_after_content_php',
			'generate_after_content',
			'generate_before_right_sidebar_content_php',
			'generate_before_right_sidebar_content',
			'generate_after_right_sidebar_content_php',
			'generate_after_right_sidebar_content',
			'generate_before_left_sidebar_content_php',
			'generate_before_left_sidebar_content',
			'generate_after_left_sidebar_content_php',
			'generate_after_left_sidebar_content',
			'generate_before_footer_php',
			'generate_before_footer',
			'generate_after_footer_widgets_php',
			'generate_after_footer_widgets',
			'generate_before_footer_content_php',
			'generate_before_footer_content',
			'generate_after_footer_content_php',
			'generate_after_footer_content',
			'generate_wp_footer_php',
			'generate_wp_footer'
		);
		
		return $hooks;
	}
endif;
if ( ! function_exists( 'generate_hooks_add_export' ) ) :
	add_action('generate_add_export_items','generate_hooks_add_export');
	function generate_hooks_add_export()
	{
		?>
		<form method="post">
			<p><input type="hidden" name="generate_hooks_export_action" value="export_hooks_settings" /></p>
			<p>
				<?php wp_nonce_field( 'generate_hooks_export_nonce', 'generate_hooks_export_nonce' ); ?>
				<?php submit_button( __( 'Export GP Hooks', 'generate-hooks' ), 'button-primary', 'submit', false ); ?>
			</p>
		</form>
		<?php
	}
endif;

if ( ! function_exists( 'generate_hooks_process_settings_export' ) ) :
	/**
	 * Process a settings export that generates a .json file of the shop settings
	 */
	function generate_hooks_process_settings_export() {

		if( empty( $_POST['generate_hooks_export_action'] ) || 'export_hooks_settings' != $_POST['generate_hooks_export_action'] )
			return;

		if( ! wp_verify_nonce( $_POST['generate_hooks_export_nonce'], 'generate_hooks_export_nonce' ) )
			return;

		if( ! current_user_can( 'manage_options' ) )
			return;
		
		$settings = get_option( 'generate_hooks' );

		ignore_user_abort( true );

		nocache_headers();
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=generate-hooks-export-' . date( 'm-d-Y' ) . '.json' );
		header( "Expires: 0" );

		echo json_encode( $settings );
		
		exit;
	}
	add_action( 'admin_init', 'generate_hooks_process_settings_export' );
endif;

if ( ! function_exists( 'generate_hooks_reset_settings' ) ) :
/**
 * Reset customizer settings
 */
add_action( 'generate_delete_settings_form','generate_hooks_reset_settings');
function generate_hooks_reset_settings()
{
	?>
	<form method="post">
		<p><input type="hidden" name="generate_hooks_reset_customizer" value="generate_hooks_reset_customizer_settings" /></p>
		<p>
			<?php 
			$warning = 'return confirm("' . __( 'Warning: This will delete your settings.','generate-hooks' ) . '")';
			wp_nonce_field( 'generate_hooks_reset_customizer_nonce', 'generate_hooks_reset_customizer_nonce' );
			submit_button( __( 'Delete GP Hooks', 'generate-hooks' ), 'spacing-button', 'spacing-submit', false, array( 'onclick' => $warning ) ); ?>
		</p>
	</form>
	<?php
}
endif;

if ( ! function_exists( 'generate_hooks_reset_customizer_settings' ) ) :
add_action( 'admin_init', 'generate_hooks_reset_customizer_settings' );
function generate_hooks_reset_customizer_settings() {

	if( empty( $_POST['generate_hooks_reset_customizer'] ) || 'generate_hooks_reset_customizer_settings' != $_POST['generate_hooks_reset_customizer'] )
		return;

	if( ! wp_verify_nonce( $_POST['generate_hooks_reset_customizer_nonce'], 'generate_hooks_reset_customizer_nonce' ) )
		return;

	if( ! current_user_can( 'manage_options' ) )
		return;

	delete_option('generate_hooks');
	
	$hooks = generate_hooks_get_hooks();

	foreach ( $hooks as $hook ) {
		$hooks = get_option( $hook );
		if ( ! empty( $hooks ) ) :
			delete_option( $hook );
		endif;
	}
	
	wp_safe_redirect( admin_url( 'themes.php?page=generate-options&status=reset#gen-delete' ) ); exit;

}
endif;
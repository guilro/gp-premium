<?php
if ( ! function_exists( 'generate_insert_import_export' ) ) :
add_action('generate_options_items','generate_insert_import_export', 15);
function generate_insert_import_export()
{
	?>
	<div class="postbox generate-metabox" id="generate-ie">
		<h3 class="hndle"><?php _e('Import / Export','generate-ie');?></h3>
		<div class="inside">
			<p><?php printf( __( '<strong>Export</strong> your settings set in the <a href="%s">Customizer</a>.','generate-ie' ), admin_url('customize.php') ); ?></p>
			<form method="post">
				<p><input type="hidden" name="generate_action" value="export_settings" /></p>
				<p>
					<?php wp_nonce_field( 'generate_export_nonce', 'generate_export_nonce' ); ?>
					<?php submit_button( __( 'Export Default Customizer Settings', 'generate-ie' ), 'button-primary', 'submit', false ); ?>
				</p>
			</form>
							
			<?php do_action('generate_add_export_items') ;?>
									
			<div class="clear"></div>
										
			<p><?php _e( '<strong>Import</strong> your settings by uploading your exported .json file.','generate-ie' ); ?></p>
			<form method="post" enctype="multipart/form-data">
				<p>
					<input type="file" name="import_file"/>
				</p>
				<p>
					<input type="hidden" name="generate_action" value="import_settings" />
					<?php wp_nonce_field( 'generate_import_nonce', 'generate_import_nonce' ); ?>
					<?php submit_button( __( 'Import Settings', 'generate-ie' ), 'button-primary', 'submit', false ); ?>
				</p>
			</form>
							
			<?php do_action('generate_add_import_items'); ?>
							
		</div>
	</div>
	<?php
}
endif;

if ( ! function_exists( 'generate_process_settings_export' ) ) :
/**
 * Process a settings export that generates a .json file of the shop settings
 */
add_action( 'admin_init', 'generate_process_settings_export' );
function generate_process_settings_export() {

	if( empty( $_POST['generate_action'] ) || 'export_settings' != $_POST['generate_action'] )
		return;

	if( ! wp_verify_nonce( $_POST['generate_export_nonce'], 'generate_export_nonce' ) )
		return;

	if( ! current_user_can( 'manage_options' ) )
		return;
	
	$settings = get_option( 'generate_settings' );

	ignore_user_abort( true );

	nocache_headers();
	header( 'Content-Type: application/json; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=generate-settings-export-' . date( 'm-d-Y' ) . '.json' );
	header( "Expires: 0" );

	echo json_encode( $settings );
	exit;
}
endif;

if ( ! function_exists( 'generate_process_settings_import' ) ) :
/**
 * Process a settings import from a json file
 */
add_action( 'admin_init', 'generate_process_settings_import' );
function generate_process_settings_import() {

	if( empty( $_POST['generate_action'] ) || 'import_settings' != $_POST['generate_action'] )
		return;

	if( ! wp_verify_nonce( $_POST['generate_import_nonce'], 'generate_import_nonce' ) )
		return;

	if( ! current_user_can( 'manage_options' ) )
		return;
	
	$filename = $_FILES['import_file']['name'];
	$extension = end( explode( '.', $_FILES['import_file']['name'] ) );
	$name = substr( $filename, 0, strrpos($filename,'-export') );
	$name = str_replace( '-', '_',$name);

	if( $extension != 'json' ) {
		wp_die( __( 'Please upload a valid .json file', 'generate-ie' ) );
	}

	$import_file = $_FILES['import_file']['tmp_name'];

	if( empty( $import_file ) ) {
		wp_die( __( 'Please upload a file to import', 'generate-ie' ) );
	}

	// Retrieve the settings from the file and convert the json object to an array.
	$settings = json_decode( file_get_contents( $import_file ), true );

	update_option( $name, $settings );

	wp_safe_redirect( admin_url( 'admin.php?page=generate-options&status=imported' ) ); exit;

}
endif;

if ( ! function_exists( 'generate_ie_exportable' ) ) :
function generate_ie_exportable()
{
	// A check to see if other addons can add their export button
}
endif;
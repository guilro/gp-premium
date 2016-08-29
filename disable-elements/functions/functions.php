<?php
if ( !function_exists('generate_disable_elements') ) :
/**
 * Remove the default disable_elements
 * @since 0.1
 */
function generate_disable_elements()
{
	// Don't run the function unless we're on a page it applies to
	if ( ! is_singular() )
		return;
		
	global $post;
		
	// Prevent PHP notices
	if ( isset( $post ) ) :
		$disable_header = get_post_meta( $post->ID, '_generate-disable-header', true );
		$disable_nav = get_post_meta( $post->ID, '_generate-disable-nav', true );
		$disable_secondary_nav = get_post_meta( $post->ID, '_generate-disable-secondary-nav', true );
		$disable_post_image = get_post_meta( $post->ID, '_generate-disable-post-image', true );
		$disable_headline = get_post_meta( $post->ID, '_generate-disable-headline', true );
		$disable_footer = get_post_meta( $post->ID, '_generate-disable-footer', true );
	endif;
	
	$return = '';
		
	if ( !empty($disable_header) && false !== $disable_header ) :
		$return = '.site-header {display:none}';
	endif;
	
	if ( !empty($disable_nav) && false !== $disable_nav ) :
		$return .= '#site-navigation,.navigation-clone {display:none !important}';
	endif;
	
	if ( !empty($disable_secondary_nav) && false !== $disable_secondary_nav ) :
		$return .= '#secondary-navigation {display:none}';
	endif;
	
	if ( !empty($disable_post_image) && false !== $disable_post_image ) :
		$return .= '.generate-page-header, .page-header-image, .page-header-image-single {display:none}';
	endif;
	
	if ( ( !empty( $disable_headline ) && false !== $disable_headline ) && ! is_single() ) :
		$return .= '.entry-header {display:none} .page-content, .entry-content, .entry-summary {margin-top:0}';
	endif;
	
	if ( !empty($disable_footer) && false !== $disable_footer ) :
		$return .= '.site-footer {display:none}';
	endif;
	
	return $return;
}
endif;

if ( !function_exists('generate_de_scripts') ) :
/**
 * Enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'generate_de_scripts', 50 );
function generate_de_scripts() {
	wp_add_inline_style( 'generate-style', generate_disable_elements() );
}
endif;

if ( !function_exists('generate_add_de_meta_box') ) :
/**
 * Generate the layout metabox
 * @since 0.1
 */
add_action('add_meta_boxes', 'generate_add_de_meta_box');
function generate_add_de_meta_box() {  
		
	$post_types = get_post_types();
	foreach ($post_types as $type) {
		if ( 'attachment' !== $type ) {
			add_meta_box(  
				'generate_de_meta_box', // $id  
				__('Disable Elements','generate-disable-elements'), // $title   
				'generate_show_de_meta_box', // $callback  
				$type, // $page  
				'side', // $context  
				'default' // $priority  
			); 
		}
	}
}  
endif;

if ( !function_exists('generate_show_de_meta_box') ) :
/**
 * Outputs the content of the metabox
 */
function generate_show_de_meta_box( $post ) {  

    wp_nonce_field( basename( __FILE__ ), 'generate_de_nonce' );
    $stored_meta = get_post_meta( $post->ID );
	
	if ( isset($stored_meta['_generate-disable-header'][0]) ) :
		$stored_meta['_generate-disable-header'][0] = $stored_meta['_generate-disable-header'][0];
	else :
		$stored_meta['_generate-disable-header'][0] = '';
	endif;
	
	if ( isset($stored_meta['_generate-disable-nav'][0]) ) :
		$stored_meta['_generate-disable-nav'][0] = $stored_meta['_generate-disable-nav'][0];
	else :
		$stored_meta['_generate-disable-nav'][0] = '';
	endif;
	
	if ( isset($stored_meta['_generate-disable-secondary-nav'][0]) ) :
		$stored_meta['_generate-disable-secondary-nav'][0] = $stored_meta['_generate-disable-secondary-nav'][0];
	else :
		$stored_meta['_generate-disable-secondary-nav'][0] = '';
	endif;
	
	if ( isset($stored_meta['_generate-disable-post-image'][0]) ) :
		$stored_meta['_generate-disable-post-image'][0] = $stored_meta['_generate-disable-post-image'][0];
	else :
		$stored_meta['_generate-disable-post-image'][0] = '';
	endif;
	
	if ( isset($stored_meta['_generate-disable-headline'][0]) ) :
		$stored_meta['_generate-disable-headline'][0] = $stored_meta['_generate-disable-headline'][0];
	else :
		$stored_meta['_generate-disable-headline'][0] = '';
	endif;
	
	if ( isset($stored_meta['_generate-disable-footer'][0]) ) :
		$stored_meta['_generate-disable-footer'][0] = $stored_meta['_generate-disable-footer'][0];
	else :
		$stored_meta['_generate-disable-footer'][0] = '';
	endif;
	
	if ( isset($stored_meta['_generate-disable-header'][0]) && '' == $stored_meta['_generate-disable-header'][0] ) :
		$checked = 'checked="checked"';
	else :
		$checked = '';
	endif;
	
	if ( isset($stored_meta['_generate-disable-nav'][0]) && '' == $stored_meta['_generate-disable-nav'][0] ) :
		$checked = 'checked="checked"';
	else :
		$checked = '';
	endif;
	
	if ( isset($stored_meta['_generate-disable-secondary-nav'][0]) && '' == $stored_meta['_generate-disable-secondary-nav'][0] ) :
		$checked = 'checked="checked"';
	else :
		$checked = '';
	endif;
	
	if ( isset($stored_meta['_generate-disable-post-image'][0]) && '' == $stored_meta['_generate-disable-post-image'][0] ) :
		$checked = 'checked="checked"';
	else :
		$checked = '';
	endif;
	
	if ( isset($stored_meta['_generate-disable-headline'][0]) && '' == $stored_meta['_generate-disable-headline'][0] ) :
		$checked = 'checked="checked"';
	else :
		$checked = '';
	endif;
	
	if ( isset($stored_meta['_generate-disable-footer'][0]) && '' == $stored_meta['_generate-disable-footer'][0] ) :
		$checked = 'checked="checked"';
	else :
		$checked = '';
	endif;
    ?>
 
    <p>
		<div class="generate_disable_elements">
			<label for="meta-generate-disable-header" style="display:block;margin-bottom:3px;" title="<?php _e('Header','generate-disable-elements');?>">
				<input type="checkbox" name="_generate-disable-header" id="meta-generate-disable-header" value="true" <?php checked( $stored_meta['_generate-disable-header'][0], 'true' ); ?>>
				<?php _e('Header','generate-disable-elements');?>
			</label>
			<label for="meta-generate-disable-nav" style="display:block;margin-bottom:3px;" title="<?php _e('Primary Navigation','generate-disable-elements');?>">
				<input type="checkbox" name="_generate-disable-nav" id="meta-generate-disable-nav" value="true" <?php checked( $stored_meta['_generate-disable-nav'][0], 'true' ); ?>>
				<?php _e('Primary Navigation','generate-disable-elements');?>
			</label>
			<?php if ( function_exists( 'generate_secondary_nav_setup' ) ) : ?>
				<label for="meta-generate-disable-secondary-nav" style="display:block;margin-bottom:3px;" title="<?php _e('Secondary Navigation','generate-disable-elements');?>">
					<input type="checkbox" name="_generate-disable-secondary-nav" id="meta-generate-disable-secondary-nav" value="true" <?php checked( $stored_meta['_generate-disable-secondary-nav'][0], 'true' ); ?>>
					<?php _e('Secondary Navigation','generate-disable-elements');?>
				</label>
			<?php endif; ?>
			<label for="meta-generate-disable-post-image" style="display:block;margin-bottom:3px;" title="<?php _e('Post Image / Page Header','generate-disable-elements');?>">
				<input type="checkbox" name="_generate-disable-post-image" id="meta-generate-disable-post-image" value="true" <?php checked( $stored_meta['_generate-disable-post-image'][0], 'true' ); ?>>
				<?php _e('Post Image / Page Header','generate-disable-elements');?>
			</label>
			<label for="meta-generate-disable-headline" style="display:block;margin-bottom:3px;" title="<?php _e('Content Title','generate-disable-elements');?>">
				<input type="checkbox" name="_generate-disable-headline" id="meta-generate-disable-headline" value="true" <?php checked( $stored_meta['_generate-disable-headline'][0], 'true' ); ?>>
				<?php _e('Content Title','generate-disable-elements');?>
			</label>
			<label for="meta-generate-disable-footer" style="display:block;margin-bottom:3px;" title="<?php _e('Footer','generate-disable-elements');?>">
				<input type="checkbox" name="_generate-disable-footer" id="meta-generate-disable-footer" value="true" <?php checked( $stored_meta['_generate-disable-footer'][0], 'true' ); ?>>
				<?php _e('Footer','generate-disable-elements');?>
			</label>
		</div>
	</p>
 
    <?php
}
endif;

if ( !function_exists('generate_save_de_meta') ) :
// Save the Data  
add_action('save_post', 'generate_save_de_meta');
function generate_save_de_meta($post_id) {  
    
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'generate_de_nonce' ] ) && wp_verify_nonce( $_POST[ 'generate_de_nonce' ], basename( __FILE__ ) ) ) ? true : false;
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
	
	$options = array(
		'_generate-disable-header',
		'_generate-disable-nav',
		'_generate-disable-secondary-nav',
		'_generate-disable-headline',
		'_generate-disable-footer',
		'_generate-disable-post-image'
	);
	
	foreach ( $options as $key ) {
		$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );

		if ( $value )
			update_post_meta( $post_id, $key, $value );
		else
			delete_post_meta( $post_id, $key );
	}
}  
endif;

if ( ! function_exists( 'generate_disable_title' ) ) :
add_filter( 'generate_show_title', 'generate_disable_title' );
function generate_disable_title()
{
	global $post;
	$disable_headline = ( isset( $post ) ) ? get_post_meta( $post->ID, '_generate-disable-headline', true ) : '';
	
	if ( !empty($disable_headline) && false !== $disable_headline ) :
		return false;
	endif;
	
	return true;
}
endif;
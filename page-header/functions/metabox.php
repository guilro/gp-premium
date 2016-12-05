<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'add_generate_page_header_meta_box' ) ) :
/**
 * Generate the page header metabox
 * @since 0.1
 */
add_action('add_meta_boxes', 'add_generate_page_header_meta_box');
function add_generate_page_header_meta_box() { 
	
	$args = array( 'public' => true );
	$post_types = get_post_types( $args );
	foreach ($post_types as $type) {
		if ( 'attachment' !== $type ) {
			add_meta_box(  
				'generate_page_header_meta_box', // $id  
				__('Page Header','page-header'), // $title   
				'show_generate_page_header_meta_box', // $callback  
				$type, // $page  
				'normal', // $context  
				'high' // $priority  
			); 
		}
	}
} 
endif;

if ( ! function_exists( 'generate_page_header_metabox_enqueue' ) ) :
/**
 * Add our metabox scripts
 */
add_action( 'admin_enqueue_scripts','generate_page_header_metabox_enqueue' );
function generate_page_header_metabox_enqueue( $hook )
{
	// I prefer to enqueue the styles only on pages that are using the metaboxes
	if( in_array( $hook, array( "post.php", "post-new.php" ) ) ){
		$args = array( 'public' => true );
		$post_types = get_post_types( $args );
		
		$screen = get_current_screen();
		$post_type = $screen->id;

		if ( in_array( $post_type, (array) $post_types ) ){
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'generate-page-header-metabox', plugin_dir_url( __FILE__ ) . 'css/metabox.css', array(), GENERATE_PAGE_HEADER_VERSION ); 
			wp_enqueue_script( 'generate-lc-switch', plugin_dir_url( __FILE__ ) . 'js/lc_switch.js', array( 'jquery' ), GENERATE_PAGE_HEADER_VERSION, false ); 
			wp_enqueue_script( 'generate-page-header-metabox', plugin_dir_url( __FILE__ ) . 'js/metabox.js', array( 'jquery','generate-lc-switch', 'wp-color-picker' ), GENERATE_PAGE_HEADER_VERSION, false ); 
		}
	}
}
endif;

if ( ! function_exists( 'show_generate_page_header_meta_box' ) ) :
/**
 * Outputs the content of the metabox
 */
function show_generate_page_header_meta_box( $post ) {  

    wp_nonce_field( basename( __FILE__ ), 'generate_page_header_nonce' );
    $stored_meta = get_post_meta( $post->ID );
	
	// Set defaults to avoid PHP notices	
	$stored_meta['_meta-generate-page-header-image'][0] = ( isset( $stored_meta['_meta-generate-page-header-image'][0] ) ) ? $stored_meta['_meta-generate-page-header-image'][0] : '';
	$stored_meta['_meta-generate-page-header-image-id'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-id'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-id'][0] : '';
	$stored_meta['_meta-generate-page-header-image-link'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-link'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-link'][0] : '';	
	$stored_meta['_meta-generate-page-header-enable-image-crop'][0] = ( isset( $stored_meta['_meta-generate-page-header-enable-image-crop'][0] ) ) ? $stored_meta['_meta-generate-page-header-enable-image-crop'][0] : '';
	$stored_meta['_meta-generate-page-header-image-width'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-width'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-width'][0] : '';
	$stored_meta['_meta-generate-page-header-image-height'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-height'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-height'][0] : '';
	$stored_meta['_meta-generate-page-header-content'][0] = ( isset( $stored_meta['_meta-generate-page-header-content'][0] ) ) ? $stored_meta['_meta-generate-page-header-content'][0] : '';
	$stored_meta['_meta-generate-page-header-content-autop'][0] = ( isset( $stored_meta['_meta-generate-page-header-content-autop'][0] ) ) ? $stored_meta['_meta-generate-page-header-content-autop'][0] : '';
	$stored_meta['_meta-generate-page-header-content-padding'][0] = ( isset( $stored_meta['_meta-generate-page-header-content-padding'][0] ) ) ? $stored_meta['_meta-generate-page-header-content-padding'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-type'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-type'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-type'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-fixed'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-fixed'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-fixed'][0] : '';
	$stored_meta['_meta-generate-page-header-full-screen'][0] = ( isset( $stored_meta['_meta-generate-page-header-full-screen'][0] ) ) ? $stored_meta['_meta-generate-page-header-full-screen'][0] : '';
	$stored_meta['_meta-generate-page-header-vertical-center'][0] = ( isset( $stored_meta['_meta-generate-page-header-vertical-center'][0] ) ) ? $stored_meta['_meta-generate-page-header-vertical-center'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-alignment'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-alignment'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-alignment'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-spacing'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-spacing'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-spacing'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-spacing-unit'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-spacing-unit'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-spacing-unit'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-text-color'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-text-color'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-text-color'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-color'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-color'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-color'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-link-color'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-link-color'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-link-color'][0] : '';
	$stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0] = ( isset( $stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0] ) ) ? $stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0] : '';
	$stored_meta['_meta-generate-page-header-combine'][0] = ( isset( $stored_meta['_meta-generate-page-header-combine'][0] ) ) ? $stored_meta['_meta-generate-page-header-combine'][0] : '';
	$stored_meta['_meta-generate-page-header-absolute-position'][0] = ( isset( $stored_meta['_meta-generate-page-header-absolute-position'][0] ) ) ? $stored_meta['_meta-generate-page-header-absolute-position'][0] : '';
	$stored_meta['_meta-generate-page-header-navigation-transparent-navigation'][0] = ( isset( $stored_meta['_meta-generate-page-header-navigation-transparent-navigation'][0] ) ) ? $stored_meta['_meta-generate-page-header-navigation-transparent-navigation'][0] : '';
	$stored_meta['_meta-generate-page-header-navigation-text'][0] = ( isset( $stored_meta['_meta-generate-page-header-navigation-text'][0] ) ) ? $stored_meta['_meta-generate-page-header-navigation-text'][0] : '';
	$stored_meta['_meta-generate-page-header-site-title'][0] = ( isset( $stored_meta['_meta-generate-page-header-site-title'][0] ) ) ? $stored_meta['_meta-generate-page-header-site-title'][0] : '';
	$stored_meta['_meta-generate-page-header-site-tagline'][0] = ( isset( $stored_meta['_meta-generate-page-header-site-tagline'][0] ) ) ? $stored_meta['_meta-generate-page-header-site-tagline'][0] : '';
	$stored_meta['_meta-generate-page-header-navigation-background-hover'][0] = ( isset( $stored_meta['_meta-generate-page-header-navigation-background-hover'][0] ) ) ? $stored_meta['_meta-generate-page-header-navigation-background-hover'][0] : '';
	$stored_meta['_meta-generate-page-header-navigation-text-hover'][0] = ( isset( $stored_meta['_meta-generate-page-header-navigation-text-hover'][0] ) ) ? $stored_meta['_meta-generate-page-header-navigation-text-hover'][0] : '';
	$stored_meta['_meta-generate-page-header-navigation-background-current'][0] = ( isset( $stored_meta['_meta-generate-page-header-navigation-background-current'][0] ) ) ? $stored_meta['_meta-generate-page-header-navigation-background-current'][0] : '';
	$stored_meta['_meta-generate-page-header-navigation-text-current'][0] = ( isset( $stored_meta['_meta-generate-page-header-navigation-text-current'][0] ) ) ? $stored_meta['_meta-generate-page-header-navigation-text-current'][0] : '';
	$stored_meta['_meta-generate-page-header-video'][0] = ( isset( $stored_meta['_meta-generate-page-header-video'][0] ) ) ? $stored_meta['_meta-generate-page-header-video'][0] : '';
	$stored_meta['_meta-generate-page-header-video-ogv'][0] = ( isset( $stored_meta['_meta-generate-page-header-video-ogv'][0] ) ) ? $stored_meta['_meta-generate-page-header-video-ogv'][0] : '';
	$stored_meta['_meta-generate-page-header-video-webm'][0] = ( isset( $stored_meta['_meta-generate-page-header-video-webm'][0] ) ) ? $stored_meta['_meta-generate-page-header-video-webm'][0] : '';
	$stored_meta['_meta-generate-page-header-video-overlay'][0] = ( isset( $stored_meta['_meta-generate-page-header-video-overlay'][0] ) ) ? $stored_meta['_meta-generate-page-header-video-overlay'][0] : '';
	if ( 'post' == get_post_type() && !is_single() ) {
		$stored_meta['_meta-generate-page-header-add-to-excerpt'][0] = ( isset( $stored_meta['_meta-generate-page-header-add-to-excerpt'][0] ) ) ? $stored_meta['_meta-generate-page-header-add-to-excerpt'][0] : '';
	}
	$stored_meta['_meta-generate-page-header-logo'][0] = ( isset( $stored_meta['_meta-generate-page-header-logo'][0] ) ) ? $stored_meta['_meta-generate-page-header-logo'][0] : '';
	$stored_meta['_meta-generate-page-header-logo-id'][0] = ( isset( $stored_meta['_meta-generate-page-header-logo-id'][0] ) ) ? $stored_meta['_meta-generate-page-header-logo-id'][0] : '';
	
	$show_excerpt_option = ( has_post_thumbnail() ) ? 'style="display:none;"' : 'style="display:block;"';
	?>
	<script>
		jQuery(document).ready(function($) {
			
			<?php if ( $stored_meta['_meta-generate-page-header-content'][0] == '' ) : ?>
				$("li.generate-page-header-content-required, .content-settings-area").hide();
			<?php else : ?>
				$('#generate-tab-1').hide();
				$('#generate-tab-2').show();
				$('.generate-tabs-menu .content-settings').addClass('generate-current');
				$('.generate-tabs-menu .image-settings').removeClass('generate-current');
				$("li.generate-page-header-content-required, .content-settings-area").show();
			<?php endif; ?>
			
		});
	</script>
	<div id="generate-tabs-container">
		<ul class="generate-tabs-menu">
			<li class="generate-current image-settings"><a href="#generate-tab-1"><?php _e( 'Image','page-header' ); ?></a></li>
			<li class="content-settings"><a href="#generate-tab-2"><?php _e( 'Content','page-header' ); ?></a></li>
			<li class="video-settings generate-page-header-content-required" style="display:none;"><a href="#generate-tab-3"><?php _e( 'Background Video','page-header' ); ?></a></li>
			<?php if ( generate_page_header_logo_exists() ) : ?>
				<li class="logo-settings"><a href="#generate-tab-4"><?php _e( 'Logo','page-header' ); ?></a></li>
			<?php endif; ?>
			<li class="advanced-settings generate-page-header-content-required" style="display:none"><a href="<?php if ( generate_page_header_logo_exists() ) : ?>#generate-tab-5<?php else : ?>#generate-tab-4<?php endif; ?>"><?php _e( 'Advanced','page-header' ); ?></a></li>
			<?php if ( 'post' == get_post_type() && !is_single() ) { ?>
				<div class="show-in-excerpt" <?php echo $show_excerpt_option; ?>>
					<p>
						<label for="_meta-generate-page-header-add-to-excerpt"><strong><?php _e('Add to excerpt','page-header');?></strong></label><br />
						<input class="add-to-excerpt" type="checkbox" name="_meta-generate-page-header-add-to-excerpt" id="_meta-generate-page-header-add-to-excerpt" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-add-to-excerpt'] ) ) checked( $stored_meta['_meta-generate-page-header-add-to-excerpt'][0], 'yes' ); ?> />
					</p>
				</div>
			<?php } ?>
		</ul>
		<div class="generate-tab">
			<div id="generate-tab-1" class="generate-tab-content">
				<?php 
				$show_featured_image_message = ( has_post_thumbnail() && '' == $stored_meta['_meta-generate-page-header-image-id'][0] ) ? 'style="display:block;"' : 'style="display:none;"'; 
				$remove_button = ( $stored_meta['_meta-generate-page-header-image'][0] != "") ? 'style="display:inline-block;"' : 'style="display:none;"';
				$show_image_settings = ( has_post_thumbnail() || '' !== $stored_meta['_meta-generate-page-header-image-id'][0] ) ? 'style="display:block;"' : 'style="display: none;"';
				$no_image_selected = ( ! has_post_thumbnail() && '' == $stored_meta['_meta-generate-page-header-image-id'][0] ) ? 'style="display:block;"' : 'style="display:none;"';
				?>
				<div class="featured-image-message" <?php echo $show_featured_image_message; ?>>
					<p class="description">
						<?php _e( 'Currently using your <a href="#" class="generate-featured-image">featured image</a>.','page-header' ); ?>
					</p>
				</div>
				<div id="preview-image" class="generate-page-header-image">
					<?php if( $stored_meta['_meta-generate-page-header-image'][0] != "") { ?>
						<img class="saved-image" src="<?php echo $stored_meta['_meta-generate-page-header-image'][0];?>" width="100" style="margin-bottom:12px;" />
					<?php } ?>
				</div>
				<input data-prev="true" id="upload_image" type="hidden" name="_meta-generate-page-header-image" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-image'][0]); ?>" />			   
				<button class="generate-upload-file button" type="button" data-type="image" data-title="<?php _e( 'Page Header Image','page-header' );?>" data-insert="<?php _e( 'Insert Image','page-header'); ?>" data-prev="true">
					<?php _e('Choose Image','page-header') ;?>
				</button>
				<button class="generate-page-header-remove-image button" type="button" <?php echo $remove_button; ?> data-input="#upload_image" data-input-id="#_meta-generate-page-header-image-id" data-prev=".generate-page-header-image">
					<?php _e('Remove Image','page-header') ;?>
				</button>
				<input class="image-id" id="_meta-generate-page-header-image-id" type="hidden" name="_meta-generate-page-header-image-id" value="<?php echo $stored_meta['_meta-generate-page-header-image-id'][0]; ?>" />
				<div class="generate-page-header-set-featured-image" <?php echo $no_image_selected; ?>>
					<p class="description"><?php _e( 'Or you can <a href="#">set the featured image</a>.','page-header' ); ?></p>
				</div>
				<div class="page-header-image-settings" <?php echo $show_image_settings; ?>>
					<p>
						<label for="_meta-generate-page-header-image-link" class="example-row-title"><strong><?php _e('Image link','page-header');?></strong></label><br />
						<input class="widefat" style="max-width:350px;" placeholder="http://" id="_meta-generate-page-header-image-link" type="text" name="_meta-generate-page-header-image-link" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-image-link'][0]); ?>" />
					</p>
					
					<p>
						<label for="_meta-generate-page-header-enable-image-crop" class="example-row-title"><strong><?php _e('Resize image','page-header');?></strong></label><br />
						<select name="_meta-generate-page-header-enable-image-crop" id="_meta-generate-page-header-enable-image-crop">
							<option value="" <?php selected( $stored_meta['_meta-generate-page-header-enable-image-crop'][0], '' ); ?>><?php _e('Disable','page-header');?></option>
							<option value="enable" <?php selected( $stored_meta['_meta-generate-page-header-enable-image-crop'][0], 'enable' ); ?>><?php _e('Enable','page-header');?></option>
						</select>
					</p>
					
					<div id="crop-enabled" style="display:none">					
						<p>
							<label for="_meta-generate-page-header-image-width" class="example-row-title"><strong><?php _e('Image width','page-header');?></strong></label><br />
							<input style="width:45px" type="text" name="_meta-generate-page-header-image-width" id="_meta-generate-page-header-image-width" value="<?php echo intval( $stored_meta['_meta-generate-page-header-image-width'][0] ); ?>" /><label for="_meta-generate-page-header-image-width"><span class="pixels">px</span></label>
						</p>
						
						<p style="margin-bottom:0;">
							<label for="_meta-generate-page-header-image-height" class="example-row-title"><strong><?php _e('Image height','page-header');?></strong></label><br />
							<input placeholder="" style="width:45px" type="text" name="_meta-generate-page-header-image-height" id="_meta-generate-page-header-image-height" value="<?php echo intval( $stored_meta['_meta-generate-page-header-image-height'][0] ); ?>" />
							<label for="_meta-generate-page-header-image-height"><span class="pixels">px</span></label>
							<span class="description" style="display:block;"><?php _e('Use "0" or leave blank for proportional resizing.','page-header');?></span>
						</p>
					</div>
				</div>
			</div>
			<div id="generate-tab-2" class="generate-tab-content">
				
				<textarea style="width:100%;min-height:200px;" name="_meta-generate-page-header-content" id="_meta-generate-page-header-content"><?php echo esc_html($stored_meta['_meta-generate-page-header-content'][0]); ?></textarea>
				<p class="description" style="margin:0;"><?php _e('HTML and shortcodes allowed.','page-header');?></p>
				
				<div class="generate-page-header-content-required content-settings-area" style="margin-top:12px;">
					<div class="page-header-column">
						<p>
							<label for="_meta-generate-page-header-content-autop"><strong><?php _e('Automatically add paragraphs','page-header');?></strong></label><br />
							<input type="checkbox" name="_meta-generate-page-header-content-autop" id="_meta-generate-page-header-content-autop" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-content-autop'] ) ) checked( $stored_meta['_meta-generate-page-header-content-autop'][0], 'yes' ); ?> /> 
						</p>
						<p>
							<label for="_meta-generate-page-header-content-padding"><?php _e('Add padding','page-header');?></label><br />
							<input type="checkbox" name="_meta-generate-page-header-content-padding" id="_meta-generate-page-header-content-padding" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-content-padding'] ) ) checked( $stored_meta['_meta-generate-page-header-content-padding'][0], 'yes' ); ?> /> 
						</p>
						<p>
							<label for="_meta-generate-page-header-image-background"><?php _e('Add background image','page-header');?></label><br />
							<input class="image-background" type="checkbox" name="_meta-generate-page-header-image-background" id="_meta-generate-page-header-image-background" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-image-background'] ) ) checked( $stored_meta['_meta-generate-page-header-image-background'][0], 'yes' ); ?> /> 
						</p>
						<p class="parallax">
							<label for="_meta-generate-page-header-image-background-fixed"><?php _e('Parallax effect','page-header');?></label><br />
							<input type="checkbox" name="_meta-generate-page-header-image-background-fixed" id="_meta-generate-page-header-image-background-fixed" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-image-background-fixed'] ) ) checked( $stored_meta['_meta-generate-page-header-image-background-fixed'][0], 'yes' ); ?> /> 
						</p>
						<p class="fullscreen">
							<label for="_meta-generate-page-header-full-screen"><?php _e('Fullscreen','page-header');?></label><br />
							<input type="checkbox" name="_meta-generate-page-header-full-screen" id="_meta-generate-page-header-full-screen" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-full-screen'] ) ) checked( $stored_meta['_meta-generate-page-header-full-screen'][0], 'yes' ); ?> /> 
						</p>
						<p class="vertical-center">
							<label for="_meta-generate-page-header-vertical-center"><?php _e('Vertical center content','page-header');?></label><br />
							<input type="checkbox" name="_meta-generate-page-header-vertical-center" id="_meta-generate-page-header-vertical-center" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-vertical-center'] ) ) checked( $stored_meta['_meta-generate-page-header-vertical-center'][0], 'yes' ); ?> />
						</p>
					</div>
					<div class="page-header-column">
						<p>
							<label for="_meta-generate-page-header-image-background-type" class="example-row-title"><strong><?php _e('Container type','page-header');?></strong></label><br />
							<select name="_meta-generate-page-header-image-background-type" id="_meta-generate-page-header-image-background-type">
								<option value="" <?php selected( $stored_meta['_meta-generate-page-header-image-background-type'][0], '' ); ?>><?php _e('Contained','page-header');?></option>
								<option value="fluid" <?php selected( $stored_meta['_meta-generate-page-header-image-background-type'][0], 'fluid' ); ?>><?php _e('Full width','page-header');?></option>
							</select>
						</p>

						<p>
							<label for="_meta-generate-page-header-image-background-alignment" class="example-row-title"><strong><?php _e('Text alignment','page-header');?></strong></label><br />
							<select name="_meta-generate-page-header-image-background-alignment" id="_meta-generate-page-header-image-background-alignment">
								<option value="" <?php selected( $stored_meta['_meta-generate-page-header-image-background-alignment'][0], '' ); ?>><?php _e('Left','page-header');?></option>
								<option value="center" <?php selected( $stored_meta['_meta-generate-page-header-image-background-alignment'][0], 'center' ); ?>><?php _e('Center','page-header');?></option>
								<option value="right" <?php selected( $stored_meta['_meta-generate-page-header-image-background-alignment'][0], 'right' ); ?>><?php _e('Right','page-header');?></option>
							</select>
						</p>
						
						<p>
							<label for="_meta-generate-page-header-image-background-spacing" class="example-row-title"><strong><?php _e('Top/Bottom padding','page-header');?></strong></label><br />
							<input placeholder="" style="width:45px" type="text" name="_meta-generate-page-header-image-background-spacing" id="_meta-generate-page-header-image-background-spacing" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-spacing'][0]; ?>" />
							<select name="_meta-generate-page-header-image-background-spacing-unit" id="_meta-generate-page-header-image-background-spacing-unit">
								<option value="" <?php selected( $stored_meta['_meta-generate-page-header-image-background-spacing-unit'][0], '' ); ?>>px</option>
								<option value="%" <?php selected( $stored_meta['_meta-generate-page-header-image-background-spacing-unit'][0], '%' ); ?>>%</option>
							</select>
						</p>
					</div>
					<div class="page-header-column last">
						<p>
							<label for="_meta-generate-page-header-image-background-color" class="example-row-title"><strong><?php _e('Background color','page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-color" id="_meta-generate-page-header-image-background-color" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-color'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-image-background-text-color" class="example-row-title"><strong><?php _e('Text color','page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-text-color" id="_meta-generate-page-header-image-background-text-color" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-text-color'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-image-background-link-color" class="example-row-title"><strong><?php _e('Link color','page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-link-color" id="_meta-generate-page-header-image-background-link-color" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-link-color'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-image-background-link-color-hover" class="example-row-title"><strong><?php _e('Link color hover','page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-link-color-hover" id="_meta-generate-page-header-image-background-link-color-hover" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0]; ?>" />
						</p>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div id="generate-tab-3" class="generate-tab-content generate-video-tab generate-page-header-content-required" style="display:none">
				<p style="margin-top:0;">
					<label for="_meta-generate-page-header-video" class="example-row-title"><strong><?php _e('MP4 file','page-header');?></strong></label><br />
					<input placeholder="http://" class="widefat" style="max-width:350px" id="_meta-generate-page-header-video" type="text" name="_meta-generate-page-header-video" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-video'][0]); ?>" />			   
					<button class="generate-upload-file button" type="button" data-type="video" data-title="<?php _e( 'Page Header Video','page-header' );?>" data-insert="<?php _e( 'Insert Video','page-header'); ?>" data-prev="false">
						<?php _e('Choose Video','page-header') ;?>
					</button>
				</p>
				<p>
					<label for="_meta-generate-page-header-video-ogv" class="example-row-title"><strong><?php _e('OGV file','page-header');?></strong></label><br />
					<input placeholder="http://" class="widefat" style="max-width:350px" id="_meta-generate-page-header-video-ogv" type="text" name="_meta-generate-page-header-video-ogv" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-video-ogv'][0]); ?>" />			   
					<button class="generate-upload-file button" type="button" data-type="video" data-title="<?php _e( 'Page Header Video','page-header' );?>" data-insert="<?php _e( 'Insert Video','page-header'); ?>" data-prev="false">
						<?php _e('Choose Video','page-header') ;?>
					</button>
				</p>
				<p>
					<label for="_meta-generate-page-header-video-webm" class="example-row-title"><strong><?php _e('WEBM file','page-header');?></strong></label><br />
					<input placeholder="http://" class="widefat" style="max-width:350px" id="_meta-generate-page-header-video-webm" type="text" name="_meta-generate-page-header-video-webm" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-video-webm'][0]); ?>" />			   
					<button class="generate-upload-file button" type="button" data-type="video" data-title="<?php _e( 'Page Header Video','page-header' );?>" data-insert="<?php _e( 'Insert Video','page-header'); ?>" data-prev="false">
						<?php _e('Choose Video','page-header') ;?>
					</button>
				</p>
				<p>
					<label for="_meta-generate-page-header-video-overlay" class="example-row-title"><strong><?php _e('Overlay color','page-header');?></strong></label><br />
					<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-video-overlay" id="_meta-generate-page-header-video-overlay" value="<?php echo $stored_meta['_meta-generate-page-header-video-overlay'][0]; ?>" />
				</p>
			</div>
			<?php if ( generate_page_header_logo_exists() ) : ?>
				<div id="generate-tab-4" class="generate-tab-content">
					<p class="description" style="margin-top:0;"><?php _e( 'Overwrite your site-wide logo/header on this page.','page-header' ); ?></p>
					<div id="preview-image" class="generate-logo-image">
						<?php if( $stored_meta['_meta-generate-page-header-logo'][0] != "") { ?>
							<img class="saved-image" src="<?php echo $stored_meta['_meta-generate-page-header-logo'][0];?>" width="100" style="margin-bottom:12px;" />
						<?php } ?>
					</div>
					<input style="width:350px" id="_meta-generate-page-header-logo" type="hidden" name="_meta-generate-page-header-logo" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-logo'][0]); ?>" />			   
					<button class="generate-upload-file button" type="button" data-type="image" data-title="<?php _e( 'Header / Logo','page-header' );?>" data-insert="<?php _e( 'Insert Logo','page-header'); ?>" data-prev="true">
						<?php _e('Choose Logo','page-header') ;?>
					</button>
					<input class="image-id" id="_meta-generate-page-header-logo-id" type="hidden" name="_meta-generate-page-header-logo-id" value="<?php echo $stored_meta['_meta-generate-page-header-logo-id'][0]; ?>" />
					<?php if( $stored_meta['_meta-generate-page-header-logo'][0] != "") {
						$remove_button = 'style="display:inline-block;"';
					} else {
						$remove_button = 'style="display:none;"';
					}
					?>
					<button class="generate-page-header-remove-image button" type="button" <?php echo $remove_button; ?> data-input="#_meta-generate-page-header-logo" data-input-id="_meta-generate-page-header-logo-id" data-prev=".generate-logo-image">
						<?php _e('Remove Logo','page-header') ;?>
					</button>
				</div>
			<?php endif; ?>
			<div id="<?php if ( generate_page_header_logo_exists() ) : ?>generate-tab-5<?php else : ?>generate-tab-4<?php endif; ?>" class="generate-tab-content generate-page-header-content-required" style="display:none">
				<p style="margin-top:0;">
					<label for="_meta-generate-page-header-combine"><?php _e('Merge with site header','page-header');?></label><br />
					<input type="checkbox" name="_meta-generate-page-header-combine" id="_meta-generate-page-header-combine" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-combine'] ) ) checked( $stored_meta['_meta-generate-page-header-combine'][0], 'yes' ); ?> /> 
				</p>
				
				<div class="combination-options">
					<p class="absolute-position">
						<label for="_meta-generate-page-header-absolute-position"><?php _e('Place content behind header (sliders etc..)','page-header');?></label><br />
						<input type="checkbox" name="_meta-generate-page-header-absolute-position" id="_meta-generate-page-header-absolute-position" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-absolute-position'] ) ) checked( $stored_meta['_meta-generate-page-header-absolute-position'][0], 'yes' ); ?> /> 
					</p>
				
					<p>
						<label for="_meta-generate-page-header-site-title" class="example-row-title"><strong><?php _e('Site title','page-header');?></strong></label><br />
						<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-site-title" id="_meta-generate-page-header-site-title" value="<?php echo $stored_meta['_meta-generate-page-header-site-title'][0]; ?>" />
					</p>
					
					<p>
						<label for="_meta-generate-page-header-site-tagline" class="example-row-title"><strong><?php _e('Site tagline','page-header');?></strong></label><br />
						<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-site-tagline" id="_meta-generate-page-header-site-tagline" value="<?php echo $stored_meta['_meta-generate-page-header-site-tagline'][0]; ?>" />
					</p>
					
					<p>
						<label for="_meta-generate-page-header-transparent-navigation"><?php _e('Transparent navigation','page-header');?></label><br />
						<input type="checkbox" name="_meta-generate-page-header-transparent-navigation" id="_meta-generate-page-header-transparent-navigation" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-transparent-navigation'] ) ) checked( $stored_meta['_meta-generate-page-header-transparent-navigation'][0], 'yes' ); ?> /> 
					</p>
					
					<div class="navigation-colors">
						<p>
							<label for="_meta-generate-page-header-navigation-text" class="example-row-title"><strong><?php _e('Navigation text','page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-text" id="_meta-generate-page-header-navigation-text" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-text'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-navigation-background-hover" class="example-row-title"><strong><?php _e('Navigation background hover','page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-background-hover" id="_meta-generate-page-header-navigation-background-hover" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-background-hover'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-navigation-text-hover" class="example-row-title"><strong><?php _e('Navigation text hover','page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-text-hover" id="_meta-generate-page-header-navigation-text-hover" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-text-hover'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-navigation-background-current" class="example-row-title"><strong><?php _e('Navigation background current','page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-background-current" id="_meta-generate-page-header-navigation-background-current" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-background-current'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-navigation-text-current" class="example-row-title"><strong><?php _e('Navigation text current','page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-text-current" id="_meta-generate-page-header-navigation-text-current" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-text-current'][0]; ?>" />
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
    <?php
}
endif;

if ( ! function_exists( 'save_generate_page_header_meta' ) ) :
// Save the Data  
add_action('save_post', 'save_generate_page_header_meta');
function save_generate_page_header_meta($post_id) {  
    
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'generate_page_header_nonce' ] ) && wp_verify_nonce( $_POST[ 'generate_page_header_nonce' ], basename( __FILE__ ) ) ) ? true : false;
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
	
	$options = array(
		'_meta-generate-page-header-content' => 'FILTER_DEFAULT',
		'_meta-generate-page-header-image' => 'FILTER_SANITIZE_URL',
		'_meta-generate-page-header-image-id' => 'FILTER_SANITIZE_NUMBER_INT',
		'_meta-generate-page-header-image-link' => 'FILTER_SANITIZE_URL',
		'_meta-generate-page-header-enable-image-crop' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-crop' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-width' => 'FILTER_SANITIZE_NUMBER_INT',
		'_meta-generate-page-header-image-height' => 'FILTER_SANITIZE_NUMBER_INT',
		'_meta-generate-page-header-image-background-type' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background-alignment' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background-spacing' => 'FILTER_SANITIZE_NUMBER_INT',
		'_meta-generate-page-header-image-background-spacing-unit' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background-color' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background-text-color' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background-link-color' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background-link-color-hover' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-navigation-text' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-navigation-background-hover' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-navigation-text-hover' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-navigation-background-current' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-navigation-text-current' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-site-title' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-site-tagline' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-video' => 'FILTER_SANITIZE_URL',
		'_meta-generate-page-header-video-ogv' => 'FILTER_SANITIZE_URL',
		'_meta-generate-page-header-video-webm' => 'FILTER_SANITIZE_URL',
		'_meta-generate-page-header-video-overlay' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-content-autop' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-content-padding' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-full-screen' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-vertical-center' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-image-background-fixed' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-combine' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-absolute-position' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-transparent-navigation' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-add-to-excerpt' => 'FILTER_SANITIZE_STRING',
		'_meta-generate-page-header-logo' => 'FILTER_SANITIZE_URL',
		'_meta-generate-page-header-logo-id' => 'FILTER_SANITIZE_NUMBER_INT',
	);

	foreach ( $options as $key => $sanitize ) {
		if ( 'FILTER_SANITIZE_STRING' == $sanitize ) {
			$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
		} elseif ( 'FILTER_SANITIZE_URL' == $sanitize ) {
			$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_URL );
		} elseif ( 'FILTER_SANITIZE_NUMBER_INT' == $sanitize ) {
			$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT );
		} else {
			$value = filter_input( INPUT_POST, $key, FILTER_DEFAULT );
		}
		
		if ( $value )
			update_post_meta( $post_id, $key, $value );
		else
			delete_post_meta( $post_id, $key );
	}
	
}  
endif;
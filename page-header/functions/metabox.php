<?php
if ( ! function_exists( 'add_generate_page_header_meta_box' ) ) :
/**
 *
 *
 * Generate the page header metabox
 * @since 0.1
 *
 *
 */
add_action('add_meta_boxes', 'add_generate_page_header_meta_box');
function add_generate_page_header_meta_box() { 
	
	
	$post_types = get_post_types();
	foreach ($post_types as $type) {
		if ( 'attachment' !== $type ) {
			add_meta_box(  
				'generate_page_header_meta_box', // $id  
				__('Page Header','generate-page-header'), // $title   
				'show_generate_page_header_meta_box', // $callback  
				$type, // $page  
				'normal', // $context  
				'high' // $priority  
			); 
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
    
	
	?>
	<div id="generate-tabs-container">
		<ul class="generate-tabs-menu">
			<li class="generate-current image-settings"><a class="button button-large" href="#generate-tab-1"><?php _e( 'Image Settings','generate-page-header' ); ?></a></li>
			<li class="video-settings generate-page-header-content-required"><a class="button button-large" href="#generate-tab-2"><?php _e( 'Video Settings','generate-page-header' ); ?></a></li>
			<li class="content-settings"><a class="button button-large" href="#generate-tab-3"><?php _e( 'Content Settings','generate-page-header' ); ?></a></li>
			<?php if ( generate_page_header_logo_exists() ) : ?>
				<li class="logo-settings"><a class="button button-large" href="#generate-tab-4"><?php _e( 'Logo Settings','generate-page-header' ); ?></a></li>
			<?php endif; ?>
			<li class="advanced-settings generate-page-header-content-required"><a class="button button-large" href="<?php if ( generate_page_header_logo_exists() ) : ?>#generate-tab-5<?php else : ?>#generate-tab-4<?php endif; ?>"><?php _e( 'Advanced Settings','generate-page-header' ); ?></a></li>
		</ul>
		<div class="generate-tab">
			<div id="generate-tab-1" class="generate-tab-content">
				<div id="preview-image">
					<?php if( $stored_meta['_meta-generate-page-header-image'][0] != "") { ?>
						<img class="saved-image" src="<?php echo $stored_meta['_meta-generate-page-header-image'][0];?>" width="300" />
					<?php } ?>
				</div>
				<label for="upload_image" class="example-row-title"><strong><?php _e('Page Header Image','generate-page-header');?></strong></label><br />
				<input style="width:350px" id="upload_image" type="text" name="_meta-generate-page-header-image" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-image'][0]); ?>" />			   
				<button class="generate-upload-file button" type="button" data-type="image" data-title="<?php _e( 'Page Header Image','generate-page-header' );?>" data-insert="<?php _e( 'Insert Image','generate-page-header'); ?>" data-prev="true">
					<?php _e('Add Image','generate-page-header') ;?>
				</button>
				<input id="_meta-generate-page-header-image-id" type="hidden" name="_meta-generate-page-header-image-id" value="<?php echo $stored_meta['_meta-generate-page-header-image-id'][0]; ?>" />
				
				<p>
					<label for="_meta-generate-page-header-image-link" class="example-row-title"><strong><?php _e('Page Header Link','generate-page-header');?></strong></label><br />
					<input style="width:350px" placeholder="http://" id="_meta-generate-page-header-image-link" type="text" name="_meta-generate-page-header-image-link" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-image-link'][0]); ?>" />
				</p>
				
				<p>
					<label for="_meta-generate-page-header-enable-image-crop" class="example-row-title"><strong><?php _e('Hard Crop','generate-page-header');?></strong></label><br />
					<select name="_meta-generate-page-header-enable-image-crop" id="_meta-generate-page-header-enable-image-crop">
						<option value="" <?php selected( $stored_meta['_meta-generate-page-header-enable-image-crop'][0], '' ); ?>><?php _e('Disable','generate-page-header');?></option>
						<option value="enable" <?php selected( $stored_meta['_meta-generate-page-header-enable-image-crop'][0], 'enable' ); ?>><?php _e('Enable','generate-page-header');?></option>
					</select>
				</p>
				
				<div id="crop-enabled" style="display:none">					
					<p>
						<label for="_meta-generate-page-header-image-width" class="example-row-title"><strong><?php _e('Image Width','generate-page-header');?></strong></label><br />
						<input style="width:45px" type="text" name="_meta-generate-page-header-image-width" id="_meta-generate-page-header-image-width" value="<?php echo intval( $stored_meta['_meta-generate-page-header-image-width'][0] ); ?>" /><label for="_meta-generate-page-header-image-width"><span class="pixels">px</span></label>
					</p>
					
					<p>
						<label for="_meta-generate-page-header-image-height" class="example-row-title"><strong><?php _e('Image Height','generate-page-header');?></strong></label><br />
						<input placeholder="" style="width:45px" type="text" name="_meta-generate-page-header-image-height" id="_meta-generate-page-header-image-height" value="<?php echo intval( $stored_meta['_meta-generate-page-header-image-height'][0] ); ?>" /><label for="_meta-generate-page-header-image-height"><span class="pixels">px</span></label>
						<span class="small"><?php _e('Use "0" or leave blank for proportional resizing.','generate-page-header');?></span>
					</p>
				</div>
			</div>
			<div id="generate-tab-2" class="generate-tab-content generate-video-tab generate-page-header-content-required">
				<p>
					<label for="_meta-generate-page-header-video" class="example-row-title"><strong><?php _e('Video background - MP4 file only','generate-page-header');?></strong></label><br />
					<input style="width:350px" id="_meta-generate-page-header-video" type="text" name="_meta-generate-page-header-video" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-video'][0]); ?>" />			   
					<button class="generate-upload-file button" type="button" data-type="video" data-title="<?php _e( 'Page Header Video','generate-page-header' );?>" data-insert="<?php _e( 'Insert Video','generate-page-header'); ?>" data-prev="false">
						<?php _e('Add Video','generate-page-header') ;?>
					</button>
				</p>
				<p>
					<label for="_meta-generate-page-header-video-ogv" class="example-row-title"><strong><?php _e('Video background - OGV file only','generate-page-header');?></strong></label><br />
					<input style="width:350px" id="_meta-generate-page-header-video-ogv" type="text" name="_meta-generate-page-header-video-ogv" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-video-ogv'][0]); ?>" />			   
					<button class="generate-upload-file button" type="button" data-type="video" data-title="<?php _e( 'Page Header Video','generate-page-header' );?>" data-insert="<?php _e( 'Insert Video','generate-page-header'); ?>" data-prev="false">
						<?php _e('Add Video','generate-page-header') ;?>
					</button>
				</p>
				<p>
					<label for="_meta-generate-page-header-video-webm" class="example-row-title"><strong><?php _e('Video background - WEBM file only','generate-page-header');?></strong></label><br />
					<input style="width:350px" id="_meta-generate-page-header-video-webm" type="text" name="_meta-generate-page-header-video-webm" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-video-webm'][0]); ?>" />			   
					<button class="generate-upload-file button" type="button" data-type="video" data-title="<?php _e( 'Page Header Video','generate-page-header' );?>" data-insert="<?php _e( 'Insert Video','generate-page-header'); ?>" data-prev="false">
						<?php _e('Add Video','generate-page-header') ;?>
					</button>
				</p>
				<p>
					<label for="_meta-generate-page-header-video-overlay" class="example-row-title"><strong><?php _e('Overlay color','generate-page-header');?></strong></label><br />
					<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-video-overlay" id="_meta-generate-page-header-video-overlay" value="<?php echo $stored_meta['_meta-generate-page-header-video-overlay'][0]; ?>" />
				</p>
			</div>
			<div id="generate-tab-3" class="generate-tab-content">
				<p>
					<label for="_meta-generate-page-header-content" class="example-row-title"><strong><?php _e('Content','generate-page-header');?></strong></label><br />
					<textarea style="width:100%;min-height:200px;" name="_meta-generate-page-header-content" id="_meta-generate-page-header-content"><?php echo esc_html($stored_meta['_meta-generate-page-header-content'][0]); ?></textarea>
					<span class="description"><?php _e('HTML and shortcodes allowed.','generate-page-header');?></span>
				</p>
				<div class="generate-page-header-content-required content-settings-area">
					<div class="page-header-column">
						<p>
							<input type="checkbox" name="_meta-generate-page-header-content-autop" id="_meta-generate-page-header-content-autop" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-content-autop'] ) ) checked( $stored_meta['_meta-generate-page-header-content-autop'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-content-autop"><?php _e('Automatically add paragraphs','generate-page-header');?></label>
						</p>
						<p>
							<input type="checkbox" name="_meta-generate-page-header-content-padding" id="_meta-generate-page-header-content-padding" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-content-padding'] ) ) checked( $stored_meta['_meta-generate-page-header-content-padding'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-content-padding"><?php _e('Add padding','generate-page-header');?></label>
						</p>
						<p>
							<input class="image-background" type="checkbox" name="_meta-generate-page-header-image-background" id="_meta-generate-page-header-image-background" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-image-background'] ) ) checked( $stored_meta['_meta-generate-page-header-image-background'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-image-background"><?php _e('Add background image','generate-page-header');?></label>
						</p>
						<p class="parallax">
							<input type="checkbox" name="_meta-generate-page-header-image-background-fixed" id="_meta-generate-page-header-image-background-fixed" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-image-background-fixed'] ) ) checked( $stored_meta['_meta-generate-page-header-image-background-fixed'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-image-background-fixed"><?php _e('Parallax effect','generate-page-header');?></label>
						</p>
						<p class="fullscreen">
							<input type="checkbox" name="_meta-generate-page-header-full-screen" id="_meta-generate-page-header-full-screen" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-full-screen'] ) ) checked( $stored_meta['_meta-generate-page-header-full-screen'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-full-screen"><?php _e('Fullscreen','generate-page-header');?></label>
						</p>
						<p class="vertical-center">
							<input type="checkbox" name="_meta-generate-page-header-vertical-center" id="_meta-generate-page-header-vertical-center" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-vertical-center'] ) ) checked( $stored_meta['_meta-generate-page-header-vertical-center'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-vertical-center"><?php _e('Vertical center content','generate-page-header');?></label>
						</p>
						<?php if ( 'post' == get_post_type() && !is_single() ) { ?>
							<div class="show-in-excerpt">
								<p>
									<input type="checkbox" name="_meta-generate-page-header-add-to-excerpt" id="_meta-generate-page-header-add-to-excerpt" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-add-to-excerpt'] ) ) checked( $stored_meta['_meta-generate-page-header-add-to-excerpt'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-add-to-excerpt"><?php _e('Add to blog excerpt','generate-page-header');?></label>
								</p>
							</div>
						<?php } ?>
					</div>
					<div class="page-header-column">
						<p>
							<label for="_meta-generate-page-header-image-background-type" class="example-row-title"><strong><?php _e('Container type','generate-page-header');?></strong></label><br />
							<select name="_meta-generate-page-header-image-background-type" id="_meta-generate-page-header-image-background-type">
								<option value="" <?php selected( $stored_meta['_meta-generate-page-header-image-background-type'][0], '' ); ?>><?php _e('Contained','generate-page-header');?></option>
								<option value="fluid" <?php selected( $stored_meta['_meta-generate-page-header-image-background-type'][0], 'fluid' ); ?>><?php _e('Fluid','generate-page-header');?></option>
							</select>
						</p>

						<p>
							<label for="_meta-generate-page-header-image-background-alignment" class="example-row-title"><strong><?php _e('Text alignment','generate-page-header');?></strong></label><br />
							<select name="_meta-generate-page-header-image-background-alignment" id="_meta-generate-page-header-image-background-alignment">
								<option value="" <?php selected( $stored_meta['_meta-generate-page-header-image-background-alignment'][0], '' ); ?>><?php _e('Left','generate-page-header');?></option>
								<option value="center" <?php selected( $stored_meta['_meta-generate-page-header-image-background-alignment'][0], 'center' ); ?>><?php _e('Center','generate-page-header');?></option>
								<option value="right" <?php selected( $stored_meta['_meta-generate-page-header-image-background-alignment'][0], 'right' ); ?>><?php _e('Right','generate-page-header');?></option>
							</select>
						</p>
						
						<p>
							<label for="_meta-generate-page-header-image-background-spacing" class="example-row-title"><strong><?php _e('Top/Bottom padding','generate-page-header');?></strong></label><br />
							<input placeholder="" style="width:45px" type="text" name="_meta-generate-page-header-image-background-spacing" id="_meta-generate-page-header-image-background-spacing" value="<?php echo intval( $stored_meta['_meta-generate-page-header-image-background-spacing'][0] ); ?>" /><label for="_meta-generate-page-header-image-background-spacing"><span class="pixels">px</span></label>
						</p>
					</div>
					<div class="page-header-column last">
						<p>
							<label for="_meta-generate-page-header-image-background-color" class="example-row-title"><strong><?php _e('Background color','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-color" id="_meta-generate-page-header-image-background-color" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-color'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-image-background-text-color" class="example-row-title"><strong><?php _e('Text color','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-text-color" id="_meta-generate-page-header-image-background-text-color" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-text-color'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-image-background-link-color" class="example-row-title"><strong><?php _e('Link color','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-link-color" id="_meta-generate-page-header-image-background-link-color" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-link-color'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-image-background-link-color-hover" class="example-row-title"><strong><?php _e('Link color hover','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-link-color-hover" id="_meta-generate-page-header-image-background-link-color-hover" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0]; ?>" />
						</p>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<?php if ( generate_page_header_logo_exists() ) : ?>
				<div id="generate-tab-4" class="generate-tab-content">
					<div id="preview-image">
						<?php if( $stored_meta['_meta-generate-page-header-logo'][0] != "") { ?>
							<img class="saved-image" src="<?php echo $stored_meta['_meta-generate-page-header-logo'][0];?>" width="100" />
						<?php } ?>
					</div>
					<label for="_meta-generate-page-header-logo" class="example-row-title"><strong><?php _e('Header / Logo','generate-page-header');?></strong></label><br />
					<input style="width:350px" id="_meta-generate-page-header-logo" type="text" name="_meta-generate-page-header-logo" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-logo'][0]); ?>" />			   
					<button class="generate-upload-file button" type="button" data-type="image" data-title="<?php _e( 'Header / Logo','generate-page-header' );?>" data-insert="<?php _e( 'Insert Image','generate-page-header'); ?>" data-prev="true">
						<?php _e('Add Image','generate-page-header') ;?>
					</button>
					<input id="_meta-generate-page-header-logo-id" type="hidden" name="_meta-generate-page-header-logo-id" value="<?php echo $stored_meta['_meta-generate-page-header-logo-id'][0]; ?>" />
				</div>
			<?php endif; ?>
			<div id="<?php if ( generate_page_header_logo_exists() ) : ?>generate-tab-5<?php else : ?>generate-tab-4<?php endif; ?>" class="generate-tab-content generate-page-header-content-required">
				<p>
					<input type="checkbox" name="_meta-generate-page-header-combine" id="_meta-generate-page-header-combine" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-combine'] ) ) checked( $stored_meta['_meta-generate-page-header-combine'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-combine"><?php _e('Merge with site header','generate-page-header');?></label>
				</p>
				
				<div class="combination-options">
					<p class="absolute-position">
						<input type="checkbox" name="_meta-generate-page-header-absolute-position" id="_meta-generate-page-header-absolute-position" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-absolute-position'] ) ) checked( $stored_meta['_meta-generate-page-header-absolute-position'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-absolute-position"><?php _e('Place content behind header (sliders etc..)','generate-page-header');?></label>
					</p>
				
					<p>
						<label for="_meta-generate-page-header-site-title" class="example-row-title"><strong><?php _e('Site title','generate-page-header');?></strong></label><br />
						<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-site-title" id="_meta-generate-page-header-site-title" value="<?php echo $stored_meta['_meta-generate-page-header-site-title'][0]; ?>" />
					</p>
					
					<p>
						<label for="_meta-generate-page-header-site-tagline" class="example-row-title"><strong><?php _e('Site tagline','generate-page-header');?></strong></label><br />
						<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-site-tagline" id="_meta-generate-page-header-site-tagline" value="<?php echo $stored_meta['_meta-generate-page-header-site-tagline'][0]; ?>" />
					</p>
					
					<p>
						<input type="checkbox" name="_meta-generate-page-header-transparent-navigation" id="_meta-generate-page-header-transparent-navigation" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-transparent-navigation'] ) ) checked( $stored_meta['_meta-generate-page-header-transparent-navigation'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-transparent-navigation"><?php _e('Transparent navigation','generate-page-header');?></label>
					</p>
					
					<div class="navigation-colors">
						<p>
							<label for="_meta-generate-page-header-navigation-text" class="example-row-title"><strong><?php _e('Navigation text','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-text" id="_meta-generate-page-header-navigation-text" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-text'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-navigation-background-hover" class="example-row-title"><strong><?php _e('Navigation background hover','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-background-hover" id="_meta-generate-page-header-navigation-background-hover" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-background-hover'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-navigation-text-hover" class="example-row-title"><strong><?php _e('Navigation text hover','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-text-hover" id="_meta-generate-page-header-navigation-text-hover" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-text-hover'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-navigation-background-current" class="example-row-title"><strong><?php _e('Navigation background current','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-background-current" id="_meta-generate-page-header-navigation-background-current" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-background-current'][0]; ?>" />
						</p>
						
						<p>
							<label for="_meta-generate-page-header-navigation-text-current" class="example-row-title"><strong><?php _e('Navigation text current','generate-page-header');?></strong></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-navigation-text-current" id="_meta-generate-page-header-navigation-text-current" value="<?php echo $stored_meta['_meta-generate-page-header-navigation-text-current'][0]; ?>" />
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		(function(a){if("undefined"!=typeof a.fn.lc_switch)return!1;a.fn.lc_switch=function(d,f){a.fn.lcs_destroy=function(){a(this).each(function(){a(this).parents(".lcs_wrap").children().not("input").remove();a(this).unwrap()});return!0};a.fn.lcs_on=function(){a(this).each(function(){var b=a(this).parents(".lcs_wrap"),c=b.find("input");"function"==typeof a.fn.prop?b.find("input").prop("checked",!0):b.find("input").attr("checked",!0);b.find("input").trigger("lcs-on");b.find("input").trigger("lcs-statuschange");
b.find(".lcs_switch").removeClass("lcs_off").addClass("lcs_on");if(b.find(".lcs_switch").hasClass("lcs_radio_switch")){var d=c.attr("name");b.parents("form").find("input[name="+d+"]").not(c).lcs_off()}});return!0};a.fn.lcs_off=function(){a(this).each(function(){var b=a(this).parents(".lcs_wrap");"function"==typeof a.fn.prop?b.find("input").prop("checked",!1):b.find("input").attr("checked",!1);b.find("input").trigger("lcs-off");b.find("input").trigger("lcs-statuschange");b.find(".lcs_switch").removeClass("lcs_on").addClass("lcs_off")});
return!0};return this.each(function(){if(!a(this).parent().hasClass("lcs_wrap")){var b="undefined"==typeof d?"ON":d,c="undefined"==typeof f?"OFF":f,b=b?'<div class="lcs_label lcs_label_on">'+b+"</div>":"",c=c?'<div class="lcs_label lcs_label_off">'+c+"</div>":"",g=a(this).is(":disabled")?!0:!1,e=a(this).is(":checked")?!0:!1,e=""+(e?" lcs_on":" lcs_off");g&&(e+=" lcs_disabled");b='<div class="lcs_switch '+e+'"><div class="lcs_cursor"></div>'+b+c+"</div>";!a(this).is(":input")||"checkbox"!=a(this).attr("type")&&
"radio"!=a(this).attr("type")||(a(this).wrap('<div class="lcs_wrap"></div>'),a(this).parent().append(b),a(this).parent().find(".lcs_switch").addClass("lcs_"+a(this).attr("type")+"_switch"))}})};a(document).ready(function(){a(document).delegate(".lcs_switch:not(.lcs_disabled)","click tap",function(d){a(this).hasClass("lcs_on")?a(this).hasClass("lcs_radio_switch")||a(this).lcs_off():a(this).lcs_on()});a(document).delegate(".lcs_wrap input","change",function(){a(this).is(":checked")?a(this).lcs_on():
a(this).lcs_off()})})})(jQuery);

		jQuery(document).ready(function($) {
			$('.generate-tab-content input[type="checkbox"]').lc_switch('', '');
			$(".generate-tabs-menu a").click(function(event) {
				event.preventDefault();
				$(this).parent().addClass("generate-current");
				$(this).parent().siblings().removeClass("generate-current");
				var tab = $(this).attr("href");
				$(".generate-tab-content").not(tab).css("display", "none");
				$(tab).fadeIn();
			});
			
			$('#_meta-generate-page-header-content').bind('input change', function() {
				$("li.generate-page-header-content-required, .content-settings-area").hide();

				if ( this.value.length ) {
					$("li.generate-page-header-content-required, .content-settings-area").show();
				}
			});
		});
		jQuery(window).load(function($) {
			
			<?php if ( $stored_meta['_meta-generate-page-header-content'][0] == '' ) : ?>
				jQuery('#generate-tab-3').hide();
				jQuery('.generate-tabs-menu .image-settings').addClass('generate-current');
				jQuery('.generate-tabs-menu .content-settings').removeClass('generate-current');
				jQuery("li.generate-page-header-content-required, .content-settings-area").hide();
			<?php else : ?>
				jQuery('#generate-tab-1').hide();
				jQuery('#generate-tab-3').show();
				jQuery('.generate-tabs-menu .content-settings').addClass('generate-current');
				jQuery('.generate-tabs-menu .image-settings').removeClass('generate-current');
				jQuery("li.generate-page-header-content-required, .content-settings-area").show();
			<?php endif; ?>
			
			if ( jQuery('#_meta-generate-page-header-enable-image-crop').val() == 'enable' ) {
				jQuery('#crop-enabled').show();
			}
            jQuery('#_meta-generate-page-header-enable-image-crop').change(function () {
                if (jQuery(this).val() === 'enable') {
                    jQuery('#crop-enabled').show();
                } else {
                    jQuery('#crop-enabled').hide();
                }
            });
			
			if ( jQuery('#_meta-generate-page-header-image-background').is(':checked')) {
				jQuery('.parallax').show();
			} else {
				jQuery('.parallax').hide();
			}
			
			jQuery('body').delegate('.image-background', 'lcs-statuschange', function() {
				if (jQuery(this).is(":checked")) {
                    jQuery('.parallax').show();
                } else {
                    jQuery('.parallax').hide();
					jQuery('#_meta-generate-page-header-image-background-fixed').lcs_off();
                }
			});
			
			if ( jQuery('#_meta-generate-page-header-full-screen').is(':checked')) {
				jQuery('.vertical-center').show();
			} else {
				jQuery('.vertical-center').hide();
			}
			
			jQuery('body').delegate('#_meta-generate-page-header-full-screen', 'lcs-statuschange', function() {
				if (jQuery(this).is(":checked")) {
                    jQuery('.vertical-center').show();
                } else {
                    jQuery('.vertical-center').hide();
					jQuery('#_meta-generate-page-header-vertical-center').lcs_off();
                }
			});
			
			if ( jQuery('#_meta-generate-page-header-transparent-navigation').is(':checked')) {
				jQuery('.navigation-colors').show();
			} else {
				jQuery('.navigation-colors').hide();
			}
			
			jQuery('body').delegate('#_meta-generate-page-header-transparent-navigation', 'lcs-statuschange', function() {
				if (jQuery(this).is(":checked")) {
                    jQuery('.navigation-colors').show();
                } else {
                    jQuery('.navigation-colors').hide();
                }
			});
			
			if ( jQuery('#_meta-generate-page-header-combine').is(':checked')) {
				jQuery('.combination-options').show();
			} else {
				jQuery('.combination-options').hide();
			}
			
			jQuery('body').delegate('#_meta-generate-page-header-combine', 'lcs-statuschange', function() {
				if (jQuery(this).is(":checked")) {
                    jQuery('.combination-options').show();
                } else {
                    jQuery('.combination-options').hide();
                }
			});
			
			if ( jQuery('#_meta-generate-page-header-image-background-type').val() == '' ) {
				jQuery('.vertical-center').hide();
				jQuery('.fullscreen').hide();
			}
            jQuery('#_meta-generate-page-header-image-background-type').change(function () {
                if (jQuery(this).val() === '') {
                    jQuery('.vertical-center').hide();
					jQuery('#_meta-generate-page-header-vertical-center').lcs_off();
					jQuery('.fullscreen').hide();
					jQuery('#_meta-generate-page-header-full-screen').lcs_off();
                } else {
                    //jQuery('.vertical-center').show();
					jQuery('.fullscreen').show();
                }
            });
			
			var $set_button = jQuery('.generate-upload-file');
			/**
			 * open the media manager
			 */
			$set_button.click(function (e) {
				e.preventDefault();
				
				var $thisbutton = jQuery(this);
				var frame = wp.media({
					title : $thisbutton.data('title'),
					multiple : false,
					library : { type : $thisbutton.data('type') },
					button : { text : $thisbutton.data('insert') }
				});
				// close event media manager
				frame.on('select', function () {
					var attachment = frame.state().get('selection').first().toJSON();
					// set the file
					//set_dfi(attachment.url);
					$thisbutton.prev('input').val(attachment.url);
					$thisbutton.next('input').val(attachment.id);
					if ( $thisbutton.data('prev') === true ) {
						$thisbutton.prev('input').prev('#preview-image').children('.saved-image').remove();
						$thisbutton.prev('input').prev('#preview-image').append('<img src="' + attachment.url + '" width="100" class="saved-image" />');
					}
				});

				// everthing is set open the media manager
				frame.open();
			});
		});
		jQuery(document).ready(function($) {
			$('.color-picker').wpColorPicker();
		});
	</script>
	
	<style>
		@media (min-width: 769px) {
			.page-header-column {
				width: 30%;
				margin-right: 3%;
				float: left;
			}
			.page-header-column.last {
				margin-right: 0;
			}
		}
		.generate-tab {
			clear: both;
		}
		.generate-tabs-menu li {
			display: inline-block;
		}
		.generate-tab-content {
			display: none;
		}

		#generate-tab-1 {
			display: block;   
		}
		
		.generate-current a.button,
		.generate-tabs-menu li a.button:focus{
			background: #eee;
			border-color: #999;
			-webkit-box-shadow: inset 0 2px 5px -3px rgba(0,0,0,.5);
			box-shadow: inset 0 2px 5px -3px rgba(0,0,0,.5);
			-webkit-transform: translateY(1px);
			-ms-transform: translateY(1px);
			transform: translateY(1px);
		}
		
		.lcs_wrap {
			display: inline-block;	
			direction: ltr;
			height: 28px;
			vertical-align: middle;
		}
		.lcs_wrap input {
			display: none;	
		}

		.lcs_switch {
			display: inline-block;	
			position: relative;
			width: 73px;
			height: 28px;
			border-radius: 30px;
			background: #ddd;
			overflow: hidden;
			cursor: pointer;
			
			-webkit-transition: all .2s ease-in-out;  
			-ms-transition: 	all .2s ease-in-out; 
			transition: 		all .2s ease-in-out; 
		}
		.lcs_cursor {
			display: inline-block;
			position: absolute;
			top: 3px;	
			width: 22px;
			height: 22px;
			border-radius: 100%;
			background: #fff;
			box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2), 0 3px 4px 0 rgba(0, 0, 0, 0.1);
			z-index: 10;
			
			-webkit-transition: all .2s linear;  
			-ms-transition: 	all .2s linear; 
			transition: 		all .2s linear; 
		}
		.lcs_label {
			font-family: "Trebuchet MS", Helvetica, sans-serif;
			font-size: 12px;
			letter-spacing: 1px;
			line-height: 18px;
			color: #fff;
			font-weight: bold;
			position: absolute;
			width: 33px;
			top: 5px;
			overflow: hidden;
			text-align: center;
			opacity: 0;
			
			-webkit-transition: all .2s ease-in-out .1s;  
			-ms-transition: 	all .2s ease-in-out .1s;   
			transition: 		all .2s ease-in-out .1s;   
		}
		.lcs_label.lcs_label_on {
			left: -70px;
			z-index: 6;	
		}
		.lcs_label.lcs_label_off {
			right: -70px;
			z-index: 5;	
		}


		/* on */
		.lcs_switch.lcs_on {
			background: #75b936;
			box-shadow: 0 0 2px #579022 inset;
		}
		.lcs_switch.lcs_on .lcs_cursor {
			left: 48px;
		}
		.lcs_switch.lcs_on .lcs_label_on {
			left: 10px;	
			opacity: 1;
		}


		/* off */
		.lcs_switch.lcs_off {
			background: #b2b2b2;
			box-shadow: 0px 0px 2px #a4a4a4 inset; 	
		}
		.lcs_switch.lcs_off .lcs_cursor {
			left: 3px;
		}
		.lcs_switch.lcs_off .lcs_label_off {
			right: 10px;
			opacity: 1;	
		}


		/* disabled */
		.lcs_switch.lcs_disabled {
			opacity: 0.65;
			filter: alpha(opacity=65);	
			cursor: default;
		}
		
		.choose-content-options span {
			display:block;
			color:#222;
		}
		.choose-content-options div {
			margin-bottom:10px;
			border-bottom:1px solid #DDD;
			padding-bottom:10px;
		}
		.nav-tab.active {
			border-bottom:1px solid #fff;
			color:#124964;
			background:#FFF;
		}
		.nav-tab {
			margin-bottom: 0;
			position:relative;
			bottom: -1px;
		}
		#poststuff h2.nav-tab-wrapper {
			padding: 0;
		}
		.nav-tab:focus {
			outline: none;
		}
		h2.page-header .nav-tab {
			font-size:15px;
		}
		.small {
			display: block;
			font-size: 11px;
		}
	</style>
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
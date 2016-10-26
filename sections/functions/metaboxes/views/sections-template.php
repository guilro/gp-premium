<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Prints the templates used in the sections metabox
 *
 * @global bool $is_IE
 */
function generate_sections_print_templates() {
	global $is_IE;
	$class = 'media-modal wp-core-ui';
	if ( $is_IE && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7') !== false ){
		$class .= ' ie7';
	}
		
		
	/**
	 * Backbone Templates
	 * This file contains all of the HTML used in our application
	 *
	 * Each template is wrapped in a script block ( note the type is set to "text/html" ) and given an ID prefixed with
	 * 'tmpl'. The wp.template method retrieves the contents of the script block and converts these blocks into compiled
	 * templates to be used and reused in your application.
	 */
	
	
	/**
	 * The Singular List View
	 */
	?>
	<script type="text/template" id="tmpl-generate-sections-section">
	
		<h3 class="section-title">
			<span class="text generate-section-text" title="<?php _e( 'Click to edit', 'generate-sections' );?>">{{{ data.title }}}</span>
			<div class="section-controls">
				<a class="edit-section edit-content dashicons dashicons-edit" href="#" title="<?php _e( 'Click to edit content', 'generate-sections' );?>"></a>
				<a class="edit-section edit-settings dashicons dashicons-admin-generic" href="#" title="<?php _e( 'Click to edit settings', 'generate-sections' );?>"></a>
				<a class="move-section dashicons dashicons-move" href="#"  title="<?php _e( 'Click and drag to sort', 'generate-sections' );?>"></a>
				<a class="delete-section dashicons dashicons-no" href="#" title="<?php esc_attr_e( 'Click to remove', 'generate-sections' );?>"></a>
		   </div>   
		   
		</h3>
		<textarea name="_generate_sections[sections][{{{ data.index }}}]" readonly="readonly"></textarea>
	
	</script>
	
	<?php
	/**
	 * The Add/Clear buttons
	 */
	?>
	<script type="text/template" id="tmpl-generate-sections-buttons">
		<a href="#" id="generate-add-section" class="button-primary button-large"><?php _e( 'Add Section', 'generate-sections' );?></a>
		<a href="#" style="display:none;" id="generate-delete-sections" class="button button-large"><?php _e( 'Remove Sections', 'generate-sections');?></a>
		<?php wp_nonce_field( 'generate_sections_nonce', '_generate_sections_nonce' ); ?>
	</script>
	
		
	<?php
	/**
	 * The Modal Window, including sidebar and content area.
	 * Add menu items to ".media-frame-menu"
	 * Add content to ".media-frame-content"
	 */
	?>
	<script type="text/html" id="tmpl-generate-sections-modal-window">
		<div class="<?php echo $class; ?>">
			<button type="button" class="button-link media-modal-close" aria-label="close"><span class="media-modal-icon"><span class="screen-reader-text"><?php _e( 'Close', 'generate-sections' ); ?></span></span></button>
			<div class="media-modal-content">
				<div class="media-frame mode-select wp-core-ui hide-router">
					<div class="media-frame-menu"><div class="media-menu"></div></div>
					<div class="media-frame-title">
						<h1><?php _e( 'Edit Section', 'generate-sections' ); ?><span class="dashicons dashicons-arrow-down"></span></h1>
					</div>
					<div class="media-frame-content"></div>
					<div class="media-frame-toolbar">
						<div class="media-toolbar">
							<div class="media-toolbar-primary">
								<button type="button" class="button media-button button-primary button-large media-button-insert"><?php _e( 'Apply', 'generate-sections' ); ?></button>
								<button type="button" class="button button media-button button button-large media-button-close"><?php _e( 'Cancel', 'generate-sections' ); ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="media-modal-backdrop"></div>
	</script>
	
	<?php
	/**
	 * Base template for a navigation-bar menu item
	 */
	?>
	<script type="text/html" id='tmpl-generate-sections-modal-menu-item'>
		<a class="media-menu-item generate-section-item-{{ data.target }}" data-target="{{ data.target }}">{{ data.name }}</a>
	</script>
	
	
	<?php
	/**
	 * the Edit Sections
	 */
	?>
	<script type="text/html" id="tmpl-generate-sections-edit-content">
		<div data-id="content" class="panel generate-section-content">
		
			<div class="grid-100 section-title">
					<label for="title"><?php _e( 'Section Label','generate-sections' );?></label>
			
					<p>
						<input type="text" class="grid-50" name="title" placeholder="{{{ generate_sections_metabox_i18n.default_title }}}" id="title" value="{{{ data.title }}}"/>
					</p>
				</div>
		
			<div class="grid-100 wp-core-ui wp-editor-wrap">
					
				<div class="postarea wp-editor-expand">
		
					<div id="wp-generate-sections-editor-wrap" class="wp-core-ui wp-editor-wrap">
				
						<div id="wp-generate-sections-editor-editor-tools" class="wp-editor-tools hide-if-no-js">
					
							<div class="wp-media-buttons">
								<button type="button" class="button insert-media add_media generate-sections-add-media" data-editor="generate-sections-editor"><span class="wp-media-buttons-icon"></span><?php _e( 'Add Media', 'generate-sections' );?></button>				
								<?php do_action( 'media_buttons' ); ?>
							</div>
					
							<div class="wp-editor-tabs">
								<button type="button" id="content-tmce" class="wp-switch-editor switch-tmce" data-wp-editor-id="generate-sections-editor"><?php _e( 'Visual', 'generate-sections' ); ?></button>
								<button type="button" id="content-html" class="wp-switch-editor switch-html" data-wp-editor-id="generate-sections-editor"><?php _ex( 'Text', 'Name for the Text editor tab (formerly HTML)', 'generate-sections' ); ?></button>
							</div>
				
						</div><!-- .wp-editor-tools -->
					
						<div class="wp-editor-container">
							<textarea id="generate-sections-editor" class="wp-editor-area" autocomplete="off" cols="40" name="content">{{{ data.content }}}</textarea>
						</div>
						
					</div>
				
				</div>
			
			</div>
		</div>
	
	</script>
	<script type="text/html" id="tmpl-generate-sections-edit-layout">
	
		<div data-id="layout" class="panel">
			
		</div>
	
	</script>
	<script type="text/html" id="tmpl-generate-sections-edit-style">
	
	<div data-id="style" class="panel generate-section-settings">
			<div class="grid-container grid-parent">
				<div class="grid-33">
					<h3><?php _e( 'Layout','generate-sections' ); ?></h3>
					<label for="box_type"><?php _e('Box Type','generate-sections');?></label>
					
					<p>
						<select name="box_type" id="box_type">
							<option value=""><?php _e( 'Full Width','generate-sections' );?></option>
							<option value="contained"><?php _e( 'Contained','generate-sections' );?></option>
						</select>
					</p>
					
					<label for="inner_box_type"><?php _e('Inner Box Type','generate-sections');?></label>
					
					<p>
						<select name="inner_box_type" id="inner_box_type">
							<option value=""><?php _e( 'Contained','generate-sections' );?></option>
							<option value="fluid"><?php _e( 'Full Width','generate-sections' );?></option>
						</select>
					</p>
					
					<label for="custom_classes"><?php _e( 'Custom Classes','generate-sections' );?></label>
			
					<p>
						<input type="text" name="custom_classes" id="custom_classes" value="{{{ data.custom_classes }}}"/>
					</p>
					
					<label for="top_padding"><?php _e( 'Top Padding','generate-sections' );?></label>
			
					<p>
						<input placeholder="{{{ generate_sections_metabox_i18n.top_padding }}}" type="number" name="top_padding" id="top_padding" value="{{{ data.top_padding }}}"/><select style="margin:0;position:relative;top:-2px;" name="top_padding_unit" id="top_padding_unit">
							<option value="">px</option>
							<option value="%">%</option>
						</select>
					</p>
					
					<label for="bottom_padding"><?php _e( 'Bottom Padding','generate-sections' );?></label>
			
					<p>
						<input placeholder="{{{ generate_sections_metabox_i18n.bottom_padding }}}" type="number" name="bottom_padding" id="bottom_padding" value="{{{ data.bottom_padding }}}"/><select style="margin:0;position:relative;top:-2px;" name="bottom_padding_unit" id="bottom_padding_unit">
							<option value="">px</option>
							<option value="%">%</option>
						</select>
					</p>
				</div>
				<div class="grid-33">
					<h3><?php _e( 'Colors','generate-sections' ); ?></h3>
					<label for="background_color"><?php _e( 'Background Color','generate-sections' );?></label>
					<p>
						<input class="generate-sections-color" type="text" name="background_color" id="background_color" value="{{{ data.background_color }}}"/>
					</p>
					
					<label for="text_color"><?php _e( 'Text Color','generate-sections' );?></label>
			
					<p>
						<input class="generate-sections-color" type="text" name="text_color" id="text_color" value="{{{ data.text_color }}}"/>
					</p>
				
					<label for="link_color"><?php _e( 'Link Color','generate-sections' );?></label>
			
					<p>
						<input class="generate-sections-color" type="text" name="link_color" id="link_color" value="{{{ data.link_color }}}"/>
					</p>
			
					<label for="link_color_hover"><?php _e('Link Color Hover','generate-sections');?></label>
					
					<p>
						<input class="generate-sections-color" type="text" name="link_color_hover" id="link_color_hover" value="{{{ data.link_color_hover }}}"/>
					</p>
				</div>
				<div class="grid-33">
					<h3><?php _e( 'Background','generate-sections' ); ?></h3>
					<label for="generate-sections-background-image"><?php _e( 'Background Image','generate-sections' );?></label>
					<p id="generate-section-image-preview"></p>
					<p>
						
						<input class="image_id" type="hidden" id="generate-sections-background-image" name="background_image" value="{{{ data.background_image }}}" />
						<button id="image_button" class="generate-sections-upload-button button" type="button" data-uploader_title="<?php _e( 'Background Image','generate-sections' );?>"><?php _e('Upload','generate-sections') ;?></button>
						<button id="remove_image" class="generate-sections-remove-image button" type="button"><?php _e( 'Remove','generate-sections' );?></button>
			
					</p>
					
					<label for="parallax_effect"><?php _e('Parallax Effect','generate-sections');?></label>
					<p>
						<select name="parallax_effect" id="parallax_effect">
							<option value=""><?php _e( 'Disable','generate-sections' );?></option>
							<option value="enable"><?php _e( 'Enable','generate-sections' );?></option>
						</select>
					</p>
				</div>
			</div>
		</div>

	</script>
	
<?php
}
<div class="generate_sections_control">
 
	<?php while ( $mb->have_fields_and_multi( 'sections' ) ) : ?>

	<?php $mb->the_group_open(); ?>

	<div class="group-wrap tmce-enabled <?php echo $mb->get_the_value( 'toggle_state' ) ? ' closed' : ''; ?>" >

		<?php $mb->the_field('toggle_state'); ?>
		<?php // @ TODO: toggle should be user specific ?>
		<input type="checkbox" name="<?php $mb->the_name(); ?>" value="1" <?php checked( 1, $mb->get_the_value() ); ?> class="toggle_state hidden" />
		
		<div class="group-control dodelete" title="<?php _e( 'Click to remove', 'generate-sections' );?>"></div>
		<div class="group-control toggle" title="<?php _e( 'Click to toggle', 'generate-sections' );?>"></div>
		<div class="group-control generate-sortable" title="<?php _e( 'Click and drag to sort', 'generate-sections' );?>"></div>
		
		<?php // need to html_entity_decode() the value b/c WP Alchemy's get_the_value() runs the data through htmlentities() ?>
		<h3 class="handle"><?php echo $mb->get_the_value('content') ? substr( strip_tags( html_entity_decode( $mb->get_the_value('content') ) ), 0, 50 ) : __( 'Section','generate-sections' );?></h3>
		
		<div class="group-inside">
	
			<?php

			// 'html' is used for the "Text" editor tab.
			// if ( 'html' === wp_default_editor() ) {
				// add_filter( 'generate_section_content', 'wp_htmledit_pre' );
				// $switch_class = 'html-active';
			// } else {
				// add_filter( 'generate_section_content', 'wp_richedit_pre' );
				// $switch_class = 'tmce-active';
			// }
			?>
			
			<?php $mb->the_field('box_type'); ?>
			<div class="grid-container grid-parent bottom-border top-border">
				<div class="grid-25 box-type border-right">
					<label for="<?php $mb->the_name(); ?>"><?php _e('Box Type','generate-sections');?></label>
					
					<p>
						<select name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>">
							<option value=""><?php _e( 'Fluid','generate-sections' );?></option>
							<option value="contained"<?php $mb->the_select_state('contained'); ?>><?php _e( 'Contained','generate-sections' );?></option>
						</select>
					</p>
				</div>
				
				<?php $mb->the_field('inner_box_type'); ?>
				<div class="grid-25 inner-box-type border-right">
					<label for="<?php $mb->the_name(); ?>"><?php _e('Inner Box Type','generate-sections');?></label>
					
					<p>
						<select name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>">
							<option value=""><?php _e( 'Contained','generate-sections' );?></option>
							<option value="fluid"<?php $mb->the_select_state('fluid'); ?>><?php _e( 'Fluid','generate-sections' );?></option>
						</select>
					</p>
				</div>
				
				<?php $mb->the_field('custom_classes'); ?>
				<div class="grid-25 custom-classes border-right">
					<label for="<?php $mb->the_name(); ?>"><?php _e( 'Custom Classes','generate-sections' );?></label>
	 
					<p>
						<input type="text" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
					</p>
				</div>
				
				<?php
				// Default padding top
				$padding_top = apply_filters( 'generate_sections_default_padding_top','40' );
				
				// Default padding bottom
				$padding_bottom = apply_filters( 'generate_sections_default_padding_bottom','40' );
				?>
				
				<?php $mb->the_field('top_padding'); ?>
				<div class="grid-12 top-padding border-right">
					<label for="<?php $mb->the_name(); ?>"><?php _e( 'Top Padding','generate-sections' );?></label>
	 
					<p>
						<input placeholder="<?php echo $padding_top;?>" type="number" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
					</p>
				</div>
				
				<?php $mb->the_field('bottom_padding'); ?>
				<div class="grid-12 bottom-padding">
					<label for="<?php $mb->the_name(); ?>"><?php _e( 'Bottom Padding','generate-sections' );?></label>
	 
					<p>
						<input placeholder="<?php echo $padding_bottom; ?>" type="number" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
					</p>
				</div>
			
			</div>
			
			<div class="grid-container grid-parent bottom-border">
			
				<?php $mb->the_field('background_color'); ?>
				<div class="grid-33 background-color">
					<label for="<?php $mb->the_name(); ?>"><?php _e( 'Background Color','generate-sections' );?></label>
					<p>
						<input class="generate-sections-color" type="text" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
					</p>
				</div>
				
				<?php $mb->the_field('background_image'); ?>
				<div class="grid-33 background-image border-right border-left">
					<label for="<?php $mb->the_name(); ?>"><?php _e( 'Background Image','generate-sections' );?></label>
					<p class="image-preview">
						<?php 
						$image_exists = $mb->get_the_value();
						if ( ! empty( $image_exists ) ) :
							echo wp_get_attachment_image( $mb->get_the_value(), array(50,50) );
						endif; 
						?>
					</p>
					<p>
						
						<input class="image_id" type="hidden" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php echo $mb->get_the_value(); ?>" />
						<button id="image_button" class="generate-sections-upload-button button" type="button" data-uploader_title="<?php _e( 'Background Image','generate' );?>"><?php _e('Upload','generate-sections') ;?></button>
						<?php $remove = ( ! empty( $image_exists ) ) ? 'style="display:inline;"' : 'style="display:none;"'; ?>
						<button <?php echo $remove;?> id="remove_image" class="generate-sections-remove-image button" type="button"><?php _e( 'Remove','generate-sections' );?></button>

					</p>
				</div>
				
				<?php $mb->the_field('parallax_effect'); ?>
				<div class="grid-33 parallax-effect">
					<label for="<?php $mb->the_name(); ?>"><?php _e('Parallax Effect','generate-sections');?></label>
					<p>
						<select name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>">
							<option value=""><?php _e( 'Disable','generate-sections' );?></option>
							<option value="enable" <?php $mb->the_select_state('enable'); ?>><?php _e( 'Enable','generate-sections' );?></option>
						</select>
					</p>
				</div>
			</div>
			
			<div class="grid-container grid-parent bottom-border">
				<?php $mb->the_field('text_color'); ?>
				
				<div class="grid-33 text-color">
					<label for="<?php $mb->the_name('text_color'); ?>"><?php _e( 'Text Color','generate-sections' );?></label>
	 
					<p>
						<input class="generate-sections-color" type="text" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
					</p>
				</div>
				
				<?php $mb->the_field('link_color'); ?>
				<div class="grid-33 link-color border-left border-right">
					<label for="<?php $mb->the_name('link_color'); ?>"><?php _e( 'Link Color','generate-sections' );?></label>
	 
					<p>
						<input class="generate-sections-color" type="text" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
					</p>
				</div>
				
				<?php $mb->the_field('link_color_hover'); ?>
				<div class="grid-33 link-color-hover">
					<label for="<?php $mb->the_name('link_color_hover'); ?>"><?php _e('Link Color Hover','generate-sections');?></label>
					
					<p>
						<input class="generate-sections-color" type="text" name="<?php $mb->the_name(); ?>" id="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
					</p>
				</div>
			</div>
			
			<div class="clear" style="clear:both;display:block;"></div>
			<?php $mb->the_field('content'); ?>
			<div class="customEditor wp-core-ui wp-editor-wrap <?php echo 'tmce-active'; //echo $switch_class;?>">
				
				<div class="wp-editor-tools hide-if-no-js">

					<div class="wp-media-buttons custom_upload_buttons">
						<?php do_action( 'media_buttons' ); ?>
					</div>

					<div class="wp-editor-tabs">
						<a data-mode="tmce" class="wp-switch-editor switch-tmce"><?php _e('Visual','generate-sections'); ?></a>
						<a data-mode="html" class="wp-switch-editor switch-html"> <?php _ex( 'Text', 'Name for the Text editor tab (formerly HTML)','generate-sections' ); ?></a>
					</div>

				</div><!-- .wp-editor-tools -->

				<div class="wp-editor-container">
					<textarea style="height:300px;" class="wp-sections-area tmce-enabled" name="<?php $mb->the_name(); ?>"><?php echo esc_html( apply_filters( 'generate_section_content', html_entity_decode( $mb->get_the_value(), ENT_COMPAT, 'UTF-8' ) ) ); ?></textarea>
				</div>

			</div>

		</div><!-- .group-inside -->

	</div><!-- .group-wrap -->

	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>

	<p>
		<a href="#" class="docopy-sections button button-primary button-large"><?php _e( 'Add Section', 'generate-sections' );?></a>
		<a href="#" class="dodelete-sections button button-large"><?php _e('Remove Sections', 'generate-sections');?></a>
	</p>

</div>
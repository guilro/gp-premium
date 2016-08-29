<div class="generate_sections_control">
	
	<p>
		<?php $mb->the_field('use_sections'); ?>
		<select name="<?php $mb->the_name(); ?>">
			<option value=""><?php _e( 'No','generate-sections' );?></option>
			<option value="true"<?php $mb->the_select_state('true'); ?>><?php _e( 'Yes','generate-sections' );?></option>
		</select>
	</p>
	
	<a class="button send-to-editor"><?php _e( 'Send sections to default editor','generate-sections' );?></a>
</div>
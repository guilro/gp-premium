<?php
if ( ! class_exists( 'Generate_Copyright_Textarea_Custom_Control' ) ) :
/**
 * Class to create a custom tags control
 */
class Generate_Copyright_Textarea_Custom_Control extends WP_Customize_Control
{
	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overriden without having to rewrite the wrapper.
	 *
	 * @since   10/16/2012
	 * @return  void
	 */
	public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea id="<?php echo $this->id;?>" class="large-text" cols="20" rows="5" <?php $this->link(); ?>><?php echo $this->value(); ?></textarea>
			<small style="display:block;margin-bottom:5px;"><?php _e('<code>%current_year%</code> to update year automatically.','generate-copyright');?></small>
			<small style="display:block;margin-bottom:5px;"><?php _e('<code>%copy%</code> to include the copyright symbol.','generate-copyright');?></small>
			<small style="display:block;margin-bottom:5px;"><?php _e('HTML is allowed.','generate-copyright');?></small>
			<small style="display:block;"><?php _e('Shortcodes are allowed.','generate-copyright');?></small>
		</label>
		<?php
	}
}
endif;
<?php
if ( class_exists( 'WP_Customize_Control' ) ) {
	if ( ! class_exists( 'Generate_Blog_Customize_Control' ) ) :
		class Generate_Blog_Customize_Control extends WP_Customize_Control {
			public $type = 'blog';
			public $placeholder = '';
			public function render_content() {
				?>
				<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input placeholder="<?php echo $this->placeholder;?>" style="max-width:75px;text-align:center;" type="text" <?php $this->link(); ?> value="<?php echo absint( $this->value() );?>" />px
				</label>
				<?php
			}
		}
	endif;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Generate_Post_Image_Save' ) ) {
	class Generate_Post_Image_Save extends WP_Customize_Control {
		public $settings = 'blogname';

		public function render_content() {
			echo '<a class="button save-post-images" onclick="wp.customize.previewer.refresh();" href="#">' . __( 'Apply image sizes','generate-blog' ) . '</a>';
		}
	}
}
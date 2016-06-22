<?php
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Generate_Blog_Page_Header_Image_Save' ) ) {
	class Generate_Blog_Page_Header_Image_Save extends WP_Customize_Control {
		public $settings = 'blogname';

		public function render_content() {
			echo '<a class="button save-post-images" onclick="wp.customize.previewer.refresh();" href="#">' . __( 'Apply image sizes','generate-blog' ) . '</a>';
		}
	}
}
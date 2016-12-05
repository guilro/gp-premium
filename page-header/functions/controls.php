<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Generate_Blog_Page_Header_Image_Save' ) ) {
	class Generate_Blog_Page_Header_Image_Save extends WP_Customize_Control {
		public $type = 'page_header_image_save';
		
		public function to_json() {
			parent::to_json();
			$this->json[ 'text' ] = __( 'Apply image sizes','page-header' );
		}
		
		public function content_template() {
			?>
			<a class="button save-post-images" onclick="wp.customize.previewer.refresh();" href="#">{{{ data.text }}}</a>
			<?php
		}
	}
}
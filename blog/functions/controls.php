<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) ) {
	if ( ! class_exists( 'Generate_Blog_Customize_Control' ) ) :
		class Generate_Blog_Customize_Control extends WP_Customize_Control {
			public $type = 'gp-post-image-size';
			public $placeholder = '';
			
			public function enqueue() {
				wp_enqueue_script( 'gp-blog-customizer', plugin_dir_url( __FILE__ )  . '/js/blog-customizer.js', array( 'customize-controls' ), GENERATE_BLOG_VERSION, true );
			}
			
			public function to_json() {
				parent::to_json();
				$this->json[ 'link' ] = $this->get_link();
				$this->json[ 'value' ] = $this->value();
				$this->json[ 'placeholder' ] = $this->placeholder;
			}
			public function content_template() {
				?>
				<label>
					<span class="customize-control-title">{{{ data.label }}}</span>
					<input class="blog-size-input" placeholder="{{{ data.placeholder }}}" style="max-width:75px;text-align:center;" type="number" {{{ data.link }}} value="{{ data.value }}" />px
				</label>
				<?php
			}
		}
	endif;
}

if ( class_exists( 'WP_Customize_Control' ) ) {
	if ( ! class_exists( 'Generate_Blog_Number_Customize_Control' ) ) :
		class Generate_Blog_Number_Customize_Control extends WP_Customize_Control {
			public $type = 'gp-blog-number';
			public $placeholder = '';
			
			public function enqueue() {
				wp_enqueue_script( 'gp-blog-customizer', plugin_dir_url( __FILE__ )  . '/js/blog-customizer.js', array( 'customize-controls' ), GENERATE_BLOG_VERSION, true );
			}
			
			public function to_json() {
				parent::to_json();
				$this->json[ 'link' ] = $this->get_link();
				$this->json[ 'value' ] = $this->value();
				$this->json[ 'placeholder' ] = $this->placeholder;
			}
			public function content_template() {
				?>
				<label>
					<span class="customize-control-title">{{{ data.label }}}</span>
					<input class="blog-size-input" placeholder="{{{ data.placeholder }}}" type="number" {{{ data.link }}} value="{{ data.value }}" />
				</label>
				<?php
			}
		}
	endif;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Generate_Post_Image_Save' ) ) {
	class Generate_Post_Image_Save extends WP_Customize_Control {
		public $type = 'post_image_save';
		
		public function to_json() {
			parent::to_json();
			$this->json[ 'text' ] = __( 'Apply image sizes','generate-blog' );
		}
		
		public function content_template() {
			?>
			<a class="button save-post-images" onclick="wp.customize.previewer.refresh();" href="#">{{{ data.text }}}</a>
			<?php
		}
	}
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Generate_Blog_Text_Control' ) ) {
	class Generate_Blog_Text_Control extends WP_Customize_Control {
		public $type = 'blog_text';
		public $description = '';
		public function to_json() {
			parent::to_json();
			$this->json[ 'description' ] = $this->description;
		}
		
		public function content_template() {
			?>
			<p>{{{ data.description }}}</p>
			<?php
		}
	}
}
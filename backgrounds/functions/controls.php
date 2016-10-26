<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Generate_Backgrounds_Customize_Control' ) ) :
class Generate_Backgrounds_Customize_Control extends WP_Customize_Control {
	public $type = 'position';
	public $placeholder = '';
	
	public function enqueue() {
		wp_enqueue_script( 'gp-backgrounds-customizer', plugin_dir_url( __FILE__ )  . '/js/backgrounds-customizer.js', array( 'customize-controls' ), GENERATE_BACKGROUNDS_VERSION, true );
	}
	
	public function to_json() {
		parent::to_json();
		$this->json[ 'placeholder' ] = $this->placeholder;
		$this->json[ 'link' ] = $this->get_link();
		$this->json[ 'value' ] = sanitize_text_field( $this->value() );
	}
	
	public function content_template() {
		?>
		<label>
			<input class="background-position-input" type="text" placeholder="{{ data.placeholder }}" style="text-align:center;" {{{ data.link }}} value="{{{ data.value }}}" />
			<span class="small-customize-label">{{{ data.label }}}</span>
		</label>
		<?php
	}
}
endif;
	
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Generate_Backgrounds_Customize_Misc_Control' ) ) :
class Generate_Backgrounds_Customize_Misc_Control extends WP_Customize_Control {
    public $settings = 'generate_backgrounds_misc';
    public $description = '';
	public $areas = '';
	public $type = 'backgrounds-heading';
 
 
    public function render_content() {
       echo '<span class="customize-control-title backgrounds-title">' . esc_html( $this->label ) . '</span>';
		if ( !empty( $this->description ) ) :
			echo '<span class="backgrounds-title-description">' . esc_html( $this->description ) . '</span>';
		endif;
    }
	
}
endif;
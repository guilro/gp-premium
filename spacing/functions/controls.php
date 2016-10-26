<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Generate_Spacing_Customize_Control' ) ) :
class Generate_Spacing_Customize_Control extends WP_Customize_Control {
	public $type = 'spacing';
	public $description = '';
	public $secondary_description = '';
	
	public function enqueue() {
		wp_enqueue_script( 'gp-spacing-customizer', plugin_dir_url( __FILE__ )  . '/js/spacing-customizer.js', array( 'customize-controls' ), GENERATE_FONT_VERSION, true );
	}
	
	public function to_json() {
		parent::to_json();
		$this->json[ 'link' ] = $this->get_link();
		$this->json[ 'value' ] = absint( $this->value() );
		$this->json[ 'description' ] = esc_html( $this->description );
		$this->json[ 'secondary_description' ] = esc_html( $this->secondary_description );
	}
	
	public function content_template() {
		?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>
			
			<# if ( data.description ) { #>
				<span class="description">{{ data.description }}</span>
			<# } #>
			
			<input class="generate-number-control" type="number" style="text-align: center;" {{{ data.link }}} value="{{{ data.value }}}" />
		
			<# if ( data.secondary_description ) { #>
				<span class="description" style="text-align:left;display:block;">{{{ data.secondary_description }}}</span>
			<# } #>
		</label>
		<?php
	}
}
endif;
	
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Generate_Spacing_Customize_Misc_Control' ) ) :
class Generate_Spacing_Customize_Misc_Control extends WP_Customize_Control {
    public $settings = 'generate_spacing_headings';
    public $description = '';
	public $areas = '';
 
 
    public function render_content() {
        switch ( $this->type ) {
            default:
            case 'text' :
                echo '<label><span class="customize-control-title">' . $this->description . '</span></label>';
                break;
 
            case 'spacing-heading':
                if ( ! empty( $this->label ) ) echo '<span class="customize-control-title spacing-title">' . esc_html( $this->label ) . '</span>';
				if ( ! empty( $this->description ) ) echo '<span class="spacing-title-description">' . esc_html( $this->description ) . '</span>';
				if ( ! empty( $this->areas ) ) :
					echo '<div style="clear:both;display:block;"></div>';
					foreach ( $this->areas as $value => $label ) :
						echo '<span class="spacing-area">' . esc_html( $label ) . '</span>';
					endforeach;
				endif;
                break;
 
            case 'line' :
                echo '<hr />';
                break;
        }
    }
}
endif;
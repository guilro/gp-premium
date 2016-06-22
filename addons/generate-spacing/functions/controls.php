<?php
if ( class_exists( 'WP_Customize_Control' ) ) {
	if ( ! class_exists( 'Generate_Spacing_Customize_Control' ) ) :
		class Generate_Spacing_Customize_Control extends WP_Customize_Control {
			public $type = 'spacing';
			 
			public function render_content() {
				?>
				<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input type="text" style="text-align:center;" <?php $this->link(); ?> value="<?php echo absint( $this->value() );?>" />
				</label>
				<?php
			}
		}
	endif;
}
	
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Generate_Spacing_Customize_Misc_Control' ) ) :
class Generate_Spacing_Customize_Misc_Control extends WP_Customize_Control {
    public $settings = 'generate_spacing_headings';
    public $description = '';
	public $areas = '';
 
 
    public function render_content() {
        switch ( $this->type ) {
            default:
            case 'text' :
                echo '<p class="description">' . $this->description . '</p>';
                break;
 
            case 'spacing-heading':
                echo '<span class="customize-control-title spacing-title">' . esc_html( $this->label ) . '</span>';
				if ( !empty( $this->description ) ) :
					echo '<span class="spacing-title-description">' . esc_html( $this->description ) . '</span>';
				endif;
				if ( !empty( $this->areas ) ) :
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
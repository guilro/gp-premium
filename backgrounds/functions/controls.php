<?php
if ( class_exists( 'WP_Customize_Control' ) ) {
	if ( ! class_exists( 'Generate_Backgrounds_Customize_Control' ) ) :
	class Generate_Backgrounds_Customize_Control extends WP_Customize_Control {
		public $type = 'position';
		public $placeholder = '';
		 
		public function render_content() {
			?>
			<label>
			<input type="text" placeholder="<?php echo $this->placeholder;?>" style="text-align:center;" <?php $this->link(); ?> value="<?php echo absint( $this->value() );?>" />
			<span class="small-customize-label"><?php echo esc_html( $this->label ); ?></span>
			</label>
			<?php
		}
	}
	endif;
}
	
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Generate_Backgrounds_Customize_Misc_Control' ) ) :
class Generate_Backgrounds_Customize_Misc_Control extends WP_Customize_Control {
    public $settings = 'generate_backgrounds_misc';
    public $description = '';
	public $areas = '';
 
 
    public function render_content() {
        switch ( $this->type ) {
            default:
            case 'text' :
                echo '<p class="description">' . $this->description . '</p>';
                break;
 
            case 'backgrounds-heading':
                echo '<span class="customize-control-title backgrounds-title">' . esc_html( $this->label ) . '</span>';
				if ( !empty( $this->description ) ) :
					echo '<span class="backgrounds-title-description">' . esc_html( $this->description ) . '</span>';
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

if ( !class_exists('Generate_Background_Upload_Control') ) :
	class Generate_Background_Upload_Control extends WP_Customize_Control {
		public $description;

		public function render_content() {

			$value = $this->value();

			?>
			<div class='generate-upload'>
				<a href="#" class="button upload" data-title="<?php _e('Select Image','generate');?>" data-button="<?php _e('Use Image','generate');?>"><?php _e('Upload','generate');?></a>
				<a href="#" class="remove" <?php if ( empty( $value ) ) { ?>style="display:none;"<?php } ?>><?php _e('Remove','generate'); ?></a>
				<input type='hidden' value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?>/>
			</div>
			<?php
		}
		
		public function enqueue() {
			wp_enqueue_media();
			wp_enqueue_script( 'generate-upload-control', plugin_dir_url( __FILE__ ) . '/js/generate-upload-control.js', array('jquery'), GENERATE_VERSION );
		}
	}
endif;
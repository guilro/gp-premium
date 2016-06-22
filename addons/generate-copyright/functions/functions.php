<?php
if ( !function_exists('generate_copyright_option') ) :
	add_action('generate_inside_options_form','generate_copyright_option', 2);
	function generate_copyright_option()
	{
			
		$copyright_value = get_option('gen_custom_copyright');
		$escaped_value = esc_html($copyright_value);
		?>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'generate-copyright-settings-group' );
			do_settings_sections( 'generate-copyright-settings-group' );
			?>
			<div class="postbox generate-metabox" id="gen-3">
				<h3 class="hndle"><?php _e('Copyright','generate-copyright');?></h3>
				<div class="inside">
					<p>
						<textarea id="gen_custom_copyright" name="gen_custom_copyright" style="width:100%;" class="regular-text"><?php echo $escaped_value; ?></textarea>
						<span class="description" style="display:block;margin-bottom:5px;margin-top:5px;"><?php _e('Use <code>%current_year%</code> to include the current year dynamically.','generate-copyright');?></span>
						<span class="description" style="display:block;margin-bottom:5px;"><?php _e('Use <code>%copy%</code> to include the copyright symbol.','generate-copyright');?></span>
						<span class="description" style="display:block;"><?php _e('HTML is allowed.','generate-copyright');?></span>
						<span class="description" style="display:block;"><?php _e('Shortcodes are allowed.','generate-copyright');?></span>
					</p>	

					<?php
					submit_button( 
						__( 'Save Copyright','generate-copyright' ),
						'primary',
						'submit',
						false
					); 
					?>
				</div>
			</div>
		</form>
		<?php
	}
endif;

if ( !function_exists('generate_copyright_register_settings') ) :
	add_action( 'admin_init', 'generate_copyright_register_settings' );
	function generate_copyright_register_settings() {
		//register our settings
		register_setting( 'generate-copyright-settings-group', 'gen_custom_copyright' );
	}
endif;

/**
 * Remove the default copyright
 * @since 0.1
 */
if ( ! function_exists( 'generate_copyright_remove_default' ) ) :
	add_action('after_setup_theme','generate_copyright_remove_default');
	function generate_copyright_remove_default()
	{
			
		if ( get_option('gen_custom_copyright') == '' )
			return;
			
		remove_action( 'generate_credits', 'generate_add_footer_info' );
		remove_action( 'generate_copyright_line','generate_add_login_attribution' );
	}
endif;

/**
 * Add the custom copyright
 * @since 0.1
 */
if ( ! function_exists( 'generate_copyright_add_custom' ) ) :
	add_action('generate_credits','generate_copyright_add_custom');
	function generate_copyright_add_custom()
	{
		
		$options = array(
			'%current_year%',
			'%copy%'
		);
		$replace = array(
			date('Y'),
			'&copy;'
		);
			
		$new_copyright = get_option('gen_custom_copyright');
		$new_copyright = str_replace($options, $replace, get_option('gen_custom_copyright'));
			
		if ( get_option('gen_custom_copyright') !== '' ) :
			echo do_shortcode($new_copyright);
		endif;

	}
endif;
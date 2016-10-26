( function( $, api ) {
	api.controlConstructor['gp-customizer-fonts'] = api.Control.extend( {
		ready: function() {
			var control = this;
			$( 'select', control.container ).change(
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
	} );
	
	api.controlConstructor['gp-typography-select'] = api.Control.extend( {
		ready: function() {
			var control = this;
			$( 'select', control.container ).change(
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
	} );
	
	api.controlConstructor['gp-typography-slider'] = api.Control.extend( {
		ready: function() {
			var control = this;
			$( '.slider-input', control.container ).on( 'change keyup',
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
	} );
	
	api.controlConstructor['gp-hidden-input'] = api.Control.extend( {
		ready: function() {
			var control = this;
			$( '.gp-hidden-input', control.container ).on( 'change keyup',
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
	} );
} )( jQuery, wp.customize );

function generate_typography_set_data( id, setting ) {
	jQuery( id + ' select' ).on( 'change', function() {
		// Bail if our controls don't exist
		if ( 'undefined' == typeof wp.customize.control( setting + '_category' ) || 'undefined' == typeof wp.customize.control( setting + '_variants' ) )
			return;
		
		// Get the value of our select
		var _this = jQuery( this ).val();
		
		// Send our request to the generate_get_all_google_fonts_ajax function
		var response = jQuery.getJSON({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'generate_get_all_google_fonts_ajax',
				gp_customize_nonce: gp_customize.nonce
			},
			async: false,
			dataType: 'json',
		});
		
		// Get our response
		var fonts = response.responseJSON;
		
		// Create an ID from our selected font
		var id = _this.split(' ').join('_').toLowerCase();
		
		// Set our values if we have them
		if ( id in fonts ) {
			wp.customize.control( setting + '_category' ).setting.set( fonts[ id ].category )
			wp.customize.control( setting + '_variants' ).setting.set( fonts[ id ].variants.join( ',' ) )
			jQuery( 'input[name="' + setting + '_category"' ).val( fonts[ id ].category );
			jQuery( 'input[name="' + setting + '_variants"' ).val( fonts[ id ].variants.join( ',' ) );
		} else {
			wp.customize.control( setting + '_category' ).setting.set( '' )
			wp.customize.control( setting + '_variants' ).setting.set( '' )
			jQuery( 'input[name="' + setting + '_category"' ).val( '' );
			jQuery( 'input[name="' + setting + '_variants"' ).val( '' );
		}
	});
}

jQuery( document ).ready( function($) {
	generate_typography_set_data( '#customize-control-google_font_body_control', 'font_body' );
	generate_typography_set_data( '#customize-control-font_site_title_control', 'font_site_title' );
	generate_typography_set_data( '#customize-control-font_site_tagline_control', 'font_site_tagline' );
	generate_typography_set_data( '#customize-control-google_font_site_navigation_control', 'font_navigation' );
	generate_typography_set_data( '#customize-control-google_font_site_secondary_navigation_control', 'font_secondary_navigation' );
	generate_typography_set_data( '#customize-control-font_heading_1_control', 'font_heading_1' );
	generate_typography_set_data( '#customize-control-font_heading_2_control', 'font_heading_2' );
	generate_typography_set_data( '#customize-control-font_heading_3_control', 'font_heading_3' );
	generate_typography_set_data( '#customize-control-google_font_widget_title_control', 'font_widget_title' );
});
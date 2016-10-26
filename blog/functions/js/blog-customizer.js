( function( $, api ) {
	api.controlConstructor['gp-post-image-size'] = api.Control.extend( {
		ready: function() {
			var control = this;
			$( '.blog-size-input', control.container ).on( 'change keyup', 
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
	} );
	
	api.controlConstructor['gp-blog-number'] = api.Control.extend( {
		ready: function() {
			var control = this;
			$( '.blog-size-input', control.container ).on( 'change keyup', 
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
	} );
} )( jQuery, wp.customize );
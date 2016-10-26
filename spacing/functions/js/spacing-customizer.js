( function( $, api ) {
	api.controlConstructor['spacing'] = api.Control.extend( {
		ready: function() {
			var control = this;
			$( '.generate-number-control', control.container ).on( 'change keyup',
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
	} );
} )( jQuery, wp.customize );
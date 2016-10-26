( function( $, api ) {
	api.controlConstructor['position'] = api.Control.extend( {
		ready: function() {
			var control = this;
			$( 'input[type="text"]', control.container ).change(
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
	} );
} )( jQuery, wp.customize );
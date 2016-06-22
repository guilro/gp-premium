/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	
	// Container width
	wp.customize( 'generate_settings[container_width]', function( value ) {
		value.bind( function( newval ) {
			
			if ( $( '.navigation-clone.grid-container' )[0] ) {
				var width = newval / 2;
				$( '.navigation-clone.grid-container' ).css( 'margin-left', '-' + width + 'px' );
			}
			
			if ( $( '.main-navigation.is_stuck' )[0] ) {
				var width = newval / 2;
				$( '.main-navigation.is_stuck.grid-container' ).css( 'margin-left', '-' + width + 'px' );
			}
		} );
	} );
	
} )( jQuery );
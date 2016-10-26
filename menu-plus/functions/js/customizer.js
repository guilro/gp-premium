/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	
	// Container width	
	wp.customize( 'generate_settings[container_width]', function( value ) {
		value.bind( function( newval ) {
			var width = newval / 2;
			if ( jQuery( 'style#sticky_container_width' ).length ) {
				jQuery( 'style#sticky_container_width' ).html( '.navigation-clone.grid-container, .main-navigation.is_stuck.grid-container{margin-left:-' + width + 'px !important;width: ' + newval + 'px !important;max-width:' + newval + 'px !important}' );
			} else {
				jQuery( 'head' ).append( '<style id="sticky_container_width">.navigation-clone.grid-container, .main-navigation.is_stuck.grid-container{margin-left:-' + width + 'px !important;width: ' + newval + 'px !important;max-width:' + newval + 'px !important}</style>' );
				setTimeout(function() {
					jQuery( 'style#sticky_container_width' ).not( ':last' ).remove();
				}, 100);
			}
		} );
	} );
	
} )( jQuery );
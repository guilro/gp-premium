/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */
jQuery( document ).ready( function($) {
	if (typeof jQuery.fn.GenerateMobileMenu !== 'undefined' && jQuery.isFunction(jQuery.fn.GenerateMobileMenu)) {
		// Initiate our mobile menu
		$( '#secondary-navigation .menu-toggle' ).GenerateMobileMenu({
			menu: '.secondary-navigation',
			dropdown_toggle: false
		});
	} else {
		$( '.secondary-navigation .menu-toggle' ).on( 'click', function( e ) {
			e.preventDefault();
			$( this ).closest( '.secondary-navigation' ).toggleClass( 'toggled' );
			$( this ).closest( '.secondary-navigation' ).attr( 'aria-expanded', $( this ).closest( '.secondary-navigation' ).attr( 'aria-expanded' ) === 'true' ? 'false' : 'true' );
			$( this ).toggleClass( 'toggled' );
			$( this ).children( 'i' ).toggleClass( 'fa-bars' ).toggleClass( 'fa-close' );
			$( this ).attr( 'aria-expanded', $( this ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			return false;
		});
	}
});
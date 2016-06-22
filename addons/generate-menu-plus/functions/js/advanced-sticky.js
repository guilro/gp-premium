function generateMobile() 
{
	bodyTag = document.querySelector( 'body' );
	if ( classie.has( bodyTag, 'slideout-mobile' ) || classie.has( bodyTag, 'slideout-both' ) ) 
		return;

	if ( typeof jQuery.fn.GenerateMobileMenu !== 'undefined' && jQuery.isFunction( jQuery.fn.GenerateMobileMenu ) ) {
		// Initiate our mobile menu
		jQuery( '#sticky-navigation .menu-toggle' ).GenerateMobileMenu({
			menu: '.navigation-clone',
			dropdown_toggle: false
		});
	} else {
		// Open the mobile menu
		jQuery( '.navigation-clone .menu-toggle' ).on( 'click', function( e ) {
			e.preventDefault();
			jQuery( this ).closest( '.navigation-clone' ).toggleClass( 'toggled' );
			jQuery( this ).closest( '.navigation-clone' ).attr( 'aria-expanded', jQuery( this ).closest( '.navigation-clone' ).attr( 'aria-expanded' ) === 'true' ? 'false' : 'true' );
			jQuery( this ).toggleClass( 'toggled' );
			jQuery( this ).children( 'i' ).toggleClass( 'fa-bars' ).toggleClass( 'fa-close' );
			jQuery( this ).attr( 'aria-expanded', $( this ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			return false;
		});
	}
}

function generateMenuSearch()
{
	if ( typeof jQuery.fn.GenerateMenuSearch !== 'undefined' && jQuery.isFunction( jQuery.fn.GenerateMenuSearch ) ) {
		jQuery( ".navigation-clone .search-item a" ).GenerateMenuSearch();
	} else {
		jQuery( '.navigation-clone .search-item a' ).on( 'click', function( e ) {
			e.preventDefault();
			if ( jQuery( '.navigation-search' ).is( ':visible' ) ) {
				jQuery( this ).parent().removeClass( 'current-menu-item' );
				jQuery( this ).parent().removeClass( 'sfHover' );
				jQuery( this ).css( 'opacity','1' );
				jQuery( '.navigation-search' ).show().fadeOut( 200 );
				jQuery( '.search-item i' ).replaceWith( '<i class="fa fa-fw fa-search"></i>' );
			} else {
				jQuery( this ).parent().addClass( 'current-menu-item' );
				jQuery( this ).parent().removeClass( 'sfHover' );
				jQuery( this ).css( 'opacity','0.9' );
				jQuery( '.navigation-search' ).hide().fadeIn( 200 );
				jQuery( '.navigation-search input' ).focus();
				jQuery( '.search-item i' ).replaceWith( '<i class="fa fa-fw fa-times"></i>' );
			}
			return false;
		});
	}
}

// This function is only needed if we're using an old version of GP
function generateDisableMenuSearch()
{
	if ( typeof jQuery.fn.GenerateMenuSearch !== 'undefined' && jQuery.isFunction( jQuery.fn.GenerateMenuSearch ) ) {
		// do nothing
	} else {
		jQuery( '.main-navigation:not(.navigation-clone) .navigation-search' ).attr( 'class', 'navigation-search-disabled' ).hide();
		jQuery( '.main-navigation:not(.navigation-clone) .search-item' ).attr( 'class', 'search-item-disabled' );
	}
}

// This function is only needed if we're using an old version of GP
function generateEnableMenuSearch()
{
	if ( typeof jQuery.fn.GenerateMenuSearch !== 'undefined' && jQuery.isFunction( jQuery.fn.GenerateMenuSearch ) ) {
		// do nothing
	} else {
		jQuery( '.main-navigation:not(.navigation-clone) .navigation-search-disabled' ).attr( 'class', 'navigation-search' );
		jQuery( '.main-navigation:not(.navigation-clone) .search-item-disabled' ).attr( 'class', 'search-item' );
		jQuery( '.search-item i' ).replaceWith( '<i class="fa fa-fw fa-search"></i>' );
		jQuery( '.main-navigation .navigation-search' ).hide();
	}
}

function generateMenuOffset( element )
{
	// Get the top of our navigation
	var top = element.position().top;
	
	// Set up our mobile variable
	var mobile;
	mobile = jQuery( '.menu-toggle' );
	
	// If our navigation is in a sidebar and we're on mobile, use the container
	if ( ( jQuery( '.nav-right-sidebar' )[0] || jQuery( '.nav-left-sidebar' )[0] ) && mobile.is( ':visible' ) ) {
		top = jQuery( '#page.container' ).position().top;
	}
	
	// Get the top of our navigation when our navigation is floating
	if ( jQuery( '.nav-float-right' )[0] || jQuery( '.nav-float-left' )[0] ) {
		top = top + element.parent().parent().position().top;
	}
	
	// Get the bottom of the navigation
	var bottom = top + element.outerHeight() + 50;
	
	return bottom;
}

(function ( $ ) 
{
	$.fn.GenerateStickyNavigation = function( options ) 
	{
		// Set the default settings
		var settings = $.extend({
			cloned_element: $( this ),
			cloned_class: 'navigation-clone',
			cloned_id: 'sticky-navigation',
			sticky_class: 'navigation-stick'
		}, options );
		
		// Bail if our menu doesn't exist
		if ( ! $( settings.cloned_element ).length ) {
			return;
		}
		
		// Set up our mobile variable
		var mobile;
		mobile = $( '.menu-toggle' );
		
		// Clone our navigation
		$( settings.cloned_element ).clone().prependTo( 'body' ).addClass( settings.cloned_class ).attr( 'id', settings.cloned_id );
		
		// Set up the navigation search for the cloned navigation
		generateMenuSearch();
		
		// Get our position from the top
		var stickyTimer;
		var bottom = generateMenuOffset( settings.cloned_element );
		var top = bottom - settings.cloned_element.outerHeight() - 50;
		
		// Update our variables when you change your browser width
		$(window).resize(function() {
			clearTimeout(stickyTimer);
			stickyTimer = setTimeout(function() {
				bottom = generateMenuOffset( settings.cloned_element );
				top = bottom - settings.cloned_element.outerHeight() - 50;
			}, 100)
		});
		
		// Listen for scrolling and set classes
		$(window).on('scroll touchmove', function() {
			if ( $( '.slide-opened' )[0] ) {
				return;
			}
	
			if ( $( window ).scrollTop() >= bottom ) {
				$( '.' + settings.cloned_class ).addClass( settings.sticky_class );
				$( '.sticky-menu-fade ' + '.' + settings.cloned_class ).fadeIn( 300 );
				generateDisableMenuSearch();
			} else if ( $( window ).scrollTop() <= top ) {
				$( '.' + settings.cloned_class ).removeClass( settings.sticky_class );
				$( '.sticky-menu-fade ' + '.' + settings.cloned_class ).hide( 50 );
				generateEnableMenuSearch();
			}
		});
	};
}( jQuery ));

jQuery( document ).ready( function($) 
{
	// Initiate sticky menu
	$( '#site-navigation' ).GenerateStickyNavigation();
	
	// Set up the mobile menu toggle for the cloned navigation
	generateMobile();
});
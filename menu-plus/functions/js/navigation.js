jQuery( document ).ready( function( $ ) {
	// Build the mobile button that displays the dropdown menu
	$( document ).on( 'click', 'nav .dropdown-menu-toggle', function( e ) {
		e.preventDefault();
		// Get the clicked element
		var _this = $( this );
		var mobile = $( '.menu-toggle' );
		var slideout = $( '.slideout-navigation' );
		
		if ( mobile.is( ':visible' ) || 'visible' == slideout.css( 'visibility' ) ) {
			_this.closest( 'li' ).toggleClass( 'sfHover' );
			_this.parent().siblings( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
			_this.attr( 'aria-expanded', $( this ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
		}
		return false;
	});
	
	// Display the dropdown on click if the item URL doesn't go anywhere
	$( document ).on( 'click', '.main-nav .menu-item-has-children > a', function( e ) {
		var _this = $( this );
		var mobile = $( '.menu-toggle' );
		var slideout = $( '.slideout-navigation' );
		var url = _this.attr( 'href' );
		if ( '#' == url || '' == url ) {
			if ( mobile.is( ':visible' ) || 'visible' == slideout.css( 'visibility' ) ) {
				e.preventDefault();
				_this.closest( 'li' ).toggleClass( 'sfHover' );
				_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
				_this.attr( 'aria-expanded', $( this ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
				return false;
			}
		}
	});
	
	// Build the mobile button that displays the dropdown menu
	// This is for sites using an older version than GP (< 1.3.24)
	jQuery( 'nav .dropdown-toggle' ).click( function( e ) {
		var _this = jQuery( this );
		e.preventDefault();
		_this.toggleClass( 'toggle-on' );
		_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
		_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
		_this.html( _this.html() === '<i class="fa fa-caret-down"></i>' ? '<i class="fa fa-caret-up"></i>' : '<i class="fa fa-caret-down"></i>' );
			return false;
	} );
});
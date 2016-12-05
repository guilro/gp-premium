(function( $ ){	
	/** 
	 * Navigation width
	 */
	wp.customize( 'generate_secondary_nav_settings[secondary_nav_layout_setting]', function( value ) {
		value.bind( function( newval ) {
			if ( 'secondary-fluid-nav' == newval ) {
				$( '.secondary-navigation' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
				if ( 'full-width' !== wp.customize.value('generate_secondary_nav_settings[secondary_nav_inner_width]')() ) {
					$( '.secondary-navigation .inside-navigation' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
				}
			}
			if ( 'secondary-contained-nav' == newval ) {
				jQuery( '.secondary-navigation' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
				jQuery( '.secondary-navigation .inside-navigation' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
			}
		} );
	} );
	
	/** 
	 * Inner navigation width
	 */
	wp.customize( 'generate_secondary_nav_settings[secondary_nav_inner_width]', function( value ) {
		value.bind( function( newval ) {
			if ( 'full-width' == newval ) {
				$( '.secondary-navigation .inside-navigation' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
			}
			if ( 'contained' == newval ) {
				$( '.secondary-navigation .inside-navigation' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
			}
		} );
	} );
	
	/** 
	 * Navigation position
	 */
	wp.customize( 'generate_secondary_nav_settings[secondary_nav_position_setting]', function( value ) {
		value.bind( function( newval ) {
			if ( $( '.gen-sidebar-secondary-nav' ).length ) {
				wp.customize.preview.send( 'refresh' );
				return false;
			}
			if ( 'secondary-nav-left-sidebar' == newval ) {
				wp.customize.preview.send( 'refresh' );
				return false;
			}
			if ( 'secondary-nav-right-sidebar' == newval ) {
				wp.customize.preview.send( 'refresh' );
				return false;
			}
			var classes = [ 'secondary-nav-below-header', 'secondary-nav-above-header', 'secondary-nav-float-right', 'secondary-nav-float-left', 'secondary-nav-left-sidebar', 'secondary-nav-right-sidebar' ];
			if ( 'secondary-nav-left-sidebar' !== newval && 'secondary-nav-right-sidebar' !== newval ) {
				$.each( classes, function( i, v ) {
					$( 'body' ).removeClass( v );
				});
			}
			$( 'body' ).addClass( newval );
			if ( 'secondary-nav-below-header' == newval ) {
				if ( $( 'body' ).hasClass( 'nav-below-header' ) ) {
					$( '#secondary-navigation' ).insertAfter( '#site-navigation' ).show();
				} else {
					$( '#secondary-navigation' ).insertAfter( '.site-header' ).show();
				}
			}
			if ( 'secondary-nav-above-header' == newval ) {
				$( '#secondary-navigation' ).insertBefore( '.site-header' ).show();
			}
			if ( 'secondary-nav-float-right' == newval ) {
				$( '#secondary-navigation' ).prependTo( '.inside-header' ).show();
			}
			if ( 'secondary-nav-float-left' == newval ) {
				$( '#secondary-navigation' ).appendTo( '.inside-header' ).show();
			}
			if ( '' == newval ) {
				if ( $( '.gen-sidebar-secondary-nav' ).length ) {
					wp.customize.preview.send( 'refresh' );
				} else {
					$( '#secondary-navigation' ).hide();
				}
			}
		} );
	} );
	
	wp.customize( 'generate_secondary_nav_settings[secondary_nav_alignment]', function( value ) {
		value.bind( function( newval ) {
			var classes = [ 'secondary-nav-aligned-left', 'secondary-nav-aligned-center', 'secondary-nav-aligned-right' ];
			$.each( classes, function( i, v ) {
				$( 'body' ).removeClass( v );
			});
			$( 'body' ).addClass( 'secondary-nav-aligned-' + newval );
		} );
	} );
	
	wp.customize( 'generate_secondary_nav_settings[secondary_menu_item]', function( value ) {
		value.bind( function( newval ) {
			jQuery( 'head' ).append( '<style id="secondary_menu_item">.secondary-navigation .main-nav ul li a, .secondary-navigation .menu-toggle{padding: 0 ' + newval + 'px;}</style>' );
			setTimeout(function() {
				jQuery( 'style#secondary_menu_item' ).not( ':last' ).remove();
			}, 50);
		} );
	} );
	
	wp.customize( 'generate_secondary_nav_settings[secondary_menu_item_height]', function( value ) {
		value.bind( function( newval ) {
			jQuery( 'head' ).append( '<style id="secondary_menu_item_height">.secondary-navigation .main-nav ul li a, .secondary-navigation .menu-toggle{line-height: ' + newval + 'px;}.secondary-navigation ul ul{top:' + newval + 'px;}</style>' );
			setTimeout(function() {
				jQuery( 'style#secondary_menu_item_height' ).not( ':last' ).remove();
			}, 50);
		} );
	} );
	
	wp.customize( 'generate_secondary_nav_settings[secondary_sub_menu_item_height]', function( value ) {
		value.bind( function( newval ) {
			jQuery( 'head' ).append( '<style id="secondary_sub_menu_item_height">.secondary-navigation .main-nav ul ul li a{padding-top: ' + newval + 'px;padding-bottom: ' + newval + 'px;}</style>' );
			setTimeout(function() {
				jQuery( 'style#secondary_sub_menu_item_height' ).not( ':last' ).remove();
			}, 50);
		} );
	} );

})( jQuery );
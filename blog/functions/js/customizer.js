/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	
	// Container width
	wp.customize( 'generate_settings[container_width]', function( value ) {
		value.bind( function( newval ) {
			if ( $( '.masonry-container' )[0] ) {
				var $initiate = jQuery('.masonry-container').imagesLoaded( function() {
					$container = jQuery('.masonry-container');
					if (jQuery($container).length) {
						$container.masonry({
							columnWidth: '.grid-sizer',
							itemSelector: '.masonry-post',
							stamp: '.page-header'
						});
					}
				});
			}
		} );
	} );
	
	$( 'body' ).on( 'generate_spacing_updated', function() {
		if ( $( '.masonry-container' )[0] ) {
			var $initiate = jQuery('.masonry-container').imagesLoaded( function() {
				$container = jQuery('.masonry-container');
				if (jQuery($container).length) {
					$container.masonry({
						columnWidth: '.grid-sizer',
						itemSelector: '.masonry-post',
						stamp: '.page-header'
					});
				}
			});
		}
	});
	
} )( jQuery );
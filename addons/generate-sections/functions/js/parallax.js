function generateSectionParallax() {

	// Disable on mobile
	var mobile = jQuery( '.menu-toggle' );
	if ( mobile.is( ':visible' ) )
		return;

	// Only run the function if the setting exists
	if ( ! jQuery('.generate-sections-container.enable-parallax')[0] )
		return;
	
	var $this = jQuery( '.generate-sections-container.enable-parallax' );
				
	var x = jQuery(window).scrollTop();
	var speed = $this.data('speed');
	return $this.css('background-position', 'center ' + parseInt(-x / speed) + 'px');	
	

}

jQuery(document).ready(function($) {
	if ( jQuery('.generate-sections-container.enable-parallax')[0] ) {
		// Initiate parallax effect
		$(document).scroll(function() {			
			generateSectionParallax();
		});
	}
});
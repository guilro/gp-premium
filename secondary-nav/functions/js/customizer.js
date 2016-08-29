var $j = jQuery.noConflict();

$j(function(){

	var secondary_nav_typography = $j('input[name="generate_secondary_nav_settings[secondary_navigation_font_size]"]').val();

	// wait till iframe has been loaded
	setTimeout(function() {
	
		// Body
		$j('input[name="generate_secondary_nav_settings[secondary_navigation_font_size]"]').next('div.slider').slider({
			value: secondary_nav_typography,
			min: 6,
			max: 25,
			slide: function( event, ui ) {
				// Change input value and slider position
				$j('input[name="generate_secondary_nav_settings[secondary_navigation_font_size]"]').val( ui.value ).change();
				$j('#customize-control-generate_secondary_nav_settings-secondary_navigation_font_size .value').text( ui.value );
				// Change CSS in LivePreview			
				//$j("iframe").contents().find('body').css('font-size', ui.value+'px');
					
			}
		});

	});

});
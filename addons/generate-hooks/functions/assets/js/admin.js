jQuery(document).ready(function($) {
	
	jQuery('#hook-dropdown').on('change', function() {
		var id = jQuery(this).children(":selected").attr("id");
		jQuery('#gp_hooks_settings .form-table tr').hide();
		jQuery('#gp_hooks_settings .form-table tr').eq(id).show();
		$.cookie('remember_hook', $('#hook-dropdown option:selected').attr('id'), { expires: 90, path: '/'});
		
		if ( jQuery('#hook-dropdown').val() == 'all' ) {
			$('#gp_hooks_settings .form-table tr').show();
			$.cookie('remember_hook', 'none', { expires: 90, path: '/'});
		}
		
	});

	//checks if the cookie has been set
	if( $.cookie('remember_hook') === null || $.cookie('remember_hook') === "" || $.cookie('remember_hook') === "null" || $.cookie('remember_hook') === "none" || $.cookie('remember_hook') === undefined )
	{	
		$('#gp_hooks_settings .form-table tr').show();
		$.cookie('remember_hook', 'none', { expires: 90, path: '/'});
	} else {
		$('#hook-dropdown option[id="' + $.cookie('remember_hook') + '"]').attr('selected', 'selected');
		$('#gp_hooks_settings .form-table tr').hide();
		$('#gp_hooks_settings .form-table tr').eq($.cookie('remember_hook')).show();
	}
	
	var top = $('.sticky-scroll-box').offset().top;
	$(window).scroll(function (event) {
		var y = $(this).scrollTop();
		if (y >= top)
			$('.sticky-scroll-box').addClass('fixed');
		else
			$('.sticky-scroll-box').removeClass('fixed');
			$('.sticky-scroll-box').width($('.sticky-scroll-box').parent().width());
	});

});


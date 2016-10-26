function generate_blog_masonry() {
	if ( typeof imagesLoaded !== 'undefined' ) {
		jQuery('.masonry-container').imagesLoaded().done( function() {
			jQuery('.masonry-container').masonry({
				columnWidth: '.grid-sizer',
				itemSelector: '.masonry-post',
				stamp: '.page-header'
			});
		});
	} else {
		jQuery('.masonry-container').masonry({
			columnWidth: '.grid-sizer',
			itemSelector: '.masonry-post',
			stamp: '.page-header'
		});
	}
}

if ( jQuery('.masonry-container')[0] ) {
	
	var widthTimer;

	jQuery(document).ready(function () {
		generate_blog_masonry();
	});
	
	jQuery( window ).on( "orientationchange", function( event ) {
		generate_blog_masonry();
	});

	jQuery(function () {
		var pageNum = parseInt(jQuery('.load-more a').attr('data-page')) + 1;
		var max = parseInt(jQuery('.load-more a').attr('data-pages'));
		if (pageNum > max) jQuery('.load-more').remove();
		var nextLink = jQuery('.load-more a').attr('data-link');
		jQuery('.load-more a').click(function () {
			loading = false;
			if (pageNum <= max && !loading) {
				loading = true;
				jQuery(this).html('<i class="fa fa-spinner fa-spin"></i> ' + objectL10n.loading);
				jQuery.get(nextLink, function (data) {
					pageNum++;
					if (nextLink.indexOf("paged=") > 0) nextLink = nextLink.replace(/paged=[0-9]*/, 'paged=' + pageNum);
					else nextLink = nextLink.replace(/\/page\/[0-9]*/, '/page/' + pageNum);
					var items = Array();
					var $newItems = jQuery('.masonry-post', data);
					//alert($newItems);
					$newItems.imagesLoaded().done(function () {
						jQuery('.masonry-container').append($newItems).masonry('appended', $newItems );
						jQuery(window).resize();

						setTimeout(function () {
							loading = false;
							jQuery('.load-more a').html(objectL10n.more);
							jQuery('.masonry-container').masonry('reloadItems');
							jQuery(window).resize();
							if (pageNum > max) jQuery('.load-more').remove();
						}, 500);
						
						if ( 'object' === typeof _gaq ) {
							_gaq.push( [ '_trackPageview', nextLink ] );
						}
						if ( 'function' === typeof ga ) {
							ga( 'send', 'pageview', nextLink );
						}
						
					});
				});
			} else {}
			return false;
		});
	});
}
function gp_premium_typography_live_update( id, selector, property, unit, settings ) {
	unit = typeof unit !== 'undefined' ? unit : '';
	settings = typeof settings !== 'undefined' ? settings : 'generate_settings';
	wp.customize( settings + '[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			if ( jQuery( 'style#' + id ).length ) {
				jQuery( 'style#' + id ).html( selector + '{' + property + ':' + newval + unit + ';}' );
			} else {
				jQuery( 'head' ).append( '<style id="' + id + '">' + selector + '{' + property + ':' + newval + unit + ';}</style>' );
				setTimeout(function() {
					jQuery( 'style#' + id ).not( ':last' ).remove();
				}, 1000);
			}
			setTimeout("jQuery('body').trigger('generate_spacing_updated');", 1000);
		} );
	} );
}

/** 
 * Body font size, weight and transform
 */
gp_premium_typography_live_update( 'body_font_size', 'body, button, input, select, textarea', 'font-size', 'px' );
gp_premium_typography_live_update( 'body_line_height', 'body', 'line-height', '' );
gp_premium_typography_live_update( 'paragraph_margin', 'p', 'margin-bottom', 'em' );
gp_premium_typography_live_update( 'body_font_weight', 'body, button, input, select, textarea', 'font-weight' );
gp_premium_typography_live_update( 'body_font_transform', 'body, button, input, select, textarea', 'text-transform' );

/** 
 * Site title font size, weight and transform
 */
wp.customize( 'generate_settings[site_title_font_size]', function( value ) {
	value.bind( function( newval ) {
		if ( jQuery( 'style#site_title_font_size' ).length ) {
			jQuery( 'style#site_title_font_size' ).html( '@media(min-width:769px){.main-title{font-size:' + newval + 'px;}}' );
		} else {
			jQuery( 'head' ).append( '<style id="site_title_font_size">@media(min-width:769px){.main-title{font-size:' + newval + 'px;}}</style>' );
			setTimeout(function() {
				jQuery( 'style#site_title_font_size' ).not( ':last' ).remove();
			}, 1000);
		}
	} );
} );
gp_premium_typography_live_update( 'site_title_font_weight', '.main-title', 'font-weight' );
gp_premium_typography_live_update( 'site_title_font_transform', '.main-title', 'text-transform' );

/** 
 * Site description font size, weight and transform
 */
gp_premium_typography_live_update( 'site_tagline_font_size', '.site-description', 'font-size', 'px' );
gp_premium_typography_live_update( 'site_tagline_font_weight', '.site-description', 'font-weight' );
gp_premium_typography_live_update( 'site_tagline_font_transform', '.site-description', 'text-transform' );

/** 
 * Main navigation font size, weight and transform
 */
gp_premium_typography_live_update( 'navigation_font_size', '.main-navigation a, .menu-toggle', 'font-size', 'px' );
gp_premium_typography_live_update( 'navigation_font_weight', '.main-navigation a, .menu-toggle', 'font-weight' );
gp_premium_typography_live_update( 'navigation_font_transform', '.main-navigation a, .menu-toggle', 'text-transform' );

/** 
 * Secondary navigation font size, weight and transform
 */
gp_premium_typography_live_update( 'secondary_navigation_font_size', '.secondary-navigation .main-nav ul li a,.secondary-navigation .menu-toggle', 'font-size', 'px', 'generate_secondary_nav_settings' );
gp_premium_typography_live_update( 'secondary_navigation_font_weight', '.secondary-navigation .main-nav ul li a,.secondary-navigation .menu-toggle', 'font-weight', '', 'generate_secondary_nav_settings' );
gp_premium_typography_live_update( 'secondary_navigation_font_transform', '.secondary-navigation .main-nav ul li a,.secondary-navigation .menu-toggle', 'text-transform', '', 'generate_secondary_nav_settings' );

/** 
 * H1 font size, weight and transform
 */
wp.customize( 'generate_settings[heading_1_font_size]', function( value ) {
	value.bind( function( newval ) {
		if ( jQuery( 'style#heading_1_font_size' ).length ) {
			jQuery( 'style#heading_1_font_size' ).html( '@media(min-width:769px){h1{font-size:' + newval + 'px;}}' );
		} else {
			jQuery( 'head' ).append( '<style id="heading_1_font_size">@media(min-width:769px){h1{font-size:' + newval + 'px;}}</style>' );
			setTimeout(function() {
				jQuery( 'style#heading_1_font_size' ).not( ':last' ).remove();
			}, 1000);
		}
	} );
} );
gp_premium_typography_live_update( 'heading_1_weight', 'h1', 'font-weight' );
gp_premium_typography_live_update( 'heading_1_transform', 'h1', 'text-transform' );

/** 
 * H2 font size, weight and transform
 */
wp.customize( 'generate_settings[heading_2_font_size]', function( value ) {
	value.bind( function( newval ) {
		if ( jQuery( 'style#heading_2_font_size' ).length ) {
			jQuery( 'style#heading_2_font_size' ).html( '@media(min-width:769px){h2{font-size:' + newval + 'px;}}' );
		} else {
			jQuery( 'head' ).append( '<style id="heading_2_font_size">@media(min-width:769px){h2{font-size:' + newval + 'px;}}</style>' );
			setTimeout(function() {
				jQuery( 'style#heading_2_font_size' ).not( ':last' ).remove();
			}, 1000);
		}
	} );
} );
gp_premium_typography_live_update( 'heading_2_weight', 'h2', 'font-weight' );
gp_premium_typography_live_update( 'heading_2_transform', 'h2', 'text-transform' );

/** 
 * H3 font size, weight and transform
 */
gp_premium_typography_live_update( 'heading_3_font_size', 'h3', 'font-size', 'px' );
gp_premium_typography_live_update( 'heading_3_weight', 'h3', 'font-weight' );
gp_premium_typography_live_update( 'heading_3_transform', 'h3', 'text-transform' );

/** 
 * Widget title font size, weight and transform
 */
gp_premium_typography_live_update( 'widget_title_font_size', '.widget-title', 'font-size', 'px' );
gp_premium_typography_live_update( 'widget_title_font_weight', '.widget-title', 'font-weight' );
gp_premium_typography_live_update( 'widget_title_font_transform', '.widget-title', 'text-transform' );
gp_premium_typography_live_update( 'widget_content_font_size', '.sidebar .widget, .footer-widgets .widget', 'font-size', 'px' );

/** 
 * Footer font size
 */
gp_premium_typography_live_update( 'footer_font_size', '.site-info', 'font-size', 'px' );

/** 
 * Mobile font sizes
 */
wp.customize( 'generate_settings[mobile_site_title_font_size]', function( value ) {
	value.bind( function( newval ) {
		if ( jQuery( 'style#mobile_site_title_font_size' ).length ) {
			jQuery( 'style#mobile_site_title_font_size' ).html( '@media(max-width: 768px){.main-title{font-size:' + newval + 'px;}}' );
		} else {
			jQuery( 'head' ).append( '<style id="mobile_site_title_font_size">@media(max-width: 768px){.main-title{font-size:' + newval + 'px;}}</style>' );
			setTimeout(function() {
				jQuery( 'style#mobile_site_title_font_size' ).not( ':last' ).remove();
			}, 1000);
		}
	} );
} );

wp.customize( 'generate_settings[mobile_heading_1_font_size]', function( value ) {
	value.bind( function( newval ) {
		if ( jQuery( 'style#mobile_heading_1_font_size' ).length ) {
			jQuery( 'style#mobile_heading_1_font_size' ).html( '@media(max-width: 768px){h1{font-size:' + newval + 'px;}}' );
		} else {
			jQuery( 'head' ).append( '<style id="mobile_heading_1_font_size">@media(max-width: 768px){h1{font-size:' + newval + 'px;}}</style>' );
			setTimeout(function() {
				jQuery( 'style#mobile_heading_1_font_size' ).not( ':last' ).remove();
			}, 1000);
		}
	} );
} );

wp.customize( 'generate_settings[mobile_heading_2_font_size]', function( value ) {
	value.bind( function( newval ) {
		if ( jQuery( 'style#mobile_heading_2_font_size' ).length ) {
			jQuery( 'style#mobile_heading_2_font_size' ).html( '@media(max-width: 768px){h2{font-size:' + newval + 'px;}}' );
		} else {
			jQuery( 'head' ).append( '<style id="mobile_heading_2_font_size">@media(max-width: 768px){h2{font-size:' + newval + 'px;}}</style>' );
			setTimeout(function() {
				jQuery( 'style#mobile_heading_2_font_size' ).not( ':last' ).remove();
			}, 1000);
		}
	} );
} );
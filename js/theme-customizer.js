/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 * Things like site title, description, and background color changes.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).html( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).html( to );
		} );
	} );
	wp.customize( 'copyright_notice', function( value ) {
		value.bind( function( to ) {
			$( '.copyright-notice' ).html( to );
		} );
	} );
	wp.customize( 'header_text_shadow', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a', '.site-description a','.header-navigation li a', '.header-navigation li a:hover' ).html( to );
		} );
	} );
	wp.customize( 'main_menu_link', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation li a' ).html( to );
		} );
	} );
	wp.customize( 'menu_text_shadow', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation li a' ).html( to );
		} );
	} );
	wp.customize( 'menu_current_page', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation li a:hover, .main-navigation .current-menu-item a, .main-navigation .current-menu-ancestor a' ).html( to );
		} );
	} );
	wp.customize( 'menu_hover_background', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation li ul li a:hover, #secondary .widget h3, .archive-header .archive-title, .search-header .search-title, .entry-content .search-header .search-title, .showcase-header .showcase-heading, .content-slider-header .showcase-heading' ).html( to );
		} );
	} );
	wp.customize( 'footer_sidebar_text', 'footer_sidebar_shadow',  function( value ) {
		value.bind( function( to ) {
			$( '#sidebar-homepage #supplementary .widget .textwidget', '#sidebar-homepage #supplementary .widget-title', '#sidebar-homepage #supplementary .widget p' ).html( to );
		} );
	} );
	wp.customize( 'footer_sidebar_link', 'footer_sidebar_shadow', function( value ) {
		value.bind( function( to ) {
			$( '#supplementary .widget a, #supplementary .widget a:hover, .template-front-page #supplementary .widget li a, .template-front-page #supplementary .widget li a:hover, #supplementary .widget .tagcloud' ).html( to );
		} );
	} );
	wp.customize( 'homepage_sidebar_text', 'homepage_sidebar_shadow', function( value ) {
		value.bind( function( to ) {
			$( '#sidebar-homepage #supplementary .widget .textwidget', '#sidebar-homepage #supplementary .widget-title', '#sidebar-homepage #supplementary .widget p' ).html( to );
		} );
	} );
	wp.customize( 'homepage_content_text', 'homepage_content_shadow', function( value ) {
		value.bind( function( to ) {
			$( '.template-homepage .entry-content' ).html( to );
		} );
	} );
	wp.customize( 'primary_text_color', function( value ) {
		value.bind( function( to ) {
			$( '.comments-area article header cite a, .main-navigation li ul li a:hover, .template-homepage .entry-content .sd-title' ).html( to );
		} );
	} );
	wp.customize( 'secondary_text_color', function( value ) {
		value.bind( function( to ) {
			$( '.menu-toggle:active, .menu-toggle.toggled-on, input[type="submit"]:active, article.post-password-required input[type=submit]:active, input[type="submit"].toggled-on, .wp-caption .wp-caption-text, .gallery-caption, .entry-caption, .author-description p, article.sticky .featured-post, .entry-content table, .comment-content table, footer.entry-meta, .archive-meta, .format-status .entry-header header a, #secondary .widget .textwidget, article.format-quote .entry-content cite, .entry-content .cubricks-chat .chat-even, #secondary .widget .textwidget, #secondary .widget p, #secondary .widget #calendar_wrap table' ).html( to );
		} );
	} );
	wp.customize( 'link_color', function( value ) {
		value.bind( function( to ) {
			$( 'a, .entry-meta a, .entry-meta a:hover, .format-status .entry-header header a:hover, .comments-area article header a:hover, a.comment-reply-link:hover, .template-homepage .widget-area .widget li a:hover, .entry-header .entry-title a:hover' ).html( to );
		} );
	} );
	wp.customize( 'post_entry_titles', function( value ) {
		value.bind( function( to ) {
			$( '.entry-header .entry-title a, article.format-quote .entry-content blockquote:before, article.format-quote .entry-content blockquote, #social-links-label h1' ).html( to );
		} );
	} );
	wp.customize( 'post_entry_headers', function( value ) {
		value.bind( function( to ) {
			$( '.entry-content h1, .comment-content h1, .entry-content h2, .comment-content h2, .entry-content .cubricks-chat .chat-even strong' ).html( to );
		} );
	} );
	wp.customize( 'slider_caption_color', 'slider_caption_bg', 'slider_caption_opacity', function( value ) {
		value.bind( function( to ) {
			$( '#showcase-slider .nivo-caption, #content-slider .nivo-caption' ).html( to );
		} );
	} );
	

	// Hook into background color change and adjust body class value as needed.
	wp.customize( 'background_color', function( value ) {
		value.bind( function( to ) {
			if ( 'F5F5F5' == to || '' == to )
				$( 'body' ).addClass( 'custom-background-white' );
			else if ( '' == to )
				$( 'body' ).addClass( 'custom-background-empty' );
			else
				$( 'body' ).removeClass( 'custom-background-empty custom-background-white' );
		} );
	} );
} )( jQuery );
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
	wp.customize( 'footer_sidebar_heading', function( value ) {
		value.bind( function( to ) {
			$( '.footer-sidebar-heading' ).html( to );
		} );
	} );
	wp.customize( 'frontpage_sidebar_heading', function( value ) {
		value.bind( function( to ) {
			$( '.front-sidebar-heading' ).html( to );
		} );
	} );
	wp.customize( 'full-wide', function( value ) {
		value.bind( function( to ) {
			if ( 'full-wide' == to ) {
				$( 'body' ).removeClass( 'post-boxes page-centered' );
				$( 'body' ).addClass( 'full-wide' );
			} else if ( 'page-centered' == to ) {
				$( 'body' ).removeClass( 'post-boxes full-wide' );
				$( 'body' ).addClass( 'page-centered' );
			} else if ( 'post-boxes' == to ) {
				$( 'body' ).removeClass( 'full-wide page-centered' );
				$( 'body' ).addClass( 'post-boxes' );
			}
		} );
	} );
	wp.customize( 'header_text_shadow', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a', '.site-description a','.header-navigation li a', '.header-navigation li a:hover' ).css( 'color', to );
		} );
	} );
	wp.customize( 'main_menu_text', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation li a' ).css( 'color', to );
		} );
	} );
	wp.customize( 'menu_text_shadow', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation li a' ).css( 'color', to );
		} );
	} );
	wp.customize( 'menu_current_page', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation li a:hover, .main-navigation .current-menu-item a, .main-navigation .current-menu-ancestor a' ).css( 'color', to );
		} );
	} );
	wp.customize( 'main_menu_children', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation li ul li a' ).css( 'background', to );
		} );
	} );
	wp.customize( 'menu_hover_background', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation li ul li a:hover, #comments #respond' ).css( 'background', to );
		} );
	} );
	wp.customize( 'sidebar_title_color', function( value ) {
		value.bind( function( to ) {
			$( '#secondary .widget-title, #secondary .widget-title > span a, .archive-header .archive-title span, .search-header .search-title span, .entry-content .search-header .search-title span, .recent-posts-header .recent-posts-heading span, .featured-header .featured-heading span, #social-links-label h1' ).css( 'color', to );
		} );
	} );
	wp.customize( 'sidebar_title_color', function( value ) {
		value.bind( function( to ) {
			$( '#secondary .widget h3, .archive-header .archive-title, .search-header .search-title, .entry-content .search-header .search-title, .recent-posts-header .recent-posts-heading, .featured-header .featured-heading' ).css( 'background', to );
		} );
	} );
	wp.customize( 'sidebar_link_color', function( value ) {
		value.bind( function( to ) {
			$( '#secondary .widget a, #secondary .widget a:hover, #secondary .widget .tagcloud' ).css( 'color', to );
		} );
	} );
	wp.customize( 'footer_sidebar_text', 'footer_sidebar_shadow',  function( value ) {
		value.bind( function( to ) {
			$( '#sidebar-front-page #supplementary .widget .textwidget', '#sidebar-front-page #supplementary .widget-title', '#sidebar-front-page #supplementary .widget p' ).css( 'color', to );
		} );
	} );
	wp.customize( 'footer_sidebar_link', 'footer_sidebar_shadow', function( value ) {
		value.bind( function( to ) {
			$( '#supplementary .widget a, #supplementary .widget a:hover, .template-front-page #supplementary .widget li a, .template-front-page #supplementary .widget li a:hover, #supplementary .widget .tagcloud' ).css( 'color', to );
		} );
	} );
	wp.customize( 'frontpage_sidebar_text', function( value ) {
		value.bind( function( to ) {
			$( '#sidebar-front-page #supplementary .widget .textwidget', '#sidebar-front-page #supplementary .widget-title', '#sidebar-front-page #supplementary .widget p' ).css( 'color', to );
		} );
	} );
	wp.customize( 'frontpage_content_text', function( value ) {
		value.bind( function( to ) {
			$( '.template-front-page .entry-content' ).css( 'color', to );
		} );
	} );
	wp.customize( 'primary_text_color', function( value ) {
		value.bind( function( to ) {
			$( '.comments-area article header cite a, .main-navigation li ul li a:hover, .template-front-page .entry-content .sd-title' ).css( 'color', to );
		} );
	} );
	wp.customize( 'secondary_text_color', function( value ) {
		value.bind( function( to ) {
			$( '.menu-toggle:active, .menu-toggle.toggled-on, input[type="submit"]:active, article.post-password-required input[type=submit]:active, input[type="submit"].toggled-on, .wp-caption .wp-caption-text, .gallery-caption, .entry-caption, .author-description p, article.sticky .featured-post, .entry-content table, .comment-content table, footer.entry-meta, .archive-meta, .format-status .entry-header header a, #secondary .widget .textwidget, article.format-quote .entry-content cite, .entry-content .cubricks-chat .chat-even, #secondary .widget .textwidget, #secondary .widget p, #secondary .widget #calendar_wrap table' ).css( 'color', to );
		} );
	} );
	wp.customize( 'link_color', function( value ) {
		value.bind( function( to ) {
			$( 'a, .entry-meta a, .entry-meta a:hover, .format-status .entry-header header a:hover, .comments-area article header a:hover, a.comment-reply-link:hover, .template-front-page .widget-area .widget li a:hover, .entry-header .entry-title a:hover' ).css( 'color', to );
		} );
	} );
	wp.customize( 'post_entry_titles', function( value ) {
		value.bind( function( to ) {
			$( '.entry-header .entry-title a, article.format-quote .entry-content blockquote:before, article.format-quote .entry-content blockquote, #social-links-label h1' ).css( 'color', to );
		} );
	} );
	wp.customize( 'post_entry_headers', function( value ) {
		value.bind( function( to ) {
			$( '.entry-content h1, .comment-content h1, .entry-content h2, .comment-content h2, .entry-content .cubricks-chat .chat-even strong' ).css( 'color', to );
		} );
	} );
	wp.customize( 'slider_caption_color', 'slider_caption_bg', 'slider_caption_opacity', function( value ) {
		value.bind( function( to ) {
			$( '#showcase-slider .nivo-caption, #content-slider .nivo-caption' ).css( 'color', to );
		} );
	} );
	
	// Page wrapper
	wp.customize( 'page_wrapper_color', 'page_wrapper_opacity', 'page_wrapper_image', 'page_wrapper_position_x', 'page_wrapper_position_y', 'page_wrapper_repeat', 'page_wrapper_attachment', function( value ) {
		value.bind( function( to ) {
			$( '.site' ).css( 'background', to );
		} );
	} );
	
	// Header wrapper
	wp.customize( 'header_wrapper_color', 'header_wrapper_opacity', 'header_wrapper_image', 'header_wrapper_position_x', 'header_wrapper_position_y', 'header_wrapper_repeat', 'header_wrapper_attachment', function( value ) {
		value.bind( function( to ) {
			$( '#header' ).css( 'background', to );
		} );
	} );
	
	// Navigation menu wrapper
	wp.customize( 'nav_wrapper_color', 'nav_wrapper_opacity', 'nav_wrapper_image', 'nav_wrapper_position_x', 'nav_wrapper_position_y', 'nav_wrapper_repeat', 'nav_wrapper_attachment', function( value ) {
		value.bind( function( to ) {
			$( '#sub-head, .entry-content .contact-form' ).css( 'background', to );
		} );
	} );
	
	// Content wrapper
	wp.customize( 'content_wrapper_color', 'content_wrapper_opacity', 'content_wrapper_image', 'content_wrapper_position_x', 'content_wrapper_position_y', 'content_wrapper_repeat', 'content_wrapper_attachment', function( value ) {
		value.bind( function( to ) {
			$( '#main-content, #secondary .widget h3 span, .archive-header .archive-title span, .search-header .search-title span, .entry-content .search-header .search-title span, .recent-posts-header .recent-posts-heading span, .featured-header .featured-heading span' ).css( 'background', to );
		} );
	} );
	
	// Footer Sidebar wrapper
	wp.customize( 'footer_sidebar_wrapper_color', 'footer_sidebar_wrapper_opacity', 'footer_sidebar_wrapper_image', 'footer_sidebar_wrapper_position_x', 'footer_sidebar_wrapper_position_y', 'footer_sidebar_wrapper_repeat', 'footer_sidebar_wrapper_attachment', function( value ) {
		value.bind( function( to ) {
			$( '#sidebar-footer, #sidebar-front-page' ).css( 'background', to );
		} );
	} );
	
	// Footer wrapper
	wp.customize( 'footer_wrapper_color', 'footer_wrapper_opacity', 'footer_wrapper_image', 'footer_wrapper_position_x', 'footer_wrapper_position_y', 'footer_wrapper_repeat', 'footer_wrapper_attachment', function( value ) {
		value.bind( function( to ) {
			$( '#footer' ).css( 'background', to );
		} );
	} );
	
	// Slider wrapper
	wp.customize( 'slider_wrapper_color', 'slider_wrapper_opacity', 'slider_wrapper_image', 'slider_wrapper_position_x', 'slider_wrapper_position_y', 'slider_wrapper_repeat', 'slider_wrapper_attachment', function( value ) {
		value.bind( function( to ) {
			$( '#showcase-slider' ).css( 'background', to );
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
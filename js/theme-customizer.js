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
	wp.customize( 'menu_text_shadow', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation li a' ).html( to );
		} );
	} );
	wp.customize( 'footer_sidebar_shadow', function( value ) {
		value.bind( function( to ) {
			$( '#sidebar-homepage #supplementary .widget .textwidget', '#sidebar-homepage #supplementary .widget-title', '#sidebar-homepage #supplementary .widget p' ).html( to );
		} );
	} );
	wp.customize( 'homepage_sidebar_shadow', function( value ) {
		value.bind( function( to ) {
			$( '#sidebar-homepage #supplementary .widget .textwidget', '#sidebar-homepage #supplementary .widget-title', '#sidebar-homepage #supplementary .widget p' ).html( to );
		} );
	} );
	
	// Hook into background color change and adjust body class value as needed.
	wp.customize( 'background_color', function( value ) {
		value.bind( function( to ) {
			if ( '#ffffff' == to || '#fff' == to || '' == to )
				$( 'body' ).addClass( 'custom-background-white' );
			else if ( '' == to )
				$( 'body' ).addClass( 'custom-background-empty' );
			else
				$( 'body' ).removeClass( 'custom-background-empty custom-background-white' );
		} );
	} );
} )( jQuery );
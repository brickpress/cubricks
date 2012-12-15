/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
( function() {
	var button = document.getElementById( 'site-navigation', 'top-navigation' ).getElementsByTagName( 'h3' )[0],
	    menu   = document.getElementById( 'site-navigation', 'top-navigation' ).getElementsByTagName( 'ul' )[0];
		
	if ( undefined === button )
		return false;

	// Hide button if menu is missing or empty.
	if ( undefined === menu || ! menu.childNodes.length ) {
		button.style.display = 'none';
		return false;
	}

	button.onclick = function() {
		if ( -1 == menu.className.indexOf( 'nav-menu' ) )
			menu.className = 'nav-menu';

		if ( -1 != button.className.indexOf( 'toggled-on' ) ) {
			button.className = button.className.replace( ' toggled-on', '' );
			menu.className = menu.className.replace( ' toggled-on', '' );
		
		} else {
			button.className += ' toggled-on';
			menu.className += ' toggled-on';
		}
	};	
} )();


( function() {
	var topButton = document.getElementById( 'top-navigation' ).getElementsByTagName( 'h3' )[0],
	    topMenu   = document.getElementById( 'top-navigation' ).getElementsByTagName( 'ul' )[0];
		
	if ( undefined === topButton )
		return false;

	// Hide button if menu is missing or empty.
	if ( undefined === topMenu || ! topMenu.childNodes.length ) {
		topButton.style.display = 'none';
		return false;
	}
	
	topButton.onclick = function() {
		if ( -1 == topMenu.className.indexOf( 'nav-menu' ) )
			topMenu.className = 'nav-menu';

		if ( -1 != topButton.className.indexOf( 'toggled-on' ) ) {
			topButton.className = topButton.className.replace( ' toggled-on', '' );
			topMenu.className = topMenu.className.replace( ' toggled-on', '' );
		
		} else {
			topButton.className += ' toggled-on';
			topMenu.className += ' toggled-on';
		}
	};
	
} )();
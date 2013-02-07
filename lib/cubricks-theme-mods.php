<?php
/**
 * Cubricks Theme deault theme mods.
 *
 * @package     Cubricks Theme
 * @subpackage  Cubricks Theme Customizer
 * @author      Raphael Villanea <raphael@cubrick.us>
 * @copyright   Copyright (c) 2012, Raphael Villanea
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @since Cubricks 1.0.6
 */

/**
 * Initializes theme mods.
 *
 * @uses get_theme_mod
 *
 * @since Cubricks 1.0.6
 */
function cubricks_initialize_theme_mods() {
		
	$theme_mods = cubricks_theme_mods();
	
	if( ! isset($theme_mods) ) {
		foreach( $theme_mods as $theme_mod => $default ) {
			set_theme_mod( $theme_mod, $default );
		}
	}
}
add_action( 'admin_init', 'cubricks_initialize_theme_mods' );


/**
 * An array of default theme_mods for our theme.
 *
 * @uses   get_theme_mod
 * @return array
 * 
 * @since 1.0.6
 */
function cubricks_theme_mods() {
	
	return array(
		'cubricks_page_width'	  => '1024',
	    'page_layout'             => 'full-wide',
		'page_top_margin'         => '48',
		'header_nav_primary'      => false,
		'site_logo'               => '',
		// Featured Posts Slider
		'slider_position'         => 'after_header',
		'large_slider_width'      => '1400',
		'large_slider_height'     => '518',
		'slider_timer'            => '5',
		'slider_effects'          => 'fade',
		'slider_items'            => '10',
		'slider_caption_color'    => '#FFFFFF',
		'slider_caption_bg'       => '#000000',
		'slider_caption_opacity'  => '6',
		// Site and Tagline
		'header_textcolor'        => get_theme_support( 'custom-header', 'default-text-color' ),
		'header_text_shadow'      => '#6F94BC',
		// Text Colors
		'primary_text_color'      => '#444444',
		'secondary_text_color'    => '#757575',
		'link_color'		      => '#21759B',
		'link_hover'		      => '#F1831E',
		'post_entry_titles'       => '#1E598E',
		'post_entry_headers'      => '#357AE8',
		'sidebar_title_color'     => '#757575',
		'sidebar_link_color'      => '#336699',
		'footer_sidebar_text'     => '#474747',
		'footer_sidebar_link'     => '#1E598E',
		'footer_sidebar_shadow'   => '#FFFFFF',
		'footer_text_color'       => '#F5F5F5',
		'footer_link_color'       => '#F7F7F7',
		// Section Wrappers
		// Custom Background
		'background_color'      => get_theme_support( 'custom-background', 'default-color' ),
		'background_opacity'    => '10',
		'background_image'      => get_theme_support( 'custom-background', 'default-image' ),
		'background_repeat'     => 'repeat',
		'background_position_x' => '0',
		'background_position_y' => '0',
		'background_attachment' => 'scroll',
		// Page Wrapper
		'page_wrapper_color'      => '#FFFFFF',
		'page_wrapper_opacity'    => '10',
		'page_wrapper_image'      => '',
		'page_wrapper_repeat'     => 'repeat',
		'page_wrapper_position_x' => '0',
		'page_wrapper_position_y' => '0',
		'page_wrapper_attachment' => 'scroll',
		// Header Wrapper
		'header_wrapper_color'      => '#638EBC',
		'header_wrapper_opacity'    => '10',
		'header_wrapper_image'      => '',
		'header_wrapper_repeat'     => 'repeat-x',
		'header_wrapper_position_x' => '0',
		'header_wrapper_position_y' => '50',
		'header_wrapper_attachment' => 'scroll',
		// Navigation Wrapper
		'nav_wrapper_color'	      => '#E3EDF4',
		'nav_wrapper_opacity'     => '10',
		'nav_wrapper_image'	      => '',
		'nav_wrapper_repeat'      => 'repeat-x',
		'nav_wrapper_position_x'  => '0',
		'nav_wrapper_position_y'  => '50',
		'nav_wrapper_attachment'  => 'scroll',
		// Content Wrapper
		'content_wrapper_color'      => '#FFFFFF',
		'content_wrapper_opacity'    => '10',
		'content_wrapper_image'      => get_template_directory_uri() . '/images/content-bg.png',
		'content_wrapper_repeat'     => 'repeat',
		'content_wrapper_position_x' => '0',
		'content_wrapper_position_y' => '0',
		'content_wrapper_attachment' => 'scroll',
		// Footer Sidebar Wrapper and Homepage Sidebar Wrapper
		'footer_sidebar_wrapper_color'      => '#E3EDF4',
		'footer_sidebar_wrapper_opacity'    => '10',
		'footer_sidebar_wrapper_image'      => '',
		'footer_sidebar_wrapper_repeat'     => 'repeat',
		'footer_sidebar_wrapper_position_x' => '0',
		'footer_sidebar_wrapper_position_y' => '0',
		'footer_sidebar_wrapper_attachment' => 'scroll',
		// Footer Wrapper
		'footer_wrapper_color' 	    => '#1E598E',
		'footer_wrapper_opacity'    => '10',
		'footer_wrapper_image' 	    => '',
		'footer_wrapper_repeat'     => 'repeat-x',
		'footer_wrapper_position_x' => '0',
		'footer_wrapper_position_y' => '50',
		'footer_wrapper_attachment' => 'scroll',
		// Featured Slider Wrapper
		'slider_wrapper_color'	    => '#FFFFFF',
		'slider_wrapper_opacity'    => '10',
		'slider_wrapper_image'	    => get_template_directory_uri() . '/images/content-bg.png',
		'slider_wrapper_repeat'     => 'repeat',
		'slider_wrapper_position_x' => '0',
		'slider_wrapper_position_y' => '0',
		'slider_wrapper_attachment' => 'scroll',
		// Navigation
		'main_menu_text'          => '#1E598E',
		'menu_current_page'       => '#333333',
		'menu_children'           => '#ECEEF5',
		'menu_hover_background'   => '#F5F5F5',
		'menu_text_shadow'        => '#FFFFFF',
		'header_menu_hover'       => '#DD4B39',
		// Front Page
		'front_page_slider'         => true,
		'front_page_text_size'      => '26',
		'front_page_content_text'   => '#757575',
		'front_page_content_shadow' => '#FFFFFF',
		'front_page_sidebar_text'   => '#0B3C63',
		'front_page_sidebar_shadow' => '#FFFFFF',
		// Reset Theme Mods
		'reset_theme'		        => false
	);
}


/**
 * Returns the default value of a theme_mod.
 *
 * @uses    get_theme_mod
 * @uses    cubricks_theme_mods
 * @param   string  $mod_name (theme_mod name)
 * @return 	string	$value (Returns default value for theme_mod)
 *
 * @since 1.0.6
 */
function cubricks_defaults( $mod_name ) {
	
	$theme_mods = cubricks_theme_mods();
	foreach( $theme_mods as $theme_mod => $value ) {
		if( $mod_name == $theme_mod )
			return $value;
	}
}


/**
 * Resets theme layout, colors, featured slider size to defaults.
 *
 * It does not reset text entries such as copyright notice and
 * social links.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.6
 */
function cubricks_reset_theme() {
	
	$cubricks_mods = cubricks_theme_mods();
	if( get_theme_mod('reset_theme') ) {
		foreach( $cubricks_mods as $mod_name => $value ) {
			set_theme_mod( $mod_name, $value );
		}
	}
}
add_action( 'after_setup_theme', 'cubricks_reset_theme' );


/**
 * Convert a hexadecimal color code to its RGB equivalent
 *
 * @param	string	$hexStr (hexadecimal color value)
 * @param	boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
 * @param	string 	$seperator (to separate RGB values. Applicable only if second parameter is true.)
 * @return 	array or string (depending on second parameter. Returns False if invalid hex color value)
 *
 * @since 1.0.0
 */                                                                                           
function hex_to_rgb($hexStr, $returnAsString = true, $seperator = ',') {
	
	$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
	$rgbArray = array();
	if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
		$colorVal = hexdec($hexStr);
		$rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
		$rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
		$rgbArray['blue'] = 0xFF & $colorVal;
	} elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
		$rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
		$rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
		$rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
	} else {
		return false; //Invalid hex color code
	}
	return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}
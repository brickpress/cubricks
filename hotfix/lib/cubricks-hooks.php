<?php
/**
 * Cubricks custom hook functions.
 *
 * @package Cubricks Theme
 * @subpackage Functions
 * @since 1.0.0
 */

/**
 * Navigation menu located at the header.
 * @since 1.0.0
 */
function cubricks_header_menu() {
	do_action( 'cubricks_header_menu' );
}
 
/**
 * Before the site header.
 * @since 1.0.0
 */
function cubricks_before_header() {
	do_action( 'cubricks_before_header' );
}

/**
 * After the site header.
 * @since 1.0.0
 */
function cubricks_after_header() {
	do_action( 'cubricks_after_header' );
}

/**
 * After all the site content has loaded.
 * @since 1.0.0
 */
function cubricks_after_content() {
	do_action( 'cubricks_after_content' );
}

/**
 * At footer, before"Proudly powered by WordPress" is called.
 * @since 1.0.0
 */
function cubricks_credits() {
	do_action( 'cubricks_credits' );
}
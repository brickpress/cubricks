<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Cubricks Theme
 *
 * @since Cubricks 1.0.0
 */
?><!DOCTYPE html>
<!--[if IE 7 | IE 8]>
<html class="ie" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
<?php if( is_page_template('page-templates/showcase.php') && get_theme_mod('slider_position') == 'before_header' || is_page_template('page-templates/homepage.php') && get_theme_mod('slider_position') == 'before_header' )
		cubricks_showcase_slider(); ?>
    <div id="header" class="wrapper">
        <header id="masthead" class="site-header inner" role="banner">
        	<?php if( '' != get_theme_mod('site_logo') ) : ?>
				<a class="site-logo" href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo get_theme_mod('site_logo'); ?>" alt="<?php esc_attr_e( 'Site Logo', 'cubricks' ); ?>" /></a>
            <?php endif; ?>
            <hgroup>
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
            </hgroup>
            <?php cubricks_header_nav(); ?>
            <?php cubricks_custom_header(); ?>
        </header><!-- #masthead .inner -->
    </div><!-- #header .wrapper -->
	<?php //cubricks_custom_header(); ?>
    <div id="sub-head" class="wrapper">
    <?php if( false == get_theme_mod('header_nav_primary') )
    		cubricks_nav_menu(); ?>
    </div><!-- #sub-head .inner -->
    <?php if( is_page_template('page-templates/showcase.php') && get_theme_mod('slider_position') == 'after_header' || is_page_template('page-templates/homepage.php') && get_theme_mod('slider_position') == 'after_header' )
          cubricks_showcase_slider(); ?>
    <div id="main-content" class="wrapper">
        <div id="main" class="inner">
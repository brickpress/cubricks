<?php
/**
 * Renders the Cubricks theme_mods.
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
 * Adds social media icons before the footer sidebars.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
 
/**
 * Add style blocks to the theme.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since 1.0.6
 */
function cubricks_print_styles() {
	
	cubricks_text_colors();
	cubricks_page_wrapper();
	cubricks_header_wrapper();
	cubricks_nav_wrapper();
	cubricks_content_wrapper();
	cubricks_footer_sidebar_wrapper();
	cubricks_footer_wrapper();
	cubricks_slider_wrapper();
	cubricks_page_layout();
	cubricks_header_layout_fix();
	cubricks_large_slider_size();
	cubricks_menu_colors();
	cubricks_front_page_colors();
}
add_action( 'wp_head', 'cubricks_print_styles' );


/**
 * Adds a style block to modify the theme's text color.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.6
 */
function cubricks_text_colors() {
	
	$primary_text_color = get_theme_mod('primary_text_color');
	$secondary_text_color = get_theme_mod('secondary_text_color');
	$link_color = get_theme_mod('link_color');
	$link_hover = get_theme_mod('link_hover');
	$post_entry_titles = get_theme_mod('post_entry_titles');
	$post_entry_headers = get_theme_mod('post_entry_headers');
	$slider_caption_bg = get_theme_mod('slider_caption_bg');
	$slider_caption_color = get_theme_mod('slider_caption_color');
	$sidebar_title_color = get_theme_mod('sidebar_title_color');
	$sidebar_link_color = get_theme_mod('sidebar_link_color');
	$footer_text_color = get_theme_mod('footer_text_color');
	$footer_link_color = get_theme_mod('footer_link_color');
	$footer_sidebar_text = get_theme_mod('footer_sidebar_text');
	$footer_sidebar_link = get_theme_mod('footer_sidebar_link');
	$footer_sidebar_shadow = get_theme_mod('footer_sidebar_shadow');
	$header_text_shadow = get_theme_mod('header_text_shadow');
	?>
	<style id="text-colors-css" type="text/css">
	<?php if( $primary_text_color != cubricks_defaults('primary_text_color') ) : ?>
		body,
		.main-navigation li ul li a:hover,
		.template-front-page .entry-content .sd-title,
		.entry-content .contact-form label {
			color: <?php echo $primary_text_color; ?>;
		}
	<?php endif; ?>
	<?php if( $secondary_text_color != cubricks_defaults('secondary_text_color') ) : ?>
		.menu-toggle:active,
		.menu-toggle.toggled-on,
		input[type="submit"]:active,
		article.post-password-required input[type=submit]:active,
		input[type="submit"].toggled-on,
		.wp-caption .wp-caption-text,
		.gallery-caption,
		.entry-caption,
		.author-description p,
		article.sticky .featured-post,
		.comments-area article header cite a,
		.entry-content table,
		.comment-content table,
		footer.entry-meta,
		.post-topics,
		.post-topics a,
		.read-more,
		.read-more a,
		.archive-meta,
		.format-status .entry-header header a,
		#secondary .widget .textwidget,
		article.format-quote .entry-content cite,
		article.format-quote .entry-content cite a,
		.entry-content .cubricks-chat .chat-even,
		#secondary .widget .textwidget,
		#secondary .widget p,
		#secondary .widget #calendar_wrap table,
		.entry-content .contact-form label span,
		.entry-header h4.author-url a {
			color: <?php echo $secondary_text_color; ?>;
		}
	<?php endif; ?>
	<?php if( $link_color != cubricks_defaults('link_color') ) : ?>
		a,
		.entry-meta a,
		.read-more a span,
		.author-link a {
			color: <?php echo $link_color; ?>;
		}
	<?php endif; ?>
	<?php if( $link_hover != cubricks_defaults('link_hover') ) : ?>
		a:hover,
		.entry-meta a:hover,
		.post-topics a:hover,
		a.post-edit-link:hover,
		.format-status .entry-header header a:hover,
		.comments-area article header a:hover,
		a.comment-reply-link:hover,
		.template-front-page .widget-area .widget li a:hover,
		.entry-header .entry-title a:hover,
		.entry-header .entry-title a:hover,
		.entry-header h4.author-url a:hover,
		.author-link a:hover {
			color: <?php echo $link_hover; ?>;
		}
	<?php endif; ?>
	<?php if( $post_entry_titles != cubricks_defaults('post_entry_titles') ) : ?>
		.entry-header .entry-title a,
		article.format-quote .entry-content blockquote:before,
		article.format-quote .entry-content blockquote {
			color: <?php echo $post_entry_titles; ?>;
		}
	<?php endif; ?>
	<?php if( $post_entry_headers != cubricks_defaults('post_entry_headers') ) : ?>
		.entry-content h1, .comment-content h1,
		.entry-content h2, .comment-content h2,
		.entry-content .cubricks-chat .chat-even strong,
		div.sharedaddy, #content div.sharedaddy, #main div.sharedaddy {
			color: <?php echo $post_entry_headers; ?>;
		}
		article.format-standard .entry-content blockquote,
		.comment-content blockquote {
			background: rgba(<?php echo hex_to_rgb($post_entry_headers); ?>,0.2);
		}
		article.format-standard .entry-content blockquote:before,
		.comment-content blockquote:before {
			color: rgba(<?php echo hex_to_rgb($post_entry_headers); ?>,0.7);
		}
	<?php endif; ?>
	<?php if( $sidebar_title_color != cubricks_defaults('sidebar_title_color') ) : ?>
		#secondary .widget-title,
		#secondary .widget-title > span a,
		.archive-header .archive-title span,
		.search-header .search-title span,
		.entry-content .search-header .search-title span,
		.recent-posts-header .recent-posts-heading span,
		.featured-header .featured-heading span,
		#social-links-label h1 {
			color: <?php echo $sidebar_title_color; ?>;
		}
		#secondary .widget h3,
		.archive-header .archive-title,
		.search-header .search-title,
		.entry-content .search-header .search-title,
		.recent-posts-header .recent-posts-heading,
		.featured-header .featured-heading {
			background: rgba(<?php echo hex_to_rgb($sidebar_title_color); ?>,0.3);
		}
	<?php endif; ?>
	<?php if( $sidebar_link_color != cubricks_defaults('sidebar_link_color') ) : ?>
		#secondary .widget a,
		#secondary .widget a:hover,
		#secondary .widget .tagcloud {
			color: <?php echo $sidebar_link_color; ?>;
		}
	<?php endif; ?>
	<?php if( $footer_text_color != cubricks_defaults('footer_text_color') ) : ?>
		footer[role="contentinfo"],
		footer[role="contentinfo"] p {
			color: <?php echo $footer_text_color; ?>;
		}
	<?php endif; ?>
	<?php if( $footer_link_color != cubricks_defaults('footer_link_color') ) : ?>
		footer[role="contentinfo"] a,
		footer[role="contentinfo"] a:hover {
			color: <?php echo $footer_link_color; ?>;
		}
	<?php endif; ?>
	#showcase-slider .nivo-caption, #content-slider .nivo-caption {
		background: rgba( <?php echo hex_to_rgb($slider_caption_bg) .','. get_theme_mod('slider_caption_opacity') / 10; ?>);
		color: <?php echo $slider_caption_color; ?>;
		padding-left: <?php echo 0 == get_theme_mod('slider_caption_opacity') ? '0' : '10px'; ?>;
	}
	#supplementary .widget .textwidget,
	#supplementary .widget-title,
	#supplementary .widget .widget-title a,
	#supplementary .widget p,
	#supplementary .widget #calendar_wrap table {
		color: <?php echo $footer_sidebar_text; ?>;
		text-shadow: 1px 1px 0 <?php echo $footer_sidebar_shadow; ?>;
	}
	#supplementary .widget a,
	#supplementary .widget a:hover,
	.template-front-page #supplementary .widget li a,
	.template-front-page #supplementary .widget li a:hover,
	#supplementary .widget .tagcloud {
		color: <?php echo $footer_sidebar_link; ?>;
		text-shadow: 1px 1px 0 <?php echo $footer_sidebar_shadow; ?>;
	}
	/* Minimum width of 600 pixels. */
	@media screen and (min-width: 600px) {
		.header-navigation li a,
		.header-navigation li a:hover,
		.site-title,
		.site-description {
			text-shadow: 1px 1px 0 <?php echo $header_text_shadow; ?>;
		}
	}
	</style>
    <?php
}


/**
 * Adds a style block to modify the page container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_page_wrapper() {
	
	$color    = get_theme_mod('page_wrapper_color');
	$opacity  = get_theme_mod('page_wrapper_opacity');
	$bg_image = get_theme_mod('page_wrapper_image');
	$default_color    = cubricks_defaults('page_wrapper_color');
	$default_opacity  = cubricks_defaults('page_wrapper_opacity');
	$default_bg_image = cubricks_defaults('page_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color . $opacity;
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color);
			$opacity = ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'page_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'page_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'page_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'page_wrapper_attachment' ). ';';
			$style = $color . $opacity . $image . $position_x . $position_y . $repeat . $attachment;	
		}	
	}
	?><style type="text/css" id="page-wrapper-css">
		#page { <?php echo trim( $style ); ?> }
	</style><?php
}


/*
 * Adds a style block to modify the header container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_header_wrapper() {
	
	$color    = get_theme_mod('header_wrapper_color');
	$opacity  = get_theme_mod('header_wrapper_opacity');
	$bg_image = get_theme_mod('header_wrapper_image');
	$default_color    = cubricks_defaults('header_wrapper_color');
	$default_opacity  = cubricks_defaults('header_wrapper_opacity');
	$default_bg_image = cubricks_defaults('header_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color .$opacity;
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color). ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'header_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'header_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'header_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'header_wrapper_attachment' ). ';';
			$style = $color . $image . $position_x . $position_y . $repeat . $attachment;	
		}	
	}
	?><style type="text/css" id="header-wrapper-css">
		#header { <?php echo trim( $style ); ?> }
	</style><?php
}


/**
 * Adds a style block to modify the nav container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_nav_wrapper() {
	
	$color    = get_theme_mod('nav_wrapper_color');
	$opacity  = get_theme_mod('nav_wrapper_opacity');
	$bg_image = get_theme_mod('nav_wrapper_image');
	$default_color    = cubricks_defaults('nav_wrapper_color');
	$default_opacity  = cubricks_defaults('nav_wrapper_opacity');
	$default_bg_image = cubricks_defaults('nav_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color .$opacity;
				$color_style = $color. ',1);';
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color);
			$opacity = ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'nav_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'nav_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'nav_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'nav_wrapper_attachment' ). ';';
			$style = $color . $opacity . $image . $position_x . $position_y . $repeat . $attachment;
			$color_style = $color. ',1);';
		}	
	}
	?><style type="text/css" id="nav-wrapper-css">
		#sub-head, .entry-content .contact-form, .main-navigation li ul li a { <?php echo trim( $color_style ); ?> }
		/* Minimum width of 600 pixels. */
		@media screen and (min-width: 600px) {
			#sub-head { <?php echo trim( $style ); ?> }
		}
	</style><?php
}


/**
 * Adds a style block to modify the main content container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_content_wrapper() {
	
	$color    = get_theme_mod('content_wrapper_color');
	$opacity  = get_theme_mod('content_wrapper_opacity');
	$bg_image = get_theme_mod('content_wrapper_image');
	$default_color    = cubricks_defaults('content_wrapper_color');
	$default_opacity  = cubricks_defaults('content_wrapper_opacity');
	$default_bg_image = cubricks_defaults('content_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color . $opacity;
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color);
			$opacity = ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'content_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'content_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'content_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'content_wrapper_attachment' ). ';';
			$style = $color . $opacity . $image . $position_x . $position_y . $repeat . $attachment;
		}	
	}
	// If Page Layout is post boxes
	if( get_theme_mod('page_layout') == 'post-boxes' ) : ?>
    <style type="text/css" id="content-wrapper-css">
		body.post-boxes #content > article, body.post-boxes #secondary .widget, body.post-boxes #secondary .widget h3 span, .search-header .search-title span, .entry-content .search-header .search-title span, body.post-boxes .nav-single, body.post-boxes #comments { <?php echo trim( $style ); ?> }
	</style><?php
	// If Page Layout is full-wide or page-centered
	else : ?>
    <style type="text/css" id="content-wrapper-css">
		#main-content, #secondary .widget h3 span, .archive-header .archive-title span, .search-header .search-title span, .entry-content .search-header .search-title span, .recent-posts-header .recent-posts-heading span, .featured-header .featured-heading span { <?php echo trim( $style ); ?> }
	</style><?php
	endif;
}


/**
 * Adds a style block to modify the footer sidebar container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_footer_sidebar_wrapper() {
	
	$color    = get_theme_mod('footer_sidebar_wrapper_color');
	$opacity  = get_theme_mod('footer_sidebar_wrapper_opacity');
	$bg_image = get_theme_mod('footer_sidebar_wrapper_image');
	$default_color    = cubricks_defaults('footer_sidebar_wrapper_color');
	$default_opacity  = cubricks_defaults('footer_sidebar_wrapper_opacity');
	$default_bg_image = cubricks_defaults('footer_sidebar_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color . $opacity;
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color);
			$opacity = ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'footer_sidebar_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'footer_sidebar_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'footer_sidebar_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'footer_sidebar_wrapper_attachment' ). ';';
			$style = $color . $opacity . $image . $position_x . $position_y . $repeat . $attachment;	
		}	
	}
	?><style type="text/css" id="footer_sidebar-wrapper-css">
		#sidebar-footer, #sidebar-front-page { <?php echo trim( $style ); ?> }
	</style><?php
}


/**
 * Adds a style block to modify the footer container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_footer_wrapper() {
	
	$color    = get_theme_mod('footer_wrapper_color');
	$opacity  = get_theme_mod('footer_wrapper_opacity');
	$bg_image = get_theme_mod('footer_wrapper_image');
	$default_color    = cubricks_defaults('footer_wrapper_color');
	$default_opacity  = cubricks_defaults('footer_wrapper_opacity');
	$default_bg_image = cubricks_defaults('footer_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color . $opacity;
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color);
			$opacity = ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'footer_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'footer_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'footer_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'footer_wrapper_attachment' ). ';';
			$style = $color . $opacity . $image . $position_x . $position_y . $repeat . $attachment;	
		}	
	}
	?><style type="text/css" id="footer-wrapper-css">
		#footer { <?php echo trim( $style ); ?> }
	</style><?php
}


/**
 * Adds a style block to modify the featured slider container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_slider_wrapper() {
	
	$color    = get_theme_mod('slider_wrapper_color');
	$opacity  = get_theme_mod('slider_wrapper_opacity');
	$bg_image = get_theme_mod('slider_wrapper_image');
	$default_color    = cubricks_defaults('slider_wrapper_color');
	$default_opacity  = cubricks_defaults('slider_wrapper_opacity');
	$default_bg_image = cubricks_defaults('slider_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color . $opacity;
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color);
			$opacity = ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'slider_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'slider_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'slider_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'slider_wrapper_attachment' ). ';';
			$style = $color . $opacity . $image . $position_x . $position_y . $repeat . $attachment;	
		}	
	}
	?><style type="text/css" id="slider-wrapper-css">
		#showcase-slider { <?php echo trim( $style ); ?> }
	</style><?php
}


/**
 * Adjusts page top-margin when using page-centered page_layout.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.6
 */
function cubricks_page_layout() {
	
	$page_layout = get_theme_mod('page_layout');
	$page_top_margin = get_theme_mod('page_top_margin');
	$rembase = 14;
	
	if( $page_layout == 'page-centered' ) :	
		if( cubricks_defaults('page_top_margin') != $page_top_margin ) : ?>
        <style type="text/css">
		body.page-centered .site {
			margin-top: <?php echo $page_top_margin; ?>px;
			margin-top: <?php echo ($page_top_margin / $rembase) ; ?>rem;
		}
		</style>
		<?php endif;
	endif;
}


/**
 * Fixes Site title and site logo margin when using
 * page-centered page_layout.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.6
 */
function cubricks_header_layout_fix() {
	
	$page_layout = get_theme_mod('page_layout');
	$site_logo = get_theme_mod('site_logo');
	
	if( $page_layout == 'page-centered' ) : 
		if( cubricks_defaults('site_logo') != $site_logo ) : ?>
        <style type="text/css">
		body.page-centered #masthead hgroup,
		body.page-centered #masthead .site-logo {
			margin-left: 24px;
			margin-left: 1.714285714rem;
		}
		/* Minimum width of 1024 pixels. */
		@media screen and (min-width: 1024px) {
			body.page-centered #masthead hgroup {
				margin-left: 0;
			}
			body.page-centered #masthead .site-logo {
				margin-left: 40px;
				margin-left: 2.857142857rem;
			}
		}
		</style>
		<?php endif;		
	endif;
}


/**
 * Modifies the large featured slider dimensions.
 * @uses get_theme_mod
 *
 * @since 1.0.6 
 */
function cubricks_large_slider_size() {
	
	$large_slider_width = get_theme_mod('large_slider_width');
	$large_slider_height = round( $large_slider_width / 2.702 );
	$rembase = 14;

	if( cubricks_defaults('large_slider_width') != $large_slider_width ) : ?>
    	<style type="text/css">
			#showcase-slider #slider-wrapper,
			#showcase-slider .nivoSlider {
				max-width: <?php echo $large_slider_width; ?>px;
				max-width: <?php echo ($large_slider_width / $rembase); ?>rem;
				max-height: <?php echo $large_slider_height; ?>px;
				max-height: <?php echo ($large_slider_height / $rembase); ?>rem;
			}
		</style>
	<?php endif;
}


/**
 * Adds shadows to selected text elements.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.6
 */
function cubricks_menu_colors() {
	?>
	<style id="nav-menu-css" type="text/css">
	.header-navigation li a:hover {
		color: <?php echo get_theme_mod('header_menu_hover'); ?>;
	}
	.main-navigation li a {
		color: <?php echo get_theme_mod('main_menu_text'); ?>;
	}
	.main-navigation li a:hover,
	.main-navigation .current-menu-item > a,
	.main-navigation .current-menu-ancestor > a  {
		color: <?php echo get_theme_mod('menu_current_page'); ?>;
	}
	#comments #respond {
		background: <?php echo get_theme_mod('menu_hover_background'); ?>;
	}
	/* Minimum width of 600 pixels. */
	@media screen and (min-width: 600px) {
		.main-navigation li a {
			text-shadow: 1px 1px 0 <?php echo get_theme_mod('menu_text_shadow'); ?>;
		}
		.main-navigation li ul li a:hover {
			background: <?php echo get_theme_mod('menu_hover_background'); ?>;
		}
	}
    </style>
    <?php
}


/**
 * Adds shadows to selected text elements.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.6
 */
function cubricks_front_page_colors() {
	?>
	<style id="front-page-css" type="text/css">
	.template-front-page .entry-content {
		color: <?php echo get_theme_mod('front_page_content_text'); ?>;
		text-shadow: 1px 1px 0 <?php echo get_theme_mod('front_page_content_shadow'); ?>;
	}
	#sidebar-front-page #supplementary .widget .textwidget,
	#sidebar-front-page #supplementary .widget-title,
	#sidebar-front-page #supplementary .widget p {
		color: <?php echo get_theme_mod('front_page_sidebar_text'); ?>;
		text-shadow: 1px 1px 0 <?php echo get_theme_mod('front_page_sidebar_shadow'); ?>;
	}
    </style>
    <?php
}


/**
 * Cubricks custom background callback.
 *
 * @since 1.0.6
 */
function cubricks_custom_background_cb() {
	
	$color = get_theme_mod( 'background_color' );
	$opacity = get_theme_mod( 'background_opacity' );
	$background = get_theme_mod( 'background_image' );

	if ( ! $background && ! $color )
		return;

	$style = cubricks_defaults('background_opacity') != $opacity ? 'background: rgba(' .hex_to_rgb($color). ',' .$opacity. ');' : 'background: rgb(' .hex_to_rgb($color). ');';
	
	if( $background ) {
		$color = 'background: rgba(' .hex_to_rgb($color). ',' .($opacity/10). ')';
		$image = ' url(' .esc_url($background). ')';
		$position_x = ' ' .get_theme_mod( 'background_position_x' ). '%';
		$position_y = ' ' .get_theme_mod( 'background_position_y' ). '%';
		$repeat = ' ' .get_theme_mod( 'background_repeat' );
		$attachment = ' ' . get_theme_mod( 'background_attachment' ). ';';
		
		$style = $color . $image . $position_x . $position_y . $repeat . $attachment;
	}
	?>
	<style type="text/css" id="custom-background-css">
        body.custom-background { <?php echo trim( $style ); ?> }
    </style>
	<?php
}


function cubricks_social_links() {
	
	$facebook_id = get_theme_mod( 'facebook_id' );
	$twitter_id = get_theme_mod( 'twitter_id' );
	$google_id = get_theme_mod( 'google_id' );
	$youtube_id = get_theme_mod( 'youtube_id' );
	$flickr_id = get_theme_mod( 'flickr_id' );
	$tumblr_id = get_theme_mod( 'tumblr_id' );
	
	if( '' == $facebook_id && '' == $twitter_id && '' == $google_id && '' == $youtube_id && '' == $flickr_id && '' == $tumblr_id )
		return;
		
	$social_links_label = get_theme_mod('social_links_label'); ?>
	<div id="social-links">
        <div id="social-links-label">
            <h1>
            <?php echo $social_links_label; ?>
            </h1>
        </div>
        <div id="social-media-links" class="dark_round">
          <ul>
            <?php if( '' != $facebook_id ) : ?>     
            <li class="facebook"><a href="<?php echo esc_url( 'http://www.facebook.com/' . esc_attr($facebook_id) ); ?>" title="<?php _e( 'Follow me on Facebook', 'cubricks' ); ?>" target="_blank"></a></li>
            <?php endif; ?>
            
            <?php if( '' != $twitter_id ) : ?>
            <li class="twitter"><a href="<?php echo esc_url( 'http://www.twitter.com/' . $twitter_id ); ?>" title="<?php _e( 'Follow me on Twitter', 'cubricks' ); ?>" target="_blank"></a></li>
            <?php endif; ?>
    
            <?php if( '' != $google_id ) : ?>
            <li class="google"><a href="<?php echo esc_url( 'http://plus.google.com/' . $google_id ); ?>" title="<?php _e( 'Add me to your circles', 'cubricks' ); ?>" target="_blank"></a></li>
            <?php endif; ?>
            
            <?php if( '' != $tumblr_id ) : ?>
            <li class="tumblr"><a href="<?php echo esc_url( 'http://' .$tumblr_id. '.tumblr.com/' ); ?>" title="<?php _e( 'Follow me on Tumblr', 'cubricks' ); ?>" target="_blank"></a></li>
            <?php endif; ?>
            
            <?php if( '' != $flickr_id ) : ?>
            <li class="flickr"><a href="<?php echo esc_url( 'http://www.flickr.com/photos/' .$flickr_id ); ?>" title="<?php _e( 'Check out my Flickr photostream', 'cubricks' ); ?>" target="_blank"></a></li>
            <?php endif; ?>
            
            <?php if( '' != $youtube_id ) : ?>     
            <li class="youtube"><a href="<?php echo esc_url( 'http://www.youtube.com/user/' . $youtube_id ); ?>" title="<?php _e( 'Subscribe to my channel on Youtube', 'cubricks' ); ?>" target="_blank"></a></li>
            <?php endif; ?>
          </ul>
          <div class="clearfix"></div>
        </div>
    </div><!-- #social-links -->
	<?php
}
add_action( 'cubricks_after_content', 'cubricks_social_links' );
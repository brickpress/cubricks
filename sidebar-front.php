<?php
/**
 * The sidebar containing the front-page widget areas.
 *
 * If no active widgets in either sidebar, they will be hidden completely.
 *
 * @package WordPress
 * @subpackage Cubricks
 *
 * @since Cubricks 1.0.5
 */

/*
 * The front-page widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if ( ! is_active_sidebar( 'sidebar-h1' ) && ! is_active_sidebar( 'sidebar-h2' ) && ! is_active_sidebar( 'sidebar-h3' ) )
	return;

// If we get this far, we have widgets. Let do this.
?>
<div id="sidebar-front-page" class="wrapper">
	<div id="supplementary" <?php cubricks_front_page_sidebar_class(); ?>>
	
	<?php if ( is_active_sidebar( 'sidebar-h1' ) ) : ?>	    
		<div id="first" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-h1' ); ?>
		</div><!-- #first .widget-area -->
	<?php endif; ?>
	
	<?php if ( is_active_sidebar( 'sidebar-h2' ) ) : ?>
		<div id="second" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-h2' ); ?>
		</div><!-- #second .widget-area -->
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-h3' ) ) : ?>	    
		<div id="third" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-h3' ); ?>
		</div><!-- #third .widget-area -->
	<?php endif; ?>
	</div><!-- #supplementary .inner -->
</div><!-- #sidebar-front-page .wrapper -->
<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Cubricks Theme
 *
 * @since Cubricks 1.0.0
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="search-header">
				<h1 class="search-title"><span><?php printf( __( 'Search Results for: %s', 'cubricks' ), get_search_query() ); ?></span></h1>
			</header>

			<?php cubricks_content_nav( 'nav-above' ); ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content' ); ?>
			<?php endwhile; ?>

			<?php cubricks_content_nav( 'nav-below' );

		else : 
			cubricks_no_posts();		
		endif; ?>
		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
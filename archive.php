<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Cubricks already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Cubricks Theme
 *
 * @since Cubricks 1.0.0
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
        
			<?php cubricks_archive_header(); ?>

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content' ); ?>

		<?php endwhile;

			cubricks_content_nav( 'nav-below' ); ?>

		<?php else : ?>
			<?php cubricks_no_posts(); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
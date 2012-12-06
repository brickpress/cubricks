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

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'cubricks' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>

			<?php cubricks_content_nav( 'nav-above' ); ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content' ); ?>
			<?php endwhile; ?>

			<?php cubricks_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'cubricks' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'cubricks' ); ?></p>
					<?php get_search_form(); ?>
                    
                    <?php the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ), array( 'widget_id' => 'Search' ) ); ?>
				
                    <hr />
                    <div class="widget widget_categories">
                        <h2 class="widgettitle"><?php _e( 'Most Used Categories', 'cubricks' ); ?></h2>
                        <ul>
                        <?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
                        </ul>
                    </div>
                    <hr />
                    
                    <?php
                    /* translators: %1$s: smilie */
                    $archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'cubricks' ), convert_smilies( ':)' ) ) . '</p>';
                    the_widget( 'WP_Widget_Archives', array('count' => 1 , 'dropdown' => 0 ), array( 'after_title' => '</h2>'.$archive_content ) );
                    ?>
                    <hr />
                    
                    <?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
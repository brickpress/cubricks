<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front-page template
 * in Cubricks consists of a page content area for adding text, images, video --
 * anything you’d like -- followed by front-page-only widgets in one, two or three columns.
 *
 * @package Cubricks Theme
 * @subpackage Page Templates
 *
 * @since Cubricks 1.0.5
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
			
			<?php while ( have_posts() ) : the_post(); ?>
               
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
                <div class="entry-content">
                    <?php cubricks_entry_content(); ?>
                    <?php wp_link_pages( cubricks_link_pages_args() ); ?>
                </div><!-- .entry-content -->        
                <div class="clear"></div>
                
                <footer class="entry-meta">
                    <?php edit_post_link( '<span class="edit-icon"></span>'. __( 'Edit', 'cubricks' ), '<span class="edit-link">', '</span>' ); ?>
                </footer>
                <div class="clear"></div>

                <div class="post-shadow">
                    <div class="left-post-shadow"></div>
                    <div class="right-post-shadow"></div>
                </div>
            </article><!-- #post-<?php the_ID(); ?> -->

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
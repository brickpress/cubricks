<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Cubricks Theme
 *
 * @since Cubricks 1.0.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
            <header class="entry-header">
            <?php $post_format = strtolower( get_post_format() );
			if( $post_format == '' || $post_format == 'aside' || $post_format == 'gallery' || $post_format == 'audio' || $post_format == 'chat' || $post_format == 'status' )
				cubricks_post_title(); ?>
			</header>    
            <div class="clear"></div>
             
                <div class="entry-content">
					<?php cubricks_entry_content(); ?>
                    <?php wp_link_pages( cubricks_link_pages_args() ); ?>
                </div><!-- .entry-content -->        
                <div class="clear"></div>
                
           		<?php cubricks_edit_link(); ?>
                <div class="clear"></div>
    
                <div class="post-shadow">
                    <div class="left-post-shadow"></div>
                    <div class="right-post-shadow"></div>
                </div>
			</article><!-- #post-<?php the_ID(); ?> -->
			<?php endwhile; // end of the loop. ?>
			
            <?php comments_template( '', true ); ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
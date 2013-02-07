<?php
/**
 * Template Name: Content Slider Template
 * Description: A Page Template that showcases Sticky Posts using nivoSlider.
 *
 * The content slider template in Cubricks works the same way as the default blog post
 * template. The only difference is that it displays sticky posts in a slider instead of
 * displaying them as individual posts.
 *
 * Compared to the Showcase Template, the Content Slider Template's width is set by the content width.
 * The content slider's location is fixed while that of the Showcase template is customizable.
 *
 * We are creating two queries to fetch the proper posts.
 *
 * @package Cubricks Theme
 * @subpackage Page Templates
 *
 * @since Cubricks 1.0.0
 */
get_header(); ?>

		<div id="primary" class="site-content">
			<div id="content" role="main">
            
			<?php cubricks_featured_slider(); ?>
            <header class="recent-posts-header">
            	<h1 class="recent-posts-heading"><span><?php _e( 'Recent Posts', 'cubricks' ); ?></span></h1>
			</header>
            <?php
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		
            $args = array(
                'orderby'             => 'date',
                'order'               => 'DESC',
                'paged'               => $paged,
                'post__not_in'        => get_option( 'sticky_posts' )
            );
            
            $temp = $wp_query;              // assign orginal query to temp variable for later use  
            $wp_query = null;

            // Our new query for the Recent Posts section.
            $wp_query = new WP_Query( $args );

            // The first Recent post is displayed normally
            if ( have_posts() ) :

				while ( $wp_query->have_posts() ) : $wp_query->the_post();
					// Set $more to 0 in order to only get the first part of the post.
					global $more;
					$more = 0;
					    
                get_template_part( 'content' ); ?>
            
            	<?php endwhile; ?>
            
            <?php cubricks_content_nav(); ?>
					
            <?php endif; ?>

			<?php $wp_query = $temp; //reset back to original query ?>

            </div><!-- #content -->
        </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
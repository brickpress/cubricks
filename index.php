<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Cubricks Theme
 *
 * @since Cubricks 1.0.0
 */
get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
		<?php /* Start the Loop */ ?>
        <?php if ( have_posts() ) : ?>
        
        <?php while ( have_posts() ) : the_post(); ?>
        
            <?php get_template_part( 'content' ); ?>
        
        <?php endwhile; ?>
    
        <?php cubricks_content_nav( 'nav-below' ); ?>
      
        <?php else : ?>
    		
			<?php if ( current_user_can( 'edit_posts' ) ) :
                // Show a different message to a logged-in user who can add posts.
            ?>
            <article id="post-0" class="post no-results not-found <?php echo get_theme_mod('page_layout') == 'post-boxes' ? 'post-boxes' : ''; ?>">
                <header class="search-header">
                    <h1 class="search-title"><span><?php _e( 'No posts to display', 'cubricks' ); ?></span></h1>
                </header>
        
                <div class="entry-content">
                    <p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'cubricks' ), admin_url( 'post-new.php' ) ); ?></p>
                </div><!-- .entry-content -->
            </article><!-- #post-0 -->
            
            <?php else :
                // Show the default message to everyone else.
            ?>
                <?php cubricks_no_posts(); ?>
                
            <?php endif; // end current_user_can() check ?>
   
		<?php endif; // end have_posts() check ?>
		
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
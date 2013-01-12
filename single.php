<?php
/**
 * The Template for displaying all single posts.
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
			if( $post_format == '' || $post_format == 'aside' || $post_format == 'gallery' || $post_format == 'audio' || $post_format == 'chat' )
				cubricks_post_title(); ?>
			</header><!-- .entry-header -->
            
			<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
                <div class="featured-post">
                    <?php _e( 'Featured post', 'cubricks' ); ?>
                </div>
            <?php endif; ?>
            
            <?php if( $post_format == 'status' ) : ?>
            <div class="entry-header">
                <header>
                    <h1><?php the_author(); ?></h1>
                    <h2><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'cubricks' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php echo get_the_date(); ?></a></h2>
                </header>
                <?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'cubricks_status_avatar', '70' ) ); ?>
            </div><!-- .entry-header -->
            <?php endif; ?>
            	
            <div class="entry-content">
                <?php cubricks_entry_content(); ?>
                <?php wp_link_pages( cubricks_link_pages_args() ); ?>
            </div><!-- .entry-content -->        
			<div class="clear"></div>
            
			<footer class="entry-meta">
				<?php cubricks_single_entry_meta(); ?>
			</footer><!-- .entry-meta -->
           		<?php cubricks_edit_link(); ?>
			<div class="clear"></div>
            
            <?php if ( get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
				<div class="author-info">
					<div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'cubricks_author_bio_avatar_size', 70 ) ); ?>
					</div><!-- .author-avatar -->
					<div class="author-description">
						<h2><?php printf( __( 'About %s', 'cubricks' ), get_the_author() ); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
						<div class="author-link">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'cubricks' ), get_the_author() ); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
			<?php endif; ?>
			<div class="clear"></div>
            <div class="post-shadow">
                <div class="left-post-shadow"></div>
                <div class="right-post-shadow"></div>
            </div>
		</article><!-- #post-<?php the_ID(); ?> -->

				<nav class="nav-single">
					<h3 class="assistive-text"><?php _e( 'Post navigation', 'cubricks' ); ?></h3>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'cubricks' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'cubricks' ) . '</span>' ); ?></span>
				</nav><!-- .nav-single -->
				<?php if ( comments_open() )
						comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
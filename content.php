<?php
/**
 * This is the default template to display posts.
 * Used for single, index, archive and search.
 *
 * @package Cubricks Theme
 *
 * @since 1.0.0
 */
?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> 
            <?php $post_format = strtolower( get_post_format() );
			// Show post title for standard, aside, audio, chat and gallery post formats.
			if( $post_format == '' || $post_format == 'aside' || $post_format == 'audio' || $post_format == 'chat' || $post_format == 'gallery' ) : ?>
            <header class="entry-header">
				<?php cubricks_post_title(); ?>
			</header><!-- .entry-header -->
            <?php endif; ?>
            
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
            	<?php // Check if Jetpack is active and shortcodes module is enabled.
				$jetpack = get_option( 'jetpack_active_modules' );
				if( in_array( 'shortcodes', $jetpack ) )
           			cubricks_excerpt();
				else
					cubricks_entry_content();
				?>
                <?php wp_link_pages( cubricks_link_pages_args() ); ?>
            </div><!-- .entry-content -->
            
            <?php if( ! is_page() ) : ?>
           	<footer class="entry-meta">
          	  	<?php cubricks_comments_link(); ?>
                <?php cubricks_friendly_date(); ?>
				<?php cubricks_entry_meta(); ?>
			</footer><!-- .entry-meta -->
            <?php endif; ?>     
           		<?php cubricks_edit_link(); ?>
			<div class="clear"></div>
            
            <?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
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

            <div class="post-shadow">
                <div class="left-post-shadow"></div>
                <div class="right-post-shadow"></div>
            </div>
		</article><!-- #post-<?php the_ID(); ?> -->
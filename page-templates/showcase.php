<?php
/**
 * Template Name: Showcase Template
 * Description: A Page Template that showcases Sticky Posts using nivoSlider.
 *
 * The showcase template consists of two sections. The first section displays a full width slideshow of
 * featured posts. The position of the slides can be customized on the theme options admin panel. The
 * second section contains a list of posts in reverse chronological order. The number of posts to show on
 * this page can also be customized on the theme options admin panel.
 *
 * @package Cubricks Theme
 * @subpackage Page Templates
 * @since Cubricks 1.0.0
 */
get_header(); ?>

		<div id="primary" class="site-content">
			<div id="content" role="main">
				<header class="showcase-header">
                	<h1 class="showcase-heading"><span><?php _e( 'Recent Posts', 'cubricks' ); ?></span></h1>
                </header>
				<?php
				$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
				
				// Display our recent posts, showing full content for the very latest.
				$recent_args = array(
					'order'          => 'DESC',
					'posts_per_page' => '10',
					'paged'          => $paged,
					'post__not_in'   => get_option( 'sticky_posts' ),
					'no_found_rows'  => true
				);

				// Our new query for the Recent Posts section.
				$recent = new WP_Query( $recent_args );

				// The first Recent post is displayed normally
				if ( $recent->have_posts() ) : $recent->the_post();
				
					get_template_part( 'content' );
				
				endif;

				while ( $recent->have_posts() ) : $recent->the_post();
					// Set $more to 0 in order to only get the first part of the post.
					global $more;
					$more = 0;
				?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="entry-header">
                <?php $post_format = strtolower( get_post_format() );
                if( $post_format == '' || $post_format == 'aside' || $post_format == 'gallery' || $post_format == 'audio' || $post_format == 'chat' )
                    cubricks_post_title(); ?>
                </header><!-- .entry-header -->

                <?php if( $post_format == 'status' ) : ?>
                <div class="entry-header">
                    <header>
                        <h1><?php the_author(); ?></h1>
                        <h2><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'cubricks' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php echo get_the_date(); ?></a></h2>
                    </header>
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'cubricks_status_avatar', '70' ) ); ?>
                </div><!-- .entry-header -->
                <?php endif; ?>
    
                <?php if( $post_format == 'link' ) : ?>
                    <header><span class="link-icon"><span><?php _e( 'Link', 'cubricks' ); ?></span></span></header><!-- .entry-header -->
                <?php endif; ?>
               
                <div class="clear"></div>
                <div class="entry-content">
                <?php if( $post_format == '' || $post_format == 'aside' || $post_format == 'chat' || $post_format == 'status' ) {	
                    the_excerpt(); 
				} else {
					cubricks_entry_content();
				} ?>
                </div><!-- .entry-content -->
                
                <footer class="entry-meta">
                <?php if( has_post_format('link') || has_post_format('quote') | has_post_format('aside') ) : ?>
                    <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'cubricks' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php echo get_the_date(); ?></a>
                <?php else : ?>
                    <?php cubricks_entry_meta(); ?>
                <?php endif; ?>
                </footer>
                    <?php cubricks_comments_link(); ?>
                    <?php cubricks_edit_link(); ?>
                <div class="clear"></div>
                
                <div class="post-shadow">
                    <div class="left-post-shadow"></div>
                    <div class="right-post-shadow"></div>
                </div>
            </article><!-- #post-<?php the_ID(); ?> -->   
            <?php endwhile; ?>
            
            <?php cubricks_content_nav(); ?>
            
            </div><!-- #content -->
        </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/**
 * Template Name: Category Page Template
 * Description: A Page Template that shows posts from a single category.
 *
 * @package Cubricks Theme
 * @subpackage Page Templates
 *
 * @since Cubricks 1.0.0
 */
get_header(); ?>

		<div id="primary" class="site-content">
			<div id="content" role="main">
            
            <?php if($post->post_content != '') : ?>
            
				<?php while ( have_posts() ) : the_post(); ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('intro'); ?>>
                    
                    <?php cubricks_archive_header(); ?>
                   
                    <div class="entry-content">
						<?php the_content(); ?> 
                        <?php wp_link_pages( cubricks_link_pages_args() ); ?>
                    </div><!-- .entry-content -->
                    <div class="clear"></div>
                    
                    <footer class="entry-meta">
                        <?php edit_post_link( '<span class="edit-icon"></span>'. __( 'Edit', 'cubricks' ), '<span class="edit-link">', '</span>' ); ?>
                    </footer>
                    <div class="clear"></div>

                    <div class="left-post-shadow"></div>
                    <div class="right-post-shadow"></div> 
                </article><!-- #post-<?php the_ID(); ?> -->
    
                <?php endwhile; ?>
            
            <?php endif; // End check for page content. ?>

			<?php $page_id = get_the_ID();
			
			/* Get the meta key. */
			$meta_key = cubricks_page_category_field_meta_key();
		
			if ( is_page() ) {
				/* Get the meta value of the custom field key. */
				$category = get_post_meta( $page_id, $meta_key, true );
			}

			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
			$post_per_page = 10;            // -1 shows all posts
			$do_not_show_stickies = 1;     // 0 to show stickies
			
			$args = array(
				'category__in'        => array($category),
				'orderby'             => 'date',
				'order'               => 'DESC',
				'paged'               => $paged,
				'posts_per_page'      => $post_per_page,
				'ignore_sticky_posts' => $do_not_show_stickies
			);
			
			$temp = $wp_query;              // assign orginal query to temp variable for later use  
			$wp_query = null;
			$wp_query = new WP_Query($args); 
			
			if( have_posts() ) : 
			
				while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
            
                <?php get_template_part( 'content', 'posts' ); ?>
            
            	<?php endwhile; ?>
            
            	<?php cubricks_content_nav(); ?>
          
            <?php endif; ?>
            
			<?php $wp_query = $temp; //reset back to original query ?>
	
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
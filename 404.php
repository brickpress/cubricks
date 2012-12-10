<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Cubricks Theme
 *
 * @since Cubricks 1.0.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<article id="post-0" class="post error404 no-results not-found <?php echo get_theme_mod('page_layout') == 'post-boxes' ? 'post-boxes' : ''; ?>">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'cubricks' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'cubricks' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
                <div class="clear"></div>
    
                <div class="post-shadow">
                    <div class="left-post-shadow"></div>
                    <div class="right-post-shadow"></div>
                </div>
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
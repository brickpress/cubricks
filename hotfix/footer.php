<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main div element.
 *
 * @package Cubricks Theme
 *
 * @since Cubricks 1.0.0
 */
?>
		<?php cubricks_after_content(); ?>
        </div><!-- #main .inner -->
    </div><!-- #main-content .wrapper -->
	<?php 
	if (  ! is_404() ) {
		// Get the sidebar for Homepage page template
		if( is_page_template('page-templates/front-page.php') )
			get_sidebar('front-page');
		else
			get_sidebar('footer');
	}
	?>
            
	<div id="footer" class="wrapper">
        <footer id="colophon" class="inner" role="contentinfo">
        	<?php if( get_theme_mod( 'copyright_notice' ) ) : ?>
        	<div class="footnote">
            	<p class="copyright-notice"><?php echo get_theme_mod( 'copyright_notice' ); ?></p>
            </div>
            <div class="clearfix"></div>
            <?php endif; ?>
            <div class="site-info">
                <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'cubricks' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'cubricks' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'cubricks' ), 'WordPress' ); ?></a>
                <?php cubricks_theme_link(); ?>
            </div><!-- .site-info -->
        </footer><!-- #colophon .inner -->
    </div><!-- #footer .wrapper -->
</div><!-- #page .wrapper -->    
<?php wp_footer(); ?>
</body>
</html>
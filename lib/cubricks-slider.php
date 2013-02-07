<?php
/** 
 * Cubricks Slider Template
 *
 * Uses nivoSlider by Dev7studios.
 *
 * Copyright (c) 2010-2012 Dev7studios
 * 
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * @package Cubricks Theme
 * @subpackage Functions
 */

/** 
 * Cubricks featured posts slider powered by nivoSlider.
 *
 * @since 1.0.0
 */
function cubricks_featured_slider() {
	
	global $post;
	
	$sticky = get_option( 'sticky_posts' );
	$slider_timer = get_theme_mod( 'slider_timer' );
	$slider_items = get_theme_mod( 'slider_items' );
	$slider_effects = get_theme_mod( 'slider_effects' );
	$large_slider_width = get_theme_mod( '$large_slider_width' );
 	
	// Proceed only if sticky posts exist.
	if ( ! empty( $sticky ) ) :
		$featured_args = array(
			'post__in' => $sticky,
			'post_status' => 'publish',
			'posts_per_page' => $slider_items,
			'no_found_rows' => true,
		);

		// The Featured Posts query.
		$featured = new WP_Query( $featured_args );
		
		// Proceed only if published posts exist.
		if ( $featured->have_posts() ) :
			$thumbs_counter = 0; 
			while ( $featured->have_posts() ) : $featured->the_post();					
				if ( has_post_thumbnail() ) {
					// Increase the counter.
					$thumbs_counter++;
				}
			endwhile; 

		// Show slider only if there's more than one post and more than one post thumbnail.
		if ( $featured->post_count > 1 && $thumbs_counter > 1 ) :	
			if( is_page_template( 'page-templates/content-slider.php' ) ) {
				printf( '<header class="featured-header"><h1 class="featured-heading"><span>' . __( 'Featured Posts', 'cubricks' ) . '</span></h1></header><!-- .featured-header -->' );
				echo '<div id="content-slider">';
			} else {
				echo '<div id="showcase-slider" class="wrapper">';
			}
			?>
			<input type="hidden" id="slider_timer" class="slider_timer" name="slider_timer" value="<?php echo $slider_timer ? $slider_timer : '5'; ?>"/>	
			<div id="slider-wrapper">
				<div id="slider"><!-- nivoSlider -->
				<?php 
				// Reset the counter so that we end up with matching elements
				$counter_slider = 0;
	
				// Begin from zero
				rewind_posts();
			
				while ( $featured->have_posts() ) : $featured->the_post();		
					// Increase the counter.
					$counter_slider++; 
					if ( has_post_thumbnail() ) {
						echo '<a href="' .esc_url( get_permalink() ). '" title="' .esc_attr( the_title_attribute('echo=0') ). '">';	
						if( is_page_template('page-templates/showcase.php') || is_page_template('page-templates/front-page.php') ) {
							// Get the large size thumbnails for Showcase and Homepage page templates.
							the_post_thumbnail( 'cubricks-large-slider' );
						} else {
							// Get the medium size thumbnails for Content Slider page template.
							the_post_thumbnail( 'cubricks-medium-slider' );
						}
						echo '</a>';
					}
				endwhile;
				?>				   
				</div><!-- #slider .nivoSlider -->                            
				<script type="text/javascript">
				<!--//--><![CDATA[//><!--
				jQuery(window).load(function() {
					jQuery('#slider').nivoSlider({ pauseTime: parseInt(jQuery('#slider_timer').val() * 1200), pauseOnHover: true, effect: '<?php echo $slider_effects; ?>', captionOpacity: 1, controlNav: true, controlNavThumbs:false, controlNavThumbsFromRel:true, boxCols:8, boxRows:4, manualAdvance: false, afterLoad: function(){ 
					jQuery('.slider-wrapper').css('visibility', 'visible');
					} });
				});
				//--><!]]>
				</script>
                 <div class="slider-overlay"></div><!-- .slider-overlay -->
            </div><!-- #slider-wrapper -->
            <?php echo is_page_template( 'page-templates/content-slider.php' ) ? '</div><!-- #content-slider -->' : '</div><!-- #showcase-slider -->';
 			
		/** 
		 * If there's no more than one sticky post with a featured image/post thumbnail
		 * show the featured post slider instead. This slider is based on TwentyEleven
		 * Theme's showcase slider.
		 */
		else : 
			      
			if( is_page_template( 'page-templates/content-slider.php' ) ) {
				printf( '<header class="featured-header"><h1 class="featured-heading"><span>' . __( 'Featured Posts', 'cubricks' ) . '</span></h1></header><!-- .featured-header -->' );
				echo '<div id="content-slider">';
			} else {
				echo '<div id="showcase-slider" class="wrapper">';
			}
			?>
            <div id="featured-posts-wrapper">       
                <div class="feature-controller">
                    <ul>
                    <?php // Reset the counter so that we end up with matching elements
                    $counter_slider = 0;

                    // Begin from zero
                    rewind_posts();
                    
                    while ( $featured->have_posts() ) : $featured->the_post();		
                        // Increase the counter.
                        $counter_slider++;
                        if ( 1 == $counter_slider )
                            $class = 'class="active"';
                        else
                            $class = '';
                        ?>
                        <li><a href="#featured-post-<?php echo $counter_slider; ?>" title="<?php echo esc_attr( sprintf( __( 'Featuring: %s', 'cubricks' ), the_title_attribute( 'echo=0' ) ) ); ?>" <?php echo $class; ?>></a></li>
                    <?php endwhile;	?>
                    </ul>
                </div><!-- .feature-controller" -->
                <div class="clear"></div>
                
                <div class="featured-posts">                    
                    <?php 
                    // Reset the counter so that we end up with matching elements
                    $counter_slider = 0;
        
                    // Begin from zero, again..
                    rewind_posts();
                
                    while ( $featured->have_posts() ) : $featured->the_post();		
                        // Increase the counter.
                        $counter_slider++;
	
						$feature_class = 'feature-text';
						if( is_page_template('page-templates/showcase.php') || is_page_template('page-templates/front-page.php') ) {
							$feature_class = 'cubricks-large-slider';
						} elseif( is_page_template('page-templates/content-slider.php') ) {
							$feature_class = 'cubricks-medium-slider';
						}
						?>
						<section class="featured-post <?php echo $feature_class; ?>" id="featured-post-<?php echo $counter_slider; ?>">
                        <?php 
						if ( has_post_thumbnail() ) {	
							echo '<a href="' .esc_url( get_permalink() ). '" title="' .esc_attr( the_title_attribute('echo=0') ). '">';	
							if( is_page_template('page-templates/showcase.php') || is_page_template('page-templates/front-page.php') ) {
								// Get the large size thumbnails for Showcase and Homepage page templates.
								the_post_thumbnail( 'cubricks-large-slider' );							
							} else {
								// Get the medium size thumbnails for Content Slider page template.
								the_post_thumbnail( 'cubricks-medium-slider' );
							}
							echo '</a>'; 						
						}
						get_template_part( 'content', 'featured' );
						?>
						</section>
					<?php endwhile; ?>
                    </div><!-- .featured-posts -->                          
                </div><!-- #featured-posts-wrapper -->
            <?php echo is_page_template( 'page-templates/content-slider.php' ) ? '</div><!-- #content-slider -->' : '</div><!-- #showcase-slider -->';
			endif; // End check for post count.
		endif; // End check for published posts.
 	endif; // End check for sticky posts.
}
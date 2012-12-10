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
		); ?>
       
	<input type="hidden" id="slider_timer" class="slider_timer" name="slider_timer" value="<?php if( $slider_timer ) { echo $slider_timer; } else { echo '500'; } ?>"/>	
    <input type="hidden" id="slider_effects" class="slider_effects" name="slider_effects" value="<?php if( $slider_effects ) { echo $slider_effects; } else { echo 'fade'; } ?>"/>
    <input type="hidden" id="slider_items" class="slider_items" name="slider_items" value="<?php if( $slider_items ) { echo $slider_items; } else { echo '10'; } ?>"/>
    <input type="hidden" id="large_slider_width" class="large_slider_width" name="large_slider_width" value="<?php if( $large_slider_width ) { echo $large_slider_width; } else { echo '1400'; } ?>"/>
    	<div id="slider-wrapper">
        	
            <div id="slider"><!-- nivoSlider -->
    
                <?php // The Featured Posts query.
                $featured = new WP_Query( $featured_args );
                
                // Proceed only if published posts exist
                if ( $featured->have_posts() ) :
                    $counter_slider = 0;
                    
                while ( $featured->have_posts() ) : $featured->the_post();		
                // Increase the counter.
                $counter_slider++; 
    
                if ( has_post_thumbnail() ) {
                    
                   echo '<a href="' .esc_url( get_permalink() ). '" title="' .esc_attr( the_title_attribute('echo=0') ). '">';
                   
                   if( is_page_template('page-templates/showcase.php') || is_page_template('page-templates/homepage.php') ) {
                       the_post_thumbnail( 'cubricks-large-slider' );
                   } else {
                       the_post_thumbnail( 'cubricks-medium-slider' );
                   }
                   echo '</a>';
                }
                endwhile; ?>
                
            </div><!-- .nivoSlider -->                            
            <?php // No need to initialize slider if there's only one sticky post.
                  // Disables slider and displays featured image linking to the sticky post.
                if( $counter_slider++ > 1 ) : ?>
                <script type="text/javascript">
                <!--//--><![CDATA[//><!--
                jQuery(window).load(function() {
                    jQuery('#slider').nivoSlider({ pauseTime: parseInt(jQuery('#slider_timer').val() * 1200), pauseOnHover: true, effect: '<?php echo $slider_effects; ?>', captionOpacity: 1, controlNav: true, controlNavThumbs:false, controlNavThumbsFromRel:true, boxCols:8, boxRows:4, manualAdvance: false, afterLoad: function(){ 
                    jQuery('.slider-wrapper').css('visibility', 'visible');
                    } });
                });
                //--><!]]>
                </script>
            <?php endif; ?>
        <?php endif; // End check for published posts. ?>
        
        <div class="slider-overlay"></div>
        </div><!-- #slider-wrapper -->    

 	<?php endif; // End check for sticky posts.
}

/** 
 * Cubricks slider container for content-slider page template.
 *
 * @since 1.0.0
 */
function cubricks_content_slider() {
	
    echo '<div id="content-slider">';
	cubricks_featured_slider();
    echo '</div><!-- #content-slider -->';
}

/** 
 * Cubricks slider container for showcase page template.
 *
 * @since 1.0.0
 */
function cubricks_showcase_slider() {
	?>
    <div id="showcase-slider" class="wrapper">
	<?php cubricks_featured_slider(); ?>
    </div><!-- #showcase-slider .wrapper -->
    <?php
}
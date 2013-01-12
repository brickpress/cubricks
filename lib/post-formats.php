<?php
/** 
 * Cubricks Theme post formats.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @package    Cubricks Theme
 * @subpackage Cubricks Theme Functions
 * @author     Raphael Villanea <raphael@cubrick.us>
 * @copyright  Copyright (c) 2012, Raphael Villanea
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @since      1.0.0
 */

/**
 * Displays the current post's format.
 *
 * @since 1.0.0
 */
if( ! function_exists('cubricks_post_format') ) :
function cubricks_post_format() {

	$post_format = ucwords( get_post_format() );
	if ( is_sticky() ) {
		$post_format = __( 'Featured', 'cubricks' );
	} elseif ( $post_format == '' ) {
		$post_format = __( 'Article', 'cubricks' );
	}
	$format = apply_filters( 'cubricks_post_format', '<h3 class="entry-format">' . $post_format . '</h3>' );

	echo $format;	
}
endif;


/**
 * Convert a chat post into a definition list based on "Name: What they said" content
 *
 * @since 1.0.0
 */
function cubricks_chat_content() {
	
	global $post;
	
	$output = '<ul class="cubricks-chat">';
	
	$lines = preg_split( "/(\r*?\n)+/", $post->post_content );
	
	$i = 0;
	foreach ( $lines as $line ) :	
		$i++;	
		if ( strpos( $line, ':' ) !== false ) {
			$line_pieces = explode( ':', $line, 2 );
			$name = strip_tags( trim( $line_pieces[0] ) );
			$text = force_balance_tags( strip_tags( trim( $line_pieces[1] ), '<strong><em><a><img><del><ins><span>' ) );		
			$rowclass = ( $i % 2 == 0 ? ' class="chat-even"' : ' class="chat-odd"' );	
			$output .= '<li' .$rowclass. '><strong>' .$name. ': </strong>' .$text. '</li>';	
		} else {
			$output .= '</ul>' . $line . '<ul class="cubricks-chat">';
		}	
	endforeach;
	$output .= '</ul>';
	// Remove any empty definition lists
	$output = str_replace( '<ul class="cubricks-chat"></ul>', '', $output );
	
	return apply_filters( 'the_content', $output );
}


/**
 * Convert a chat post into a definition list based on "Name: What they said" content
 *
 * @since 1.0.0
 */
function cubricks_link_content() {
	
	global $post;

	$pattern = '|<a.*?(title=[\'"](.*?)[\'"])*? href=[\'"](.*?)[\'"].*?(target=[\'"].*?[\'"])*?>(.*?)</a>|i';
	preg_match_all( $pattern, $post->post_content, $matches, PREG_SET_ORDER );
	foreach ( $matches as $link ) { 
		$url = esc_url_raw( $link[3] ); ?>	
        <div class="link-content">
        	<a <?php echo $link[1] ? 'title="' .$link[2]. '"' : 'title="' .$link[5]. '"'; ?> href="<?php echo $url; ?>" <?php echo $link[4] ? $link[4] : ''; ?>><?php echo $link[5]; ?></a>
        	<div class="link-icon"><?php esc_attr_e( 'Link', 'cubricks' ); ?></div>
        </div>
        <?php
	}
}

	
/**
 * Returns content for quote post format.
 *
 * @since 1.0.0
 */
function cubricks_quote_content() {

	global $post;
	if ( strpos( $post->post_content, '<blockquote' ) === false )
		echo '<blockquote>';
		
	the_content();
	
	if ( strpos( $post->post_content, '</blockquote' ) === false )
		echo '</blockquote>';
}


/**
 * Shows author avatar for status post format.
 *
 * @since 1.0.0
 */
if( ! function_exists('cubricks_status_content') ) :
function cubricks_status_content() {
		
	global $post;
	
	$post_format = get_post_format();
	$current_author = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(get_query_var('author'));
	
	if( ! is_author() && $post_format == 'status' ) { ?>
		<div class="avatar">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'cubricks_status_avatar', '65' ) ); ?>
		</div>
	<?php
	}
	the_content();
}
endif;


/**
 * Audio post excerpt.
 *
 * @since 1.0.8
 */
function cubricks_audio_excerpt() {
	
	global $post;

	if( preg_match( '|\[audio(.*?)\]|i', $post->post_content ) ) {
		$pattern = '|\[audio(.*?)\]|i';
		preg_match_all( $pattern, $post->post_content, $matches, PREG_SET_ORDER );	
		if( $matches ) {
			$audio_shortcode = $matches[0][0];
			if( isset($audio_shortcode) ) {
				echo do_shortcode( $audio_shortcode );
				the_excerpt();
			}
		}
	} else {
		$pattern = '|<a\s[^>]*?href=[\'"](.*?)[\'"]|i';
		preg_match_all( $pattern, $post->post_content, $matches, PREG_SET_ORDER );
		if( $matches ) {
			$audio_url = $matches[0][1];
			if( isset($audio_url) ) {
				$audio = '[audio ' . $audio_url . '|w=640]';
				echo do_shortcode( $audio );
			}
			the_excerpt();
		}
	}
}
				

/**
 * Returns the first image found and the post excerpt if one is set.
 *
 * @since 1.0.8
 */
function cubricks_image_excerpt() {
	
	global $post;
	
	$pattern = '|<a\s[^>]*?href=[\'"](.*?)[\'"]|i';
	preg_match_all( $pattern, $post->post_content, $matches, PREG_SET_ORDER );
	if( $matches )
		$url = $matches[0][1];
	
	$pattern1 = '|<img\s+(.*?)\s?/>|i';
	preg_match_all( $pattern1, $post->post_content, $matches, PREG_SET_ORDER );
	if( $matches )
		$image = $matches[0][1];
		
	$pattern2 = '|\[caption id=[\'"](.*?)[\'"] align=[\'"](.*?)[\'"] width=[\'"](.*?)[\'"]\](.*?)\[/caption]|i';
	preg_match_all( $pattern2, $post->post_content, $matches, PREG_SET_ORDER );
	if( $matches )
		$caption = $matches[0][0];
	
	if( isset($caption) )
		echo do_shortcode( $caption );
	elseif( isset($url) && isset($image) )
		echo '<div class="wp-caption aligncenter" style="width: auto"><a href="' . $url . '" rel="attachment"><img ' . $image . ' /></a></div>';
	elseif( isset($image) )
		echo '<div class="wp-caption aligncenter" style="width: auto"><img ' . $image . ' /></div>';	
	the_excerpt();
}

			
/**
 * Video post excerpt.
 *
 * @since 1.0.8
 */
function cubricks_video_excerpt() {
	
	global $post;

	preg_match_all( '|\[youtube=http://youtu\.be/([a-zA-Z0-9]*?)([\?hd\=1]*?)[&w=](.*?)\]|i', $post->post_content, $matches, PREG_SET_ORDER );	
	if( $matches )
		$youtube = $matches[0][0];

	preg_match_all( '|\[vimeo (.*?)\]|i', $post->post_content, $matches, PREG_SET_ORDER );
	if( $matches )
		$vimeo = $matches[0][0];

	if( isset($youtube) ) {
		echo do_shortcode($youtube);
		the_excerpt();
	} elseif( isset($vimeo) ) {
		echo do_shortcode($vimeo);
			the_excerpt();
	} else {
		the_content();
	}
}


/**
 * Gallery post excerpt.
 *
 * @since 1.0.8
 */
function cubricks_gallery_excerpt() {
	
	global $post;
	static $instance = 0;
	$instance++;
	
	$pattern = '|\[gallery.*?(columns=[\'"](.*?)[\'"])*? ids=[\'"](.*?)[\'"].*?(orderby=[\'"](.*?)[\'"])*?\]|i';
	preg_match_all( $pattern, $post->post_content, $matches, PREG_SET_ORDER );
	
	if( $matches ) {
		foreach ( $matches as $val ) { 
			$columns = isset($val[2]) ? intval($val[2]) : '3';
			$orderby = isset($val[4]) ? $val[4] : '';
			$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
			$float = is_rtl() ? 'right' : 'left';
			$selector = "gallery-{$instance}";
			
			if( isset( $val[3] ) ) {
				$image_array = $val[3];
				$images = explode( ',', $image_array );
				$img_count = count( $images );
			
				if( $columns <= '3' ) {
					echo "
					<style type='text/css'>
						#{$selector} {
							margin: auto;
						}
						#{$selector} .gallery-item {
							float: {$float};
							margin-top: 10px;
							text-align: center;
							width: 33%;
						}
						#{$selector} img {
							border: 1px solid #cfcfcf;
						}
						#{$selector} .gallery-caption {
							margin-left: 0;
						}
					</style>";
					echo '<div id=' .$selector. ' class="gallery gallery-columns-3 gallery-size-thumbnail">';
					for( $i=0; $i<3; $i++  ) {
					    $image_attr = wp_get_attachment_image_src( $images[$i] );
						echo '<dl class="gallery-item"><dt class="gallery-icon">';
						echo '<a href="' . get_attachment_link( $images[$i] ) . '" title="' . trim(strip_tags( get_post_meta( $images[$i], '_wp_attachment_image_alt', true) )) . '"><img width="150" height="150" src="' . $image_attr[0] . '" /></a></dt></dl>';
					}
					echo '<br style="clear:both;" />';
					echo '</div>';	     
				} else {
					echo "
					<style type='text/css'>
						#{$selector} {
							margin: auto;
						}
						#{$selector} .gallery-item {
							float: {$float};
							margin-top: 10px;
							text-align: center;
							width: {$itemwidth}%;
						}
						#{$selector} img {
							border: 1px solid #cfcfcf;
						}
						#{$selector} .gallery-caption {
							margin-left: 0;
						}
					</style>";
					echo '<div id=' .$selector. ' class="gallery gallery-columns-' . $columns . ' gallery-size-thumbnail">';
					for( $i=0; $i<$columns; $i++  ) {
						$image_attr = wp_get_attachment_image_src( $images[$i] );
						echo '<dl class="gallery-item"><dt class="gallery-icon">';
						echo '<a href="' . get_attachment_link( $images[$i] ) . '" title="' . trim(strip_tags( get_post_meta( $images[$i], '_wp_attachment_image_alt', true) )) . '"><img width="150" height="150" src="' . $image_attr[0] . '" /></a></dt></dl>';
					}
					echo '<br style="clear:both;" />';
					echo '</div>';
				}
			}
		}
	}
}


/**
 * Template to show when no posts are found.
 *
 * @since 1.0.0
 */
function cubricks_no_posts() { 
	?>
    <article id="post-0" class="post no-results not-found <?php echo get_theme_mod('page_layout') == 'post-boxes' ? 'post-boxes' : ''; ?>">
        <header class="search-header">
            <h1 class="search-title"><span><?php _e( 'Nothing Found', 'cubricks' ); ?></span></h1>
        </header>

        <div class="entry-content">
            <p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'cubricks' ); ?></p>
            
			<?php get_search_form(); ?><br />
            
			<?php the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ), array( 'before_widget' => '<div class="search-header">', 'after_widget' => '</div>', 'before_title' => '<h2 class="search-title"><span>', 'after_title' => '</span></h2></div><div>' ) ); ?>
         	<br />
            
            <div class="search-header">
                <h2 class="search-title"><span><?php _e( 'Most Used Categories', 'cubricks' ); ?></span></h2>
            </div>
                <ul>
                <?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
                </ul>
            <br />
            
            <?php
            /* translators: %1$s: smilie */
            $archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'cubricks' ), convert_smilies( ':)' ) ) . '</p>';
            the_widget( 'WP_Widget_Archives', array('count' => 1 , 'dropdown' => 0 ), array( 'before_widget' => '<div class="search-header">', 'after_widget' => '</div>', 'before_title' => '<h2 class="search-title"><span>', 'after_title' => '</span></h2></div><div>'.$archive_content ) );
            ?>
            <br />
            
            <div class="search-header">
                <h2 class="search-title"><span><?php _e( 'Tags', 'cubricks' ); ?></span></h2>
            </div>
            <?php wp_tag_cloud(); ?>
            <br /><br />
        </div><!-- .entry-content -->
        <div class="clear"></div>
    
        <div class="post-shadow">
            <div class="left-post-shadow"></div>
            <div class="right-post-shadow"></div>
        </div>
    </article><!-- #post-0 -->
    <?php
}
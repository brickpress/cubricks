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
 * Returns content for posts using link post format.
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
 * Content for posts using status post format.
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
 * Returns embedded audio.
 *
 * @since 1.0.8
 */
function cubricks_get_audio_embed() {
	
	global $post;

	preg_match_all( '|\[audio(.*?)\]|i', $post->post_content, $matches, PREG_SET_ORDER );	
	if( $matches )
		$audio_shortcode = $matches[0][0];
	
	$pattern = '@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?[\w|]*[\?|\=]?\w*)?\.mp3|mp4|ogg|mpeg|vorbis)?)*)@';
	preg_match_all( $pattern, $post->post_content, $matches, PREG_SET_ORDER );
	if( $matches )
		$audio_url = $matches[0][0];
	
	preg_match_all( '|\[soundcloud (.*?)\]|i', $post->post_content, $matches, PREG_SET_ORDER );
	if( $matches )
		$soundcloud = $matches[0][0];	
	
	if( isset($audio_shortcode) ) {
		echo do_shortcode( $audio_shortcode );
	} elseif( isset($soundcloud) ) {
		echo do_shortcode($soundcloud);
	} elseif( isset($audio_url) ) {
		$audio = '[audio ' . $audio_url . '|w=640]';
		echo do_shortcode( $audio );
	}
}


/**
 * Gallery post excerpt.
 *
 * @since 1.0.8
 */
function cubricks_get_gallery_embed() {
	
	global $post;
	$pattern = '|\[gallery(\s+columns=[\'"](.*?)[\'"])?(\s+type=[\'"](.*?)[\'"])?(\s+ids=[\'"](.*?)[\'"])?(\s+orderby=[\'"](.*?)[\'"])?\]|i';
	preg_match_all( $pattern, $post->post_content, $matches, PREG_SET_ORDER );
	if( $matches ) {
		$num_cols = isset($matches[0][1]) ? $matches[0][2] : '';
		$type     = isset($matches[0][3]) ? $matches[0][3] : '';
		$ids      = isset($matches[0][5]) ? $matches[0][6] : '';
		$order    = isset($matches[0][7]) ? $matches[0][7] : '';
		$number_columns = (isset($num_cols) && $num_cols <= 3) ? 3 : $num_cols;
		$columns  = '' != $num_cols ? 'columns="'.$number_columns.'"' : '';
		if( isset($type) && $type == 'slideshow' ) {
			$gallery = '[gallery ' .$columns. ' ' .$type. ' ids="' .$ids. '"' .$order. ']';
		} else {
			$images = explode( ",", $ids );
			$img_total = count($images);
			$img_show  = $number_columns;
			$short_gallery = implode( ",", array_slice($images, 0, $img_show) );
			$gallery = '[gallery ' .$columns. ' ' .$type. ' ids="' .$short_gallery. '"' .$order. ']';
			$count = $img_total - $img_show;
		}
		echo do_shortcode($gallery);
		if( $count >= 1 ) {
			$permalink = esc_url( get_permalink() );
			$title = esc_attr( the_title_attribute('echo=0') );
			// Translators: 1 is the number of objects, 2 is the permalink, 3 is the post title
			printf( _n( '<p class="read-more"><a href="%2$s" title="%3$s"><span>View more... </span>  %1$d more image</a></p>', '<p class="read-more"><a href="%2$s" title="%3$s"><span>View more... </span>  %1$d more images</a></p>', $count, 'cubricks' ),																																			
				$count,			// 1
				$permalink,		// 2
				$title			// 3
			);
		}
	}
}
				
			
/**
 * Returns embedded video.
 *
 * @since 1.0.8
 */
function cubricks_get_video_embed() {
	
	global $post;
	preg_match_all( '|\[youtube=http://youtu\.be/([a-zA-Z0-9]*?)([\?hd\=1]*?)[&w=](.*?)\]|i', $post->post_content, $matches, PREG_SET_ORDER );	
	if( $matches )
		$youtube = $matches[0][0];

	preg_match_all( '|\[vimeo (.*?)\]|i', $post->post_content, $matches, PREG_SET_ORDER );
	if( $matches )
		$vimeo = $matches[0][0];
		
	preg_match_all( '|\[flickr (.*?)\]|i', $post->post_content, $matches, PREG_SET_ORDER );
	if( $matches )
		$flickr = $matches[0][0];
	
	preg_match_all( '|\[dailymotion id(.*?)\]|i', $post->post_content, $matches, PREG_SET_ORDER );
	if( $matches )
		$dailymotion = $matches[0][0];
		
	$pattern = '@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?[\w|]*[\?|\=]?\w*)?)?)*)@';
	preg_match_all( $pattern, $post->post_content, $matches, PREG_SET_ORDER );
	if( $matches )
		$video_url = $matches[0][0];

	if( isset($youtube) ) {
		echo do_shortcode($youtube);
	} elseif( isset($vimeo) ) {
		echo do_shortcode($vimeo);
	} elseif( isset($flickr) ) {
		echo do_shortcode($flickr);
	} elseif( isset($dailymotion) ) {
		echo do_shortcode($dailymotion);	
	// If video is embedded using url.
	} elseif( isset($video_url) ) {
		if( preg_match( '|youtube.com|i', $video_url ) ) {
			$shortcode = '[youtube=' .$video_url. '&amp;w=680]';
			echo do_shortcode($shortcode);
		} elseif( preg_match( '|flickr.com|i', $video_url ) ) {
			$shortcode = '[flickr video=' .$video_url. ']';
			echo do_shortcode($shortcode);
		} elseif( preg_match( '|dailymotion.com|i', $video_url ) ) {
			preg_match_all( '|http://www\.dailymotion\.com/video/(.*?)_\S+|i', $video_url, $matches, PREG_SET_ORDER );
			if( $matches )
				$video_id = $matches[0][1];
			$shortcode = '[dailymotion id=' .$video_id. ']';
			echo do_shortcode($shortcode);
		} elseif( preg_match( '|vimeo.com|i', $video_url ) ) {
			preg_match_all( '|http://vimeo\.com/([0-9]+)/?|i', $video_url, $matches, PREG_SET_ORDER );
			if( $matches )
				$video_id = $matches[0][1];
			$shortcode = '[vimeo ' .$video_id. ' w=679&amp;h=382]';
			echo do_shortcode($shortcode);
		} elseif( preg_match( '|wordpress.tv|i', $video_url ) ) {
			echo $video_url . '<br />';
		}
	}
}


/**
 * Returns the first image found.
 *
 * @since 1.0.8
 */
function cubricks_get_image_embed() {
	
	global $post;
	
	// Search for images.
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
		
	preg_match_all( '|\[slideshare (.*?)\]|i', $post->post_content, $matches, PREG_SET_ORDER );
	if( $matches )
		$slideshare = $matches[0][0];
	
	if( isset($caption) ) {
		echo do_shortcode( $caption );
	} elseif( isset($url) && isset($image) ) {
		echo '<div class="wp-caption aligncenter" style="width: auto"><a href="' . $url . '" rel="attachment"><img ' . $image . ' /></a></div>';
	} elseif( isset($image) ) {
		echo '<div class="wp-caption aligncenter" style="width: auto"><img ' . $image . ' /></div>';
	} elseif( isset($slideshare) ) {
		echo do_shortcode( $slideshare );
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
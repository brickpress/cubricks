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
 * @author     Raphael Villanea <support@brickpress.us>
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
 * Display an icon representing the current post's format.
 *
 * @since 1.0.0
 */
if( ! function_exists('cubricks_post_format_icon') ) :
function cubricks_post_format_icon() {
	
	$post_format = strtolower( get_post_format() );
	
	if ( is_sticky() ) {
		$post_format = __( 'featured', 'cubricks' );
	} elseif ( $post_format == '' ) {
		$post_format = __( 'standard', 'cubricks' );
	}
	$format = apply_filters( 'cubricks_post_format_icon', '<span class="entry-format-' .$post_format. '"></span>' );

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
			
		}
		else {
			$output .= '</ul>' . $line . '<ul class="cubricks-chat">';
		}
		
	endforeach;
	
	$output .= '</ul>';
	
	// Remove any empty definition lists
	$output = str_replace( '<ul class="cubricks-chat"></ul>', '', $output );
	
	return apply_filters( 'the_content', $output );
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
 * Template to show when no posts are found.
 *
 * @since 1.0.0
 */
function cubricks_no_posts() { ?>
    <article id="post-0" class="post no-results not-found">

    <?php if ( current_user_can( 'edit_posts' ) ) :
        // Show a different message to a logged-in user who can add posts.
    ?>
        <header class="entry-header">
            <h1 class="entry-title"><?php _e( 'No posts to display', 'cubricks' ); ?></h1>
        </header>

        <div class="entry-content">
            <p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'cubricks' ), admin_url( 'post-new.php' ) ); ?></p>
        </div><!-- .entry-content -->

    <?php else :
        // Show the default message to everyone else.
    ?>
        <header class="entry-header">
            <h1 class="entry-title"><?php _e( 'Nothing Found', 'cubricks' ); ?></h1>
        </header>

        <div class="entry-content">
            <p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'cubricks' ); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
    <?php endif; // end current_user_can() check ?>
    </article><!-- #post-0 -->
    <?php
}
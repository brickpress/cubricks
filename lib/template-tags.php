<?php
/** 
 * Cubricks Theme template tags.
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
 * @author     Raphael Villanea <support@brickpress.us>
 * @copyright  Copyright (c) 2012, Raphael Villanea
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 * @since      1.0.0
 */

/**
 * Displays the current post's title.
 *
 * @since 1.0.0
 */
if( ! function_exists('cubricks_post_title') ) :
function cubricks_post_title() {
	?>
	<?php if( is_single() ) { ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
    <?php } elseif( is_sticky() ) { ?>
		<h1 class="entry-title">
		<a class="slider-caption" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h1>
    <?php } elseif( is_author() ) { ?>     
        <h1 class="entry-title"><?php the_author(); ?></h1>
        <h2><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'cubricks' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php echo get_the_date(); ?></a>
        </h2>
	<?php } else { ?>
		<h1 class="entry-title">
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'cubricks' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h1><?php
	}
}
endif;


/**
 * Displays the current post's content according to post formats.
 *
 * @since 1.0.0
 */
if( ! function_exists('cubricks_entry_content') ) :
function cubricks_entry_content() {
	
	$post_format = strtolower( get_post_format() );
	
	if( $post_format == 'chat' ) {
		echo cubricks_chat_content();
	} elseif(  $post_format == 'quote' ) {
		echo cubricks_quote_content();
	} else {
		the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>' ) );
	}
}
endif;


/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Cubricks 1.0.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function cubricks_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'cubricks' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'cubricks_wp_title', 10, 2 );


/**
 * Displays Cubricks primary navigation menu.
 *
 * @since 1.0.0
 */
if( ! function_exists('cubricks_nav_menu') ) :
	function cubricks_nav_menu() { 
	
    	global $page, $paged; ?>
        
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h3 class="menu-toggle"><?php _e( 'Menu', 'cubricks' ); ?></h3>
			<div class="skip-link assistive-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'cubricks' ); ?>"><?php _e( 'Skip to content', 'cubricks' ); ?></a></div>
            <?php wp_nav_menu( array(
					  'theme_location' => 'primary',
					  'show_home' 	   => false,
					  /*'items_wrap'     => '<ul id="%1$s" class="sf-menu">%3$s</ul>',*/
					  'menu_class' 	   => 'nav-menu'
				      ));
			?>
			<script type="text/javascript">
            <!--//--><![CDATA[//><!--
            jQuery(document).ready(function() { 
                jQuery('ul.nav-menu').superfish(); 
            });
            //--><!]]>
            </script>
        </nav><!-- #site-navigation -->
	<?php
	}
endif;


add_action( 'cubricks_header_menu', 'cubricks_header_nav' );
/**
 * Displays Cubricks header navigation menu.
 *
 * @since 1.0.0
 */
if( ! function_exists('cubricks_header_nav') ) :
function cubricks_header_nav() {

	if ( !is_user_logged_in() ) { ?>
		<div class="cubricks-login"><?php wp_loginout(); ?></div><?php
	} ?>
	<nav id="top-navigation" class="header-navigation" role="navigation">
		<h3 class="menu-toggle"><?php _e( 'Menu', 'cubricks' ); ?></h3>
		<?php wp_nav_menu( array(
				  'theme_location' => 'header',
				  'show_home' 	   => false,
				  'menu_class' 	   => 'nav-menu',
				  'depth'          => 1,
				  'fallback_cb'    => false
			  )); ?>
	</nav><!-- #site-navigation .header-navigation -->
<?php
}
endif;


if ( ! function_exists( 'cubricks_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since 1.0.0
 */
function cubricks_content_nav() {
	
	global $wp_rewrite, $wp_query;
	
	$current = ( $wp_query->query_vars['paged'] > 1 ? $wp_query->query_vars['paged'] : 1 );
	
	$pagination = array(
		'base' => @add_query_arg( 'paged','%#%' ),
		'format' => '',
		'total' => $wp_query->max_num_pages,
		'current' => $current,
		'show_all' => false,
		'type' => 'plain',
	);
	
	if( ! empty( $wp_query->query_vars['s'] ) ) {
		$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
	}
	echo '<nav id="nav-single">' . paginate_links( $pagination ) . '</nav>';	
}
endif;


if ( ! function_exists( 'cubricks_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own cubricks_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Cubricks 1.0.0
 */
function cubricks_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'cubricks' ); ?> <?php comment_author_link(); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 70 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'cubricks' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'cubricks' ), get_comment_date(), get_comment_time() )
					);
				?>
                <div class="reply">
                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'cubricks' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div><!-- .reply -->
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'cubricks' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
			</section><!-- .comment-content -->
            <?php edit_comment_link( __( 'Edit', 'cubricks' ), '<p class="edit-comment-link">', '</p>' ); ?>
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;


if ( ! function_exists( 'cubricks_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own cubricks_entry_meta() to override in a child theme.
 *
 * @since Cubricks 1.0.0
 */
function cubricks_entry_meta() {
	
	$format = get_post_format();
	if( '' == $format )
		$format = 'article';
	$post_format = sprintf( '<a href="%1$s" title="%1$s" rel="bookmark">%2$s</a>',
		esc_url( get_permalink() ),
		ucwords( $format )
	);
	
	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'cubricks' ), get_the_author() ) ),
		get_the_author()
	);
	
	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
		
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'cubricks' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'cubricks' ) );

	// Translators: 1 is the post format, 2 is the author, 3 is date published, 4 is the category and 5 is tags.
	if ( $tag_list ) {
		$utility_text = __( '%1$s posted <span class="by-author"> by %2$s</span> on %3$s in %4$s and tagged %5$s.', 'cubricks' );
	} elseif ( $categories_list ) {
		$utility_text = __( '%1$s posted <span class="by-author"> by %2$s</span> on %3$s in %4$s.', 'cubricks' );
	} else {
		$utility_text = __( '%1$s posted <span class="by-author"> by %2$s</span> on %3$s.', 'cubricks' );
	}

	printf(
		$utility_text,
		$post_format,			// 1
		$author,				// 2
		$date,					// 3
		$categories_list,		// 4
		$tag_list				// 5	
	);
}
endif;


/**
 * Returns header for archive pages.
 * 
 * @since 1.0.0
 */
if( ! function_exists('cubricks_archive_header') ) :
function cubricks_archive_header() {
	
    $format = get_post_format(); ?>
    <header class="archive-header">
    <h1 class="archive-title"><span>
		<?php if ( is_day() ) {
            printf( __( 'Daily Archives: %s', 'cubricks' ), '<span>' . get_the_date() . '</span>' );
        } elseif ( is_month() ) {
            printf( __( 'Monthly Archives: %s', 'cubricks' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); 
        } elseif ( is_year() ) {
            printf( __( 'Yearly Archives: %s', 'cubricks' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
        } elseif ( is_category() ) {
            printf( __( 'Category Archives: %s', 'cubricks' ), single_cat_title( '', false ) );
			if ( category_description() ) : // Show an optional category description ?>
				</span></h1><div class="archive-meta"><?php echo category_description(); ?></div>
			<?php endif;
        } elseif ( is_tag() ) {
            printf( __( 'Tag Archives: %s', 'cubricks' ), single_tag_title( '', false ) );
			if ( tag_description() ) : // Show an optional tag description ?>
				</span></h1><div class="archive-meta"><?php echo tag_description(); ?></div>
			<?php endif;
        } elseif ( is_author() ) {
            printf( __( 'Author Archives: %s', 'cubricks' ) );
        } elseif ( has_post_format('aside') ) {
            printf( __( 'Asides Archives', 'cubricks' ), ucwords( $format ) );
        } elseif ( has_post_format('audio') ) {
            printf( __( 'Audio Archives', 'cubricks' ), ucwords( $format ) );
        } elseif ( has_post_format('chat') ) {
            printf( __( 'Chat Archives', 'cubricks' ), ucwords( $format ) );
        } elseif ( has_post_format('gallery') ) {
            printf( __( 'Gallery Archives', 'cubricks' ), ucwords( $format ) );
        } elseif ( has_post_format('image') ) {
            printf( __( 'Image Archives', 'cubricks' ), ucwords( $format ) );
        } elseif ( has_post_format('link') ) {
            printf( __( 'Link Archives', 'cubricks' ), ucwords( $format ) );
        } elseif ( has_post_format('quote') ) {
            printf( __( 'Quote Archives', 'cubricks' ), ucwords( $format ) );
        } elseif ( has_post_format('status') ) {
            printf( __( 'Status Archives', 'cubricks' ), ucwords( $format ) );
        } elseif ( has_post_format('video') ) {
            printf( __( 'Video Archives', 'cubricks' ), ucwords( $format ) );
		} elseif( is_page_template('page-templates/category-page.php') ) {
            printf( the_title() );
        } else {
            _e( 'Blog Archives', 'cubricks' );
        } ?>
        </span></h1>
    </header><!-- .archive-header -->
	<?php
}
endif;

/* 
 * Footer sidebar class.
 *
 * Count the number of footer sidebars to enable dynamic classes for the footer.
 *
 * @param     void
 * @return    string $class
 * 
 * @since     1.0.0
 */
if( ! function_exists( 'cubricks_footer_sidebar_class' ) ) :
	function cubricks_footer_sidebar_class() {
		$count = 0;
		
		if ( is_active_sidebar( 'sidebar-f1' ) )
			$count++;
		if ( is_active_sidebar( 'sidebar-f2' ) )
			$count++;
		if ( is_active_sidebar( 'sidebar-f3' ) )
			$count++;
		if ( is_active_sidebar( 'sidebar-f4' ) )
			$count++;
		if ( is_active_sidebar( 'sidebar-f5' ) )
			$count++;
		if ( is_active_sidebar( 'sidebar-f6' ) )
			$count++;
		$class = '';
	
		switch ( $count ) {
			case '1':
				$class = 'one';
				break;
			case '2':
				$class = 'two';
				break;
			case '3':
				$class = 'three';
				break;
			case '4':
				$class = 'four';
				break;
			case '5':
				$class = 'five';
				break;
			case '6':
				$class = 'six';
				break;
		}
		if ( $class ) {
			echo 'class="inner ' . $class . '"';
		}
	}
endif;


/* 
 * Homepage sidebar class.
 *
 * Count the number of homepage sidebars to enable dynamic classes
 * for the homepage sidebar.
 *
 * @param     void
 * @return    string $class
 * 
 * @since     1.0.0
 */
if( ! function_exists( 'cubricks_homepage_sidebar_class' ) ) :
	function cubricks_homepage_sidebar_class() {
		
		$count = 0;
		if ( is_active_sidebar( 'sidebar-h1' ) )
			$count++;
		if ( is_active_sidebar( 'sidebar-h2' ) )
			$count++;
		if ( is_active_sidebar( 'sidebar-h3' ) )
			$count++;
		$class = '';
	
		switch ( $count ) {
			case '1':
				$class = 'one';
				break;
			case '2':
				$class = 'two';
				break;
			case '3':
				$class = 'three';
				break;
		}
		if ( $class ) {
			echo 'class="inner ' . $class . '"';
		}
	}
endif;


/**
 * Cubricks pagination
 *
 * @since   1.0.0
 */
function cubricks_link_pages_args() {
	
	$args = array(
			  'before'         => '<div class="page-links"><span class="page-link-meta">' . __( 'Pages:', 'cubricks' ) . '</span>',
			  'after'          => '</div>',
			  'next_or_number' => 'number',
			  'link_before'    => '<span>',
			  'link_after'     => '</span>'
		  );
	return $args;
}


/**
 * Returns comments link.
 *
 * @since 1.0.0
 */
if( ! function_exists('cubricks_comment_link') ) :
function cubricks_comments_link() {
	?>
	<div class="comments-link"><?php
	if( comments_open() && ! post_password_required() ) {
		comments_popup_link( __( 'Leave a Comment', 'cubricks' ), _x( '1 Comment ', 'comments number', 'cubricks' ), _x( '% Comments ', 'comments number', 'cubricks' ) );
	} ?>
    </div><!-- .comments-link --><?php
}
endif;


/**
 * Returns edit link.
 *
 * @since 1.0.0
 */
function cubricks_edit_link() {
	?>
	<div class="edit-link"><?php
	edit_post_link( __( 'Edit', 'cubricks' ), '', '' ); ?>
    </div><!-- .edit-link --><?php
}


function cubricks_custom_header() {
	
	if( is_page_template('page-templates/showcase.php') || is_page_template('page-templates/homepage.php') )
		return;
	
	$header_image = get_header_image();
	if ( ! empty( $header_image ) ) : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
	<?php endif;
}


/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since 1.0.0
 */
function cubricks_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'cubricks_excerpt_length' );


/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since 1.0.0
 */
function cubricks_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'cubricks' ) . '</a>';
}


/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and cubricks_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 * 
 * @since 1.0.0
 */
function cubricks_auto_excerpt_more( $more ) {
	return ' &hellip;' . cubricks_continue_reading_link();
}
add_filter( 'excerpt_more', 'cubricks_auto_excerpt_more' );


/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since 1.0.0
 */
function cubricks_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= cubricks_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'cubricks_custom_excerpt_more' );


/**
 * Returns a link leading to theme documentation homepage.
 *
 * @since 1.0.0
 */
function cubricks_theme_link() {
	?>
	<a class="theme-url" href="<?php echo esc_url( __( 'http://cubrickstheme.brickpress.us/', 'cubricks' ) ); ?>" title="<?php esc_attr_e( 'Cubricks Theme Website', 'cubricks' ); ?>"><?php printf( __( '%s', 'cubricks' ), 'Cubricks Theme' ); ?></a><?php
}
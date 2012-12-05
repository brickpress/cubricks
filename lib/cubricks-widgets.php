<?php
/**
 * Cubricks Category Posts widget class
 *
 * @since 1.0.0
 */
class Cubricks_Category_Posts_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'cubricks_category_posts', 'description' => __( "Show posts in a category.", 'cubricks' ) );
		
		/* Create the widget. */
		parent::__construct('cubricks-category-posts', __('Cubricks Category Posts', 'cubricks'), $widget_ops );
		$this->alt_option_name = 'cubricks_category_posts';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		
		global $post;
		$cache = wp_cache_get('category_posts_widget', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['category_name']) ? __('Category Posts', 'cubricks') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['numposts'] ) || ! $numposts = absint( $instance['numposts'] ) )
 			$numposts = 10;
			
		$category_name = $instance['category_name'];

		$cat_posts = get_posts( array( 'numberposts' => $numposts, 'offset'=> 1, 'category' => $category_name ) );
		
		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title; ?>

		<ul>
        <?php foreach( $cat_posts as $post ) : ?>
		
	 	<?php setup_postdata($post); ?>
		
		<li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></li>
		
        <?php endforeach; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('category_posts_widget', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['numposts'] = (int) $new_instance['numposts'];
		$instance['category_name'] = $new_instance['category_name'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['cubricks_category_posts']) )
			delete_option('cubricks_category_posts');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('category_posts_widget', 'widget');
	}

	function form( $instance ) {
		
		/* Category list */
        $categories = get_categories(array('type' => 'post', 'hide_empty' => 0, 'orderby' => 'name', 'order' => 'ASC', 'taxonomy' => 'category'));
		
		/* Set defaults */
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$numposts = isset($instance['numposts']) ? absint($instance['numposts']) : 5;
		$category_name = $this->get_field_name('category_name');
?>

	<p>
    	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'cubricks'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>

	<p>
    	<label for="<?php echo $this->get_field_id('numposts'); ?>"><?php _e('Number of posts to show:', 'cubricks'); ?></label>
		<input id="<?php echo $this->get_field_id('numposts'); ?>" name="<?php echo $this->get_field_name('numposts'); ?>" type="text" value="<?php echo $numposts; ?>" size="3" />
    </p>
        
	<p><!-- Category -->
	    <label for="<?php echo $this->get_field_id('category_name'); ?>"><?php _e('Category: ', 'cubricks'); ?></label>
	    <select id="<?php echo $this->get_field_id('category_name'); ?>" name="<?php echo $this->get_field_name('category_name'); ?>">
        	<option value="-1"<?php if(-1 == $category_name) { ?> selected="selected"<?php } ?>>
			<?php __('Current category of post', 'cubricks'); ?>
            </option>
        <?php
		foreach($categories as $category) {
		?>
		    <option value="<?php echo $category->term_id; ?>"<?php if($category->term_id == $category_name) { ?> selected="selected"<?php } ?>>
            <?php echo $category->name.' ('.$category->count.')'; ?>
            </option>
		    <?php
		}
		?>
	    </select>
	</p>
<?php
	}
} // Cubricks_Category_Posts_Widget
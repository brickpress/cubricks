<?php
/** 
 * Cubricks page category meta box.
 *
 * @package Cubricks Theme
 * @subpackage Functions
 *
 * @since 1.0.0
 */

/* Add support for the 'page_category_field' extension to pages. */
add_action( 'init', 'cubricks_page_category_field_post_type_support' );

/* Register metadata for the page category field. */
add_action( 'init', 'cubricks_page_category_field_register_meta' );

/* Create the meta box on the 'admin_menu' hook. */
add_action( 'admin_menu', 'cubricks_page_category_field_admin_setup' );


/**
 * Adds post type support of 'page-category-field' to the 'page' post type. 
 * Developers should register support for additional post types.
 *
 * @return void
 * @since 1.0.0
 */
function cubricks_page_category_field_post_type_support() {
	add_post_type_support( 'page', 'page-category-field' );
}


/**
 * Registers the category page meta key 'Category' for for specific object types and provides a 
 * function to sanitize the metadata on update.
 *
 * @access private
 * @return void
 * @since 1.0.0
 */
function cubricks_page_category_field_register_meta() {
	register_meta( 'page', cubricks_page_category_field_meta_key(), 'cubricks_page_category_field_sanitize_meta' );
}


/**
 * Callback function for sanitizing meta when add_metadata() or update_metadata() is called by WordPress. 
 * If a developer wants to set up a custom method for sanitizing the data, they should use the 
 * "sanitize_{$meta_type}_meta_{$meta_key}" filter hook to do so.
 *
 * @param mixed $meta_value The value of the data to sanitize.
 * @param string $meta_key The meta key name.
 * @param string $meta_type The type of metadata (post, comment, user, etc.)
 * @return mixed $meta_value
 * @since 1.0.0
 */
function cubricks_page_category_field_sanitize_meta( $meta_value, $meta_key, $meta_type ) {
	return strip_tags( $meta_value );
}


/**
 * Returns the meta key used for the 'Category' custom field.
 *
 * @access public
 * @return string
 * @since 1.0.0
 */
function cubricks_page_category_field_meta_key() {
	return apply_filters( 'cubricks_page_category_field_meta_key', 'Category' );
}


/**
 * Admin setup for the page category field.
 *
 * @access private
 * @return void
 * @since 1.0.0
 */
function cubricks_page_category_field_admin_setup() {

	/* Load the post meta boxes on the new page and edit page screens. */
	add_action( 'load-post.php', 'cubricks_page_category_field_load_meta_boxes' );
	add_action( 'load-post-new.php', 'cubricks_page_category_field_load_meta_boxes' );
}


/**
 * Hooks into the 'add_meta_boxes' hook to add the custom field category meta box and the 'save_post' hook 
 * to save the metadata.
 *
 * @access private
 * @return void
 * @since 1.0.0
 */
function cubricks_page_category_field_load_meta_boxes() {

	/* Add the custom field category meta box on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'cubricks_page_category_field_create_meta_box', 10, 2 );

	/* Saves the post meta box data. */
	add_action( 'save_post', 'cubricks_page_category_field_meta_box_save', 10, 2 );
}


/**
 * Creates the meta box on the post editing screen for the 'page' post type.
 *
 * @access private
 * @param string $post_type The post type of the current post being edited.
 * @param object $post The current post object.
 * @return void
 * @since 1.0.0
 */
function cubricks_page_category_field_create_meta_box( $post_type, $post ) {

	if ( post_type_supports( $post_type, 'page-category-field' ) )
		add_meta_box( 'page-category-field', __( 'Category', 'page-category-field' ), 'cubricks_page_category_field_meta_box', $post_type, 'side', 'default' );
}


/**
 * Displays the input field with the meta box.
 *
 * @access private
 * @param object $object The post object currently being edited.
 * @param array $box Specific information about the meta box being loaded.
 * @return void
 * @since 1.0.0
 */
function cubricks_page_category_field_meta_box( $object, $box ) {

		/* Category list */
        $categories = get_categories(array('type' => 'post', 'hide_empty' => 0, 'orderby' => 'name', 'order' => 'ASC', 'taxonomy' => 'category'));
		$category_name = esc_attr( get_post_meta( $object->ID, cubricks_page_category_field_meta_key(), true ) );
		
		wp_nonce_field( basename( __FILE__ ), 'page-category-field-nonce' ); ?>
 
        <p>
        <select id="page-category-field" name="page-category-field">
		
        	<option value="-1"<?php if(-1 == $category_name) { ?> selected="selected"<?php } ?>>Current category of post</option>
        <?php
		foreach($categories as $category) {
		?>
		    <option value="<?php echo $category->term_id; ?>"<?php if($category->term_id == $category_name) { ?> selected="selected"<?php } ?>><?php echo $category->name.' ('.$category->count.')'; ?></option>
		    <?php
		}
		?>
        </select>
        </p>
        <p>
      		Select <strong>Category Page Template</strong> from Page Attributes then choose from which categories of posts you want to display on this page.
        </p>
<?php
}


/**
 * Saves the single value for the page category meta key.
 *
 * @access private
 * @param int $post_id The ID of the current post being saved.
 * @param object $post The post object currently being saved.
 * @return void
 * @since 1.0.0
 */
function cubricks_page_category_field_meta_box_save( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['page-category-field-nonce'] ) || !wp_verify_nonce( $_POST['page-category-field-nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the posted category title and strip all tags from it. */
	$new_meta_value = $_POST['page-category-field'];

	/* Get the meta key. */
	$meta_key = cubricks_page_category_field_meta_key();

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If there is no new meta value but an old value exists, delete it. */
	if ( current_user_can( 'delete_post_meta', $post_id, $meta_key ) && '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );

	/* If a new meta value was added and there was no previous value, add it. */
	elseif ( current_user_can( 'add_post_meta', $post_id, $meta_key ) && $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the old layout doesn't match the new layout, update the post layout meta. */
	elseif ( current_user_can( 'edit_post_meta', $post_id, $meta_key ) && $meta_value !== $new_meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );
}
?>
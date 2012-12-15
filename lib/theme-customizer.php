<?php
/**
 * Cubricks Theme Customizer implements theme options into Theme Customizer.
 *
 * Credits where credits are due. Cubricks theme customizer is based on
 * and inspired by the tutorial written by Otto on his website:
 * http://otto42.com/bg. Please visit http://ottopress.com for sources
 * of inspiration and WordPress tips not found elsewhere.
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
 * @package     Cubricks Theme
 * @subpackage  Cubricks Theme Customizer
 * @author      Raphael Villanea <raphael@cubrick.us>
 * @copyright   Copyright (c) 2012, Raphael Villanea
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @since Cubricks 1.0.6
 */

/**
 * Registers sections, settings and controls.
 *
 * @param $wp_customize Theme Customizer object
 * @return void
 *
 * @since Cubricks 1.0.6
 */
function cubricks_customize_register( $wp_customize ) {
	
	$capability = 'edit_theme_options';
	
	// Add postMessage support for the Theme Customizer.
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	
	$cubricks_settings = cubricks_theme_mods();
	foreach( $cubricks_settings as $setting ) {
		$wp_customize->get_setting( $setting )->transport = 'postMessage';
	}
	
	/**
	 * Cubricks custom text control.
	 *
	 * @param $wp_customize Theme Customizer object
	 * @return void
	 *
	 * @since Cubricks 1.0.6
	 */
	class Cubricks_Customize_Text_Control extends WP_Customize_Control {
		
		public $type     = 'text';
		public $priority = 10;
		public $desc     = '';
	
		public function render_content() {
		
			echo '<label><span class="customize-control-title">' .esc_html( $this->label ). '</span>';
			if( $this->setting->default != '' )
				echo '<span class="default-setting" style="float:right; margin-top:-20px; color:#4F7079;">Default: <span><strong>' .$this->setting->default. '</strong></span></span>';	
			if( $this->desc != '' )
				echo '<span class="customize-control-desc">' .$this->desc. '</span>'; ?>
			<input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> /></label><?php           
		}
	}
	
	/**
	 * Cubricks custom heading control.
	 *
	 * @param $wp_customize Theme Customizer object
	 * @return void
	 *
	 * @since Cubricks 1.0.6
	 */
	class Cubricks_Customize_Heading_Control extends WP_Customize_Control {
		
		public $type     = 'heading';
		public $priority = 10;
		public $desc     = '';
	
		public function render_content() {
		
			echo '<label><span class="customize-control-title">' .esc_html( $this->label ). '</span></label>';	
			echo '<span class="customize-control-desc">' .$this->desc. '</span>';
		}
	}
	
	/**
	 * Cubricks custom textarea.
	 *
	 * @param $wp_customize Theme Customizer object
	 * @return void
	 *
	 * @since Cubricks 1.0.6
	 */
	class Cubricks_Customize_Textarea_Control extends WP_Customize_Control {
		
		public $type = 'textarea';
		public $desc = '';
	
		public function render_content() {
			
			echo '<label><span class="customize-control-title">' .esc_html( $this->label ). '</span>';
			if( $this->desc != '' )
				echo '<span class="customize-control-desc">' .$this->desc. '</span>'; ?>
			<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php esc_textarea( $this->value() ); ?></textarea></label>
			<?php
		}
	}
	
	/**
	 * Cubricks custom checkbox control.
	 *
	 * @param $wp_customize Theme Customizer object
	 * @return void
	 *
	 * @since Cubricks 1.0.6
	 */
	class Cubricks_Customize_Checkbox_Control extends WP_Customize_Control {
		
		public $type     = 'checkbox';
		public $priority = 10;
		public $desc     = '';
	
		public function render_content() {
			?>
            <label>
                <input type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
                <strong><?php echo esc_html( $this->label ); ?></strong>
			</label><br />
            <?php if( $this->desc != '' )
			echo '<span class="customize-control-desc">' .$this->desc. '</span>';
		}
	}
	
	/* Remove Sections and Settings
	=======================================================*/
	$wp_customize->remove_section( 'background_image' );
	$wp_customize->remove_setting( 'background_color' );
	$wp_customize->remove_control( 'background_color' );
	
	/* Layout Section
	=======================================================*/
	$wp_customize->add_section( 'layout_section', array(
		'title'          => __( 'Theme Layout', 'cubricks' ),
		'priority'       => 23,
	) );
	
	$wp_customize->add_setting( 'page_layout', array(
		'default'        => cubricks_defaults('page_layout'),
		'capability'     => $capability
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'page_layout', array(
		'label'      => __( 'Page Layout', 'cubricks' ),
		'section'    => 'layout_section',
		'settings' 	 => 'page_layout',
		'visibility' => 'page_layout',
		'type'       => 'radio',
		'choices'    => array(
			'full-wide'      => __('Full Width', 'cubricks'),
			'page-centered'  => __('Page Container Centered', 'cubricks'),
			'post-boxes'     => __('Post Boxes', 'cubricks')
			),
	) ) );
	
	$wp_customize->add_setting( 'page_top_margin', array(
		'default'        => cubricks_defaults('page_top_margin'),
		'capability'     => $capability
	) );
	
	$wp_customize->add_control( new Cubricks_Customize_Text_Control( $wp_customize, 'page_top_margin', array(
		'label'    => __( 'Page Top Margin', 'cubricks' ),
		'section'  => 'layout_section',
		'settings' => 'page_top_margin',
		'type'     => 'text',
		'desc'     => __( 'Top margin if Page Layout is Page Container Centered.', 'cubricks' )
	) ) );
	
	$wp_customize->add_setting( 'header_nav_primary', array(
		'default'        => cubricks_defaults('header_nav_primary'),
		'capability'     => $capability
	) );
	
	$wp_customize->add_control( new Cubricks_Customize_Checkbox_Control( $wp_customize, 'header_nav_primary', array(
		'settings' => 'header_nav_primary',
		'label'    => __( 'Make Header Nav Primary Menu', 'cubricks' ),
		'section'  => 'layout_section',
		'type'     => 'checkbox',
		'desc'     => __( 'Disables the primary nav menu and makes the header navigation your primary menu. Use this if you only have a few items to put on menu.', 'cubricks' )
	) ) );

	
	/* Site and Tagline Section
	=======================================================*/
	$wp_customize->add_setting( 'site_logo', array(
		'default'           => cubricks_defaults('site_logo'),
		'type'              => 'theme_mod',
		'capability'        => $capability,
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'site_logo', array(
		'label'    => __( 'Site Logo', 'cubricks' ),
		'section'  => 'title_tagline',
		'settings' => 'site_logo',
	) ) );
	
	/* Featured Slider Section
	============================================================*/
	$wp_customize->add_section( 'slider_section', array(
		'title'          => __( 'Featured Slider', 'cubricks' ),
		'priority'       => 24,
	) );
	
	$wp_customize->add_setting( 'featured_slider_heading', array(
		'default'        => '',
		'capability'     => $capability
	) );
		
	$wp_customize->add_control( new Cubricks_Customize_Heading_Control( $wp_customize, 'featured_slider_heading', array(
		'section'  => 'slider_section',
		'settings' => 'featured_slider_heading',
		'desc'     => __( 'Set all your featured images to 2.702:1 W:H aspect ratio (e.g. 1400x518, 1024x379,
		851x315).', 'cubricks' ),
		'priority' => 10
	) ) );
	
	$wp_customize->add_setting( 'slider_position', array(
		'default'        => cubricks_defaults('slider_position'),
		'capability'     => $capability
	) );
		
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'slider_position', array(
		'label'      => __('Slider Position', 'cubricks'),
		'section'    => 'slider_section',
		'settings'   => 'slider_position',
		'type'       => 'radio',
		'visibility' => 'slider_position',
		'choices'    => array(
			'before_header'  => __( 'Before site header', 'cubricks' ),
			'after_header'   => __( 'After site header', 'cubricks' )
		),
		'priority' => 20	
	) ) );
	
	$wp_customize->add_setting( 'slider_timer', array(
		'default'        => cubricks_defaults('slider_timer'),
		'capability'     => $capability
	) );
		
	$wp_customize->add_control( new Cubricks_Customize_Text_Control( $wp_customize, 'slider_timer', array(
		'label'    => __('Slider Timer', 'cubricks'),
		'section'  => 'slider_section',
		'settings' => 'slider_timer',
		'desc'     => __( 'Time interval (in seconds) between slides', 'cubricks' ),
		'priority' => 20
	) ) );
	
	$wp_customize->add_setting( 'slider_items', array(
		'default'        => cubricks_defaults('slider_items'),
		'capability'     => $capability
	) );
		
	$wp_customize->add_control( new Cubricks_Customize_Text_Control( $wp_customize, 'slider_items', array(
		'label'    => __('Slider Items', 'cubricks'),
		'section'  => 'slider_section',
		'settings' => 'slider_items',
		'desc'     => __( 'Number of featured posts.', 'cubricks' ),
		'priority' => 20
	) ) );
	
	$wp_customize->add_setting( 'slider_effects', array(
		'default'        => cubricks_defaults('slider_effects'),
		'capability'     => $capability
	) );
		
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'slider_effects', array(
		'label'    => __('Slider Effects', 'cubricks'),
		'section'  => 'slider_section',
		'settings' => 'slider_effects',
		'type'     => 'select',
		'choices'  => array(
			'fade'			 	 => 'fade',
			'sliceDownRight' 	 => 'sliceDownRight',
			'sliceDownLeft' 	 => 'sliceDownLeft',
			'sliceUpRight'  	 => 'sliceUpRight',
			'sliceUpLeft'    	 => 'sliceUpLeft',
			'sliceUpDown'     	 => 'sliceUpDown',
			'sliceUpDownLeft' 	 => 'sliceUpDownLeft',
			'fold'			 	 => 'fold',
            'boxRandom'		 	 => 'boxRandom',
			'boxRain'		 	 => 'boxRain',
			'boxRainReverse'  	 => 'boxRainReverse',
			'boxRainGrow'      	 => 'boxRainGrow',
			'boxRainGrowReverse' => 'boxRainGrowReverse',
			'random'		  	 => 'random'
		),
		'priority' => 20
	) ) );
	
	$wp_customize->add_setting( 'large_slider_width', array(
		'default'    => cubricks_defaults('large_slider_width'),
		'capability' => $capability
	) );
	
	$wp_customize->add_control( new Cubricks_Customize_Text_Control( $wp_customize, 'large_slider_width', array(
		'label'    => __('Featured Slider Width', 'cubricks'),
		'section'  => 'slider_section',
		'settings' => 'large_slider_width',	
		'desc'     => __( 'Recommended width is at least <strong>1024px</strong>.', 'cubricks' ),
		'priority' => 11
	) ) );

	$wp_customize->add_setting( 'slider_caption_color', array(
		'default'           => cubricks_defaults('slider_caption_color'),
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => $capability,
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'slider_caption_color', array(
		'label'    => __('Slider Caption Color', 'cubricks'),
		'section'  => 'slider_section',
		'settings' => 'slider_caption_color',
		'priority' => 20
	) ) );
	
	$wp_customize->add_setting( 'slider_caption_bg', array(
		'default'           => cubricks_defaults('slider_caption_bg'),
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => $capability,
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'slider_caption_bg', array(
		'label'    => __('Caption Background Color', 'cubricks'),
		'section'  => 'slider_section',
		'settings' => 'slider_caption_bg',
		'priority' => 21
	) ) );
	
	$wp_customize->add_setting( 'slider_caption_opacity', array(
		'default'    => cubricks_defaults('slider_caption_opacity'),
		'capability' => $capability
	) );
	
	$wp_customize->add_control( new Cubricks_Customize_Text_Control( $wp_customize, 'slider_caption_opacity', array(
		'label'    => __('Caption Background Opacity', 'cubricks'),
		'section'  => 'slider_section',
		'settings' => 'slider_caption_opacity',	
		'desc'     => __( 'Set to <strong>0</strong> to hide caption background.', 'cubricks' ),
		'priority' => 22
	) ) );
	
	/* Color Section
	=======================================================*/
	$colors = array( 'primary_text_color', 'secondary_text_color', 'link_color', 'post_entry_titles', 'post_entry_headers', 'main_menu_link', 'menu_current_page', 'menu_hover_background', 'header_menu_hover', 'sidebar_title_color', 'sidebar_link_color', 'footer_sidebar_text', 'footer_sidebar_link', 'footer_text_color', 'footer_link_color', 'front-page_content_text','front-page_sidebar_text' );
	$color_priority = 20;
	
	foreach( $colors as $color ) {
		$default = cubricks_defaults( $color );
		$label = ucwords( preg_replace('/_+/', ' ', $color) );
		$priority = $color_priority++;
		
		$wp_customize->add_setting( $color, array(
			'default'           => $default,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => $capability
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color, array(
			'label'    => $label,
			'section'  => 'colors',
			'settings' => $color,
			'priority' => $priority
		) ) );
	}
	
	/* Text Shadows Section
	=======================================================*/
	$wp_customize->add_section( 'shadows_section', array(
		'title'          => __( 'Text Shadows', 'cubricks' ),
		'priority'       => 41,
	) );
	
	$shadows = array( 'header_text_shadow', 'menu_text_shadow', 'footer_sidebar_shadow', 'front-page_sidebar_shadow', 'front-page_content_shadow' );
	foreach( $shadows as $shadow ) {
		$default = cubricks_defaults( $shadow );
		$label = ucwords( preg_replace('/_+/', ' ', $shadow) );
		
		$wp_customize->add_setting( $shadow, array(
			'default'           => $default,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => $capability,
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $shadow, array(
			'label'    => $label,
			'section'  => 'shadows_section',
			'settings' => $shadow,
		) ) );
	}
		
	/* Section Wrappers
	============================================================*/
	$wrappers = array( 'background', 'page_wrapper', 'header_wrapper', 'nav_wrapper', 'content_wrapper', 'footer_sidebar_wrapper', 'footer_wrapper', 'slider_wrapper');
	$wrapper_priority = 42;	
	foreach( $wrappers as $wrapper ) {
		$default_color = cubricks_defaults( $wrapper.'_color' );
		$default_image = cubricks_defaults( $wrapper.'_image' );
		$default_opacity = cubricks_defaults( $wrapper.'_opacity' );
		$default_repeat = cubricks_defaults( $wrapper.'_repeat' );
		$default_position_x = cubricks_defaults( $wrapper.'_position_x' );
		$default_position_y = cubricks_defaults( $wrapper.'_position_y' );
		$default_attachment = cubricks_defaults( $wrapper.'_attachment' );
		$label = ucwords( preg_replace('/_+/', ' ', $wrapper) );
		$opacity = __( 'Enter values between 0 and 10; where 0 = transparent (no color) | 5 = translucent | 1 = opaque', 'cubricks' );
		$priority = $wrapper_priority++;
		
		$wp_customize->add_section( $wrapper, array(
			'title'    => $label,
			'priority' => $priority
		) );
		
		$wp_customize->add_setting( $wrapper.'_color', array(
			'default'           => $default_color,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => $capability
		) );
	
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $wrapper.'_color', array(
			'label'    => __( 'Background Color', 'cubricks' ),
			'section'  => $wrapper,
			'settings' => $wrapper.'_color',
			'priority' => 10
		) ) );
		
		$wp_customize->add_setting( $wrapper.'_opacity', array(
			'default'    => $default_opacity,
			'capability' => $capability
		) );
	
		$wp_customize->add_control( new Cubricks_Customize_Text_Control( $wp_customize, $wrapper.'_opacity', array(
			'label'    => __( 'Background Opacity', 'cubricks' ),
			'section'  => $wrapper,
			'settings' => $wrapper.'_opacity',
			'desc'     => $opacity,
			'priority' => 11
		) ) );
		
		$wp_customize->add_setting( $wrapper.'_image', array(
			'default'    => $default_image,
			'capability' => $capability
		) );
		
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $wrapper.'_image', array(
			'label'    => $label . __( ' Image', 'cubricks' ),
			'section'  => $wrapper,
			'settings' => $wrapper.'_image',
			'priority' => 12
		) ) );
		
		$wp_customize->add_setting( $wrapper.'_repeat', array(
			'default'    => $default_repeat,
			'capability' => $capability
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $wrapper.'_repeat', array(
			'label'      => __( 'Background Repeat', 'cubricks' ),
			'section'    => $wrapper,
			'settings' 	 => $wrapper.'_repeat',
			'visibility' => $wrapper.'_image',
			'type'       => 'radio',
			'priority'   => 13,
			'choices'    => array(
				'no-repeat'  => __('No Repeat', 'cubricks'),
				'repeat'     => __('Tile', 'cubricks'),
				'repeat-x'   => __('Tile Horizontally', 'cubricks'),
				'repeat-y'   => __('Tile Vertically', 'cubricks'),
			 	),
		) ) );
		
		$wp_customize->add_setting( $wrapper.'_position_x', array(
			'default'        => $default_position_x,
			'capability'     => $capability
		) );
	
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $wrapper.'_position_x', array(
			'label'      => __( 'Background Horizontal Position', 'cubricks' ),
			'section'    => $wrapper,
			'settings' 	 => $wrapper.'_position_x',
			'visibility' => $wrapper.'_image',
			'type'       => 'radio',
			'priority'   => 14,
			'choices'    => array(
				'0'   => __('Left', 'cubricks'),
				'50'  => __('Center', 'cubricks'),
				'100' => __('Right', 'cubricks')
				),
		) ) );
		
		$wp_customize->add_setting( $wrapper.'_position_y', array(
			'default'        => $default_position_y,
			'capability'     => $capability
		) );
	
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $wrapper.'_position_y', array(
			'label'      => __( 'Background Vertical Position', 'cubricks' ),
			'section'    => $wrapper,
			'settings' 	 => $wrapper.'_position_y',
			'visibility' => $wrapper.'_image',
			'type'       => 'radio',
			'priority'   => 15,
			'choices'    => array(
				'0'   => __('Top', 'cubricks'),
				'50'  => __('Middle', 'cubricks'),
				'100' => __('Bottom', 'cubricks')
				),
		) ) );
		
		$wp_customize->add_setting( $wrapper.'_attachment', array(
			'default'        => $default_attachment,
			'capability'     => $capability
		) );
	
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $wrapper.'_attachment', array(
			'label'      => __( 'Background Attachment', 'cubricks' ),
			'section'    => $wrapper,
			'settings' 	 => $wrapper.'_attachment',
			'visibility' => $wrapper.'_image',
			'type'       => 'radio',
			'priority'   => 16,
			'choices'    => array(
				'fixed'      => __('Fixed', 'cubricks'),
				'scroll'     => __('Scroll', 'cubricks')
				),
		) ) );
	}
	// end foreach
	
	/* Footer Section
	==========================================================*/
	$wp_customize->add_section( 'footer_section', array(
		'title'          => __( 'Footer Settings', 'cubricks' ),
		'priority'       => 91,
	) );

	$wp_customize->add_setting( 'copyright_notice', array(
		'default'        => '',
		'type'			 => 'theme_mod'
	) );

	$wp_customize->add_control( new Cubricks_Customize_Textarea_Control( $wp_customize, 'copyright_notice', array(
		'label'    => __( 'Copyright Notice', 'cubricks' ),
		'section'  => 'footer_section',
		'settings' => 'copyright_notice',
		'type'     => 'textarea',	
		'desc'	   => ''
	) ) );
	
	/* Social Section
	=======================================================*/
	$wp_customize->add_section( 'social_section', array(
		'title'          => __( 'Social Links', 'cubricks' ),
		'priority'       => 61,
	) );
	
	$wp_customize->add_setting( 'social_links_label', array(
		'default'        => __( 'Follow me on', 'cubricks' ),
		'type'			 => 'theme_mod'
	) );
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'social_links_label', array(
		'label'    => __( 'Social Links Label', 'cubricks' ),
		'section'  => 'social_section',
		'settings' => 'social_links_label',
		'priority' => 10
	) ) );	

	$socials = array(
		'facebook_id'   => __( 'Username for your Facebook Page. You may use your Facebook profile if you don\'t have a page.', 'cubricks' ),
		'twitter_id'	=> __( '<strong>Username</strong>.twitter.com', 'cubricks' ),
		'google_id'		=> __( 'https://plus.google.com/<strong>012345678901234567890</strong>/', 'cubricks' ),
		'tumblr_id'		=> __( '<strong>Username</strong>.tumblr.com', 'cubricks' ),
		'flickr_id'     => __( 'http://www.flickr.com/photos/<strong>Username</strong>', 'cubricks' ),
		'youtube_id'    => __( 'http://www.youtube.com/user/<strong>Username</strong>', 'cubricks' ),
	);
	
	foreach( $socials as $social => $desc ) {
		
		$label = ucwords( preg_replace('/_+/', ' ', $social) );
		
		$wp_customize->add_setting( $social, array(
			'default'        => '',
			'type'			 => 'theme_mod'
		) );

		$wp_customize->add_control( new Cubricks_Customize_Text_Control( $wp_customize, $social, array(
			'label'    => $label,
			'section'  => 'social_section',
			'settings' => $social,
			'type'     => 'text',
			'desc'     => $desc
		) ) );
	}
	
	/* Reset Section
	=======================================================*/
	$wp_customize->add_section( 'reset_section', array(
		'title'       => __( 'Reset Theme', 'cubricks' ),
		'description' => __( 'Resets theme settings to defaults. This does not reset text entries such as copyright notice and social links.', 'cubricks' )
	) );
	
	$wp_customize->add_setting( 'reset_theme', array(
		'default'        => false,
		'capability'     => $capability
	) );
	
	$wp_customize->add_control( new Cubricks_Customize_Checkbox_Control( $wp_customize, 'reset_theme', array(
		'settings' => 'reset_theme',
		'label'    => __( 'Reset Theme Mods', 'cubricks' ),
		'section'  => 'reset_section',
		'type'     => 'checkbox',
		'desc'     => __( 'Resets theme settings to defaults. This does not reset text entries such as copyright notice and social links.', 'cubricks' )
	) ) );
}
add_action( 'customize_register', 'cubricks_customize_register' );


/**
 * Adds social media icons before the footer sidebars.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_social_links() {
	
	$facebook_id = get_theme_mod( 'facebook_id' );
	$twitter_id = get_theme_mod( 'twitter_id' );
	$google_id = get_theme_mod( 'google_id' );
	$youtube_id = get_theme_mod( 'youtube_id' );
	$flickr_id = get_theme_mod( 'flickr_id' );
	$tumblr_id = get_theme_mod( 'tumblr_id' );
	
	if( '' == $facebook_id && '' == $twitter_id && '' == $google_id && '' == $youtube_id && '' == $flickr_id && '' == $tumblr_id )
		return;
		
	$social_links_label = get_theme_mod('social_links_label'); ?>
	<div id="social-links">
        <div id="social-links-label">
            <h1>
            <?php echo $social_links_label; ?>
            </h1>
        </div>
        <div id="social-media-links" class="dark_round">
          <ul>
            <?php if( '' != $facebook_id ) : ?>     
            <li class="facebook"><a href="<?php echo esc_url( 'http://www.facebook.com/' . esc_attr($facebook_id) ); ?>" title="<?php _e( 'Follow me on Facebook', 'cubricks' ); ?>" target="_blank"></a></li>
            <?php endif; ?>
            
            <?php if( '' != $twitter_id ) : ?>
            <li class="twitter"><a href="<?php echo esc_url( 'http://www.twitter.com/' . $twitter_id ); ?>" title="<?php _e( 'Follow me on Twitter', 'cubricks' ); ?>" target="_blank"></a></li>
            <?php endif; ?>
    
            <?php if( '' != $google_id ) : ?>
            <li class="google"><a href="<?php echo esc_url( 'http://plus.google.com/' . $google_id ); ?>" title="<?php _e( 'Add me to your circles', 'cubricks' ); ?>" target="_blank"></a></li>
            <?php endif; ?>
            
            <?php if( '' != $tumblr_id ) : ?>
            <li class="tumblr"><a href="<?php echo esc_url( 'http://' .$tumblr_id. '.tumblr.com/' ); ?>" title="<?php _e( 'Follow me on Tumblr', 'cubricks' ); ?>" target="_blank"></a></li>
            <?php endif; ?>
            
            <?php if( '' != $flickr_id ) : ?>
            <li class="flickr"><a href="<?php echo esc_url( 'http://www.flickr.com/photos/' .$flickr_id ); ?>" title="<?php _e( 'Check out my Flickr photostream', 'cubricks' ); ?>" target="_blank"></a></li>
            <?php endif; ?>
            
            <?php if( '' != $youtube_id ) : ?>     
            <li class="youtube"><a href="<?php echo esc_url( 'http://www.youtube.com/user/' . $youtube_id ); ?>" title="<?php _e( 'Subscribe to my channel on Youtube', 'cubricks' ); ?>" target="_blank"></a></li>
            <?php endif; ?>
          </ul>
          <div class="clearfix"></div>
        </div>
    </div><!-- #social-links -->
	<?php
}
add_action( 'cubricks_after_content', 'cubricks_social_links' );


/**
 * Add style blocks to the theme.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since 1.0.6
 */
function cubricks_print_styles() {
	
	cubricks_text_colors();
	cubricks_text_shadows();
	cubricks_page_wrapper();
	cubricks_header_wrapper();
	cubricks_nav_wrapper();
	cubricks_content_wrapper();
	cubricks_footer_sidebar_wrapper();
	cubricks_footer_wrapper();
	cubricks_slider_wrapper();
	cubricks_page_layout();
	cubricks_header_layout_fix();
	cubricks_large_slider_size();
}
add_action( 'wp_head', 'cubricks_print_styles' );


/**
 * Adds a style block to modify the theme's text color.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.6
 */
function cubricks_text_colors() {
	
	$primary_text_color = get_theme_mod('primary_text_color');
	$secondary_text_color = get_theme_mod('secondary_text_color');
	$link_color = get_theme_mod('link_color');
	$post_entry_titles = get_theme_mod('post_entry_titles');
	$post_entry_headers = get_theme_mod('post_entry_headers');
	$slider_caption_bg = get_theme_mod('slider_caption_bg');
	$slider_caption_color = get_theme_mod('slider_caption_color');
	$sidebar_title_color = get_theme_mod('sidebar_title_color');
	$sidebar_link_color = get_theme_mod('sidebar_link_color');
	$footer_text_color = get_theme_mod('footer_text_color');
	$footer_link_color = get_theme_mod('footer_link_color');
	?>
	<style id="text-colors-css" type="text/css">
	<?php if( $primary_text_color != cubricks_defaults('primary_text_color') ) : ?>
		body,
		.main-navigation li ul li a:hover,
		.template-front-page .entry-content .sd-title,
		.entry-content .contact-form label {
			color: <?php echo $primary_text_color; ?>;
		}
	<?php endif; ?>
	<?php if( $secondary_text_color != cubricks_defaults('secondary_text_color') ) : ?>
		.menu-toggle:active,
		.menu-toggle.toggled-on,
		input[type="submit"]:active,
		article.post-password-required input[type=submit]:active,
		input[type="submit"].toggled-on,
		.wp-caption .wp-caption-text,
		.gallery-caption,
		.entry-caption,
		.author-description p,
		article.sticky .featured-post,
		.comments-area article header cite a,
		.entry-content table,
		.comment-content table,
		footer.entry-meta,
		.archive-meta,
		.format-status .entry-header header a,
		#secondary .widget .textwidget,
		article.format-quote .entry-content cite,
		article.format-quote .entry-content cite a,
		.entry-content .cubricks-chat .chat-even,
		#secondary .widget .textwidget,
		#secondary .widget p,
		#secondary .widget #calendar_wrap table,
		.entry-content .contact-form label span {
			color: <?php echo $secondary_text_color; ?>;
		}
	<?php endif; ?>
	<?php if( $link_color != cubricks_defaults('link_color') ) : ?>
		a,
		.entry-meta a,
		.entry-meta a:hover,
		a.post-edit-link:hover,
		.format-status .entry-header header a:hover,
		.comments-area article header a:hover,
		a.comment-reply-link:hover,
		.template-front-page .widget-area .widget li a:hover,
		.entry-header .entry-title a:hover {
			color: <?php echo $link_color; ?>;
		}
	<?php endif; ?>
	<?php if( $post_entry_titles != cubricks_defaults('post_entry_titles') ) : ?>
		.entry-header .entry-title a,
		article.format-quote .entry-content blockquote:before,
		article.format-quote .entry-content blockquote {
			color: <?php echo $post_entry_titles; ?>;
		}
	<?php endif; ?>
	<?php if( $post_entry_headers != cubricks_defaults('post_entry_headers') ) : ?>
		.entry-content h1, .comment-content h1,
		.entry-content h2, .comment-content h2,
		.entry-content .cubricks-chat .chat-even strong,
		div.sharedaddy, #content div.sharedaddy, #main div.sharedaddy {
			color: <?php echo $post_entry_headers; ?>;
		}
		article.format-standard .entry-content blockquote,
		.comment-content blockquote {
			background: rgba(<?php echo hex_to_rgb($post_entry_headers); ?>,0.2);
		}
		article.format-standard .entry-content blockquote:before,
		.comment-content blockquote:before {
			color: rgba(<?php echo hex_to_rgb($post_entry_headers); ?>,0.7);
		}
	<?php endif; ?>
	<?php if( $sidebar_title_color != cubricks_defaults('sidebar_title_color') ) : ?>
		#secondary .widget-title,
		#secondary .widget-title > span a,
		.archive-header .archive-title span,
		.search-header .search-title span,
		.entry-content .search-header .search-title span,
		.recent-posts-header .recent-posts-heading span,
		.featured-header .featured-heading span,
		#social-links-label h1 {
			color: <?php echo $sidebar_title_color; ?>;
		}
		#secondary .widget h3,
		.archive-header .archive-title,
		.search-header .search-title,
		.entry-content .search-header .search-title,
		.recent-posts-header .recent-posts-heading,
		.featured-header .featured-heading {
			background: rgba(<?php echo hex_to_rgb($sidebar_title_color); ?>,0.3);
		}
	<?php endif; ?>
	<?php if( $sidebar_link_color != cubricks_defaults('sidebar_link_color') ) : ?>
		#secondary .widget a,
		#secondary .widget a:hover,
		#secondary .widget .tagcloud {
			color: <?php echo $sidebar_link_color; ?>;
		}
	<?php endif; ?>
	<?php if( $footer_text_color != cubricks_defaults('footer_text_color') ) : ?>
		footer[role="contentinfo"],
		footer[role="contentinfo"] p {
			color: <?php echo $footer_text_color; ?>;
		}
	<?php endif; ?>
	<?php if( $footer_link_color != cubricks_defaults('footer_link_color') ) : ?>
		footer[role="contentinfo"] a,
		footer[role="contentinfo"] a:hover {
			color: <?php echo $footer_link_color; ?>;
		}
	<?php endif; ?>
	#showcase-slider .nivo-caption, #content-slider .nivo-caption {
		background: rgba( <?php echo hex_to_rgb($slider_caption_bg) .','. get_theme_mod('slider_caption_opacity') / 10; ?>);
		color: <?php echo $slider_caption_color; ?>;
		padding-left: <?php echo 0 == get_theme_mod('slider_caption_opacity') ? '0' : '10px'; ?>;
	}
	</style>
    <?php
}


/**
 * Adds shadows to selected text elements.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.6
 */
function cubricks_text_shadows() {
	?>
	<style id="text-shadows-css" type="text/css">
	.header-navigation li a:hover {
		color: <?php echo get_theme_mod('header_menu_hover'); ?>;
	}
	.main-navigation li a {
		color: <?php echo get_theme_mod('main_menu_link'); ?>;
	}
	.main-navigation li a:hover,
	.main-navigation .current-menu-item > a,
	.main-navigation .current-menu-ancestor > a  {
		color: <?php echo get_theme_mod('menu_current_page'); ?>;
	}
	#comments #respond {
		background: <?php echo get_theme_mod('menu_hover_background'); ?>;
	}
	#supplementary .widget .textwidget,
	#supplementary .widget-title,
	#supplementary .widget .widget-title a,
	#supplementary .widget p,
	#supplementary .widget #calendar_wrap table {
		color: <?php echo get_theme_mod('footer_sidebar_text'); ?>;
		text-shadow: 1px 1px 0 <?php echo get_theme_mod('footer_sidebar_shadow'); ?>;
	}
	.template-front-page .entry-content {
		color: <?php echo get_theme_mod('front-page_content_text'); ?>;
		text-shadow: 1px 1px 0 <?php echo get_theme_mod('front-page_content_shadow'); ?>;
	}
	#supplementary .widget a,
	#supplementary .widget a:hover,
	.template-front-page #supplementary .widget li a,
	.template-front-page #supplementary .widget li a:hover,
	#supplementary .widget .tagcloud {
		color: <?php echo get_theme_mod('footer_sidebar_link'); ?>;
		text-shadow: 1px 1px 0 <?php echo get_theme_mod('footer_sidebar_shadow'); ?>;
	}
	#sidebar-front-page #supplementary .widget .textwidget,
	#sidebar-front-page #supplementary .widget-title,
	#sidebar-front-page #supplementary .widget p {
		color: <?php echo get_theme_mod('front-page_sidebar_text'); ?>;
		text-shadow: 1px 1px 0 <?php echo get_theme_mod('front-page_sidebar_shadow'); ?>;
	}
	/* Minimum width of 600 pixels. */
	@media screen and (min-width: 600px) {
		.main-navigation li a {
			text-shadow: 1px 1px 0 <?php echo get_theme_mod('menu_text_shadow'); ?>;
		}
		.main-navigation li ul li a:hover {
			background: <?php echo get_theme_mod('menu_hover_background'); ?>;
		}
		.header-navigation li a,
		.header-navigation li a:hover,
		.site-title,
		.site-description {
			text-shadow: 1px 1px 0 <?php echo get_theme_mod('header_text_shadow'); ?>;
		}
	}
    </style>
    <?php
}


/**
 * Adds a style block to modify the page container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_page_wrapper() {
	
	$color    = get_theme_mod('page_wrapper_color');
	$opacity  = get_theme_mod('page_wrapper_opacity');
	$bg_image = get_theme_mod('page_wrapper_image');
	$default_color    = cubricks_defaults('page_wrapper_color');
	$default_opacity  = cubricks_defaults('page_wrapper_opacity');
	$default_bg_image = cubricks_defaults('page_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color . $opacity;
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color);
			$opacity = ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'page_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'page_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'page_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'page_wrapper_attachment' ). ';';
			$style = $color . $opacity . $image . $position_x . $position_y . $repeat . $attachment;	
		}	
	}
	?><style type="text/css" id="page-wrapper-css">
		#page { <?php echo trim( $style ); ?> }
	</style><?php
}


/*
 * Adds a style block to modify the header container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_header_wrapper() {
	
	$color    = get_theme_mod('header_wrapper_color');
	$opacity  = get_theme_mod('header_wrapper_opacity');
	$bg_image = get_theme_mod('header_wrapper_image');
	$default_color    = cubricks_defaults('header_wrapper_color');
	$default_opacity  = cubricks_defaults('header_wrapper_opacity');
	$default_bg_image = cubricks_defaults('header_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color .$opacity;
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color). ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'header_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'header_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'header_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'header_wrapper_attachment' ). ';';
			$style = $color . $image . $position_x . $position_y . $repeat . $attachment;	
		}	
	}
	?><style type="text/css" id="header-wrapper-css">
		#header { <?php echo trim( $style ); ?> }
	</style><?php
}


/**
 * Adds a style block to modify the nav container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_nav_wrapper() {
	
	$color    = get_theme_mod('nav_wrapper_color');
	$opacity  = get_theme_mod('nav_wrapper_opacity');
	$bg_image = get_theme_mod('nav_wrapper_image');
	$default_color    = cubricks_defaults('nav_wrapper_color');
	$default_opacity  = cubricks_defaults('nav_wrapper_opacity');
	$default_bg_image = cubricks_defaults('nav_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color .$opacity;
				$color_style = $color. ',1);';
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color);
			$opacity = ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'nav_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'nav_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'nav_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'nav_wrapper_attachment' ). ';';
			$style = $color . $opacity . $image . $position_x . $position_y . $repeat . $attachment;
			$color_style = $color. ',1);';
		}	
	}
	?><style type="text/css" id="nav-wrapper-css">
		#sub-head, .entry-content .contact-form, .main-navigation li ul li a { <?php echo trim( $color_style ); ?> }
		/* Minimum width of 600 pixels. */
		@media screen and (min-width: 600px) {
			#sub-head { <?php echo trim( $style ); ?> }
		}
	</style><?php
}


/**
 * Adds a style block to modify the main content container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_content_wrapper() {
	
	$color    = get_theme_mod('content_wrapper_color');
	$opacity  = get_theme_mod('content_wrapper_opacity');
	$bg_image = get_theme_mod('content_wrapper_image');
	$default_color    = cubricks_defaults('content_wrapper_color');
	$default_opacity  = cubricks_defaults('content_wrapper_opacity');
	$default_bg_image = cubricks_defaults('content_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color . $opacity;
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color);
			$opacity = ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'content_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'content_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'content_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'content_wrapper_attachment' ). ';';
			$style = $color . $opacity . $image . $position_x . $position_y . $repeat . $attachment;
		}	
	}
	// If Page Layout is post boxes
	if( get_theme_mod('page_layout') == 'post-boxes' ) : ?>
    <style type="text/css" id="content-wrapper-css">
		body.post-boxes #content > article, body.post-boxes #secondary .widget, body.post-boxes #secondary .widget h3 span, .search-header .search-title span, .entry-content .search-header .search-title span, body.post-boxes .nav-single, body.post-boxes #comments { <?php echo trim( $style ); ?> }
	</style><?php
	// If Page Layout is full-wide or page-centered
	else : ?>
    <style type="text/css" id="content-wrapper-css">
		#main-content, #secondary .widget h3 span, .archive-header .archive-title span, .search-header .search-title span, .entry-content .search-header .search-title span, .recent-posts-header .recent-posts-heading span, .featured-header .featured-heading span { <?php echo trim( $style ); ?> }
	</style><?php
	endif;
}


/**
 * Adds a style block to modify the footer sidebar container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_footer_sidebar_wrapper() {
	
	$color    = get_theme_mod('footer_sidebar_wrapper_color');
	$opacity  = get_theme_mod('footer_sidebar_wrapper_opacity');
	$bg_image = get_theme_mod('footer_sidebar_wrapper_image');
	$default_color    = cubricks_defaults('footer_sidebar_wrapper_color');
	$default_opacity  = cubricks_defaults('footer_sidebar_wrapper_opacity');
	$default_bg_image = cubricks_defaults('footer_sidebar_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color . $opacity;
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color);
			$opacity = ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'footer_sidebar_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'footer_sidebar_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'footer_sidebar_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'footer_sidebar_wrapper_attachment' ). ';';
			$style = $color . $opacity . $image . $position_x . $position_y . $repeat . $attachment;	
		}	
	}
	?><style type="text/css" id="footer_sidebar-wrapper-css">
		#sidebar-footer, #sidebar-front-page { <?php echo trim( $style ); ?> }
	</style><?php
}


/**
 * Adds a style block to modify the footer container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_footer_wrapper() {
	
	$color    = get_theme_mod('footer_wrapper_color');
	$opacity  = get_theme_mod('footer_wrapper_opacity');
	$bg_image = get_theme_mod('footer_wrapper_image');
	$default_color    = cubricks_defaults('footer_wrapper_color');
	$default_opacity  = cubricks_defaults('footer_wrapper_opacity');
	$default_bg_image = cubricks_defaults('footer_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color . $opacity;
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color);
			$opacity = ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'footer_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'footer_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'footer_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'footer_wrapper_attachment' ). ';';
			$style = $color . $opacity . $image . $position_x . $position_y . $repeat . $attachment;	
		}	
	}
	?><style type="text/css" id="footer-wrapper-css">
		#footer { <?php echo trim( $style ); ?> }
	</style><?php
}


/**
 * Adds a style block to modify the featured slider container.
 * This function is attached to the wp_head action hook.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.0 
 */
function cubricks_slider_wrapper() {
	
	$color    = get_theme_mod('slider_wrapper_color');
	$opacity  = get_theme_mod('slider_wrapper_opacity');
	$bg_image = get_theme_mod('slider_wrapper_image');
	$default_color    = cubricks_defaults('slider_wrapper_color');
	$default_opacity  = cubricks_defaults('slider_wrapper_opacity');
	$default_bg_image = cubricks_defaults('slider_wrapper_image');
	
	if( $color == $default_color && $opacity == $default_opacity && $bg_image == $default_bg_image )
		return;
	
	if( $color != $default_color || $opacity != $default_opacity || $bg_image != $default_bg_image ) {
		if( $bg_image == $default_bg_image ) {
			if( $color != $default_color || $opacity != $default_opacity ) {
				$color   = 'background: rgba(' .hex_to_rgb($color);
				$opacity = ',' .($opacity/10). ');';
				$style = $color . $opacity;
			}
		} else {
			$color = 'background: rgba(' .hex_to_rgb($color);
			$opacity = ',' .($opacity/10). ')';
			$image = ' url(' .esc_url($bg_image). ')';
			$position_x = ' ' .get_theme_mod( 'slider_wrapper_position_x' ). '%';
			$position_y = ' ' .get_theme_mod( 'slider_wrapper_position_y' ). '%';
			$repeat = ' ' .get_theme_mod( 'slider_wrapper_repeat' );
			$attachment = ' ' . get_theme_mod( 'slider_wrapper_attachment' ). ';';
			$style = $color . $opacity . $image . $position_x . $position_y . $repeat . $attachment;	
		}	
	}
	?><style type="text/css" id="slider-wrapper-css">
		#showcase-slider { <?php echo trim( $style ); ?> }
	</style><?php
}


/**
 * Adjusts page top-margin when using page-centered page_layout.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.6
 */
function cubricks_page_layout() {
	
	$page_layout = get_theme_mod('page_layout');
	$page_top_margin = get_theme_mod('page_top_margin');
	$rembase = 14;
	
	if( $page_layout == 'page-centered' ) :	
		if( cubricks_defaults('page_top_margin') != $page_top_margin ) : ?>
        <style type="text/css">
		body.page-centered .site {
			margin-top: <?php echo $page_top_margin; ?>px;
			margin-top: <?php echo ($page_top_margin / $rembase) ; ?>rem;
		}
		</style>
		<?php endif;
	endif;
}


/**
 * Fixes Site title and site logo margin when using
 * page-centered page_layout.
 *
 * @uses get_theme_mod
 *
 * @since 1.0.6
 */
function cubricks_header_layout_fix() {
	
	$page_layout = get_theme_mod('page_layout');
	$site_logo = get_theme_mod('site_logo');
	
	if( $page_layout == 'page-centered' ) : 
		if( cubricks_defaults('site_logo') != $site_logo ) : ?>
        <style type="text/css">
		body.page-centered #masthead hgroup,
		body.page-centered #masthead .site-logo {
			margin-left: 24px;
			margin-left: 1.714285714rem;
		}
		/* Minimum width of 1024 pixels. */
		@media screen and (min-width: 1024px) {
			body.page-centered #masthead hgroup {
				margin-left: 0;
			}
			body.page-centered #masthead .site-logo {
				margin-left: 40px;
				margin-left: 2.857142857rem;
			}
		}
		</style>
		<?php endif;		
	endif;
}


/**
 * Modifies the large featured slider dimensions.
 * @uses get_theme_mod
 *
 * @since 1.0.6 
 */
function cubricks_large_slider_size() {
	
	$large_slider_width = get_theme_mod('large_slider_width');
	$large_slider_height = round( $large_slider_width / 2.702 );
	$rembase = 14;

	if( cubricks_defaults('large_slider_width') != $large_slider_width ) : ?>
    	<style type="text/css">
			#showcase-slider #slider-wrapper,
			#showcase-slider .nivoSlider {
				max-width: <?php echo $large_slider_width; ?>px;
				max-width: <?php echo ($large_slider_width / $rembase); ?>rem;
				max-height: <?php echo $large_slider_height; ?>px;
				max-height: <?php echo ($large_slider_height / $rembase); ?>rem;
			}
		</style>
	<?php endif;
}


/**
 * Cubricks custom background callback.
 *
 * @since 1.0.6
 */
function cubricks_custom_background_cb() {
	
	$color = get_theme_mod( 'background_color' );
	$opacity = get_theme_mod( 'background_opacity' );
	$background = get_theme_mod( 'background_image' );

	if ( ! $background && ! $color )
		return;

	$style = cubricks_defaults('background_opacity') != $opacity ? 'background: rgba(' .hex_to_rgb($color). ',' .$opacity. ');' : 'background: rgb(' .hex_to_rgb($color). ');';
	
	if( $background ) {
		$color = 'background: rgba(' .hex_to_rgb($color). ',' .($opacity/10). ')';
		$image = ' url(' .esc_url($background). ')';
		$position_x = ' ' .get_theme_mod( 'background_position_x' ). '%';
		$position_y = ' ' .get_theme_mod( 'background_position_y' ). '%';
		$repeat = ' ' .get_theme_mod( 'background_repeat' );
		$attachment = ' ' . get_theme_mod( 'background_attachment' ). ';';
		
		$style = $color . $image . $position_x . $position_y . $repeat . $attachment;
	}
	?>
	<style type="text/css" id="custom-background-css">
        body.custom-background { <?php echo trim( $style ); ?> }
    </style>
	<?php
}
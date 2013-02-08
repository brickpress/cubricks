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
 * @since	1.0.6
 */

/**
 * Registers sections, settings and controls.
 *
 * @param $wp_customize Theme Customizer object
 * @return void
 *
 * @since	1.0.6
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
	 * @since	1.0.6
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
	 * @since	1.0.6
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
	 * @since	1.0.6
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
	 * @since	1.0.6
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
		
	$wp_customize->add_setting( 'header_text_shadow', array(
		'default'           => cubricks_defaults('header_text_shadow'),
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => $capability,
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_text_shadow', array(
		'label'    => __('Header Text Shadow', 'cubricks'),
		'section'  => 'title_tagline',
		'settings' => 'header_text_shadow',
		'priority' => 22
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
	$colors = array( 'primary_text_color', 'secondary_text_color', 'link_color', 'link_hover', 'post_entry_titles', 'post_entry_headers', 'sidebar_title_color', 'sidebar_link_color', 'footer_sidebar_text', 'footer_sidebar_link', 'footer_sidebar_shadow', 'footer_text_color', 'footer_link_color' );
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
	
	$wp_customize->add_setting( 'footer_sidebar_heading', array(
		'default'        => '',
		'type'			 => 'theme_mod'
	) );

	$wp_customize->add_control( new Cubricks_Customize_Textarea_Control( $wp_customize, 'footer_sidebar_heading', array(
		'label'    => __( 'Footer Sidebar Heading', 'cubricks' ),
		'desc'     => __( 'Add a heading to your footer sidebar.', 'cubricks' ),
		'section'  => 'footer_section',
		'settings' => 'footer_sidebar_heading',
		'type'     => 'textarea',	
	) ) );
	
	$wp_customize->add_setting( 'copyright_notice', array(
		'default'        => '',
		'type'			 => 'theme_mod'
	) );

	$wp_customize->add_control( new Cubricks_Customize_Textarea_Control( $wp_customize, 'copyright_notice', array(
		'label'    => __( 'Copyright Notice', 'cubricks' ),
		'section'  => 'footer_section',
		'settings' => 'copyright_notice',
		'type'     => 'textarea'
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
	
	/* Navigation Section
	=======================================================*/
	$wp_customize->add_setting( 'header_nav_primary', array(
		'default'        => cubricks_defaults('header_nav_primary'),
		'capability'     => $capability
	) );
	
	$wp_customize->add_control( new Cubricks_Customize_Checkbox_Control( $wp_customize, 'header_nav_primary', array(
		'settings' => 'header_nav_primary',
		'label'    => __( 'Make Header Nav Primary Menu', 'cubricks' ),
		'section'  => 'nav',
		'type'     => 'checkbox',
		'priority' => 21,
		'desc'     => __( 'Disables the primary nav menu and makes the header navigation your primary menu. Use this if you only have a few items to put on menu.', 'cubricks' )
	) ) );
	
	$menu_colors = array( 'main_menu_text', 'menu_current_page', 'main_menu_children', 'menu_hover_background', 'menu_text_shadow', 'header_menu_hover' );
	$color_priority = 22;
	
	foreach( $menu_colors as $color ) {
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
			'section'  => 'nav',
			'settings' => $color,
			'priority' => $priority
		) ) );
	}
	
	/* Front Page Section
	=======================================================*/
	$wp_customize->add_setting( 'frontpage_slider', array(
		'default'        => true,
		'capability'     => $capability
	) );
	
	$wp_customize->add_control( new Cubricks_Customize_Checkbox_Control( $wp_customize, 'frontpage_slider', array(
		'settings' => 'frontpage_slider',
		'label'    => __( 'Front Page Featured Slider', 'cubricks' ),
		'section'  => 'static_front_page',
		'type'     => 'checkbox',
		'priority' => 20,
		'desc'     => __( 'Enable featured slider on front page.', 'cubricks' )
	) ) );
	
	$wp_customize->add_setting( 'frontpage_text_size', array(
		'default'        => cubricks_defaults('frontpage_text_size'),
		'capability'     => $capability
	) );
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'frontpage_text_size', array(
		'label'      => __( 'Front Page Text Size', 'cubricks' ),
		'section'    => 'static_front_page',
		'settings' 	 => 'frontpage_text_size',
		'type'       => 'radio',
		'priority'   => 21,
		'choices'    => array(
			'14' => __('Regular', 'cubricks'),
			'18' => __('Medium', 'cubricks'),
			'26' => __('Large', 'cubricks'),
			),
	) ) );
	
	$frontpage_colors = array( 'frontpage_content_text', 'frontpage_content_shadow', 'frontpage_sidebar_text', 'frontpage_sidebar_shadow' );
	$frontpage_priority = 22;
	
	foreach( $frontpage_colors as $color ) {
		$default = cubricks_defaults( $color );
		$label = ucwords( preg_replace('/_+/', ' ', $color) );
		$priority = $frontpage_priority++;
		
		$wp_customize->add_setting( $color, array(
			'default'           => $default,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => $capability
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color, array(
			'label'    => $label,
			'section'  => 'static_front_page',
			'settings' => $color,
			'priority' => $priority
		) ) );
	}
	
	$wp_customize->add_setting( 'frontpage_sidebar_heading', array(
		'default'        => '',
		'type'			 => 'theme_mod'
	) );

	$wp_customize->add_control( new Cubricks_Customize_Textarea_Control( $wp_customize, 'frontpage_sidebar_heading', array(
		'label'    => __( 'Front Page Sidebar Heading', 'cubricks' ),
		'desc'     => __( 'Add a heading to your front page sidebar.', 'cubricks' ),
		'section'  => 'static_front_page',
		'settings' => 'frontpage_sidebar_heading',
		'type'     => 'textarea',	
		'priority' => '30'
	) ) );
	
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
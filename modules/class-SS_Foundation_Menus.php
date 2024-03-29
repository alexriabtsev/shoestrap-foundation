<?php


if ( !class_exists( 'SS_Foundation_Menus' ) ) {

	/**
	* The "Menus" module
	*/
	class SS_Foundation_Menus {

		function __construct() {
			global $ss_settings;

			add_filter( 'redux/options/' . SHOESTRAP_OPT_NAME . '/sections', array( $this, 'options' ), 70 );
			add_filter( 'shoestrap_nav_class',        array( $this, 'nav_class' ) );
			add_action( 'shoestrap_inside_nav_begin', array( $this, 'navbar_pre_searchbox' ), 11 );
			add_filter( 'shoestrap_navbar_class',     array( $this, 'navbar_class' ) );
			add_action( 'shoestrap_do_navbar',        array( $this, 'do_navbar' ) );
			add_filter( 'shoestrap_navbar_brand',     array( $this, 'navbar_brand' ) );
			add_filter( 'body_class',                 array( $this, 'navbar_body_class' ) );
			add_filter( 'shoestrap_compiler',         array( $this, 'variables_filter' ) );

			add_filter( 'nav_menu_css_class', array( $this, 'menu_parent_classes' ), 10, 2 );
			add_filter( 'wp_nav_menu',        array( $this, 'submenu_classes' ) );
			add_filter( 'nav_menu_css_class', array( $this, 'menu_active_class' ), 10, 2 );

			if ( isset( $ss_settings['navigation-type'] ) ) {
				if ( $ss_settings['navigation-type'] == 'off-canv-l' || $ss_settings['navigation-type'] == 'off-canv-r' ) {
					add_filter( 'shoestrap_top_bar_template', array( $this, 'off_canvas_template_start' ) );
					add_action( 'shoestrap_after_footer', array( $this, 'off_canvas_template_end' ) );
				}
			}
		}

		/*
		 * The header core options for the Shoestrap theme
		 */
		function options( $sections ) {

			// Branding Options
			$section = array( 
				'title' => __( 'Menus', 'shoestrap' ),
				'icon'  => 'el-icon-lines'
			);

			$fields[] = array( 
				'title'       => __( 'Navigation type', 'shoestrap' ),
				'desc'        => __( 'Choose the type of Navigation you want on your website.', 'shoestrap' ),
				'id'          => 'navigation-type',
				'default'     => 'normal',
				'options'        => array(
					'none'       => __( 'Off', 'shoestrap' ),
					'normal'     => __( 'Normal', 'shoestrap' ),
					'contain'    => __( 'Contain-To-Grid', 'shoestrap' ),
					'off-canv-l' => __( 'Off-Canvas (left)', 'shoestrap' ),
					'off-canv-r' => __( 'Off-Canvas (right)', 'shoestrap' ),
				),
				'type'        => 'button_set'
			);

			$fields[] = array( 
				'title'       => __( 'Navigation Background Color', 'shoestrap' ),
				'desc'        => '',
				'id'          => 'navigation-bg',
				'default'     => '#111111',
				'compiler'    => true,
				'transparent' => false,    
				'type'        => 'color'
			);

			$fields[] = array( 
				'title'       => __( 'Display Branding ( Sitename or Logo ) on the NavBar', 'shoestrap' ),
				'desc'        => __( 'Default: ON', 'shoestrap' ),
				'id'          => 'nav_brand',
				'default'     => 1,
				'type'        => 'switch'
			);

			$fields[] = array( 
				'title'       => __( 'Use Logo ( if available ) for branding on the NavBar', 'shoestrap' ),
				'desc'        => __( 'If this option is OFF, or there is no logo available, then the sitename will be displayed instead. Default: ON', 'shoestrap' ),
				'id'          => 'navbar_logo',
				'default'     => 1,
				'type'        => 'switch'
			);

			$fields[] = array( 
				'title'       => __( 'NavBar Positioning', 'shoestrap' ),
				'desc'        => __( 'Using this option you can set the navbar to be fixed to top, fixed to bottom or normal. When you\'re using one of the \'fixed\' options, the navbar will stay fixed on the top or bottom of the page. Default: Normal', 'shoestrap' ),
				'id'          => 'navbar_fixed',
				'type'        => 'button_set',
				'options'     => array(
					''          => __( 'Scroll', 'shoestrap' ),
					'fixed'     => __( 'Fixed', 'shoestrap' ),
					'sticky'    => __( 'Sticky', 'shoestrap' ),
				),
				'default' => ''
			);

			$fields[] = array( 
				'title'       => __( 'NavBar Height', 'shoestrap' ),
				'desc'        => __( 'Select the height of the NavBar in pixels. Should be equal or greater than the height of your logo if you\'ve added one.', 'shoestrap' ),
				'id'          => 'navbar_height',
				'default'     => 45,
				'min'         => 20,
				'step'        => 1,
				'max'         => 100,
				'compiler'    => true,
				'type'        => 'slider'
			);

			$fields[] = array( 
				'title'       => __( 'Navbar Font', 'shoestrap' ),
				'desc'        => __( 'The font used in navbars.', 'shoestrap' ),
				'id'          => 'font_navbar',
				'compiler'    => true,
				'default'     => array( 
					'font-family' => 'Arial, Helvetica, sans-serif',
					'font-size'   => 14,
					'color'       => '#333333',
					'google'      => 'false',
				),
				'preview'     => array( 
					'text'    => __( 'This is my preview text!', 'shoestrap' ), //this is the text from preview box
					'size'    => 30 //this is the text size from preview box
				),
				'type'        => 'typography',
				'output'      => 'ul.off-canvas-list li a'
			);

			$fields[] = array( 
				'title'       => __( 'Branding Font', 'shoestrap' ),
				'desc'        => __( 'The branding font for your site.', 'shoestrap' ),
				'id'          => 'font_brand',
				'compiler'    => true,
				'default'     => array( 
					'font-family' => 'Arial, Helvetica, sans-serif',
					'font-size'   => 18,
					'google'      => 'false',
					'color'       => '#333333',
				),
				'preview'     => array( 
					'text'    => __( 'This is my preview text!', 'shoestrap' ), //this is the text from preview box
					'size'    => 30 //this is the text size from preview box
				),
				'type'        => 'typography',
			);

			$fields[] = array( 
				'title'       => __( 'NavBar Margin', 'shoestrap' ),
				'desc'        => __( 'Select the top and bottom margin of the NavBar in pixels. Applies only in static top navbar ( scroll condition ). Default: 0px.', 'shoestrap' ),
				'id'          => 'navbar_margin',
				'default'     => 0,
				'min'         => 0,
				'step'        => 1,
				'max'         => 200,
				'type'        => 'slider',
			);

			$fields[] = array( 
				'title'       => __( 'Display social links in the NavBar.', 'shoestrap' ),
				'desc'        => __( 'Display social links in the NavBar. These can be setup in the \'Social\' section on the left. Default: OFF', 'shoestrap' ),
				'id'          => 'navbar_social',
				'default'     => 0,
				'type'        => 'switch'
			);

			$fields[] = array( 
				'title'       => __( 'Display social links as a Dropdown list or an Inline list.', 'shoestrap' ),
				'desc'        => __( 'How to display social links. Default: Dropdown list', 'shoestrap' ),
				'id'          => 'navbar_social_style',
				'default'     => 0,
				'on'          => __( 'Inline', 'shoestrap' ),
				'off'         => __( 'Dropdown', 'shoestrap' ),
				'type'        => 'switch',
				'required'    => array('navbar_social','=',array('1')),
			);

			$fields[] = array( 
				'title'       => __( 'Search form on the NavBar', 'shoestrap' ),
				'desc'        => __( 'Display a search form in the NavBar. Default: On', 'shoestrap' ),
				'id'          => 'navbar_search',
				'default'     => 1,
				'type'        => 'switch'
			);

			$fields[] = array( 
				'title'       => __( 'Float NavBar menu to the right', 'shoestrap' ),
				'desc'        => __( 'Floats the primary navigation to the right. Default: On', 'shoestrap' ),
				'id'          => 'navbar_nav_right',
				'default'     => 1,
				'type'        => 'switch'
			);

			$fields[] = array(
				'title'       => __( 'Navbar Breakpoint', 'shoestrap' ),
				'desc'        => __( 'The point at which your navbar will collapse from standard to mobile view. You can set this according to your menus width', 'shoestrap' ),
				'id'          => 'topbar_breakpoint',
				'default'     => 640,
				'min'         => 480,
				'max'         => 2560,
				'step'        => 1,
				'type'        => 'slider',
				'compiler'    => true,
			);

			$section['fields'] = $fields;

			$section = apply_filters( 'shoestrap_module_menus_options_modifier', $section );
			
			$sections[] = $section;
			return $sections;

		}

		/**
		 * Modify the nav class.
		 */
		function nav_class() {
			global $ss_settings;

			if ( $ss_settings['navbar_nav_right'] == '1' ) {
				return 'right';
			} else {
				return 'left';
			}
		}


		/*
		 * The template for the primary navbar searchbox
		 */
		function navbar_pre_searchbox() {
			global $ss_settings;

			$show_searchbox = $ss_settings['navbar_search'];

			if ( $show_searchbox == '1' ) : ?>
				<ul class="left">
					<li class="has-form">
						<div class="row collapse">
							<div class="large-8 small-9 columns">
								<form role="search" method="get" id="searchform" class="form-search right navbar-form" action="<?php echo home_url('/'); ?>">
									<input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" id="s" class="search-query" placeholder="<?php _e('Search', 'shoestrap'); ?> <?php bloginfo('name'); ?>">
								</form>
							</div>
							<div class="large-4 small-3 columns"><a href="#" class="alert button expand"><?php _e( 'Search', 'shoestrap' ); ?></a></div>
						</div>
					</li>
				</ul>
				<?php
			endif;

		}

		/**
		 * Modify the navbar class.
		 */
		public static function navbar_class( $navbar = 'main') {
			global $ss_settings;
			$toggle   = $ss_settings['navigation-type'];

			$fixed    = $ss_settings['navbar_fixed'];
			$contain  = ( $toggle == 'contain' ) ? true : false;

			$classes = $fixed;

			if ( $contain ) 
				$classes .= ' contain-to-grid';

			return $classes;
		}

		/**
		 * Will the sidebar be shown?
		 * If yes, then which navbar?
		 */
		function do_navbar() {
			global $ss_settings;

			if ( $ss_settings['navigation-type'] != 'none' ) {
				if ( ! has_action( 'shoestrap_header_top_navbar_override' ) ) {
					require( 'top-bar.php' );
				} else {
					do_action( 'shoestrap_header_top_navbar_override' );
				}
			}
		}

		/**
		 * get the navbar branding options (if the branding module exists)
		 * and then add the appropriate logo or sitename.
		 */
		function navbar_brand() {
			global $ss_settings, $ss_framework;

			$logo           = $ss_settings['logo'];
			$branding_class = ! empty( $logo['url'] ) ? 'logo' : 'text';

			if ( $ss_settings['nav_brand'] != 0 ) {
				$branding  = '<a class="' . $branding_class . '" href="' . home_url('/') . '">';
				$branding .= $ss_settings['navbar_logo'] == 1 ? $ss_framework->logo() : get_bloginfo( 'name' );
				$branding .= '</a>';
			} else {
				$branding = '';
			}

			return $branding;
		}

		/**
		 * Add and remove body_class() classes
		 */
		function navbar_body_class( $classes ) {
			global $ss_settings;

			// Add 'top-navbar' class if using fixed navbar
			// Used to add styling to account for the WordPress admin bar
			if ( $ss_settings['navbar_fixed'] == 'fixed' ) 
				$classes[] = 'top-navbar';

			return $classes;
		}

		/**
		 * Add "not-click has-dropdown" CSS classes to navigation menu items that have children in a submenu.
		 */
		function menu_parent_classes( $classes, $item ) {
			global $wpdb;

			$has_children = $wpdb->get_var( "SELECT COUNT(meta_id) FROM {$wpdb->prefix}postmeta WHERE meta_key='_menu_item_menu_item_parent' AND meta_value='" . $item->ID . "'" );

			if ( $has_children > 0 ) {
				array_push( $classes, 'not-click has-dropdown' );
			}

			return $classes;
		}

		/**
		 * Deletes empty classes and changes the sub menu class name
		 */
		function submenu_classes( $menu ) {
			return preg_replace( '/ class="sub-menu"/',' class="dropdown"',$menu );
		}

		/**
		 * Use the active class of the ZURB Foundation for the current menu item
		 */
		function menu_active_class( $classes, $item ) {
			if ( $item->current == 1 || $item->current_item_ancestor == true ) {
				$classes[] = 'active';
			}

			return $classes;
		}

		function off_canvas_template_start() {
			return 'templates/off-canvas-start';
		}

		function off_canvas_template_end() {
			ss_get_template_part( 'templates/off-canvas-end' );
		}
	}
}
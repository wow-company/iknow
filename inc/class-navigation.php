<?php

class Iknow_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * [private stored in start_el and used in start_lvl to pass custom classes on ]
	 * @var [array]
	 */
	private $right_class;

	/**
	 * Start Level.
	 *
	 * @param mixed $output Passed by reference. Used to append additional content.
	 * @param int $depth (default: 0) Depth of page. Used for padding.
	 * @param array $args (default: array()) Arguments.
	 *
	 * @return void
	 * @see Walker::start_lvl()
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent       = str_repeat( "\t", $depth );
		$iknow_option = get_option( 'iknow_settings', '' );
		$transparent  = ! empty( $iknow_option['menu_transparent'] ) ? ' is-boxed ' : '';
		$output       .= $indent . "<div class=\"navbar-dropdown";
		$output       .= $transparent;
		if ( in_array( 'is-right', $this->right_class ) ) {
			$output .= " is-right ";
		}
		$output .= "\">";
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "$indent</div><!-- END LEVEL -->\n";
	}

	/**
	 * Start El.
	 *
	 * @param mixed $output Passed by reference. Used to append additional content.
	 * @param mixed $item Menu item data object.
	 * @param int $depth (default: 0) Depth of menu item. Used for padding.
	 * @param array $args (default: array()) Arguments.
	 * @param int $id (default: 0) Menu item ID.
	 *
	 * @return void
	 * @see Walker::start_el()
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$defaults    = array(
			'menu'            => '',
			'container'       => 'div',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'item_spacing'    => 'preserve',
			'depth'           => 0,
			'walker'          => '',
			'theme_location'  => '',
		);
		$args        = wp_parse_args( $args, $defaults );
		$indent      = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $this->get_item_classes( $item, $args, $depth );
		$id          = apply_filters( 'iknow_nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
		$id          = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		$attributes  = $this->get_item_attributes( $item, $args );

		$show_title_class = 'fa-show-title';
		// we're going to show the title of the link by default
		$show_title = true;
		//Pattern for working out how to find font awesome classes
		$pattern = '/(fa-.*|^fas|^fab)/m';
		//First find the classes and assign them to a new variable
		$fa = preg_grep( $pattern, $item->classes );
		//Create string of font awesome classes
		$fa = implode( " ", $fa );
		//Look for fa-show-title class
		$the_title = strstr( $fa, $show_title_class );
		///Remove class fa-show-title
		$fa = str_replace( $show_title_class, "", $fa );
		//Remove font awesome and is-right classes from navbar-item string
		$class_names       = str_replace( array( $fa, $show_title_class, "is-right" ), "", $class_names );
		$classes           = empty( $item->classes ) ? array() : (array) $item->classes;
		$this->right_class = $classes;

		if ( ! $args['has_children'] ) {//if doesn't have children
			if ( ! in_array( 'navbar-divider', $classes ) ) {//if doesnt contains a navbar divider
				$item_output = $args['before'];//start outputting
				$item_output .= '<a' . $class_names . $attributes . '>';//item empty use defaults
				if ( ! empty( $fa ) ) {//if item title is not empty
					$item_output .= '<span class="icon"><i class="' . esc_attr( $fa ) . '"></i></span>';
				}

				$link_title  = '<span>' . apply_filters( 'iknow_the_title', $item->title, $item->ID ) . '</span>';
				$item_output .= $args['link_before'] . trim( $link_title ) . $args['link_after'];
				$item_output .= $args['after'];
			} else {
				$item_output = '<hr class="navbar-divider">';//output navbar divider
			}
			$output .= apply_filters( 'iknow_walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		} else {//if does have children
			$item_output = $args['before'];//stat outputting
			$item_output .= $indent . '<div class="navbar-item has-dropdown is-hoverable" data-target="dropdown"><!-- START DROPDOWN-->' . "\n";
			$item_output .= '<a' . $class_names . $attributes . $id . '>';//output standard
			if ( ! empty( $fa ) ) {//if fa  is not empty
				$item_output .= '<span class="icon"><i class="' . esc_attr( $fa ) . '"></i></span>';
			}
			$link_title  = '<span>' . apply_filters( 'iknow_the_title', $item->title, $item->ID ) . '</span>';
			$item_output .= $args['link_before'] . trim( $link_title ) . $args['link_after'];//remove link
			$item_output .= $args['after'];
			$item_output .= '</a>';
			$output      .= apply_filters( 'iknow_walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

	}

	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( ! in_array( 'menu-item-has-children', $item->classes ) ) {
			$output .= "</a>\n";
		} else {
			$output .= "</div><!-- END DROPDOWN-->\n";
		}
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @param mixed $element Data object.
	 * @param mixed $children_elements List of elements to continue traversing.
	 * @param mixed $max_depth Max depth to traverse.
	 * @param mixed $depth Depth of current element.
	 * @param mixed $args Arguments.
	 * @param mixed $output Passed by reference. Used to append additional content.
	 *
	 * @return null Null on failure with no changes to parameters.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @see Walker::start_el()
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element ) {
			return;
		}
		$id_field = $this->db_fields['id'];
		// Display this element.
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	private function get_item_classes( $item, $args, $depth ) {
		$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[]   = 'menu-item-' . $item->ID;
		$classes[]   = 'navbar-item';
		$class_names = join( ' ', apply_filters( 'iknow_nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		if ( $args['has_children'] ) {
			$class_names .= ' dropdown navbar-link';
			if ( $depth > 0 ) {
				$class_names .= ' is-arrowless';
			}
		}
		if ( in_array( 'current-menu-item', $classes, true ) ) {
			$class_names .= ' is-active';
		}

		return $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
	}

	private function get_item_attributes( $item, $args ) {
		$atts = array();
		if ( empty( $item->attr_title ) ) {
			$atts['title'] = ! empty( $item->title ) ? strip_tags( $item->title ) : '';
		}
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';
		$atts           = apply_filters( 'iknow_nav_menu_link_attributes', $atts, $item, $args );
		$attributes     = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		return $attributes;
	}

	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a menu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param array $args passed from the wp_nav_menu function.
	 */
	public static function fallback( $args ) {
		if ( current_user_can( 'edit_theme_options' ) ) {
			/* Get Arguments. */
			$container       = $args['container'];
			$container_id    = $args['container_id'];
			$container_class = $args['container_class'];
			$menu_class      = $args['menu_class'];
			$menu_id         = $args['menu_id'];
			if ( $container ) {
				echo '<' . esc_attr( $container );
				if ( $container_id ) {
					echo ' id="' . esc_attr( $container_id ) . '"';
				}
				if ( $container_class ) {
					echo ' class="' . sanitize_html_class( $container_class ) . '"';
				}
				echo '>';
			}
			echo '<div';
			if ( $menu_id ) {
				echo ' id="' . esc_attr( $menu_id ) . '"';
			}
			if ( $menu_class ) {
				echo ' class="' . esc_attr( $menu_class ) . '"';
			}
			echo '>';
			echo '<a class="navbar-item" href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" title="">' . esc_attr( 'Add a menu', 'iknow' ) . '</a>';
			echo '</div>';
			if ( $container ) {
				echo '</' . esc_attr( $container ) . '>';
			}
		}
	}
}

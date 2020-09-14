<?php
/**
 * Widget API: Iknow widget for category and single posts
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

class Iknow_Widget_Current_Nav extends WP_Widget {

	/**
	 * Sets up a new Category_Post widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'iknow_widget_current_nav menu',
			'description'                 => esc_attr__( 'Navigation for current category and post.', 'iknow' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'iknow_widget_current_nav', esc_attr__( 'Iknow Current Nav', 'iknow' ), $widget_ops );
	}

	public function widget( $args, $instance ) {

		if ( ! is_category() && ! is_singular( 'post' ) ) {
			return;
		}

		$title        = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$post_number  = ! empty( $instance['post_number'] ) ? $instance['post_number'] : 0;
		$post_orderby = ! empty( $instance['post_orderby'] ) ? $instance['post_orderby'] : 'date';
		$post_order   = ! empty( $instance['post_order'] ) ? $instance['post_order'] : 'DESC';
		$post_arg     = array(
			'numberposts' => $post_number,
			'orderby'     => $post_orderby,
			'order'       => $post_order,
		);

		$current_background = get_theme_mod( 'iknow_widget_main_color', 'has-background-link' );
		$current_color = get_theme_mod( 'iknow_widget_current_color', 'has-background-danger' );

		$display_posts = ! empty( $instance['display_posts'] ) ? '1' : '0';

		$out = $args['before_widget'];

		if ( $title ) {
			$out .= $args['before_title'] . esc_attr( $title ) . $args['after_title'];
		}

		$out .= '<ul class="menu-list">';

		if ( is_category() ) {
			$cat        = get_queried_object();
			$cat_parent = ( $cat->category_parent === 0 ) ? $cat->cat_ID : $cat->category_parent;

			$child_cats = get_categories(
				array( 'parent' => $cat_parent )
			);

			$parent_url     = get_category_link( $cat_parent );
			$current_parent = ( $cat->cat_ID === $cat_parent ) ? ' class="is-active ' . esc_attr( $current_background ) . '"' : ' class="' . esc_attr( $current_background ) . ' has-text-white"';
			$parent_icon    = $child_cats ? 'icon-folder-open' : 'icon-folder';
			$cat_icon       = apply_filters( 'iknow_category_icon', $parent_icon, $cat_parent );
			$out            .= '<li><a' . $current_parent . ' href="' . esc_url( $parent_url ) . '">';
			$out            .= '<span class="icon ' . esc_attr( $cat_icon ) . '"></span>';
			$out            .= esc_attr( get_the_category_by_ID( $cat_parent ) ) . '</a>';

			if ( $child_cats ) {
				$out .= '<ul>';
				foreach ( $child_cats as $child ) {
					$cat_link = get_category_link( $child->cat_ID );
					$current  = ( $cat->cat_ID === $child->cat_ID ) ? ' class="' . esc_attr( $current_color ) . '-light "' : '';
					$out      .= '<li><a' . $current . ' href="' . esc_url( $cat_link ) . '">';
					$out      .= '<span class="icon icon-folder"></span>';
					$out      .= esc_attr( $child->name ) . '</a></li>';
				}
				$out .= '</li></ul>';
			}

		} elseif ( is_single() ) {
			$cat = get_the_category()[0];

			$cat_parent = ( $cat->category_parent === 0 ) ? $cat->cat_ID : $cat->category_parent;

			$child_cats = get_categories(
				array( 'parent' => $cat_parent )
			);


			$cat_icon = apply_filters( 'iknow_category_icon', 'icon-folder-open', $cat->cat_ID );
			$url      = get_category_link( $cat->cat_ID );
			$out      .= '<li><a class="is-active ' . esc_attr( $current_background ) . '" href="' . esc_url( $url ) . '">';
			$out      .= '<span class="icon ' . esc_attr( $cat_icon ) . '"></span>';
			$out      .= esc_attr( $cat->cat_name ) . '</a>';
			if ( empty( $display_posts ) ) {
				$out .= $this->get_cat_posts( $cat->cat_ID, $post_arg );
			}
			$out .= '</li>';

			if ( $child_cats ) {
				foreach ( $child_cats as $child ) {
					if ( $child->cat_ID === $cat->cat_ID ) {
						continue;
					}
					$child_icon = apply_filters( 'iknow_category_icon', 'icon-folder', $child->cat_ID );
					$cat_link   = get_category_link( $child->cat_ID );
					$out        .= '<li><a href="' . esc_url( $cat_link ) . '">';
					$out        .= '<span class="icon ' . esc_attr( $child_icon ) . '"></span>';
					$out        .= esc_attr( $child->name ) . '</a></li>';
				}
			}
		}
		$out .= '</ul>';

		$out .= $args['after_widget'];

		echo wp_kses_post( $out );


	}

	/**
	 * Handles updating settings for the current Categories widget instance.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Updated settings to save.
	 * @since 2.8.0
	 *
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                  = $old_instance;
		$instance['title']         = sanitize_text_field( $new_instance['title'] );
		$instance['display_posts'] = ! empty( $new_instance['display_posts'] ) ? 1 : 0;
		$instance['post_number']   = isset( $new_instance['post_number'] ) ? absint( $new_instance['post_number'] ) : 0;
		$instance['post_orderby']  = isset( $new_instance['post_orderby'] ) ? $this->sanitize_post_orderby( $new_instance['post_orderby'] ) : 'date';
		$instance['post_order']    = isset( $new_instance['post_order'] ) ? $this->sanitize_post_order( $new_instance['post_order'] ) : 'DESC';


		return $instance;
	}

	/**
	 * Outputs the settings form for the Categories widget.
	 *
	 * @param array $instance Current settings.
	 *
	 * @since 2.8.0
	 *
	 */
	public function form( $instance ) {
		//Defaults
		$instance      = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$display_posts = isset( $instance['display_posts'] ) ? (bool) $instance['display_posts'] : false;
		$post_number   = isset( $instance['post_number'] ) ? $instance['post_number'] : 0;
		$post_orderby  = isset( $instance['post_orderby'] ) ? $instance['post_orderby'] : 'date';
		$post_order    = isset( $instance['post_order'] ) ? $instance['post_order'] : 'DESC';

		?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'iknow' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $instance['title'] ); ?>"/></p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'iknow' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'post_number' ) ); ?>" type="number"
                   value="<?php echo esc_attr( $post_number ); ?>"/></p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'post_orderby' ) ); ?>"><?php esc_html_e( 'Posts orderby:', 'iknow' ); ?></label><br/>
            <select id="<?php echo esc_attr( $this->get_field_id( 'post_orderby' ) ); ?>"
                    name="<?php echo esc_attr( $this->get_field_name( 'post_orderby' ) ); ?>">
                <option value="date" <?php selected( $post_orderby, 'date' ); ?>><?php esc_html_e( 'Date', 'iknow' ); ?></option>
                <option value="title" <?php selected( $post_orderby, 'title' ); ?>><?php esc_html_e( 'Title', 'iknow' ); ?></option>
                <option value="comment_count" <?php selected( $post_orderby, 'comment_count' ); ?>><?php esc_html_e( 'Comment count', 'iknow' ); ?></option>
            </select></p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'post_order' ) ); ?>"><?php esc_html_e( 'Posts order:', 'iknow' ); ?></label><br/>
            <select id="<?php echo esc_attr( $this->get_field_id( 'post_order' ) ); ?>"
                    name="<?php echo esc_attr( $this->get_field_name( 'post_order' ) ); ?>">
                <option value="DESC" <?php selected( $post_order, 'DESC' ); ?>><?php esc_html_e( 'DESC ', 'iknow' ); ?></option>
                <option value="ASC" <?php selected( $post_order, 'ASC' ); ?>><?php esc_html_e( 'ASC', 'iknow' ); ?></option>
            </select></p>

        <input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'display_posts' ) ); ?>"
               name="<?php echo esc_attr( $this->get_field_name( 'display_posts' ) ); ?>"<?php checked( $display_posts ); ?> />
        <label for="<?php echo esc_attr( $this->get_field_id( 'display_posts' ) ); ?>"><?php esc_html_e( 'Hide Posts', 'iknow' ); ?></label>
        <br/>

		<?php
	}

	private function get_cat_posts( $cat_ID, $post_arg ) {
		$defaults = array(
			'numberposts' => 0,
			'category'    => $cat_ID,
			'orderby'     => 'date',
			'order'       => 'DESC',
		);

		$args          = wp_parse_args( $post_arg, $defaults );
		$posts         = get_posts( $args );
		$current_color = get_theme_mod( 'iknow_widget_current_color', 'has-background-danger' );
		$out           = '';
		if ( $posts ) {
			$post_icon       = apply_filters( 'iknow_post_icon', 'icon-doc' );
			$current_post_id = get_the_ID();
			$out             .= '<ul>';
			foreach ( $posts as $post ) {
				setup_postdata( $post );
				if ( $current_post_id === $post->ID ) {
					$out .= '<li><a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="' . esc_attr( $current_color ) . '-light">';
				} else {
					$out .= '<li><a href="' . esc_url( get_permalink( $post->ID ) ) . '">';
				}
				$out .= '<span class="icon ' . esc_attr( $post_icon ) . '"></span>';
				$out .= esc_attr( get_the_title( $post->ID ) ) . '</a></li>';
			}
			wp_reset_postdata();
			$out .= '</ul>';
		}

		return $out;
	}

	private function sanitize_post_orderby( $input ) {
		$valid = array(
			''              => esc_attr__( 'Date', 'iknow' ),
			'title'         => esc_attr__( 'Title', 'iknow' ),
			'comment_count' => esc_attr__( 'Comment count', 'iknow' ),
		);

		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return 'date';
		}
	}

	private function sanitize_post_order( $input ) {
		$valid = array(
			'ASC'  => esc_attr__( 'ASC', 'iknow' ),
			'DESC' => esc_attr__( 'DESC', 'iknow' ),
		);

		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return 'DESC';
		}
	}
}
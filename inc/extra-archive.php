<?php
/**
 * Extra functions for Category page
 *
 * @package Iknow
 * @subpackage Iknow
 * @since Iknow 1.0
 */

function iknow_get_breadcrumbs_archive() {
	$out = '';

	if ( is_category() || is_tag() ) {
		$object = get_queried_object();

		if ( ! empty( $object->parent ) ) {
			$term_id   = $object->parent;
			$term_link = get_term_link( (int) $term_id, $object->taxonomy );
			$out       .= '<li><a href="' . esc_url( $term_link ) . '">' . esc_attr( get_the_category_by_ID( (int) $term_id ) ) . '</a></li>';
		}

		$term_id   = $object->term_id;
		$term_link = get_term_link( (int) $term_id, $object->taxonomy );
		$out       .= '<li class="is-active"><a href="' . esc_url( $term_link ) . '">' . esc_attr( $object->name ) . '</a></li>';
	} else {
		$out .= '<li class="is-active"><a href="#">' . get_the_archive_title() . '</a></li>';
	}

	return $out;
}

function iknow_breadcrumbs_archive() {
	echo wp_kses_post( iknow_get_breadcrumbs_archive() );
}


function iknow_go_filter() {

	global $wp_query;

	$select = ! empty( $_GET['select'] ) ? sanitize_text_field( wp_unslash( $_GET['select'] ) ) : 'newest';

	if ( $select === 'newest' ) {
		$args['orderby'] = 'date';
		$args['order']   = 'DESC';
	}
	if ( $select === 'lastest' ) {
		$args['orderby'] = 'date';
		$args['order']   = 'ASC';
	}
	if ( $select === 'title' ) {
		$args['orderby'] = 'title';
		$args['order']   = 'ASC';
	}
	if ( $select === 'comments' ) {
		$args['orderby'] = 'comment_count';
	}
	if ( $select === 'correct' ) {
		$args['orderby'] = 'modified';
	}
	if ( $select === 'useful' ) {
		$args['orderby']  = 'meta_value_num';
		$args['meta_key'] = 'useful';
	}
	if ( $select === 'count' ) {
		$args['orderby']  = 'meta_value_num';
		$args['meta_key'] = 'post_views_count';
	}

	$posts_per_page = ! empty( $_GET['per_page'] ) ? absint( $_GET['per_page'] ) : 'default';

	if ( $posts_per_page === 'default' ) {
		$posts_per_page = get_option( 'posts_per_page ' );
	}

	$args['posts_per_page'] = $posts_per_page;

	query_posts( array_merge( $args, $wp_query->query ) );
}

function iknow_posts_sorter() {
	if ( $_GET && ! empty( $_GET ) ) {
		iknow_go_filter();
	}

	$sorterby = ! empty( $_GET['select'] ) ? sanitize_text_field( wp_unslash( $_GET['select'] ) ) : '';


	$sorter_arr = array(
		'newest'   => esc_attr__( 'newest', 'iknow' ),
		'title'    => esc_attr__( 'by title', 'iknow' ),
		'comments' => esc_attr__( 'by comments', 'iknow' ),
	);

	$posts = ! empty( $_GET['per_page'] ) ? absint( $_GET['per_page'] ) : 'default';

	$posts_arr         = array(
		'default' => esc_attr__( 'Default', 'iknow' ),
		'20'      => '20 ' . esc_attr__( 'Per Page', 'iknow' ),
		'50'      => '50 ' . esc_attr__( 'Per Page', 'iknow' ),
		'100'     => '100 ' . esc_attr__( 'Per Page', 'iknow' ),

	);
	$sort_color_scheme = get_theme_mod( 'iknow_archive_sort_color', 'is-primary' );
	$sort_size = get_theme_mod( 'iknow_settings_sort_size', 'is-small' );
	?>
    <form method="get" id="order" class="level-right">
        <div class="level-item">
            <div class="field">
                <div class="control">
                    <div class="select <?php echo esc_attr( $sort_size ); ?> <?php echo esc_attr( $sort_color_scheme ); ?>">
                        <select name="select" class="" onchange="this.form.submit();">
							<?php
							foreach ( $sorter_arr as $key => $val ) {
								echo '<option value="' . esc_attr( $key ) . '" ' . selected( $key, $sorterby, false ) . '>' . esc_attr( $val ) . '</option>';
							}
							?>

                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="level-item">
            <div class="field">
                <div class="control">
                    <div class="select <?php echo esc_attr( $sort_size ); ?> <?php echo esc_attr( $sort_color_scheme ); ?>">
                        <select name="per_page" class="" onchange="this.form.submit();">
							<?php
							foreach ( $posts_arr as $key => $val ) {
								echo '<option value="' . esc_attr( $key ) . '" ' . selected( $key, $posts, false ) . '>' . esc_attr( $val ) . '</option>';
							}
							?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>

	<?php

}
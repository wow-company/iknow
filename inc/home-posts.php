<?php
/**
 * Get posts for home page
 *
 * @package Iknow
 * @subpackage Iknow
 * @since Iknow 1.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iknow_get_home_posts() {
	$defaults = array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => 1,
		'exclude'    => '',
		'include'    => '',
		'pad_counts' => true,
	);
	$args     = apply_filters( 'iknow_category_home_args', $defaults );


	$categories = get_categories( $args );
	$categories = wp_list_filter( $categories, array( 'parent' => 0 ) );

	if ( ! $categories ) {
		return;
	}

	$panel_color = get_theme_mod( 'iknow_panel_color', 'is-dark' );

	$out = '';
	foreach ( $categories as $cat ) {
		$cat_icon = apply_filters( 'iknow_category_icon', 'icon-folder-open', $cat->cat_ID );

		$out .= '<div class="column is-full-tablet is-half-desktop is-one-third-widescreen">';
		$out .= '<div class="panel ' . esc_attr( $panel_color ) . '">';
		$out .= '<div class="panel-heading  level is-mobile">';
		$out .= '<div class="level-left">';
		$out .= '<div class="level-item"><span class="' . esc_attr( $cat_icon ) . ' has-text-white"></span></div>';
		$out .= '<div class="level-item"> ' . esc_attr( $cat->name ) . '</div>';
		$out .= '</div>';
		$out .= '<div class="level-right">' . absint( $cat->count ) . '</div>';
		$out .= '</div>';
		$out .= iknow_home_panel_tabs( $cat->cat_ID );
		$out .= '</div>';
		$out .= '</div>';
	}
	echo $out;
}


function iknow_home_panel_tabs( $cat_ID ) {


	$elements = array(
		'subcats'       => esc_attr__( 'Subcategories', 'iknow' ),
		'date'          => esc_attr__( 'New', 'iknow' ),
		'comment_count' => esc_attr__( 'Popular', 'iknow' ),
	);

	$child_cats = get_categories( array(
		'parent' => $cat_ID,
	) );

	if ( ! $child_cats ) {
		unset( $elements['subcats'] );
	}

	$header = '<p class="panel-tabs">';

	$i = 0;
	foreach ( $elements as $key => $val ) {
		if ( $i === 0 ) {
			$header .= '<a class="is-active" data-tab="' . esc_attr( $key ) . '"' . iknow_panel_toogle( $elements, $key, $cat_ID ) . '>' . esc_html( $val ) . '</a>';
		} else {
			$header .= '<a class="" data-tab="' . esc_attr( $key ) . '"' . iknow_panel_toogle( $elements, $key, $cat_ID ) . '>' . esc_html( $val ) . ' </a>';
		}
		$i ++;
	}
	$header .= '</p>';

	$content = '';

	$iknow_numberposts = get_theme_mod( 'iknow_home_post_number', 5 );

	$posts_arg = array(
		'numberposts' => $iknow_numberposts,
		'category'    => $cat_ID,
	);

	$i = 0;
	foreach ( $elements as $key => $val ) {
		if ( $i === 0 ) {
			$content .= '<div data-content="' . esc_attr( $key ) . '" class="tabs-content ttt"' . iknow_panel_content_toogle( $elements, $key, $cat_ID ) . '>';
		} else {
			$content .= '<div data-content="' . esc_attr( $key ) . '" class="tabs-content is-hidden"' . iknow_panel_content_toogle( $elements, $key, $cat_ID ) . '>';
		}

		if ( $key === 'subcats' ) {
			foreach ( $child_cats as $cat ) {
				$cat_icon = apply_filters( 'iknow_category_icon', 'icon-folder', $cat->cat_ID );
				$cat_link = get_category_link( $cat->cat_ID );
				$content  .= '<a class="panel-block" href="' . esc_url( $cat_link ) . '">';
				$content  .= '<span class="panel-icon ' . esc_attr( $cat_icon ) . '"></span>';
				$content  .= esc_html( $cat->cat_name );
				$content  .= '</a>';
			}
		} else {
			$posts_arg['orderby'] = $key;
			$posts                = get_posts( $posts_arg );
			$post_icon            = apply_filters( 'iknow_post_icon', 'icon-doc' );
			foreach ( $posts as $single ) {
				setup_postdata( $single );
				$content .= '<a class="panel-block" href="' . esc_url( get_permalink( $single->ID ) ) . '">';
				$content .= '<span class="panel-icon"><span class="' . esc_attr( $post_icon ) . '"></span></span>';
				$content .= esc_html( $single->post_title );
				$content .= '</a>';
			}
		}
		$content .= '</div>';
		$i ++;
	}
	$btn_color = get_theme_mod( 'iknow_view_btn_color', 'is-primary' );
	$cat_link  = get_category_link( $cat_ID );
	$link      = '<div class="panel-block">';
	$link      .= '<a href="' . esc_url( $cat_link ) . '" class="button ' . esc_attr( $btn_color ) . ' is-outlined is-fullwidth ">' . esc_attr__( 'View all', 'iknow' ) . '</a>';
	$link      .= '</div>';

	return $header . $content . $link;
}

function iknow_panel_toogle( $elements, $key, $cat_ID ) {
	if ( iknow_is_amp() ) {
		$attr    = ' on="tap:AMP.setState({panelMenuExpanded_' . $cat_ID . ': \'' . $key . '\'})" ';
		$default = array_key_exists( 'subcats', $elements ) ? 'subcats' : 'date';
		$attr    .= "[class]=\"panelMenuExpanded_" . $cat_ID . " ? (panelMenuExpanded_" . $cat_ID . " == '" . $key . "' ? 'is-active' : '') : ('" . $key . "' == '" . $default . "' ? 'is-active' : '')\"";

		return $attr;
	}
}

function iknow_panel_content_toogle( $elements, $key, $cat_ID ) {
	if ( iknow_is_amp() ) {
		$default = array_key_exists( 'subcats', $elements ) ? 'subcats' : 'date';
		$attr    = " [class]=\"panelMenuExpanded_" . $cat_ID . " ? (panelMenuExpanded_" . $cat_ID . " == '" . $key . "' ? '' : 'is-hidden') : ('" . $key . "' == '" . $default . "' ? '' : 'is-hidden')\"";

		return $attr;
	}
}

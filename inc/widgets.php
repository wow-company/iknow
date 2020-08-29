<?php
/**
 * Iknow Widgets
 *
 * @package Iknow
 * @subpackage Iknow
 * @since Iknow 1.0
 */

get_template_part( 'inc/widgets/class-widget-current-nav' );


if ( ! function_exists( 'iknow_widgets_include' ) ) {
	function iknow_widgets_include() {
		register_widget( 'Iknow_Widget_Current_Nav' );

	}
}
add_action( 'widgets_init', 'iknow_widgets_include' );

// Add container with class content to widgets
function iknow_add_container_widget( $params ) {

	$widgets_id = array(
		'categories',
		'recent-posts',
		'archives',
		'meta',
		'pages',
		'recent-comments',
		'text',
	);

	foreach ( $widgets_id as $id ) {
		$is_in = stripos( $params[0]['widget_id'], $id );
		if ( $is_in !== false ) {
			$params[0]['before_widget'] .= '<div class="content">';
			$params[0]['after_widget']  = '</div>' . $params[0]['after_widget'];
			break;
		}

	}

	return $params;
}

add_filter( 'dynamic_sidebar_params', 'iknow_add_container_widget' );
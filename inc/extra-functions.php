<?php
/**
 * Extra functions
 *
 * @package Iknow
 * @subpackage Iknow
 * @since Iknow 1.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'get_custom_logo', 'iknow_logo_class' );
function iknow_logo_class( $html ) {

	$html = str_replace( 'custom-logo-link', 'navbar-item', $html );

	return $html;
}

add_filter( 'iknow_comment_form_default_fields', 'iknow_show_comments_cookies_opt_in' );
function iknow_show_comments_cookies_opt_in( $fields ) {
	$check_cookie = get_option( 'show_comments_cookies_opt_in' );
	if ( ! $check_cookie ) {
		unset ( $fields['cookies'] );
	}

	return $fields;
}

// Widget Nav Menu filter
add_filter( 'widget_nav_menu_args', 'iknow_filter_widget_nav_menu', 10, 4 );
function iknow_filter_widget_nav_menu( $nav_menu_args, $nav_menu, $args, $instance ) {

	$args = array(
		'container'       => 'nav',
		'container_class' => 'menu',
		'menu_class'      => 'menu-list',
	);

	$nav_menu_args = wp_parse_args( $args, $nav_menu_args );

	return $nav_menu_args;
}

add_filter( 'get_the_archive_title', 'iknow_filter_archive_title' );
function iknow_filter_archive_title( $title ) {
	$title    = preg_replace( '~^[^:]+: ~', '', $title );
	$term     = get_queried_object();
	$cat_icon = apply_filters( 'iknow_category_icon', '', $term->term_taxonomy_id );
	if ( ! empty( $cat_icon ) ) {
		$title = '<span class="' . esc_attr( $cat_icon ) . '"></span> ' . $title;
	}

	return $title;
}

add_filter( 'widget_tag_cloud_args', 'iknow_change_tag_cloud_font_sizes' );
function iknow_change_tag_cloud_font_sizes( array $args ) {
	$args['smallest'] = '12';
	$args['largest']  = '12';

	return $args;
}

add_filter( 'wp_generate_tag_cloud_data', 'iknow_add_hash_tags_cloud' );
function iknow_add_hash_tags_cloud( $tags_data ) {

	foreach ( $tags_data as $key => $tag_data ) {
		foreach ( $tag_data as $data => $value ) {
			if ( $data === 'name' ) {
				$tags_data[ $key ][ $data ] = '#' . $value;
			} elseif ( $data === 'class' ) {
				$tags_data[ $key ][ $data ] = 'is-italic has-text-weight-light ' . esc_attr( $value );
			}
		}
	}

	return $tags_data;
}

add_filter( 'post_gallery', 'iknow_gallery_output', 10, 3 );
function iknow_gallery_output( $output, $attr, $instance ) {

	global $post, $wp_locale;

	$html5 = current_theme_supports( 'html5', 'gallery' );
	$atts  = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => $html5 ? 'div' : 'dl',
		'icontag'    => $html5 ? 'figure' : 'dt',
		'captiontag' => $html5 ? 'figcaption' : 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'exclude'    => '',
		'link'       => ''
	), $attr, 'gallery' );

	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts( array(
			'include'        => $atts['include'],
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => $atts['order'],
			'orderby'        => $atts['orderby']
		) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[ $val->ID ] = $_attachments[ $key ];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children( array(
			'post_parent'    => $id,
			'exclude'        => $atts['exclude'],
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => $atts['order'],
			'orderby'        => $atts['orderby']
		) );
	} else {
		$attachments = get_children( array(
			'post_parent'    => $id,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => $atts['order'],
			'orderby'        => $atts['orderby']
		) );
	}

	if ( empty( $attachments ) ) {
		return '';
	}

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}

		return $output;
	}

	$itemtag    = tag_escape( $atts['itemtag'] );
	$captiontag = tag_escape( $atts['captiontag'] );
	$icontag    = tag_escape( $atts['icontag'] );
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) ) {
		$itemtag = 'dl';
	}
	if ( ! isset( $valid_tags[ $captiontag ] ) ) {
		$captiontag = 'dd';
	}
	if ( ! isset( $valid_tags[ $icontag ] ) ) {
		$icontag = 'dt';
	}

	$columns   = intval( $atts['columns'] );
	$itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
	$float     = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = '';

	/**
	 * Filter whether to print default gallery styles.
	 *
	 * @param bool $print Whether to print default gallery styles.
	 *                    Defaults to false if the theme supports HTML5 galleries.
	 *                    Otherwise, defaults to true.
	 *
	 * @since 3.1.0
	 *
	 */
	if ( apply_filters( 'iknow_use_default_gallery_style', ! $html5 ) ) {
		$gallery_style = "
	<style type='text/css'>
		#{$selector} {
			margin: auto;
		}
		#{$selector} .gallery-item {
			float: {$float};
			margin-top: 10px;
			text-align: center;
			width: {$itemwidth}%;
		}
		#{$selector} img {
			border: 2px solid #cfcfcf;
		}
		#{$selector} .gallery-caption {
			margin-left: 0;
		}
		/* see gallery_shortcode() in wp-includes/media.php */
	</style>\n\t\t";
	}

	switch ( $columns ) {
		case '1':
			$column = ' is-full';
			break;
		case '2':
			$column = ' is-half';
			break;
		case '3':
			$column = ' is-one-third';
			break;
		case '4':
			$column = ' is-one-quarter';
			break;
		default:
			$column = '';
			break;
	}


	$size_class  = sanitize_html_class( $atts['size'] );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} columns is-multiline gallery-size-{$size_class}'>";

	/**
	 * Filter the default gallery shortcode CSS styles.
	 *
	 * @param string $gallery_style Default CSS styles and opening HTML div container
	 *                              for the gallery shortcode output.
	 *
	 * @since 2.5.0
	 *
	 */
	$output = apply_filters( 'iknow_gallery_style', $gallery_style . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {

		$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
		if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
			$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
		} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
			$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
		} else {
			$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
		}
		$image_meta = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
		}
		$output .= "<{$itemtag} class='gallery-item column{$column}'>";
		$output .= "
		<{$icontag} class='gallery-icon is-marginless image {$orientation}'>
			$image_output
		";
		if ( $captiontag && trim( $attachment->post_excerpt ) ) {
			$output .= "
			<{$captiontag} class='wp-caption-text gallery-caption is-italic is-size-7 has-text-dark' id='$selector-$id'>
			" . wptexturize( $attachment->post_excerpt ) . "
			</{$captiontag}>";
		}
		$output .= "</{$icontag}></{$itemtag}>";
		if ( ! $html5 && $columns > 0 && ++ $i % $columns == 0 ) {
			$output .= '<br style="clear: both" />';
		}
	}

	if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
		$output .= "
		<br style='clear: both' />";
	}

	$output .= "
	</div>\n";

	return $output;
}

// Filter Pagination page link
function iknow_link_pages_link( $link, $i ) {

	$new_link = str_replace( 'post-page-numbers', 'button is-black is-small', $link );
	$new_link = str_replace( 'current', 'is-outlined', $new_link );
	$link     = $new_link;

	return $link;

}

add_filter( 'wp_link_pages_link', 'iknow_link_pages_link', 10, 2 );

// Filter the tags link
add_filter( 'term_links-post_tag', 'iknow_filter_tags_link', 10, 5 );
function iknow_filter_tags_link( $links ) {

	$links = str_replace( 'rel="tag">', 'class="is-italic has-text-weight-light" rel="tag">#', $links );

	return $links;
}

add_filter( 'iknow_category_home_args', 'iknow_filter_categories_homepage' );
function iknow_filter_categories_homepage( $arg ) {
	$iknow_option = get_theme_mod( 'iknow_home', '' );

	$orderby = ! empty( $iknow_option['cat_orderby'] ) ? $iknow_option['cat_orderby'] : 'name';
	$order   = ! empty( $iknow_option['cat_order'] ) ? $iknow_option['cat_order'] : 'ASC';
	$exclude = ! empty( $iknow_option['cat_exclude'] ) ? $iknow_option['cat_exclude'] : '';
	$include = ! empty( $iknow_option['cat_include'] ) ? $iknow_option['cat_include'] : '';

	$new_args = array(
		'orderby'    => $orderby,
		'order'      => $order,
		'hide_empty' => 1,
		'exclude'    => $exclude,
		'include'    => $include,
	);

	$arg = wp_parse_args( $new_args, $arg );

	return $arg;
}

// Post Icon filter
add_filter( 'iknow_post_icon', 'iknow_filter_post_icon' );
function iknow_filter_post_icon( $icon ) {
	$iknow_option = get_option( 'iknow_settings', '' );
	$post_icon    = ! empty( $iknow_option['post_icon'] ) ? $iknow_option['post_icon'] : '';
	if ( ! empty( $post_icon ) ) {
		$icon = $post_icon;
	}

	return $icon;

}

// Add class to comment reply link
add_filter( 'comment_reply_link', 'iknow_filter_replay_comment_link' );
function iknow_filter_replay_comment_link( $link ) {

	$link = str_replace( 'comment-reply-link', 'comment-reply-link button is-radiusless is-small is-info is-outlined', $link );

	return $link;
}

// Add class to the comment reply link
add_filter( 'cancel_comment_reply_link', 'iknow_filter_cancel_comment_reply_link' );
function iknow_filter_cancel_comment_reply_link( $formatted_link ) {

	$formatted_link = str_replace( 'id="cancel-comment-reply-link"', 'id="cancel-comment-reply-link" class="button is-radiusless is-small is-danger is-outlined"', $formatted_link );

	return $formatted_link;

}

function iknow_the_posts_pagination() {
	$args = array(
		'show_all'           => false,
		'end_size'           => 1,
		'mid_size'           => 1,
		'prev_next'          => true,
		'prev_text'          => esc_attr__( 'Previous', 'iknow' ),
		'next_text'          => esc_attr__( 'Next page', 'iknow' ),
		'add_args'           => false,
		'add_fragment'       => '',
		'screen_reader_text' => esc_attr__( 'Posts navigation', 'iknow' ),
	);

	the_posts_pagination( $args );
}

function iknow_menu_nav_classes( $classes ) {
	$iknow_option          = get_option( 'iknow_settings', '' );
	$iknow_menu_background = get_theme_mod( 'iknow_menu_color_scheme', '' );
	$color                 = ! empty( $iknow_menu_background ) ? ' ' . $iknow_menu_background : '';
	$space                 = ! empty( $iknow_option['menu_space'] ) ? '' : ' is-spaced';
	$shadow                = ! empty( $iknow_option['menu_shadow'] ) ? '' : ' has-shadow';
	$fixed                 = ! empty( $iknow_option['menu_fixed'] ) ? ' is-fixed-top' : '';
	$transparent           = ! empty( $iknow_option['menu_transparent'] ) ? ' is-transparent' : '';

	$classes = $color . $space . $shadow . $fixed . $transparent;

	return $classes;
}

add_filter( 'iknow_menu_nav_classes', 'iknow_menu_nav_classes' );


function iknow_body_fixed_menu_class( $classes ) {
	$iknow_option          = get_option( 'iknow_settings', '' );
	$iknow_menu_fixed_body = ! empty( $iknow_option['menu_fixed'] ) ? ' has-navbar-fixed-top' : '';

	$classes[] = $iknow_menu_fixed_body;

	return $classes;
}

add_filter( 'body_class', 'iknow_body_fixed_menu_class' );


function iknow_main_section_class( $classes ) {
	$iknow_option     = get_option( 'iknow_home', '' );
	$iknow_hero_color = get_theme_mod( 'iknow_home_hero_color_scheme', 'is-primary' );
	$gradient         = ! empty( $iknow_option['hero_gradient'] ) ? '' : ' is-bold';
	$background       = ! empty( $iknow_hero_color ) ? ' ' . $iknow_hero_color : ' is-primary';

	$classes = $background . $gradient;

	return $classes;

}

add_filter( 'iknow_hero_classes', 'iknow_main_section_class' );

function iknow_get_nav_search_form() {
	$iknow_option = get_option( 'iknow_settings', '' );
	if ( empty( $iknow_option['menu_searchform'] ) ) {
		return;
	}
	?>
    <div class="navbar-item">
        <form role="search" method="get" id="navsearchform" class="navsearch-form"
              action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php $iknow_form_id = rand( 100, 9999 ); ?>
            <div class="field has-addons">
                <div class="control has-icons-left is-expanded">
                    <label class="screen-reader-text"
                           for="s<?php echo absint( $iknow_form_id ); ?>"><?php esc_html_x( 'Search for:', 'label', 'iknow' ); ?></label>
                    <input type="text" value="<?php the_search_query(); ?>" name="s"
                           id="s<?php echo absint( $iknow_form_id ); ?>"
                           placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'iknow' ); ?>"
                           class="input"/><span class="icon is-small is-left"><i class="icon-search"></i></span>
                </div>
            </div>
        </form>
    </div>
	<?php
}
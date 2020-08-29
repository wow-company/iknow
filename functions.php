<?php
/**
 * Functions and definitions
 *
 * @package Iknow
 * @subpackage Iknow
 * @since Iknow 1.0
 */

if ( ! defined( 'IKNOW_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'IKNOW_VERSION', '1.1.3' );
}

if ( ! function_exists( 'iknow_setup' ) ) :
	function iknow_setup() {
		// keep the media in check
		if ( ! isset( $content_width ) ) {
			$content_width = 762;
		}

		/*
			* Make theme available for translation.
			* Translations can be filed in the /languages/ directory.
		*/
		load_theme_textdomain( 'iknow', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
			 */
		add_theme_support( 'title-tag' );

		/*
			* This theme styles the visual editor to resemble the theme style,
			* specifically font, colors, icons, and column width.
		*/
//		add_editor_style( array( 'inc/assets/css/editor-style.css', get_template_directory() ) );

		// Enable support for Custom Logo for site.
		add_theme_support( 'custom-logo', array(
			'height' => 30,
		) );

		/*
			* Enable support for Post Thumbnails on posts and pages.
		*/
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'start-nav' => esc_attr__( 'Left Menu', 'iknow' ),
			'end-nav'   => esc_attr__( 'Right Menu', 'iknow' ),
			'footer'    => esc_attr__( 'Footer Menu', 'iknow' ),
		) );

		// Enable support for HTML5 markup.
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
	}
endif;
add_action( 'after_setup_theme', 'iknow_setup' );

function iknow_scripts() {
	$iknow_option = get_option( 'iknow_settings', '' );
	$fontawesome  = ! empty( $iknow_option['fontawesome'] ) ? 1 : 0;
	$dashicons    = ! empty( $iknow_option['dashicons'] ) ? 1 : 0;
	$pre_suffix   = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	$template_uri = get_template_directory_uri();

	wp_enqueue_style( 'iknow', $template_uri . '/assets/css/style' . $pre_suffix . '.css', '', IKNOW_VERSION );

	if ( $fontawesome ) {
		wp_enqueue_style( 'fontawesome', $template_uri . '/assets/vendors/fontawesome/css/all' . $pre_suffix . '.css', '', '5.12.0' );
	}

	if ( $dashicons ) {
		wp_enqueue_style( 'dashicons' );
	}

	wp_enqueue_script( 'iknow', $template_uri . '/assets/js/script' . $pre_suffix . '.js', array(), IKNOW_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'iknow_scripts' );


function iknow_admin_scripts( $hook_suffix ) {
	if ( $hook_suffix === 'edit.php' || $hook_suffix === 'edit-comments.php' ) {
		$template_uri = get_template_directory_uri();
		$pre_suffix   = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_style( 'admin-iknow', $template_uri . '/assets/css/admin-style' . $pre_suffix . '.css', '', '1.0' );
	}
}

add_action( 'admin_enqueue_scripts', 'iknow_admin_scripts' );

function iknow_widgets_init() {
	register_sidebar( array(
		'name'          => esc_attr__( 'Sidebar', 'iknow' ),
		'id'            => 'sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s box">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="title is-size-4">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_attr__( 'Footer Left', 'iknow' ),
		'id'            => 'footer-sidebar-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s box is-shadowless has-background-white-bis is-size-7">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="title is-size-5">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_attr__( 'Footer Center', 'iknow' ),
		'id'            => 'footer-sidebar-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s box is-shadowless has-background-white-bis is-size-7">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="title is-size-5">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_attr__( 'Footer Right', 'iknow' ),
		'id'            => 'footer-sidebar-3',
		'before_widget' => '<div id="%1$s" class="widget %2$s box is-shadowless has-background-white-bis is-size-7">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="title is-size-5">',
		'after_title'   => '</h4>',
	) );

}

add_action( 'widgets_init', 'iknow_widgets_init' );

require get_template_directory() . '/inc/class-navigation.php';
require get_template_directory() . '/inc/class-comments.php';
require get_template_directory() . '/inc/extra-functions.php';
require get_template_directory() . '/inc/extra-single.php';
require get_template_directory() . '/inc/home-posts.php';
require get_template_directory() . '/inc/extra-archive.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/widgets.php';

if ( is_admin() ) {
// Recommend plugins
	require_once( get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php' );
	require_once( get_template_directory() . '/inc/plugins/tgm-plugin-activation.php' );
}


function iknow_theme_info_notice_notice() {

	if ( get_user_meta( get_current_user_id(), 'iknow_dismissed_notice', true ) === IKNOW_VERSION ) {
		return;
	}

	$message = esc_attr__( 'Some information about WordPress theme Iknow!', 'iknow' );
	$links   = '<a href="https://wow-estore.com/docs/about-iknow-wordpress-theme/" target="_blank">' . esc_attr__( 'Documentation', 'iknow' ) . '</a> | ';
	$links   .= '<a href="https://wow-estore.com/docs/changelog/" target="_blank">' . esc_attr__( 'Changelog', 'iknow' ) . '</a> | ';
	$links   .= '<a href="https://wordpress.org/support/theme/iknow/" target="_blank">' . esc_attr__( 'Support Forum', 'iknow' ) . '</a> | ';
	$links   .= '<a href="https://wordpress.org/support/theme/iknow/reviews/#new-post" target="_blank">' . esc_attr__( 'Rate Theme on WordPress.org', 'iknow' ) . '</a> | ';
	$links   .= '<a href="' . esc_url( wp_nonce_url( add_query_arg( 'iknow-dismiss', 'dismiss_admin_notices' ), 'iknow-dismiss-' . get_current_user_id() ) ) . '">' . esc_attr__( 'Dismiss this notice', 'iknow' ) . '</a>';
	$email   = esc_attr__( 'Have any idea? Write us on email', 'iknow' ) . ' <a href="mailto:support@wow-company.com">support@wow-company.com</a>';

	$notice = '
	<div class="notice notice-info is-dismissible">
	<p style="color: red;"><strong><u>' . $message . '</u></strong></p>	
	<p><strong>' . $email . '</strong></p>
	<p><strong>' . $links . '</strong></p>
	</div>';

	echo wp_kses_post( $notice );
}

add_action( 'admin_notices', 'iknow_theme_info_notice_notice' );

function iknow_theme_info_dismiss_notice() {
	if ( isset( $_GET['iknow-dismiss'] ) && check_admin_referer( 'iknow-dismiss-' . get_current_user_id() ) ) {
		update_user_meta( get_current_user_id(), 'iknow_dismissed_notice', IKNOW_VERSION );
	}
}

add_action( 'admin_head', 'iknow_theme_info_dismiss_notice' );
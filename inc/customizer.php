<?php
/**
 * iknow Theme Customizer
 *
 * @package iknow
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function iknow_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-name',
				'render_callback' => 'iknow_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'iknow_customize_partial_blogdescription',
			)
		);
	}


	$wp_customize->add_setting( 'iknow_home[cat_orderby]', array(
		'default'           => 'name',
		'sanitize_callback' => 'iknow_sanitize_cat_orderby',
	) );
	$wp_customize->add_control( 'iknow_home[cat_orderby]', array(
		'type'    => 'select',
		'label'   => esc_attr__( 'Categories Order by:', 'iknow' ),
		'section' => 'static_front_page',
		'choices' => array(
			'name' => esc_attr__( 'Name', 'iknow' ),
			'ID'   => esc_attr__( 'ID', 'iknow' ),
		),
	) );

	$wp_customize->add_setting( 'iknow_home[cat_order]', array(
		'default'           => 'ASC',
		'sanitize_callback' => 'iknow_sanitize_cat_order',
	) );
	$wp_customize->add_control( 'iknow_home[cat_order]', array(
		'type'    => 'select',
		'label'   => esc_attr__( 'Categories Order:', 'iknow' ),
		'section' => 'static_front_page',
		'choices' => array(
			'ASC'  => esc_attr__( 'ASC', 'iknow' ),
			'DESC' => esc_attr__( 'DESC', 'iknow' ),
		),
	) );


	$wp_customize->add_setting( 'iknow_home[cat_exclude]', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'iknow_home[cat_exclude]', array(
		'type'        => 'text',
		'label'       => esc_attr__( 'Exclude Categories:', 'iknow' ),
		'section'     => 'static_front_page',
		'description' => esc_attr__( 'Exclude categories. A comma-separated string of category ids to exclude along with all of their descendant categories.', 'iknow' ),
	) );

	$wp_customize->add_setting( 'iknow_home[cat_include]', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'iknow_home[cat_include]', array(
		'type'        => 'text',
		'label'       => esc_attr__( 'Include Categories:', 'iknow' ),
		'section'     => 'static_front_page',
		'description' => esc_attr__( 'Include categories. A comma-separated string of category ids.', 'iknow' ),
	) );


	$wp_customize->add_section( 'iknow_settings', array(
		'title'       => esc_attr__( 'Theme Settings', 'iknow' ),
		'description' => __( 'Main theme settings.', 'iknow' ),
		'priority'    => 15,
	) );

	$wp_customize->add_setting( 'iknow_settings[fontawesome]', array(
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'default'           => 0,
		'sanitize_callback' => 'iknow_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'iknow_settings[fontawesome]', array(
		'label'   => esc_attr__( 'Enable Font Awesome', 'iknow' ),
		'section' => 'iknow_settings',
		'type'    => 'checkbox',

	) );

	$wp_customize->add_setting( 'iknow_settings[dashicons]', array(
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'default'           => 0,
		'sanitize_callback' => 'iknow_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'iknow_settings[dashicons]', array(
		'label'   => esc_attr__( 'Enable Dashicons', 'iknow' ),
		'section' => 'iknow_settings',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'iknow_settings[post_icon]', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'option',
	) );

	$wp_customize->add_control( 'iknow_settings[post_icon]', array(
		'label'       => esc_attr__( 'Post icon', 'iknow' ),
		'section'     => 'iknow_settings',
		'description' => esc_attr__( 'Enter Icon class (for example: fab fa-font-awesome-flag). Before using, you need to include on the site any icon font.', 'iknow' ),
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'iknow_settings[footer_text]', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '&copy; ' . date_i18n( esc_attr__( 'Y', 'iknow' ) ) . ' ' . get_bloginfo( 'name' ),
		'type'              => 'option',
	) );

	$wp_customize->add_control( 'iknow_settings[footer_text]', array(
		'label'       => esc_attr__( 'Footer Text', 'iknow' ),
		'section'     => 'iknow_settings',
		'description' => esc_attr__( 'Enter custom footer text.', 'iknow' ),
		'type'        => 'text',
	) );

}

add_action( 'customize_register', 'iknow_customize_register' );


function iknow_sanitize_cat_orderby( $input ) {
	$valid = array(
		'name' => esc_attr__( 'Name', 'iknow' ),
		'ID'   => esc_attr__( 'ID', 'iknow' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return 'name';
	}
}

function iknow_sanitize_cat_order( $input ) {
	$valid = array(
		'ASC'  => esc_attr__( 'ASC', 'iknow' ),
		'DESC' => esc_attr__( 'DESC', 'iknow' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return 'ASC';
	}
}


function iknow_sanitize_checkbox( $input ) {
	if ( 1 == $input ) {
		return 1;
	} else {
		return 0;
	}
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function iknow_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function iknow_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function iknow_customize_preview_js() {
	wp_enqueue_script( 'iknow-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), IKNOW_VERSION, true );
}

add_action( 'customize_preview_init', 'iknow_customize_preview_js' );


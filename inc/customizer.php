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

	$wp_customize->add_panel( 'iknow_settings', array(
		'title'       => esc_attr__( 'Theme Settings', 'iknow' ),
		'description' => esc_attr__( 'Main theme settings.', 'iknow' ),
		'priority'    => 10,
	) );

	//region Main colors
	$wp_customize->add_section( 'iknow_section_color_settings', array(
		'title'    => esc_attr__( 'Main colors', 'iknow' ),
		'priority' => 10,
		'panel'    => 'iknow_settings',
	) );

	$wp_customize->add_setting( 'iknow_home_hero_color_scheme', array(
		'default'           => 'is-primary',
		'sanitize_callback' => 'iknow_sanitize_color_scheme',
	) );
	$wp_customize->add_control( 'iknow_home_hero_color_scheme', array(
		'type'    => 'select',
		'label'   => esc_attr__( 'Main section background:', 'iknow' ),
		'section' => 'iknow_section_color_settings',
		'choices' => array(
			'is-primary' => esc_attr__( 'Turquoise', 'iknow' ),
			'is-link'    => esc_attr__( 'Blue', 'iknow' ),
			'is-info'    => esc_attr__( 'Cyan', 'iknow' ),
			'is-success' => esc_attr__( 'Green', 'iknow' ),
			'is-warning' => esc_attr__( 'Yellow', 'iknow' ),
			'is-danger'  => esc_attr__( 'Red', 'iknow' ),
			'is-black'   => esc_attr__( 'Black', 'iknow' ),
			'is-dark'    => esc_attr__( 'Dark', 'iknow' ),
			'is-light'   => esc_attr__( 'Light', 'iknow' ),
			'is-white'   => esc_attr__( 'White', 'iknow' ),
		),
	) );

	$wp_customize->add_setting( 'iknow_home[hero_gradient]', array(
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'default'           => 0,
		'sanitize_callback' => 'iknow_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'iknow_home[hero_gradient]', array(
		'label'   => esc_attr__( 'Remove main section gradient', 'iknow' ),
		'section' => 'iknow_section_color_settings',
		'type'    => 'checkbox',
	) );


	$wp_customize->add_setting( 'iknow_search_button_color_scheme]', array(
		'default'           => 'is-success',
		'sanitize_callback' => 'iknow_sanitize_color_scheme',
	) );
	$wp_customize->add_control( 'iknow_search_button_color_scheme', array(
		'type'    => 'select',
		'label'   => esc_attr__( 'Search button color:', 'iknow' ),
		'section' => 'iknow_section_color_settings',
		'choices' => array(
			'is-primary' => esc_attr__( 'Turquoise', 'iknow' ),
			'is-link'    => esc_attr__( 'Blue', 'iknow' ),
			'is-info'    => esc_attr__( 'Cyan', 'iknow' ),
			'is-success' => esc_attr__( 'Green', 'iknow' ),
			'is-warning' => esc_attr__( 'Yellow', 'iknow' ),
			'is-danger'  => esc_attr__( 'Red', 'iknow' ),
			'is-black'   => esc_attr__( 'Black', 'iknow' ),
			'is-dark'    => esc_attr__( 'Dark', 'iknow' ),
			'is-light'   => esc_attr__( 'Light', 'iknow' ),
			'is-white'   => esc_attr__( 'White', 'iknow' ),
		),
	) );

	$wp_customize->add_setting( 'iknow_search_button_color_light', array(
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'default'           => 0,
		'sanitize_callback' => 'iknow_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'iknow_search_button_color_light', array(
		'label'   => esc_attr__( 'Search button light version', 'iknow' ),
		'section' => 'iknow_section_color_settings',
		'type'    => 'checkbox',
	) );

	//endregion

	//region Navigation Menu Settings
	$wp_customize->add_section( 'iknow_navbar', array(
		'title'    => esc_attr__( 'Navigation menu', 'iknow' ),
		'priority' => 10,
		'panel'    => 'iknow_settings',
	) );

	$wp_customize->add_setting( 'iknow_settings[menu_space]', array(
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'default'           => 0,
		'sanitize_callback' => 'iknow_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'iknow_settings[menu_space]', array(
		'label'   => esc_attr__( 'Remove Menu space', 'iknow' ),
		'section' => 'iknow_navbar',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'iknow_settings[menu_shadow]', array(
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'default'           => 0,
		'sanitize_callback' => 'iknow_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'iknow_settings[menu_shadow]', array(
		'label'   => esc_attr__( 'Remove Menu shadow', 'iknow' ),
		'section' => 'iknow_navbar',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'iknow_settings[menu_fixed]', array(
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'default'           => 0,
		'sanitize_callback' => 'iknow_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'iknow_settings[menu_fixed]', array(
		'label'   => esc_attr__( 'Fixed Menu', 'iknow' ),
		'section' => 'iknow_navbar',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'iknow_settings[menu_transparent]', array(
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'default'           => 0,
		'sanitize_callback' => 'iknow_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'iknow_settings[menu_transparent]', array(
		'label'   => esc_attr__( 'Remove any hover or active background from the navbar items', 'iknow' ),
		'section' => 'iknow_navbar',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'iknow_settings[menu_searchform]', array(
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'default'           => 0,
		'sanitize_callback' => 'iknow_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'iknow_settings[menu_searchform]', array(
		'label'   => esc_attr__( 'Add search form to navigation menu', 'iknow' ),
		'section' => 'iknow_navbar',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'iknow_menu_color_scheme]', array(
		'default'           => '',
		'sanitize_callback' => 'iknow_sanitize_color_scheme',
	) );
	$wp_customize->add_control( 'iknow_menu_color_scheme', array(
		'type'    => 'select',
		'label'   => esc_attr__( 'Background color:', 'iknow' ),
		'section' => 'iknow_navbar',
		'choices' => array(
			''           => esc_attr__( 'Default', 'iknow' ),
			'is-primary' => esc_attr__( 'Turquoise', 'iknow' ),
			'is-link'    => esc_attr__( 'Blue', 'iknow' ),
			'is-info'    => esc_attr__( 'Cyan', 'iknow' ),
			'is-success' => esc_attr__( 'Green', 'iknow' ),
			'is-warning' => esc_attr__( 'Yellow', 'iknow' ),
			'is-danger'  => esc_attr__( 'Red', 'iknow' ),
			'is-black'   => esc_attr__( 'Black', 'iknow' ),
			'is-dark'    => esc_attr__( 'Dark', 'iknow' ),
			'is-light'   => esc_attr__( 'Light', 'iknow' ),
			'is-white'   => esc_attr__( 'White', 'iknow' ),
		),
	) );
	//endregion

	//region Home Category
	$wp_customize->add_section( 'iknow_home_category', array(
		'title'    => esc_attr__( 'Home page', 'iknow' ),
		'priority' => 10,
		'panel'    => 'iknow_settings',
	) );

	$wp_customize->add_setting( 'iknow_panel_color', array(
		'default'           => 'is-dark',
		'sanitize_callback' => 'iknow_sanitize_color_scheme',
	) );
	$wp_customize->add_control( 'iknow_panel_color', array(
		'type'    => 'select',
		'label'   => esc_attr__( 'Panel background:', 'iknow' ),
		'section' => 'iknow_home_category',
		'choices' => array(
			'is-primary' => esc_attr__( 'Turquoise', 'iknow' ),
			'is-link'    => esc_attr__( 'Blue', 'iknow' ),
			'is-info'    => esc_attr__( 'Cyan', 'iknow' ),
			'is-success' => esc_attr__( 'Green', 'iknow' ),
			'is-warning' => esc_attr__( 'Yellow', 'iknow' ),
			'is-danger'  => esc_attr__( 'Red', 'iknow' ),
			'is-black'   => esc_attr__( 'Black', 'iknow' ),
			'is-dark'    => esc_attr__( 'Dark', 'iknow' ),
			'is-light'   => esc_attr__( 'Light', 'iknow' ),
			'is-white'   => esc_attr__( 'White', 'iknow' ),
		),
	) );

	$wp_customize->add_setting( 'iknow_view_btn_color', array(
		'default'           => 'is-primary',
		'sanitize_callback' => 'iknow_sanitize_color_scheme',
	) );
	$wp_customize->add_control( 'iknow_view_btn_color', array(
		'type'    => 'select',
		'label'   => esc_attr__( 'View button color:', 'iknow' ),
		'section' => 'iknow_home_category',
		'choices' => array(
			'is-primary' => esc_attr__( 'Turquoise', 'iknow' ),
			'is-link'    => esc_attr__( 'Blue', 'iknow' ),
			'is-info'    => esc_attr__( 'Cyan', 'iknow' ),
			'is-success' => esc_attr__( 'Green', 'iknow' ),
			'is-warning' => esc_attr__( 'Yellow', 'iknow' ),
			'is-danger'  => esc_attr__( 'Red', 'iknow' ),
			'is-black'   => esc_attr__( 'Black', 'iknow' ),
			'is-dark'    => esc_attr__( 'Dark', 'iknow' ),
		),
	) );

	$wp_customize->add_setting( 'iknow_home_post_number', array(
		'default'           => '5',
		'sanitize_callback' => 'iknow_sanitize_number',
	) );
	$wp_customize->add_control( 'iknow_home_post_number', array(
		'type'        => 'number',
		'label'       => esc_attr__( 'Post Number', 'iknow' ),
		'section'     => 'iknow_home_category',
		'description' => esc_attr__( 'Set the numbers of posts on home page.', 'iknow' ),
	) );


	$wp_customize->add_setting( 'iknow_home[cat_orderby]', array(
		'default'           => 'name',
		'sanitize_callback' => 'iknow_sanitize_cat_orderby',
	) );
	$wp_customize->add_control( 'iknow_home[cat_orderby]', array(
		'type'    => 'select',
		'label'   => esc_attr__( 'Categories Order by:', 'iknow' ),
		'section' => 'iknow_home_category',
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
		'section' => 'iknow_home_category',
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
		'section'     => 'iknow_home_category',
		'description' => esc_attr__( 'Exclude categories. A comma-separated string of category ids to exclude along with all of their descendant categories.', 'iknow' ),
	) );

	$wp_customize->add_setting( 'iknow_home[cat_include]', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'iknow_home[cat_include]', array(
		'type'        => 'text',
		'label'       => esc_attr__( 'Include Categories:', 'iknow' ),
		'section'     => 'iknow_home_category',
		'description' => esc_attr__( 'Include categories. A comma-separated string of category ids.', 'iknow' ),
	) );
	//endregion

	//region Posts
	$wp_customize->add_section( 'iknow_posts_settings', array(
		'title'    => esc_attr__( 'Post', 'iknow' ),
		'priority' => 10,
		'panel'    => 'iknow_settings',
	) );

	$wp_customize->add_setting( 'iknow_settings[featured_image]', array(
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'default'           => 0,
		'sanitize_callback' => 'iknow_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'iknow_settings[featured_image]', array(
		'label'   => esc_attr__( 'Disabled featured image', 'iknow' ),
		'section' => 'iknow_posts_settings',
		'type'    => 'checkbox',
	) );
	//endregion

	//region Icons Settings
	$wp_customize->add_section( 'iknow_icons_settings', array(
		'title'    => esc_attr__( 'Icons', 'iknow' ),
		'priority' => 10,
		'panel'    => 'iknow_settings',
	) );

	$wp_customize->add_setting( 'iknow_settings[fontawesome]', array(
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'default'           => 0,
		'sanitize_callback' => 'iknow_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'iknow_settings[fontawesome]', array(
		'label'   => esc_attr__( 'Enable Font Awesome', 'iknow' ),
		'section' => 'iknow_icons_settings',
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
		'section' => 'iknow_icons_settings',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'iknow_settings[post_icon]', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'option',
	) );

	$wp_customize->add_control( 'iknow_settings[post_icon]', array(
		'label'       => esc_attr__( 'Post icon', 'iknow' ),
		'section'     => 'iknow_icons_settings',
		'description' => esc_attr__( 'Enter Icon class (for example: fab fa-font-awesome-flag). Before using, you need to include on the site any icon font.', 'iknow' ),
		'type'        => 'text',
	) );
	//endregion

	$wp_customize->add_section( 'iknow_archive', array(
		'title'    => esc_attr__( 'Archive', 'iknow' ),
		'priority' => 10,
		'panel'    => 'iknow_settings',
	) );

	$wp_customize->add_setting( 'iknow_archive_sort_color', array(
		'default'           => 'is-primary',
		'sanitize_callback' => 'iknow_sanitize_color_scheme',
	) );
	$wp_customize->add_control( 'iknow_archive_sort_color', array(
		'type'    => 'select',
		'label'   => esc_attr__( 'Sort dropdown color:', 'iknow' ),
		'section' => 'iknow_archive',
		'choices' => array(
			'is-primary' => esc_attr__( 'Turquoise', 'iknow' ),
			'is-link'    => esc_attr__( 'Blue', 'iknow' ),
			'is-info'    => esc_attr__( 'Cyan', 'iknow' ),
			'is-success' => esc_attr__( 'Green', 'iknow' ),
			'is-warning' => esc_attr__( 'Yellow', 'iknow' ),
			'is-danger'  => esc_attr__( 'Red', 'iknow' ),
			'is-black'   => esc_attr__( 'Black', 'iknow' ),
			'is-dark'    => esc_attr__( 'Dark', 'iknow' ),
		),
	) );

	$wp_customize->add_setting( 'iknow_settings_sort_size', array(
		'default'           => 'is-small',
		'sanitize_callback' => 'iknow_sanitize_size',
	) );
	$wp_customize->add_control( 'iknow_settings_sort_size', array(
		'type'    => 'select',
		'label'   => esc_attr__( 'Sort dropdown size:', 'iknow' ),
		'section' => 'iknow_archive',
		'choices' => array(
			'is-small'  => esc_attr__( 'Small', 'iknow' ),
			'is-normal' => esc_attr__( 'Normal', 'iknow' ),
			'is-medium' => esc_attr__( 'Medium', 'iknow' ),
			'is-large'  => esc_attr__( 'Large', 'iknow' ),
		),
	) );


	//region Footer Settings
	$wp_customize->add_section( 'iknow_footer', array(
		'title'    => esc_attr__( 'Footer', 'iknow' ),
		'priority' => 10,
		'panel'    => 'iknow_settings',
	) );

	$wp_customize->add_setting( 'iknow_settings[footer_text]', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '&copy; ' . date_i18n( esc_attr__( 'Y', 'iknow' ) ) . ' ' . get_bloginfo( 'name' ),
		'type'              => 'option',
	) );

	$wp_customize->add_control( 'iknow_settings[footer_text]', array(
		'label'       => esc_attr__( 'Footer Text', 'iknow' ),
		'section'     => 'iknow_footer',
		'description' => esc_attr__( 'Enter custom footer text.', 'iknow' ),
		'type'        => 'text',
	) );
	//endregion

	//region Widget colors
	$wp_customize->add_section( 'iknow_widget_settings', array(
		'title'       => esc_attr__( 'Widget style', 'iknow' ),
		'description' => esc_attr__( 'Style for widget "Iknow Current Nav".', 'iknow' ),
		'priority'    => 10,
		'panel'       => 'iknow_settings',
	) );

	$wp_customize->add_setting( 'iknow_widget_main_color', array(
		'default'           => 'has-background-link',
		'sanitize_callback' => 'iknow_sanitize_background_scheme',
	) );
	$wp_customize->add_control( 'iknow_widget_main_color', array(
		'type'    => 'select',
		'label'   => esc_attr__( 'Main background:', 'iknow' ),
		'section' => 'iknow_widget_settings',
		'choices' => array(
			'has-background-primary' => esc_attr__( 'Turquoise', 'iknow' ),
			'has-background-link'    => esc_attr__( 'Blue', 'iknow' ),
			'has-background-info'    => esc_attr__( 'Cyan', 'iknow' ),
			'has-background-success' => esc_attr__( 'Green', 'iknow' ),
			'has-background-warning' => esc_attr__( 'Yellow', 'iknow' ),
			'has-background-danger'  => esc_attr__( 'Red', 'iknow' ),
			'has-background-black'   => esc_attr__( 'Black', 'iknow' ),
			'has-background-dark'    => esc_attr__( 'Dark', 'iknow' ),
		),
	) );

	$wp_customize->add_setting( 'iknow_widget_current_color', array(
		'default'           => 'has-background-danger',
		'sanitize_callback' => 'iknow_sanitize_background_scheme',
	) );
	$wp_customize->add_control( 'iknow_widget_current_color', array(
		'type'    => 'select',
		'label'   => esc_attr__( 'Current post background:', 'iknow' ),
		'section' => 'iknow_widget_settings',
		'choices' => array(
			'has-background-primary' => esc_attr__( 'Turquoise', 'iknow' ),
			'has-background-link'    => esc_attr__( 'Blue', 'iknow' ),
			'has-background-info'    => esc_attr__( 'Cyan', 'iknow' ),
			'has-background-success' => esc_attr__( 'Green', 'iknow' ),
			'has-background-warning' => esc_attr__( 'Yellow', 'iknow' ),
			'has-background-danger'  => esc_attr__( 'Red', 'iknow' ),
		),
	) );


	//endregion
}

add_action( 'customize_register', 'iknow_customize_register' );

function iknow_sanitize_background_scheme( $input ) {
	$valid = array(
		'has-background-primary' => esc_attr__( 'Turquoise', 'iknow' ),
		'has-background-link'    => esc_attr__( 'Blue', 'iknow' ),
		'has-background-info'    => esc_attr__( 'Cyan', 'iknow' ),
		'has-background-success' => esc_attr__( 'Green', 'iknow' ),
		'has-background-warning' => esc_attr__( 'Yellow', 'iknow' ),
		'has-background-danger'  => esc_attr__( 'Red', 'iknow' ),
		'has-background-black'   => esc_attr__( 'Black', 'iknow' ),
		'has-background-dark'    => esc_attr__( 'Dark', 'iknow' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

function iknow_sanitize_color_scheme( $input ) {
	$valid = array(
		''           => esc_attr__( 'Default', 'iknow' ),
		'is-primary' => esc_attr__( 'Turquoise', 'iknow' ),
		'is-link'    => esc_attr__( 'Blue', 'iknow' ),
		'is-info'    => esc_attr__( 'Cyan', 'iknow' ),
		'is-success' => esc_attr__( 'Green', 'iknow' ),
		'is-warning' => esc_attr__( 'Yellow', 'iknow' ),
		'is-danger'  => esc_attr__( 'Red', 'iknow' ),
		'is-black'   => esc_attr__( 'Black', 'iknow' ),
		'is-dark'    => esc_attr__( 'Dark', 'iknow' ),
		'is-light'   => esc_attr__( 'Light', 'iknow' ),
		'is-white'   => esc_attr__( 'White', 'iknow' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

function iknow_sanitize_size( $input ) {
	$valid = array(
		'is-small'  => esc_attr__( 'Small', 'iknow' ),
		'is-normal' => esc_attr__( 'Normal', 'iknow' ),
		'is-medium' => esc_attr__( 'Medium', 'iknow' ),
		'is-large'  => esc_attr__( 'Large', 'iknow' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}


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

function iknow_sanitize_number($number, $setting) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );

	// If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
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


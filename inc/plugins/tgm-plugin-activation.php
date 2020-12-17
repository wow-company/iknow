<?php
/**
 * Recommends plugins for use with the theme via the TGMA Script
 *
 * @package OceanWP WordPress theme
 */

function iknow_tgmpa_register() {

	// Get array of recommended plugins
	$plugins = array();

	$plugins[] = array(
		'name'				=> 'Iknow Extra',
		'slug'				=> 'iknow-extra',
		'required'			=> true,
		'force_activation'	=> false,
	);

	// If  Pro is not active, recommend Lite
	if ( ! class_exists( '\side_menu_pro\Wow_Plugin' ) ) {
		$plugins[] = array(
			'name'				=> 'Side Menu Lite',
			'slug'				=> 'side-menu-lite',
			'required'			=> false,
			'force_activation'	=> false,
		);
	}

	if ( ! class_exists( '\popup_box_pro\Wow_Plugin' ) ) {
		$plugins[] = array(
			'name'				=> 'Popup Box',
			'slug'				=> 'popup-box',
			'required'			=> false,
			'force_activation'	=> false,
		);
	}

	if ( ! class_exists( '\herd_effects_pro\Wow_Plugin' ) ) {
		$plugins[] = array(
			'name'				=> 'Herd Effects',
			'slug'				=> 'mwp-herd-effect',
			'required'			=> false,
			'force_activation'	=> false,
		);
	}

	if ( ! class_exists( '\counter_box_pro\Wow_Plugin' ) ) {
		$plugins[] = array(
			'name'				=> 'Counter Box',
			'slug'				=> 'counter-box',
			'required'			=> false,
			'force_activation'	=> false,
		);
	}

	// Register notice
	tgmpa( $plugins, array(
		'id'           => 'iknow',
		'domain'       => '',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => false,
		'dismissable'  => true,
	) );

}
add_action( 'tgmpa_register', 'iknow_tgmpa_register' );
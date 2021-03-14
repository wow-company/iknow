<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
        <link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header>
	<?php if ( ! is_404() ) : ?>
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'iknow' ); ?></a>
		<?php $iknow_menu_classes = apply_filters('iknow_menu_nav_classes', ''); ?>
        <nav class="navbar <?php echo esc_attr( $iknow_menu_classes ); ?>" role="navigation"
             aria-label="<?php esc_attr_e( 'Main Navigation', 'iknow' ); ?>">
            <div class="container">
                <div class="navbar-brand">
					<?php if ( has_custom_logo() ) :
						the_custom_logo();
						?>
					<?php else : ?>
                        <a class="navbar-item" href="<?php echo esc_url( home_url( '/' ) ); ?>"
                           title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                            <span class="navbar-item has-text-info has-text-orbitron"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
                        </a>
					<?php endif; ?>

                    <a href="#" role="button" class="navbar-burger burger" id="navigation-burger"
                       aria-label="<?php esc_attr_e( 'Menu', 'iknow' ); ?>" aria-expanded="false"
                       data-target="main-menu" <?php iknow_amp_menu_toggle(); ?>>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>

                <div id="main-menu" class="navbar-menu" <?php iknow_amp_menu_is_toggled(); ?>>
                    <div class="navbar-start">
						<?php
						wp_nav_menu( array(
							'theme_location'  => 'start-nav',
							'depth'           => '2',
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => '',
							'menu_id'         => '',
							'items_wrap'      => '%3$s',
							'walker'          => new Iknow_Walker_Nav_Menu(),
							'fallback_cb'     => 'Iknow_Walker_Nav_Menu::fallback',
						) );
						?>
                    </div>

                    <div class="navbar-end">
						<?php
						wp_nav_menu( array(
							'theme_location'  => 'end-nav',
							'depth'           => '2',
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => '',
							'menu_id'         => '',
							'items_wrap'      => '%3$s',
							'walker'          => new Iknow_Walker_Nav_Menu(),
							'fallback_cb'     => 'Iknow_Walker_Nav_Menu::fallback',
						) );
						?>
                       <?php iknow_get_nav_search_form();?>
                    </div>
                </div>
            </div>
        </nav>
	<?php endif; ?>
</header>
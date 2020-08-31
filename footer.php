<?php
/**
 * the closing of the main content elements and the footer element
 *
 * @package WordPress
 * @subpackage Iknow
 * @since Iknow 1.0
 */
?>

<?php if ( ! is_404() ) : ?>


    <footer class="footer is-paddingless">
		<?php if ( is_active_sidebar( 'footer-sidebar-1' ) || is_active_sidebar( 'footer-sidebar-2' ) || is_active_sidebar( 'footer-sidebar-3' ) ) : ?>
            <div class="container">
                <div class="columns is-multiline py-5 px-0">
                    <div class="column is-full-touch">
						<?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) : ?>
							<?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
						<?php endif; ?>
                    </div>
                    <div class="column is-full-touch">
						<?php if ( is_active_sidebar( 'footer-sidebar-2' ) ) : ?>
							<?php dynamic_sidebar( 'footer-sidebar-2' ); ?>
						<?php endif; ?>
                    </div>
                    <div class="column is-full-touch">
						<?php if ( is_active_sidebar( 'footer-sidebar-3' ) ) : ?>
							<?php dynamic_sidebar( 'footer-sidebar-3' ); ?>
						<?php endif; ?>
                    </div>
                </div>
            </div>
		<?php endif; ?>
        <div class="has-background-grey-darker py-0 px-4">
            <div class="container is-size-7 has-text-white">
                <div class="columns">
					<?php
					$footer_menu = wp_nav_menu( array(
						'theme_location' => 'footer',
						'container'      => 'false',
						'menu_id'        => 'footer-menu',
						'menu_class'     => 'footer-menu',
						'depth'          => '1',
						'echo'           => false,
						'fallback_cb'    => '__return_empty_string',

					) );
					if ( ! empty( $footer_menu ) ) {
						echo '<div class="column">' . wp_kses_post( $footer_menu ) . '</div>';
					}
					$footer_text_class = ! empty( $footer_menu ) ? 'has-text-right-tablet' : 'has-text-centered';

					?>
                    <div class="column has-text-weight-semibold <?php echo esc_attr( $footer_text_class ); ?>">
						<?php
						$iknow_option = get_option( 'iknow_settings', '' );
						if ( isset( $iknow_option['footer_text'] ) ) {
							echo esc_attr( $iknow_option['footer_text'] );
						} else {
							echo '&copy; ' . esc_attr( date_i18n( esc_attr__( 'Y', 'iknow' ) ) ) . ' ' . esc_attr( get_bloginfo( 'name' ) );
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>

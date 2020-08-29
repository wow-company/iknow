<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage Iknow
 * @since Iknow 1.0
 */
?>


<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>

<aside id="sidebar">
	<?php dynamic_sidebar( 'sidebar' ); ?>
</aside>
<?php endif; ?>
	


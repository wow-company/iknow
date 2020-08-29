<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage MyStem
 * @since MyStem 1.0
 */

get_header(); ?>


<section class="hero is-primary is-bold is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title is-size-1">
                404 </h1>
            <h2 class="subtitle">
				<?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'iknow' ); ?>
            </h2>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button">
				<?php esc_html_e( 'Back to Home', 'iknow' ); ?>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>

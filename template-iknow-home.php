<?php
/**
 * Template Name: Iknow Home
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Iknow
 * @subpackage Iknow
 * @since Iknow 1.0
 */

get_header(); ?>
<section class="hero is-primary is-bold bg-image">
	<div class="hero-body">
		<div class="container has-text-centered">
			<h1 class="title is-1 is-family-secondary site-name">
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
			</h1>
			<h2 class="subtitle site-description">
				<?php echo esc_html( get_bloginfo( 'description' ) ); ?>
			</h2>
			<?php get_search_form(); ?>
		</div>
	</div>
</section>

<section class="section" id="content">
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
            <div class="content">
				<?php the_content(); ?>
            </div>
		<?php endwhile; // end of the loop. ?>
		<div class="columns is-multiline">
			<?php iknow_get_home_posts(); ?>
		</div>
	</div>
</section>


<?php get_footer(); ?>

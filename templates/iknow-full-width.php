<?php
/**
 * Template Name: Full-width Page
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Iknow
 * @subpackage Iknow
 * @since Iknow 1.2
 */

get_header();
$iknow_hero_classes = apply_filters('iknow_hero_classes', '');
?>

    <section class="hero <?php echo esc_attr($iknow_hero_classes);?>" id="content">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title is-3 is-family-secondary is-uppercase">
					<?php the_title(); ?>
                </h1>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content/content', 'template-page' ); ?>
				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
				?>
			<?php endwhile; // end of the loop. ?>
        </div>
    </section>

<?php get_footer(); ?>
<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage MyStem
 * @since MyStem 1.0
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
        <div class="columns is-desktop">
            <div class="column is-two-thirds-desktop">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content/content', 'page' ); ?>
					<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
					?>
				<?php endwhile; // end of the loop. ?>
            </div>
            <div class="column">
				<?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>

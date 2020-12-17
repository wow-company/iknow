<?php
/**
 * The template for displaying all attachment.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package KnowledgeCenter
 * @subpackage KnowledgeCenter
 * @since KnowledgeCenter 1.0
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
        <div class="columns is-desktop is-centered">
            <div class="column is-two-thirds-desktop">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content/content', 'attachment' ); ?>
				<?php endwhile; // end of the loop. ?>
            </div>
        </div>
    </div>
</section>

<?php
get_footer(); ?>

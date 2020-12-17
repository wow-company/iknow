<?php
/**
 * The template for displaying Archive pages.
 *
 * @package WordPress
 * @subpackage Iknow
 * @since Iknow 1.0
 */

get_header();
$iknow_hero_classes = apply_filters('iknow_hero_classes', '');
?>

<section class="hero <?php echo esc_attr($iknow_hero_classes);?>" id="content">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title is-1 is-family-secondary is-uppercase">
				<?php the_archive_title(); ?>
            </h1>
            <h2 class="subtitle">
				<?php the_archive_description(); ?>
            </h2>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="columns is-desktop">
            <div class="column is-two-thirds-desktop">

                <div class="level">
                    <div class="level-left">
                        <nav class="breadcrumb is-size-7" aria-label="breadcrumbs">
                            <ul>
                                <li><a href="<?php echo esc_url(home_url()); ?>"><?php esc_html_e( 'Home', 'iknow'); ?></a></li>
                                <?php iknow_breadcrumbs_archive();?>
                            </ul>
                        </nav>
                    </div>
	                <?php iknow_posts_sorter(); ?>
                </div>

	            <?php do_action('iknow_category_description'); ?>
				<?php if ( have_posts() ) : ?>
					<?php get_template_part( 'content/content', 'archive' ); ?>
				<?php endif; ?>

            </div>
            <div class="column">
				<?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>

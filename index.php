<?php
/**
 * The main template file.
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
<section class="hero is-primary is-bold">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title is-1 is-family-secondary">
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
            </h1>
            <h2 class="subtitle">
				<?php echo esc_html( get_bloginfo( 'description' ) ); ?>
            </h2>
			<?php get_search_form(); ?>
        </div>
    </div>
</section>

<section class="section" id="content">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-three-quarters">
				<?php
				if ( have_posts() ) : ?>
                    <div class="box">
						<?php
						$post_icon = apply_filters( 'iknow_post_icon', 'icon-doc' );
						// Load posts loop.
						while ( have_posts() ) :
							the_post(); ?>
                            <a class="panel-block" href="<?php the_permalink(); ?>">
                                <span class="panel-icon"><span
                                            class="<?php echo esc_attr( $post_icon ); ?>"></span></span>
								<?php the_title(); ?>
                            </a>
						<?php endwhile; ?>
                    </div>
					<?php iknow_the_posts_pagination(); ?>

                <?php endif; ?>

            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>

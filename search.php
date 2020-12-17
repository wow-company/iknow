<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage WowEstore
 * @since WowEstore 1.0
 */

get_header();
$iknow_hero_classes = apply_filters( 'iknow_hero_classes', '' );
?>

    <section class="hero <?php echo esc_attr( $iknow_hero_classes ); ?>">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title is-3 is-family-secondary is-uppercase">
					<?php esc_html_e( 'Search Results for:', 'iknow' ); ?>
                </h1>
                <h2 class="subtitle is-6">
					<?php echo esc_attr( get_search_query() ); ?>
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
                                    <li>
                                        <a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'iknow' ); ?></a>
                                    </li>
                                    <li class="is-active">
                                        <a href="#"
                                           aria-current="page"><?php echo esc_html( get_search_query() ); ?></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

					<?php if ( have_posts() ) : ?>
                        <div class="box">
                            <table class="table is-hoverable is-fullwidth">
                                <thead class="is-hidden-mobile">
                                <th></th>
                                <th class="has-text-right is-size-7"><?php esc_html_e( 'Comments', 'iknow' ); ?></th>
								<?php if ( function_exists( 'iknow_get_helpful' ) ) : ?>
                                    <th class="has-text-right is-size-7"><?php esc_html_e( '  Helpful', 'iknow' ); ?></th>
								<?php endif; ?>

                                </thead>
                                <tbody>
								<?php $post_icon = apply_filters( 'iknow_post_icon', 'icon-doc' ); ?>
								<?php while ( have_posts() ) :
								the_post(); ?>
                                <tr>
                                    <td>
                                        <span class="<?php echo esc_attr( $post_icon ); ?>"></span>
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </td>
                                    <td class="has-text-right is-size-7 is-hidden-mobile"><?php echo esc_html( get_comments_number() ); ?></td>
									<?php if ( function_exists( 'iknow_get_helpful' ) ) : ?>
                                        <td class="has-text-right has-text-weight-medium is-size-7 is-hidden-mobile"><?php iknow_get_helpful(); ?></td>
									<?php endif; ?>
                                <tr>
									<?php endwhile; // end of the loop. ?>

                                </tbody>
                            </table>
                        </div>
						<?php iknow_the_posts_pagination(); ?>
					<?php else: ?>
                        <div class="box content">
                            <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'iknow' ); ?>
                            </p>
							<?php get_search_form(); ?>
                        </div>
					<?php endif; ?>
                </div>
                <div class="column">
					<?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>
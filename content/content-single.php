<?php
/**
 * The template used for displaying single post content in single.php
 *
 * @package WordPress
 * @subpackage Iknow
 * @since Iknow 1.0
 */

$iknow_settings = get_option( 'iknow_settings', false );
?>

<div class="level">
    <div class="level-left">
        <nav class="breadcrumb is-size-7" aria-label="breadcrumbs">
            <ul>
                <li><a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'iknow' ); ?></a></li>
                <li><?php the_category( '</li><li>', 'multiple' ); ?>
                <li class="is-active"><a href="<?php the_permalink(); ?>" aria-current="page"><?php the_title(); ?></a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="level-right is-size-7 is-hidden-mobile">
		<?php iknow_get_post_meta(); ?>
    </div>
</div>


<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
	<?php if ( has_post_thumbnail() === true && empty( $iknow_settings['featured_image'] ) ) : ?>
        <div class="card-image">
            <figure class="image">
				<?php the_post_thumbnail(); ?>
            </figure>
        </div>
	<?php endif; ?>
    <div class="card-content">
        <div class="content">
			<?php the_content(); ?>
			<?php the_tags( '', ' ', '' ); ?>
        </div>
		<?php wp_link_pages(); ?>
    </div>
</article>
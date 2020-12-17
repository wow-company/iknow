<?php
/**
 * The template used for displaying single post content in page.php
 *
 * @package WordPress
 * @subpackage Iknow
 * @since Iknow 1.0
 */
?>

<div class="level">
    <div class="level-left">
        <nav class="breadcrumb is-size-7" aria-label="breadcrumbs">
            <ul>
                <li><a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'iknow' ); ?></a></li>
                <li class="is-active"><a href="<?php the_permalink(); ?>" aria-current="page"><?php the_title(); ?></a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
	<?php if ( has_post_thumbnail() === true ) : ?>
        <div class="card-image">
            <figure class="image is-4by3">
				<?php the_post_thumbnail(); ?>
            </figure>
        </div>
	<?php endif; ?>
    <div class="card-content">
        <div class="content">
			<?php the_content(); ?>
        </div>
		<?php wp_link_pages(); ?>
    </div>
</article>
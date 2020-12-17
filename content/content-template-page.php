<?php
/**
 * The template used for displaying single post content in template page
 *
 * @package WordPress
 * @subpackage Iknow
 * @since Iknow 1.2
 */
?>

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
<?php
/**
 *  Template part for displaying attachment.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package KnowledgeCenter
 * @subpackage KnowledgeCenter
 * @since KnowledgeCenter 1.0
 */

?>

<div class="entry-attachment">

    <figure class="image mt-6">
		<?php $image_size = apply_filters( 'wporg_attachment_size', 'large' );
		echo wp_get_attachment_image( get_the_ID(), $image_size ); ?>
    </figure>
	<?php if ( has_excerpt() ): ?>
        <div class="subtitle"><?php the_excerpt(); ?></div>
	<?php endif; ?>

</div>
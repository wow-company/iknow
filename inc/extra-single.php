<?php
/**
 * Functions for single posts
 *
 * @package Iknow
 * @subpackage Iknow
 * @since Iknow 1.0
 */


// Get singke post meta
function iknow_get_post_meta() {
	$post_id   = get_the_ID();
	$count_yea = get_post_meta( $post_id, "vote_yea", true );
	$count_yea = ! empty( $count_yea ) ? $count_yea : 0;

	$count_ney = get_post_meta( $post_id, "vote_nay", true );
	$count_ney = ! empty( $count_ney ) ? $count_ney : 0;

	?>
    <div class="level-item">
        <a href="#respond" class="has-text-dark">
            <i class="icon-comment"></i>
			<?php echo absint(get_comments_number( $post_id )); ?>
        </a>
    </div>
	<?php if ( function_exists( 'iknow_get_helpful' ) ) : ?>
    <div class="level-item">
        <a href="#voting" class="has-text-success">
            <i class="icon-vote-up"></i>
			<?php echo absint( $count_yea ); ?>
        </a>
    </div>
    <div class="level-item">
        <a href="#voting" class="has-text-danger">
            <i class="icon-vote-down"></i>
			<?php echo absint( $count_ney ); ?>
        </a>
    </div>
	<?php endif; ?>

	<?php
}
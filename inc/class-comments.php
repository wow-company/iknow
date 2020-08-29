<?php
/* Class for show comments in Blog Posts */


class Iknow_Walker_Blog_Comments extends Walker_Comment {
	// init classwide variables
	var $tree_type = 'comment';
	var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

	/** CONSTRUCTOR
	 * You'll have to use this if you plan to get to the top of the comments list, as
	 * start_lvl() only goes as high as 1 deep nested comments */
	function __construct() { ?>

	<?php }

	/** START_LVL
	 * Starts the list before the CHILD elements are added. Unlike most of the walkers,
	 * the start_lvl function means the start of a nested comment. It applies to the first
	 * new level under the comments that are not replies. Also, it appear that, by default,
	 * WordPress just echos the walk instead of passing it to &$output properly. Go figure.  */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		?>
        <div class="comment-list-child">
	<?php }

	/** END_LVL
	 * Ends the children list of after the elements are added. */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		?>
        </div><!-- /.children -->
	<?php }

	/** START_EL */
	function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth ++;
		$parent_class  = ( empty( $args['has_children'] ) ? 'media' : 'parent media' );
		$img_size      = ( $depth === 1 ) ? 'is-64x64' : 'is-48x48';
		$comment_id    = $comment->comment_ID;
		$post_id       = $comment->comment_post_ID;
		$author_email  = $comment->comment_author_email;
		$author        = $comment->comment_author;
		$comment_class = implode( ' ', get_comment_class( $parent_class, $comment_id, $post_id ) )

		//$comment->comment_content
		?>
        <article class="<?php echo esc_attr( $comment_class ); ?>" id="comment-<?php echo esc_attr( $comment_id ) ?>">
        <figure class="media-left is-hidden-mobile">
            <p class="image <?php echo esc_attr( $img_size ); ?>">
                <img src="<?php echo esc_url( get_avatar_url( $author_email, array( 'size' => 64 ) ) ); ?>"
                     alt="<?php echo esc_attr( $author ); ?>">
            </p>
        </figure>

        <div class="media-content">

        <div class="content is-size-7-mobile">
            <div class="has-text-success has-text-weight-semibold"><?php echo esc_html( $author ); ?></div>
			<?php comment_text( $comment_id ); ?>

            <div class="level is-mobile">
                <div class="level-left">
					<?php if ( function_exists( 'iknow_get_helpful' ) ) : ?>
                        <div class="level-item">
							<?php iknow_get_comment_voted( $comment_id ); ?>
                        </div>
					<?php endif; ?>
                    <div class="level-item">
						<?php
						$reply_args = array(
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
						);
						comment_reply_link( array_merge( $args, $reply_args ), $comment_id );
						?>
                    </div>

                </div>
            </div>

        </div>

	<?php }

	function end_el( &$output, $comment, $depth = 0, $args = array() ) { ?>
        </div></article ><!-- /#comment-' . get_comment_ID() . ' -->
	<?php }

	/** DESTRUCTOR
	 * I just using this since we needed to use the constructor to reach the top
	 * of the comments list, just seems to balance out :) */
	function __destruct() { ?>


	<?php }
}
<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage MyStem
 * @since MyStem 1.0
 */

/*
	* If the current post is protected by a password and
	* the visitor has not yet entered the password we will
	* return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments-area section">

	<?php
	$commenter        = wp_get_current_commenter();
	$req              = get_option( 'require_name_email' );
	$aria_req         = ( $req ? " aria-required='true'" : '' );
	$class_field__req = $req ? ' is-danger' : '';
	$required_text    = sprintf(
	/* translators: %s: Asterisk symbol (*). */
		' ' . esc_attr__( 'Required fields are marked %s', 'iknow' ),
		'<span class="required has-text-danger">*</span>'
	);
	$form_args        = array(
		'class_form'           => '',
		/* translators: 1: Link to author profile 2: Author 3: Link for logout */
		'logged_in_as'         => '<p class="help has-text-right">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'iknow' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( get_permalink() ) ) . '</p>',
		'comment_field'        => '<div class="field"><div class="control"><textarea name="comment" class="textarea is-size-7" aria-required="true" placeholder="' . esc_attr__( 'Add Comment', 'iknow' ) . '">' . '</textarea></div></div>',
		'class_submit'         => 'button is-info is-small',
		'title_reply_before'   => '<span class="level is-size-5">  ',
		'title_reply_after'    => '<span class="button is-dark is-small comment-number">' . get_comments_number() . '</span> </span><hr/>',
		'submit_field'         => '<p class="form-submit has-text-right">%1$s %2$s</p><hr/>',
		'comment_notes_before' => '<p class="comment-notes help">' . esc_html__( 'Your email address will not be published.', 'iknow' ) . ( $req ? $required_text : '' ) . '</p>',
		'fields'               => apply_filters( 'iknow_comment_form_default_fields', array(
			'author' => '<div class="field is-horizontal"><div class="field-label is-normal"><label class="label" for="author">' . esc_html__( 'Name', 'iknow' ) . ( $req ? ' <span class="required has-text-danger">*</span>' : '' ) . '</label></div> ' .
			            '<div class="field-body"><div class="field"><div class="control"><input id="author" class="input ' . esc_attr( $class_field__req ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div></div></div></div>',
			'email'  => '<div class="field is-horizontal"><div class="field-label is-normal"><label class="label" for="email">' . esc_html__( 'Email', 'iknow' ) . ( $req ? ' <span class="required has-text-danger">*</span>' : '' ) . '</label> </div>' .
			            '<div class="field-body"><div class="field"><div class="control"><input id="email" class="input ' . esc_attr( $class_field__req ) . '" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . ' /></div></div></div></div>',
			'url'    => '<div class="field is-horizontal"><div class="field-label is-normal"><label class="label" for="url">' . esc_html__( 'Website', 'iknow' ) . '</label> </div>' .
			            '<div class="field-body"><div class="field"><div class="control"><input class="input" id="url" name="url" type="url" value="' . esc_url( $commenter['comment_author_url'] ) . '" size="30" /></div></div></div></div>',

			'cookies' => '<div class="field is-horizontal"><div class="field-label"><label class="label"></label></div><div class="field-body"><div class="field"><div class="control"><label class="checkbox is-size-7"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"> ' . esc_html__( 'Save my name and email in this browser for the next time I comment.', 'iknow' ) . '</label></div></div></div></div>',
		) ),

	);

	comment_form( $form_args );
	?>


	<?php if ( have_comments() ) : ?>
        <div class="comments-list-area box">
            <div class="comment-list">
				<?php
				wp_list_comments( array(
					'walker'      => new Iknow_Walker_Blog_Comments,
					'style'       => 'div',
					'short_ping'  => true,
					'avatar_size' => 128,
				) );
				?>
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
					<?php
					$args = array(
						'show_all'           => false,
						'end_size'           => 1,
						'mid_size'           => 1,
						'prev_next'          => true,
						'prev_text'          => esc_attr__( 'Previous', 'iknow' ),
						'next_text'          => esc_attr__( 'Next page', 'iknow' ),
						'add_args'           => false,
						'add_fragment'       => '',
//	'type' => 'list',
						'screen_reader_text' => esc_attr__( 'Posts navigation', 'iknow' ),
					);
                    the_comments_pagination($args); ?>
				<?php endif; // check for comment navigation ?>
            </div>
        </div>
	<?php endif; // have_comments() ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'iknow' ); ?></p>
	<?php endif; ?>
</section>

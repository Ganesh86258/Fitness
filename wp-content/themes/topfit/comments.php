<?php

if ( post_password_required() ) {
	return;
}

if ( comments_open() || get_comments_number()) : ?>
<div class="mkd-comment-holder clearfix" id="comments">
	<div class="mkd-comment-number">
		<div class="mkd-comment-number-inner">
			<h5 class="mkd-comment-number-title"><?php comments_number(esc_html__('No Comments', 'topfit'), '1' . esc_html__(' Comment ', 'topfit'), '% ' . esc_html__(' Comments ', 'topfit')); ?></h5>
		</div>
	</div>
	<div class="mkd-comments">
		<?php if ( have_comments() ) : ?>
			<ul class="mkd-comment-list">
				<?php wp_list_comments(array( 'callback' => 'topfit_mikado_comment')); ?>
			</ul>
		<?php endif; ?>
		<?php if( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' )) : ?>
			<p><?php esc_html_e('Sorry, the comment form is closed at this time.', 'topfit'); ?></p>
		<?php endif; ?>
	</div>
</div>
<?php
$commenter = wp_get_current_commenter();
$req = get_option('require_name_email');
$aria_req = ($req ? " aria-required='true'" : '');

$args = array(
	'id_form'              => 'commentform',
	'id_submit'            => 'submit_comment',
	'title_reply'          => esc_html__('Add Comment', 'topfit'),
	'title_reply_before'   => '<h5 id="reply-title" class="comment-reply-title">',
	'title_reply_after'    => '</h5>',
	'title_reply_to'       => esc_html__('Post a Reply to %s', 'topfit'),
	'cancel_reply_link'    => esc_html__('Cancel Reply', 'topfit'),
	'comment_field'        => '<textarea id="comment" placeholder="' . esc_html__('Write comment', 'topfit') . '" name="comment" cols="45" rows="7" aria-required="true"></textarea>',
	'comment_notes_before' => '',
	'comment_notes_after'  => '',
	'fields'               => apply_filters('comment_form_default_fields', array(
	'author' => '<div class="mkd-comment-author">
							<div class="mkd-comment-author-label">
								<h5 class="mkd-comment-label-title">' . esc_html__('Name*', 'topfit') . '</h5>
							</div>
							<div class="mkd-comment-author-input">
								<input id="author" name="author" placeholder="' . esc_html__('Your full name', 'topfit') . '" type="text" value="' . esc_attr($commenter['comment_author']) . '"' . $aria_req . ' />
							</div>
						</div>',
	'email'  => '<div class="mkd-comment-email">
						<div class="mkd-comment-email-label">
							<h5 class="mkd-comment-label-title">' . esc_html__('Email*', 'topfit') . '</h5>
						</div>
						<div class="mkd-comment-email-input">
							<input id="email" name="email" type="text" placeholder="' . esc_html__('Your email address', 'topfit') . '" value="' . esc_attr($commenter['comment_author_email']) . '"' . $aria_req . ' />
						</div>
					</div>',
	'url'    => '<div class="mkd-comment-url">
						<div class="mkd-comment-url-label">
							<h5 class="mkd-comment-label-title">' . esc_html__('Website', 'topfit') . '</h5>
						</div>
						<div class="mkd-comment-url-input">
							<input id="url" name="url" placeholder="' . esc_html__('Your website', 'topfit') . '" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" />
						</div>
					</div>'
	)));
?>
<?php if (get_comment_pages_count() > 1) {
	?>
	<div class="mkd-comment-pager">
		<p><?php paginate_comments_links(); ?></p>
	</div>
<?php } ?>
<div class="mkd-comment-form">
	<?php comment_form($args); ?>
</div>
<?php endif; ?>
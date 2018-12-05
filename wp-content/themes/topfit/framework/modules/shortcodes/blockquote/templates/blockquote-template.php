<?php
/**
 * Blockquote shortcode template
 */
?>

<blockquote class="mkd-blockquote-shortcode" <?php topfit_mikado_inline_style($blockquote_style); ?> >
	<h5 class="mkd-blockquote-text">
		<span><?php echo esc_attr($text); ?></span>
	</h5>
</blockquote>
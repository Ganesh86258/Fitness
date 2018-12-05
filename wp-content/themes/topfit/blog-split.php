<?php
/*
Template Name: Blog: Split
*/

$background_image = get_post_meta(topfit_mikado_get_page_id(), 'mkd_blog_split_background_image_meta', true);
$title = get_post_meta(topfit_mikado_get_page_id(), 'mkd_blog_split_title_meta', true);
$subtitle = get_post_meta(topfit_mikado_get_page_id(), 'mkd_blog_split_subtitle_meta', true);

get_header();
topfit_mikado_get_title();
get_template_part('slider'); ?>
	<div class="mkd-full-width">
		<div class="mkd-full-width-inner clearfix">
			<div class="mkd-blog-split-holder"
				 style="background-image:url(<?php echo esc_url($background_image); ?>);">
				<div class="mkd-blog-split-title-subtitle clearfix">
					<?php if ($title !== ''): ?>
						<h1 class="mkd-blog-split-title">
							<?php echo esc_html($title) ?>
						</h1>
					<?php endif; ?>
					<?php if ($subtitle !== ''): ?>
						<h4 class="mkd-blog-split-subtitle">
							<?php echo esc_html($subtitle) ?>
						</h4>
					<?php endif; ?>
				</div>
				<?php topfit_mikado_get_blog('split'); ?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
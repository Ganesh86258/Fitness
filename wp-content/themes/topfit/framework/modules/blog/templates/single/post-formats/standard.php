<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="mkd-post-content">
		<?php topfit_mikado_get_module_template_part('templates/single/parts/image', 'blog'); ?>
		<div class="mkd-post-text">
			<div class="mkd-post-text-inner clearfix">
				<?php topfit_mikado_get_module_template_part('templates/single/parts/title', 'blog'); ?>
				<div class="mkd-post-info">
					<?php topfit_mikado_post_info(array('date' => 'yes')) ?>
					<div class="mkd-post-info-category">
						<?php echo topfit_mikado_icon_collections()->renderIcon('lnr-bookmark', 'linear_icons'); ?>
						<?php the_category(', '); ?>
					</div>
				</div>
				<?php the_content(); ?>
				<?php do_action('topfit_mikado_after_blog_article_content'); ?>
			</div>
			<div class="mkd-tags-share-holder clearfix">
				<?php do_action('topfit_mikado_before_blog_article_closed_tag'); ?>
				<div class="mkd-share-icons-single">
					<?php $post_info_array['share'] = topfit_mikado_options()->getOptionValue('enable_social_share') == 'yes'; ?>
					<?php if ($post_info_array['share'] == 'yes'): ?>
						<span class="mkd-share-label"><?php esc_html_e('Share', 'topfit'); ?></span>
					<?php endif; ?>
					<?php if (shortcode_exists('mkd_social_share')){ ?>
					<?php echo topfit_mikado_get_social_share_html(array(
						'type'      => 'list',
						'icon_type' => 'normal'
					)); ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</article>
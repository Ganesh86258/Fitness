<?php
/*
Template Name: Landing Page
*/
$mkd_sidebar = topfit_mikado_sidebar_layout();

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php if(!topfit_mikado_is_ajax_request()) {
		topfit_mikado_wp_title();
	} ?>

	<?php
	/**
	 * topfit_mikado_header_meta hook
	 *
	 * @see topfit_mikado_header_meta() - hooked with 10
	 * @see mkd_user_scalable_meta() - hooked with 10
	 */
	if(!topfit_mikado_is_ajax_request()) {
		do_action('topfit_mikado_header_meta');
	}
	?>

	<?php if(!topfit_mikado_is_ajax_request()) {
		wp_head();
	} ?>
</head>

<body <?php body_class(); ?>>

<?php
if((!topfit_mikado_is_ajax_request()) && topfit_mikado_options()->getOptionValue('smooth_page_transitions') == "yes") {
	$ajax_class = 'mkd-mimic-ajax';
	?>
	<div class="mkd-smooth-transition-loader <?php echo esc_attr($ajax_class); ?>">
		<div class="mkd-st-loader">
			<div class="mkd-st-loader1">
				<?php echo topfit_mikado_loading_spinners(true); ?>
			</div>
		</div>
	</div>
<?php } ?>

<div class="mkd-wrapper">
	<div class="mkd-wrapper-inner">
		<div class="mkd-content">
			<?php if(topfit_mikado_is_ajax_enabled()) { ?>
				<div class="mkd-meta">
					<?php do_action('topfit_mikado_ajax_meta'); ?>
					<span id="mkd-page-id"><?php echo esc_html($wp_query->get_queried_object_id()); ?></span>

					<div class="mkd-body-classes"><?php echo esc_html(implode(',', get_body_class())); ?></div>
				</div>
			<?php } ?>
			<div class="mkd-content-inner">
				<?php topfit_mikado_get_title(); ?>
				<?php get_template_part('slider'); ?>
				<div class="mkd-full-width">
					<div class="mkd-full-width-inner">
						<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
							<div class="mkd-grid-row">
								<div <?php echo topfit_mikado_get_content_sidebar_class(); ?>>
									<?php the_content(); ?>
									<?php do_action('topfit_mikado_page_after_content'); ?>
								</div>

								<?php if(!in_array($mkd_sidebar, array('default', ''))) : ?>
									<div <?php echo topfit_mikado_get_sidebar_holder_class(); ?>>
										<?php get_sidebar(); ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endwhile; endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
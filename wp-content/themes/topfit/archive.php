<?php
$blog_archive_pages_classes = topfit_mikado_blog_archive_pages_classes(topfit_mikado_get_default_blog_list());
?>
<?php get_header(); ?>
<?php topfit_mikado_get_title(); ?>
<div class="<?php echo esc_attr($blog_archive_pages_classes['holder']); ?>">
<?php do_action('topfit_mikado_after_container_open'); ?>
	<div class="<?php echo esc_attr($blog_archive_pages_classes['inner']); ?>">
		<?php topfit_mikado_get_blog(topfit_mikado_get_default_blog_list()); ?>
	</div>
<?php do_action('topfit_mikado_before_container_close'); ?>
</div>
<?php get_footer(); ?>
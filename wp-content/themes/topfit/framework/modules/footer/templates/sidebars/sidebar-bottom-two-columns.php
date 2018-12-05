<?php
$page_id = topfit_mikado_get_page_id();

$custom_footer_bottom_used = get_post_meta($page_id, 'show_footer_custom_widget_areas', true);
$custom_footer_bottom_left = get_post_meta($page_id, 'mkd_footer_bottom_left_meta', true);
$custom_footer_bottom_right = get_post_meta($page_id, 'mkd_footer_bottom_right_meta', true);
?>

<div class="mkd-grid-row mkd-footer-bottom-two-cols">

	<div class="mkd-grid-col-6 mkd-left">

		<?php
		if($custom_footer_bottom_left !== '' && $custom_footer_bottom_used == 'yes'){
			dynamic_sidebar($custom_footer_bottom_left);
		}
		elseif(is_active_sidebar('footer_bottom_left')) {
			dynamic_sidebar('footer_bottom_left');
		}?>

	</div>

	<div class="mkd-grid-col-6 mkd-right">

		<?php
		if($custom_footer_bottom_right !== '' && $custom_footer_bottom_used == 'yes'){
			dynamic_sidebar($custom_footer_bottom_right);
		}
		elseif(is_active_sidebar('footer_bottom_right')) {
			dynamic_sidebar('footer_bottom_right');
		}?>

	</div>
</div>
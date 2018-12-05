<?php
$page_id = topfit_mikado_get_page_id();
$custom_footer_top_area1 = get_post_meta($page_id, 'mkd_footer_top_meta_1', true);
$custom_footer_top_area2 = get_post_meta($page_id, 'mkd_footer_top_meta_2', true);
$custom_footer_top_area3 = get_post_meta($page_id, 'mkd_footer_top_meta_3', true);
?>

<div class="mkd-grid-row mkd-footer-top-25-25-50">
	<div class="mkd-grid-col-6">
		<div class="mkd-grid-row">
			<div class="mkd-grid-col-6">
				<?php
				if($custom_footer_top_area2 !== ''){
					dynamic_sidebar($custom_footer_top_area2);
				}
				elseif(is_active_sidebar('footer_column_2')) {
					dynamic_sidebar('footer_column_2');
				}
				?>
			</div>
			<div class="mkd-grid-col-6">
				<?php
				if($custom_footer_top_area3 !== ''){
					dynamic_sidebar($custom_footer_top_area3);
				}
				elseif(is_active_sidebar('footer_column_3')) {
					dynamic_sidebar('footer_column_3');
				}
				?>
			</div>
		</div>
	</div>
	<div class="mkd-grid-col-6">
		<?php
		if($custom_footer_top_area1 !== ''){
			dynamic_sidebar($custom_footer_top_area1);
		}
		elseif(is_active_sidebar('footer_column_1')) {
			dynamic_sidebar('footer_column_1');
		}
		?>
	</div>
</div>
<?php
/**
 * Footer template part
 */

topfit_mikado_get_content_bottom_area(); ?>
</div> <!-- close div.content_inner -->
</div>  <!-- close div.content -->

<?php if(!isset($_REQUEST["ajax_req"]) || $_REQUEST["ajax_req"] != 'yes') { ?>
	<footer <?php topfit_mikado_class_attribute($footer_classes); ?>>
		<div class="mkd-footer-inner clearfix">

			<?php

			if($display_footer_top) {
				topfit_mikado_get_footer_top();
			}
			if($display_footer_bottom) {
				topfit_mikado_get_footer_bottom();
			}
			?>

		</div>
	</footer>
<?php } ?>

</div> <!-- close div.mkd-wrapper-inner  -->
</div> <!-- close div.mkd-wrapper -->

<?php if(topfit_mikado_is_paspartu_on()){ ?>
</div> <!-- close div.mkd-wrapper-paspartu -->
<?php } ?>

<?php wp_footer(); ?>
</body>
</html>
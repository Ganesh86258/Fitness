<?php
if(!function_exists('topfit_mikado_layerslider_overrides')) {
	/**
	 * Disables Layer Slider auto update box
	 */
	function topfit_mikado_layerslider_overrides() {
		$GLOBALS['lsAutoUpdateBox'] = false;
	}

	add_action('layerslider_ready', 'topfit_mikado_layerslider_overrides');
}
?>
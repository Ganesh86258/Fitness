<?php

add_action('after_setup_theme', 'topfit_mikado_admin_map_init', 0);

function topfit_mikado_admin_map_init() {

	do_action('topfit_mikado_before_options_map');

	foreach(glob(MIKADO_FRAMEWORK_ROOT_DIR.'/admin/options/*/map.php') as $options_map_load) {
		include_once $options_map_load;
	}


	do_action('topfit_mikado_options_map');

	do_action('topfit_mikado_after_options_map');

}
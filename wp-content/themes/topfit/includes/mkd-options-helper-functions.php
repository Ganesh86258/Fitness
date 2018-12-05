<?php

if(!function_exists('topfit_mikado_is_responsive_on')) {
	/**
	 * Checks whether responsive mode is enabled in theme options
	 * @return bool
	 */
	function topfit_mikado_is_responsive_on() {
		return topfit_mikado_options()->getOptionValue('responsiveness') !== 'no';
	}
}

if(!function_exists('topfit_mikado_is_paspartu_on')) {
    /**
     * Checks whether responsive mode is enabled in theme options
     * @return bool
     */
    function topfit_mikado_is_paspartu_on() {
        return topfit_mikado_get_meta_field_intersect('enable_paspartu',topfit_mikado_get_page_id()) == 'yes';
    }
}
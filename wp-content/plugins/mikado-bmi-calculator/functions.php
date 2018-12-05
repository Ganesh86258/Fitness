<?php
use MikadoBmiCalculator\Lib\BmiCalculatorApi;


if(!function_exists('mkd_bmi_load_assets')) {
	function mkd_bmi_load_assets() {
		wp_enqueue_script('mkd_bmi_calculator_script', plugins_url('/assets/js/bmi-calculator.js', __FILE__), array('jquery'), '', true);
	}

	add_action('wp_enqueue_scripts', 'mkd_bmi_load_assets');
}
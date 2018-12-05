<?php

if(!function_exists('mkd_bmi_version_class')) {
    /**
     * Adds plugins version class to body
     * @param $classes
     * @return array
     */
    function mkd_bmi_version_class($classes) {
        $classes[] = 'mkd-bmi-calculator-'.MIKADOF_BMI_CALCULATOR_VERSION;

        return $classes;
    }

    add_filter('body_class', 'mkd_bmi_version_class');
}

if(!function_exists('mkd_bmi_theme_installed')) {
    /**
     * Checks whether theme is installed or not
     * @return bool
     */
    function mkd_bmi_theme_installed() {
        return defined('MIKADO_ROOT');
    }
}

if(!function_exists('mkd_bmi_get_shortcode_module_template_part')) {
	/**
	 * Loads module template part.
	 *
	 * @param string $shortcode name of the shortcode folder
	 * @param string $template name of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 */
	function mkd_bmi_get_shortcode_module_template_part($shortcode,$template, $slug = '', $params = array()) {

		//HTML Content from template
		$html = '';
		$template_path = MIKADO_BMI_CPT_PATH.'/'.$shortcode.'/shortcodes';

		$temp = $template_path.'/'.$template;
		if(is_array($params) && count($params)) {
			extract($params);
		}
		
		$template = '';

		if($temp !== '') {
			$template = $temp.'.php';

			if($slug !== '') {
				$template = "{$temp}-{$slug}.php";
			}
		}
		if($template) {
			ob_start();
			include($template);
			$html = ob_get_clean();
		}

		return $html;
	}
}

if(!function_exists('mkd_bmi_get_template_part')) {
	/**
	 * Loads template part with parameters. If file with slug parameter added exists it will load that file, else it will load file without slug added.
	 * Child theme friendly function
	 *
	 * @param string $template name of the template to load without extension
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 * @param bool $return whether to return it as a string
	 *
	 * @return mixed
	 */
	function mkd_bmi_get_template_part($template, $slug = '', $params = array(), $return = false) {
		//HTML Content from template
		$html = '';
		$template_path = MIKADO_BMI_CALCULATOR_ABS_PATH;

		$temp = $template_path.'/'.$template;
		if(is_array($params) && count($params)) {
			extract($params);
		}

		$template = '';

		if($temp !== '') {
			$template = $temp.'.php';

			if($slug !== '') {
				$template = "{$temp}-{$slug}.php";
			}
		}

		if($template) {
			if($return) {
				ob_start();
			}

			include($template);

			if($return) {
				$html = ob_get_clean();
			}

		}

		if($return) {
			return $html;
		}
	}
}

if(!function_exists('mkd_bmi_set_ajax_url')){
	/**
     * load themes ajax functionality
     * 
     */
	function mkd_bmi_set_ajax_url() {
		echo '<script type="application/javascript">var mkdBmiCalculatorAjaxUrl = "'.admin_url('admin-ajax.php').'"</script>';
	}

	add_action('wp_enqueue_scripts', 'mkd_bmi_set_ajax_url');
}


if(!function_exists('mkd_bmi_inline_style')) {
	/**
	 * Function that echoes generated style attribute
	 * @param $value string | array attribute value
	 *
	 */
	function mkd_bmi_inline_style($value) {
		echo mkd_bmi_get_inline_style($value);
	}
}

if(!function_exists('mkd_bmi_get_inline_style')) {
	/**
	 * Function that generates style attribute and returns generated string
	 * @param $value string | array value of style attribute
	 * @return string generated style attribute
	 *
	 */
	function mkd_bmi_get_inline_style($value) {
		return mkd_bmi_get_inline_attr($value, 'style', ';');
	}
}

if(!function_exists('mkd_bmi_class_attribute')) {
	/**
	 * Function that echoes class attribute
	 * @param $value string value of class attribute
	 *
	 */
	function mkd_bmi_class_attribute($value) {
		echo mkd_bmi_get_class_attribute($value);
	}
}

if(!function_exists('mkd_bmi_get_class_attribute')) {
	/**
	 * Function that returns generated class attribute
	 * @param $value string value of class attribute
	 * @return string generated class attribute
	 */
	function mkd_bmi_get_class_attribute($value) {
		return mkd_bmi_get_inline_attr($value, 'class', ' ');
	}
}

if(!function_exists('mkd_bmi_get_inline_attr')) {
	/**
	 * Function that generates html attribute
	 * @param $value string | array value of html attribute
	 * @param $attr string name of html attribute to generate
	 * @param $glue string glue with which to implode $attr. Used only when $attr is array
	 * @return string generated html attribute
	 */
	function mkd_bmi_get_inline_attr($value, $attr, $glue = '') {
		if(!empty($value)) {

			if(is_array($value) && count($value)) {
				$properties = implode($glue, $value);
			} elseif($value !== '') {
				$properties = $value;
			}

			return $attr.'="'.esc_attr($properties).'"';
		}

		return '';
	}
}

if(!function_exists('mkd_bmi_inline_attr')) {
	/**
	 * Function that generates html attribute
	 * @param $value string | array value of html attribute
	 * @param $attr string name of html attribute to generate
	 * @param $glue string glue with which to implode $attr. Used only when $attr is array
	 * @return string generated html attribute
	 */
	function mkd_bmi_inline_attr($value, $attr, $glue = '') {
		echo mkd_bmi_get_inline_attr($value, $attr, $glue);
	}
}

if(!function_exists('mkd_bmi_get_inline_attrs')) {
	/**
	 * Generate multiple inline attributes
	 *
	 * @param $attrs
	 *
	 * @return string
	 */
	function mkd_bmi_get_inline_attrs($attrs) {
		$output = '';

		if(is_array($attrs) && count($attrs)) {
			foreach($attrs as $attr => $value) {
				$output .= ' '.mkd_bmi_get_inline_attr($value, $attr);
			}
		}

		ltrim($output);

		return $output;
	}
}

if(!function_exists('mkd_bmi_get_attachment_id_from_url')) {
	/**
	 * Function that retrieves attachment id for passed attachment url
	 * @param $attachment_url
	 * @return null|string
	 */
	function mkd_bmi_get_attachment_id_from_url($attachment_url) {
		global $wpdb;
		$attachment_id = '';

		//is attachment url set?
		if($attachment_url !== '') {
			//prepare query

			$query = $wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE guid=%s", $attachment_url);

			//get attachment id
			$attachment_id = $wpdb->get_var($query);
		}

		//return id
		return $attachment_id;
	}
}
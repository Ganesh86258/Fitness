<?php

class TopFitMikadoContactForm7 extends TopFitMikadoWidget {
	protected $params;

	public function __construct() {
		parent::__construct(
			'mkd_ontact_form7_widget', // Base ID
			'Mikado Contact Form 7', // Name
			array('description' => esc_html__('Display Contact Form 7', 'topfit'),) // Args
		);

		$this->setParams();
	}

	protected function setParams() {

		$contact_forms = array();

		$cf7 = get_posts('post_type="wpcf7_contact_form"&numberposts=-1');

		if ($cf7) {
			foreach ($cf7 as $cform) {
				$contact_forms[$cform->ID] = $cform->post_title;
			}

		} else {
			$contact_forms[esc_html__('No contact forms found', 'topfit')] = 0;
		}

		$this->params = array(
			array(
				'name'  => 'title',
				'type'  => 'textfield',
				'title' => esc_html__('Title', 'topfit')
			),
			array(
				'name'  => 'text',
				'type'  => 'textfield',
				'title' => esc_html__('Text', 'topfit')
			),
			array(
				'name'  => 'background_color',
				'type'  => 'textfield',
				'title' => esc_html__('Background Color', 'topfit')
			),
			array(
				'name'  => 'background_image',
				'type'  => 'textfield',
				'title' => esc_html__('Background Image Url', 'topfit')
			),
			array(
				'name'    => 'id',
				'type'    => 'dropdown',
				'title'   => esc_html__('Contact Form', 'topfit'),
				'options' => $contact_forms
			),
			array(
				'name'        => 'html_class',
				'type'        => 'dropdown',
				'title'       => esc_html__('Style', 'topfit'),
				'options'     => array(
					'default'            => esc_html__('Default', 'topfit'),
					'cf7_custom_style_1' => esc_html__('Custom Style 1', 'topfit'),
					'cf7_custom_style_2' => esc_html__('Custom Style 2', 'topfit'),
					'cf7_custom_style_3' => esc_html__('Custom Style 3', 'topfit')
				),
				'description' => esc_html__('You can style each form element individually in Mikado Options > Contact Form 7', 'topfit')
			),
			array(
				'name'    => 'cf_type',
				'type'    => 'dropdown',
				'title'   => esc_html__('Choose Layout', 'topfit'),
				'options' => array(
					'boxed'  => esc_html__('Boxed', 'topfit'),
					'normal' => esc_html__('Normal', 'topfit')
				),
			),
			array(
				'name'    => 'color_type',
				'type'    => 'dropdown',
				'title'   => esc_html__('Choose Skin', 'topfit'),
				'options' => array(
					'light' => esc_html__('Light', 'topfit'),
					'dark'  => esc_html__('Dark', 'topfit')
				),
			),
		);
	}


	public function widget($args, $instance) {
		extract($args);

//      //prepare variables
//      $content        = '';
		$params = array();
//
		//is instance empty?
		if (is_array($instance) && count($instance)) {
			//generate shortcode params
			foreach ($instance as $key => $value) {
				$params[$key] = $value;
			}
		}

		$layout_type = '';
		if (($instance['cf_type']) == 'boxed') {
			$layout_type = ' mkd-widget-cf-boxed';
		}

		$cfStyles = array();

		if (($instance['background_color']) !== '') {
			$cfStyles[] = 'background-color: ' . $instance['background_color'] . '';
		}

		if (($instance['background_image']) !== '' && ($instance['background_color']) == '') {
			$cfStyles[] = 'background-image: url(' . $instance['background_image'] . ')';
		}

		$layout_color = '';
		if (($instance['color_type']) == 'light') {
			$layout_color = ' mkd-widget-cf-light';
		}

		$cf_custom_style = '';
		if (($instance['html_class']) === 'cf7_custom_style_1') {
			$cf_custom_style = ' cf7_custom_style_1';
		} elseif (($instance['html_class']) === 'cf7_custom_style_2') {
			$cf_custom_style = ' cf7_custom_style_2';
		}

		echo '<div class="widget mkd-contact-form-7-widget' . $layout_type . $layout_color . $cf_custom_style . '" ' . topfit_mikado_get_inline_style($cfStyles) . '>';

		echo '<div class="mkd-contact-form-title">';
		if (!empty($instance['title'])) {
			print $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		echo '</div>';

		echo '<div class="mkd-contact-form-text">';
		if (!empty($instance['text'])) {
			print $args['before_title'] . $instance['text'] . $args['after_title'];
		}
		echo '</div>';

		echo topfit_mikado_execute_shortcode('contact-form-7', $params);

		echo '</div>'; //close mkd-contact-form-7-widget
	}
}

add_action('widgets_init', function () {
	register_widget('TopFitMikadoContactForm7');
});
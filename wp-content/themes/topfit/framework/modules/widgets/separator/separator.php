<?php

/**
 * Widget that adds separator boxes type
 *
 * Class Separator_Widget
 */
class TopFitMikadoSeparatorWidget extends TopFitMikadoWidget {
	/**
	 * Set basic widget options and call parent class construct
	 */
	public function __construct() {
		parent::__construct(
			'mkd_separator_widget', // Base ID
			esc_html__('Mikado Separator Widget', 'topfit') // Name
		);

		$this->setParams();
	}

	/**
	 * Sets widget options
	 */
	protected function setParams() {
		$this->params = array(
			array(
				'type'    => 'dropdown',
				'title'   => esc_html__('Type', 'topfit'),
				'name'    => 'type',
				'options' => array(
					'normal'     => esc_html__('Normal', 'topfit'),
					'full-width' => esc_html__('Full Width', 'topfit')
				)
			),
			array(
				'type'    => 'dropdown',
				'title'   => esc_html__('Position', 'topfit'),
				'name'    => 'position',
				'options' => array(
					'center' => esc_html__('Center', 'topfit'),
					'left'   => esc_html__('Left', 'topfit'),
					'right'  => esc_html__('Right', 'topfit')
				)
			),
			array(
				'type'    => 'dropdown',
				'title'   => esc_html__('Style', 'topfit'),
				'name'    => 'border_style',
				'options' => array(
					'solid'  => esc_html__('Solid', 'topfit'),
					'dashed' => esc_html__('Dashed', 'topfit'),
					'dotted' => esc_html__('Dotted', 'topfit')
				)
			),
			array(
				'type'  => 'textfield',
				'title' => esc_html__('Color', 'topfit'),
				'name'  => 'color'
			),
			array(
				'type'        => 'textfield',
				'title'       => esc_html__('Width', 'topfit'),
				'name'        => 'width',
				'description' => ''
			),
			array(
				'type'        => 'textfield',
				'title'       => esc_html__('Thickness (px)', 'topfit'),
				'name'        => 'thickness',
				'description' => ''
			),
			array(
				'type'        => 'textfield',
				'title'       => esc_html__('Top Margin', 'topfit'),
				'name'        => 'top_margin',
				'description' => ''
			),
			array(
				'type'        => 'textfield',
				'title'       => esc_html__('Bottom Margin', 'topfit'),
				'name'        => 'bottom_margin',
				'description' => ''
			)
		);
	}

	/**
	 * Generates widget's HTML
	 *
	 * @param array $args args from widget area
	 * @param array $instance widget's options
	 */
	public function widget($args, $instance) {

		extract($args);

		//prepare variables
		$params = '';

		//is instance empty?
		if (is_array($instance) && count($instance)) {
			//generate shortcode params
			foreach ($instance as $key => $value) {
				$params .= " $key='$value' ";
			}
		}

		echo '<div class="widget mkd-separator-widget">';

		//finally call the shortcode
		echo do_shortcode("[mkd_separator $params]"); // XSS OK

		echo '</div>'; //close div.mkd-separator-widget
	}
}
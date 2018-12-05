<?php

class TopFitMikadoLatestPosts extends TopFitMikadoWidget {
	protected $params;

	public function __construct() {
		parent::__construct(
			'mkd_latest_posts_widget', // Base ID
			esc_html__('Mikado Latest Posts', 'topfit'), // Name
			array('description' => esc_html__('Display posts from your blog', 'topfit')) // Args
		);

		$this->setParams();
	}

	protected function setParams() {
		$this->params = array(
			array(
				'name'  => 'title',
				'type'  => 'textfield',
				'title' => esc_html__('Title', 'topfit')
			),
			array(
				'name'    => 'type',
				'type'    => 'dropdown',
				'title'   => esc_html__('Type', 'topfit'),
				'options' => array(
					'minimal'      => esc_html__('Minimal', 'topfit'),
					'image-in-box' => esc_html__('Image in box', 'topfit'),
					'simple' => esc_html__('Simple', 'topfit')
				)
			),
			array(
				'name'  => 'number_of_posts',
				'type'  => 'textfield',
				'title' => esc_html__('Number of posts', 'topfit')
			),
			array(
				'name'    => 'order_by',
				'type'    => 'dropdown',
				'title'   => esc_html__('Order By', 'topfit'),
				'options' => array(
					'title' => esc_html__('Title', 'topfit'),
					'date'  => esc_html__('Date', 'topfit')
				)
			),
			array(
				'name'    => 'order',
				'type'    => 'dropdown',
				'title'   => esc_html__('Order', 'topfit'),
				'options' => array(
					'ASC'  => esc_html__('ASC', 'topfit'),
					'DESC' => esc_html__('DESC', 'topfit')
				)
			),
			array(
				'name'    => 'image_size',
				'type'    => 'dropdown',
				'title'   => esc_html__('Image Size', 'topfit'),
				'options' => array(
					'original'  => esc_html__('Original', 'topfit'),
					'landscape' => esc_html__('Landscape', 'topfit'),
					'square'    => esc_html__('Square', 'topfit'),
					'custom'    => esc_html__('Custom', 'topfit')
				)
			),
			array(
				'name'  => 'custom_image_size',
				'type'  => 'textfield',
				'title' => esc_html__('Custom Image Size', 'topfit')
			),
			array(
				'name'  => 'category',
				'type'  => 'textfield',
				'title' => esc_html__('Category Slug', 'topfit'),
			),
			array(
				'name'  => 'text_length',
				'type'  => 'textfield',
				'title' => esc_html__('Number of characters', 'topfit'),
			),
			array(
				'name'    => 'title_tag',
				'type'    => 'dropdown',
				'title'   => esc_html__('Title Tag', 'topfit'),
				'options' => array(
					""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",
					"h5" => "h5",
					"h6" => "h6"
				)
			)
		);
	}

	public function widget($args, $instance) {
		extract($args);

		//prepare variables
		$content = '';
		$params = array();

		//is instance empty?
		if (is_array($instance) && count($instance)) {
			//generate shortcode params
			foreach ($instance as $key => $value) {
				$params[$key] = $value;
			}
		}
		if (empty($params['title_tag'])) {
			$params['title_tag'] = 'h6';
		}
		echo '<div class="widget mkd-latest-posts-widget">';

		if (!empty($instance['title'])) {
			print $args['before_title'] . $instance['title'] . $args['after_title'];
		}

		echo topfit_mikado_execute_shortcode('mkd_blog_list', $params);

		echo '</div>'; //close mkd-latest-posts-widget
	}
}

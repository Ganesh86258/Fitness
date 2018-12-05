<?php

class TopFitMikadoInfoWidget extends TopFitMikadoWidget {
	public function __construct() {
		parent::__construct(
			'mkd_info_widget', // Base ID
			esc_html__('Info Widget', 'topfit') // Name
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
				'name'  => 'text',
				'type'  => 'textarea',
				'title' => esc_html__('Text', 'topfit')
			),
			array(
				'name'  => 'phone_number',
				'type'  => 'textfield',
				'title' => esc_html__('Phone number', 'topfit')
			)
		);
	}

	public function widget($args, $instance) {
		print $args['before_widget'];

		if (!empty($instance['title'])) {
			print $args['before_title'] . $instance['title'] . $args['after_title'];
		} ?>

		<p class="mkd-info-text">
			<?php print $instance['text']; ?>
		</p>

		<p class="mkd-info-phone">
			<span aria-hidden="true" class="mkd-icon-font-elegant icon_phone "></span>
			<a href="tel:<?php print $instance['phone_number'] ?>">
				<?php print $instance['phone_number'] ?>
			</a>
		</p>

		<?php print $args['after_widget'];
	}

}
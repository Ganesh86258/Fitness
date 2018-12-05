<?php

class TopFitMikadoSideAreaOpener extends TopFitMikadoWidget {
	public function __construct() {
		parent::__construct(
			'mkd_side_area_opener', // Base ID
			esc_html__('Mikado Side Area Opener', 'topfit') // Name
		);

		$this->setParams();
	}

	protected function setParams() {

		$this->params = array(
			array(
				'name'        => 'side_area_opener_icon_color',
				'type'        => 'textfield',
				'title'       => esc_html__('Icon Color', 'topfit'),
				'description' => esc_html__('Define color for Side Area opener icon', 'topfit')
			)
		);

	}


	public function widget($args, $instance) {

		$sidearea_icon_styles = array();

		if (!empty($instance['side_area_opener_icon_color'])) {
			$sidearea_icon_styles[] = 'border-color: ' . $instance['side_area_opener_icon_color'];
		}

		print $args['before_widget'];

		?>
		<a class="mkd-side-menu-button-opener"
		   href="javascript:void(0)">
			<?php echo topfit_mikado_get_side_menu_icon_html($sidearea_icon_styles); ?>
		</a>

		<?php print $args['after_widget']; ?>

	<?php }

}
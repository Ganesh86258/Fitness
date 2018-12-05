<?php

/**
 * Widget that adds search icon that triggers opening of search form
 *
 * Class Mikado_Search_Opener
 */
class TopFitMikadoSearchOpener extends TopFitMikadoWidget {
	/**
	 * Set basic widget options and call parent class construct
	 */
	public function __construct() {
		parent::__construct(
			'mkd_search_opener', // Base ID
			esc_html__('Mikado Search Opener', 'topfit') // Name
		);

		$this->setParams();
	}

	/**
	 * Sets widget options
	 */
	protected function setParams() {
		$this->params = array(
			array(
				'name'        => 'search_icon_size',
				'type'        => 'textfield',
				'title'       => esc_html__('Search Icon Size (px)', 'topfit'),
				'description' => esc_html__('Define size for Search icon', 'topfit')
			),
			array(
				'name'        => 'search_icon_color',
				'type'        => 'textfield',
				'title'       => esc_html__('Search Icon Color', 'topfit'),
				'description' => esc_html__('Define color for Search icon', 'topfit')
			),
			array(
				'name'        => 'search_icon_hover_color',
				'type'        => 'textfield',
				'title'       => esc_html__('Search Icon Hover Color', 'topfit'),
				'description' => esc_html__('Define hover color for Search icon', 'topfit')
			),
			array(
				'name'        => 'show_label',
				'type'        => 'dropdown',
				'title'       => esc_html__('Enable Search Icon Text', 'topfit'),
				'description' => esc_html__('Enable this option to show \'Search\' text next to search icon in header', 'topfit'),
				'options'     => array(
					''    => '',
					'yes' => esc_html__('Yes', 'topfit'),
					'no'  => esc_html__('No', 'topfit')
				)
			),
			array(
				'name'        => 'close_icon_position',
				'type'        => 'dropdown',
				'title'       => esc_html__('Close icon stays on opener place', 'topfit'),
				'description' => esc_html__('Enable this option to set close icon on same position like opener icon', 'topfit'),
				'options'     => array(
					'yes' => esc_html__('Yes', 'topfit'),
					'no'  => esc_html__('No', 'topfit')
				)
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
		global $topfit_options, $topfit_IconCollections;

		$search_type_class = 'mkd-search-opener';
		$fullscreen_search_overlay = false;
		$search_opener_styles = array();
		$show_search_text = $instance['show_label'] == 'yes' || $topfit_options['enable_search_icon_text'] == 'yes' ? true : false;
		$close_icon_on_same_position = $instance['close_icon_position'] == 'yes' ? true : false;

		if (isset($topfit_options['search_type']) && $topfit_options['search_type'] == 'fullscreen-search') {
			if (isset($topfit_options['search_animation']) && $topfit_options['search_animation'] == 'search-from-circle') {
				$fullscreen_search_overlay = true;
			}
		}

		if (isset($topfit_options['search_type']) && $topfit_options['search_type'] == 'search_covers_header') {
			if (isset($topfit_options['search_cover_only_bottom_yesno']) && $topfit_options['search_cover_only_bottom_yesno'] == 'yes') {
				$search_type_class .= ' search_covers_only_bottom';
			}
		}

		if (!empty($instance['search_icon_size'])) {
			$search_opener_styles[] = 'font-size: ' . $instance['search_icon_size'] . 'px';
		}

		if (!empty($instance['search_icon_color'])) {
			$search_opener_styles[] = 'color: ' . $instance['search_icon_color'];
		}

		print $args['before_widget'];

		?>

		<a <?php echo topfit_mikado_get_inline_attr($instance['search_icon_hover_color'], 'data-hover-color'); ?>
			<?php if ($close_icon_on_same_position) {
				echo topfit_mikado_get_inline_attr('yes', 'data-icon-close-same-position');
			} ?>
			<?php topfit_mikado_inline_style($search_opener_styles); ?>
			<?php topfit_mikado_class_attribute($search_type_class); ?> href="javascript:void(0)">
			<?php if (isset($topfit_options['search_icon_pack'])) {
				$topfit_IconCollections->getSearchIcon($topfit_options['search_icon_pack'], false);
			} ?>
			<?php if ($show_search_text) { ?>
				<span class="mkd-search-icon-text"><?php esc_html_e('Search', 'topfit'); ?></span>
			<?php } ?>
		</a>

		<?php if ($fullscreen_search_overlay) { ?>
			<div class="mkd-fullscreen-search-overlay"></div>
		<?php } ?>

		<?php do_action('topfit_mikado_after_search_opener'); ?>

		<?php print $args['after_widget']; ?>
	<?php }
}
<?php

if(!function_exists('topfit_mikado_sidebar_options_map')) {

	function topfit_mikado_sidebar_options_map() {

		$panel_widgets = topfit_mikado_add_admin_panel(
			array(
				'page'  => '_page_page',
				'name'  => 'panel_widgets',
				'title' => esc_html__('Widgets', 'topfit')
			)
		);

		/**
		 * Navigation style
		 */

		topfit_mikado_add_admin_field(array(
			'name'          => 'page_boxed_widgets',
			'type'          => 'yesno',
			'default_value' => 'no',
			'label'         => esc_html__('Boxed Widgets', 'topfit'),
			'parent'        => $panel_widgets
		));

		$group_sidebar_padding = topfit_mikado_add_admin_group(array(
			'name'   => 'group_sidebar_padding',
			'title'  => esc_html__('Padding', 'topfit'),
			'parent' => $panel_widgets
		));

		$row_sidebar_padding = topfit_mikado_add_admin_row(array(
			'name'   => 'row_sidebar_padding',
			'parent' => $group_sidebar_padding
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'sidebar_padding_top',
			'default_value' => '',
			'label'         => esc_html__('Top Padding', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_sidebar_padding
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'sidebar_padding_right',
			'default_value' => '',
			'label'         => esc_html__('Right Padding', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_sidebar_padding
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'sidebar_padding_bottom',
			'default_value' => '',
			'label'         => esc_html__('Bottom Padding', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_sidebar_padding
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'sidebar_padding_left',
			'default_value' => '',
			'label'         => esc_html__('Left Padding', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_sidebar_padding
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'select',
			'name'          => 'sidebar_alignment',
			'default_value' => '',
			'label'         => esc_html__('Text Alignment', 'topfit'),
			'description'   => esc_html__('Choose text aligment', 'topfit'),
			'options'       => array(
				'left'   => esc_html__('Left', 'topfit'),
				'center' => esc_html__('Center', 'topfit'),
				'right'  => esc_html__('Right', 'topfit')
			),
			'parent'        => $panel_widgets
		));

	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_sidebar_options_map');

}
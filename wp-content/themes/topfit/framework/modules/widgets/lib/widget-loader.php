<?php

if(!function_exists('topfit_mikado_register_widgets')) {

	function topfit_mikado_register_widgets() {

		$widgets = array(
			'TopFitMikadoLatestPosts',
			'TopFitMikadoSearchOpener',
			'TopFitMikadoSideAreaOpener',
			'TopFitMikadoStickySidebar',
			'TopFitMikadoSocialIconWidget',
			'TopFitMikadoSeparatorWidget',
			'TopFitMikadoCallToActionButton',
			'TopFitMikadoHtmlWidget',
			'TopFitMikadoInfoWidget'
		);

		foreach($widgets as $widget) {
			register_widget($widget);
		}
	}
}

add_action('widgets_init', 'topfit_mikado_register_widgets');
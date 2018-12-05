<?php

if (!function_exists('topfit_mikado_portfolio_meta_box_map')) {
	function topfit_mikado_portfolio_meta_box_map() {

		$mkd_pages = array();
		$pages = get_pages();
		global $topfit_Framework;

		foreach($pages as $page) {
			$mkd_pages[$page->ID] = $page->post_title;
		}

		//Portfolio Images

		$mkdPortfolioImages = new TopFitMikadoMetaBox("portfolio-item", esc_html__('Portfolio Images (multiple upload)','topfit'), '', '', 'portfolio_images');
		$topfit_Framework->mkdMetaBoxes->addMetaBox("portfolio_images",$mkdPortfolioImages);

		$mkd_portfolio_image_gallery = new TopFitMikadoMultipleImages("mkd_portfolio-image-gallery", esc_html__('Portfolio Images','topfit'), esc_html('Choose your portfolio images','topfit'));
		$mkdPortfolioImages->addChild("mkd_portfolio-image-gallery",$mkd_portfolio_image_gallery);

		//Portfolio Images/Videos 2

		$mkdPortfolioImagesVideos2 = new TopFitMikadoMetaBox("portfolio-item", esc_html__('Portfolio Images/Videos (single upload)','topfit'));
		$topfit_Framework->mkdMetaBoxes->addMetaBox("portfolio_images_videos2",$mkdPortfolioImagesVideos2);

		$mkd_portfolio_images_videos2 = new TopFitMikadoImagesVideosFramework(esc_html__('Portfolio Images/Videos 2', 'topfit'),esc_html__('ThisIsDescription', 'topfit'));
		$mkdPortfolioImagesVideos2->addChild("mkd_portfolio_images_videos2",$mkd_portfolio_images_videos2);

		//Portfolio Additional Sidebar Items

		$mkdAdditionalSidebarItems = new TopFitMikadoMetaBox("portfolio-item", esc_html__('Additional Portfolio Sidebar Items' , 'topfit'));
		$topfit_Framework->mkdMetaBoxes->addMetaBox("portfolio_properties",$mkdAdditionalSidebarItems);

		$mkd_portfolio_properties = new TopFitMikadoOptionsFramework(esc_html__('Portfolio Properties','topfit'),esc_html__('ThisIsDescription','topfit'));
		$mkdAdditionalSidebarItems->addChild("mkd_portfolio_properties",$mkd_portfolio_properties);

	}
	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_portfolio_meta_box_map');
}
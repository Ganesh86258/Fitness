<?php

namespace TopFit\Modules\Shortcodes\Lib;

use TopFit\Modules\CallToAction\CallToAction;
use TopFit\Modules\Counter\Countdown;
use TopFit\Modules\Counter\Counter;
use TopFit\Modules\ElementsHolder\ElementsHolder;
use TopFit\Modules\ElementsHolderItem\ElementsHolderItem;
use TopFit\Modules\GoogleMap\GoogleMap;
use TopFit\Modules\Separator\Separator;
use TopFit\Modules\PieCharts\PieChartBasic\PieChartBasic;
use TopFit\Modules\PieCharts\PieChartDoughnut\PieChartDoughnut;
use TopFit\Modules\PieCharts\PieChartDoughnut\PieChartPie;
use TopFit\Modules\PieCharts\PieChartWithIcon\PieChartWithIcon;
use TopFit\Modules\Shortcodes\AnimationsHolder\AnimationsHolder;
use TopFit\Modules\Shortcodes\BlogSlider\BlogSlider;
use TopFit\Modules\Shortcodes\HorizontalTimeline\HorizontalTimeline;
use TopFit\Modules\Shortcodes\HorizontalTimeline\HorizontalTimelineItem;
use TopFit\Modules\Shortcodes\Icon\Icon;
use TopFit\Modules\Shortcodes\ImageGallery\ImageGallery;
use TopFit\Modules\Shortcodes\EventsList\EventsList;
use TopFit\Modules\Shortcodes\InfoBox\InfoBox;
use TopFit\Modules\Shortcodes\Process\ProcessHolder;
use TopFit\Modules\Shortcodes\Process\ProcessItem;
use TopFit\Modules\Shortcodes\SectionSubtitle\SectionSubtitle;
use TopFit\Modules\Shortcodes\SectionTitle\SectionTitle;
use TopFit\Modules\Shortcodes\TeamSlider\TeamSlider;
use TopFit\Modules\Shortcodes\TeamSliderItem\TeamSliderItem;
use TopFit\Modules\Shortcodes\CardSlider\CardSlider;
use TopFit\Modules\Shortcodes\CardSliderItem\CardSliderItem;
use TopFit\Modules\Shortcodes\TwitterSlider\TwitterSlider;
use TopFit\Modules\Shortcodes\TextMarquee\TextMarquee;
use TopFit\Modules\Shortcodes\VerticalProgressBar\VerticalProgressBar;
use TopFit\Modules\Shortcodes\VerticalSplitSlider\VerticalSplitSlider;
use TopFit\Modules\Shortcodes\VerticalSplitSliderContentItem\VerticalSplitSliderContentItem;
use TopFit\Modules\Shortcodes\VerticalSplitSliderLeftPanel\VerticalSplitSliderLeftPanel;
use TopFit\Modules\Shortcodes\VerticalSplitSliderRightPanel\VerticalSplitSliderRightPanel;
use TopFit\Modules\Shortcodes\VideoBanner\VideoBanner;
use TopFit\Modules\ProductList\ProductList;
use TopFit\Modules\SocialShare\SocialShare;
use TopFit\Modules\Team\Team;
use TopFit\Modules\OrderedList\OrderedList;
use TopFit\Modules\UnorderedList\UnorderedList;
use TopFit\Modules\Message\Message;
use TopFit\Modules\ProgressBar\ProgressBar;
use TopFit\Modules\IconListItem\IconListItem;
use TopFit\Modules\Tabs\Tabs;
use TopFit\Modules\Tab\Tab;
use TopFit\Modules\PricingTables\PricingTables;
use TopFit\Modules\PricingTable\PricingTable;
use TopFit\Modules\PricingTablesWithIcon\PricingTablesWithIcon;
use TopFit\Modules\PricingTableWithIcon\PricingTableWithIcon;
use TopFit\Modules\Accordion\Accordion;
use TopFit\Modules\AccordionTab\AccordionTab;
use TopFit\Modules\BlogList\BlogList;
use TopFit\Modules\Shortcodes\Button\Button;
use TopFit\Modules\Blockquote\Blockquote;
use TopFit\Modules\CustomFont\CustomFont;
use TopFit\Modules\Highlight\Highlight;
use TopFit\Modules\VideoButton\VideoButton;
use TopFit\Modules\Dropcaps\Dropcaps;
use TopFit\Modules\Shortcodes\IconWithText\IconWithText;
use TopFit\Modules\ImageWithTextOver\ImageWithTextOver;
use TopFit\Modules\Shortcodes\DeviceSlider\DeviceSlider;
use TopFit\Modules\Shortcodes\MobileSlider\MobileSlider;
use TopFit\Modules\Shortcodes\TableHolder\TableHolder;
use TopFit\Modules\Shortcodes\TableItem\TableItem;
use TopFit\Modules\Shortcodes\TableContentItem\TableContentItem;
use TopFit\Modules\Shortcodes\CardsGallery\CardsGallery;
use TopFit\Modules\Shortcodes\ComparisonSlider\ComparisonSlider;

/**
 * Class ShortcodeLoader
 */
class ShortcodeLoader {
	/**
	 * @var private instance of current class
	 */
	private static $instance;
	/**
	 * @var array
	 */
	private $loadedShortcodes = array();

	/**
	 * Private constuct because of Singletone
	 */
	private function __construct() {
	}

	/**
	 * Private sleep because of Singletone
	 */
	private function __wakeup() {
	}

	/**
	 * Private clone because of Singletone
	 */
	private function __clone() {
	}

	/**
	 * Returns current instance of class
	 * @return ShortcodeLoader
	 */
	public static function getInstance() {
		if (self::$instance == null) {
			return new self;
		}

		return self::$instance;
	}

	/**
	 * Adds new shortcode. Object that it takes must implement ShortcodeInterface
	 *
	 * @param ShortcodeInterface $shortcode
	 */
	private function addShortcode(ShortcodeInterface $shortcode) {
		if (!array_key_exists($shortcode->getBase(), $this->loadedShortcodes)) {
			$this->loadedShortcodes[$shortcode->getBase()] = $shortcode;
		}
	}

	/**
	 * Adds all shortcodes.
	 *
	 * @see ShortcodeLoader::addShortcode()
	 */
	private function addShortcodes() {
		$this->addShortcode(new ElementsHolder());
		$this->addShortcode(new ElementsHolderItem());
		$this->addShortcode(new Team());
		$this->addShortcode(new TeamSlider());
		$this->addShortcode(new TeamSliderItem());
		$this->addShortcode(new Icon());
		$this->addShortcode(new CallToAction());
		$this->addShortcode(new OrderedList());
		$this->addShortcode(new UnorderedList());
		$this->addShortcode(new Message());
		$this->addShortcode(new Counter());
		$this->addShortcode(new Countdown());
		$this->addShortcode(new ProgressBar());
		$this->addShortcode(new IconListItem());
		$this->addShortcode(new Tabs());
		$this->addShortcode(new Tab());
		$this->addShortcode(new PricingTables());
		$this->addShortcode(new PricingTable());
		$this->addShortcode(new PricingTablesWithIcon());
		$this->addShortcode(new PricingTableWithIcon());
		$this->addShortcode(new PieChartBasic());
		$this->addShortcode(new PieChartPie());
		$this->addShortcode(new PieChartDoughnut());
		$this->addShortcode(new PieChartWithIcon());
		$this->addShortcode(new Accordion());
		$this->addShortcode(new AccordionTab());
		$this->addShortcode(new BlogList());
		$this->addShortcode(new Button());
		$this->addShortcode(new Blockquote());
		$this->addShortcode(new CustomFont());
		$this->addShortcode(new Highlight());
		$this->addShortcode(new ImageGallery());
		$this->addShortcode(new GoogleMap());
		$this->addShortcode(new Separator());
		$this->addShortcode(new VideoButton());
		$this->addShortcode(new Dropcaps());
		$this->addShortcode(new IconWithText());
		$this->addShortcode(new TextMarquee());
		$this->addShortcode(new SocialShare());
		$this->addShortcode(new VideoBanner());
		$this->addShortcode(new AnimationsHolder());
		$this->addShortcode(new SectionTitle());
		$this->addShortcode(new SectionSubtitle());
		$this->addShortcode(new InfoBox());
		$this->addShortcode(new ProcessHolder());
		$this->addShortcode(new ProcessItem());
		$this->addShortcode(new HorizontalTimeline());
		$this->addShortcode(new HorizontalTimelineItem());
		$this->addShortcode(new VerticalProgressBar());
		$this->addShortcode(new BlogSlider());
		$this->addShortcode(new TwitterSlider());
		$this->addShortcode(new VerticalSplitSlider());
		$this->addShortcode(new VerticalSplitSliderLeftPanel());
		$this->addShortcode(new VerticalSplitSliderRightPanel());
		$this->addShortcode(new VerticalSplitSliderContentItem());
		$this->addShortcode(new CardSlider());
		$this->addShortcode(new CardSliderItem());
		$this->addShortcode(new ImageWithTextOver());
		$this->addShortcode(new DeviceSlider());
		$this->addShortcode(new MobileSlider());
		$this->addShortcode(new TableHolder());
		$this->addShortcode(new TableItem());
		$this->addShortcode(new TableContentItem());
		$this->addShortcode(new CardsGallery());
        $this->addShortcode(new ComparisonSlider());
		if (topfit_mikado_is_woocommerce_installed()) {
			$this->addShortcode(new ProductList());
		}
        if(topfit_mikado_the_events_calendar_installed()) {
            $this->addShortcode(new EventsList());
        }

	}

	/**
	 * Calls ShortcodeLoader::addShortcodes and than loops through added shortcodes and calls render method
	 * of each shortcode object
	 */
	public function load() {
		$this->addShortcodes();

		foreach ($this->loadedShortcodes as $shortcode) {
			add_shortcode($shortcode->getBase(), array($shortcode, 'render'));
		}

	}
}

$shortcodeLoader = ShortcodeLoader::getInstance();
$shortcodeLoader->load();
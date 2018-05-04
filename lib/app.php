<?php
/**
 * Project: MinervaKB.
 * Copyright: 2015-2017 @KonstruktStudio
 */

// legacy WordPress support
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/polyfill.php');

// abstract
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/abstract/admin-menu-page.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/abstract/admin-submenu-page.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/abstract/shortcode.php');

// importer
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/import/import.php');

// global modules
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/options.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/page-options.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/info.php');

// helpers
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/helpers/template-helper.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/helpers/analytics.php');

// modules
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/api.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/cpt.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/restrict.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/content.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/actions.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/assets.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/styles.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/ajax.php');

// shortcodes
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/shortcodes/search.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/shortcodes/info.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/shortcodes/faq.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/shortcodes.php');

// admin menu pages and edit screens
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/pages/sorting.php');
require_once(MINERVA_KB_PLUGIN_DIR . 'lib/pages/uninstall.php');

/**
 * Class MinervaKB_App
 * Main App Controller,
 * creates all module instances and passes down dependencies
 */
class MinervaKB_App {

	// holds current render info
	public $info;

	// custom post types controller
	private $cpt;

	// restriction module
	public $restrict;

	// manages content rendering
	public $content;

	// manages content parts rendering via actions
	public $actions;

	// inline styles manager
	private $inline_styles;

	// assets manager
	private $assets;

	// ajax manager
	private $ajax;

	// sidebars and widgets manager
	//private $widgets;

	// shortcodes manager
	public $shortcodes;

	// analytics manager
	private $analytics;

	// admin menu controller
	private $admin_page;

	// sorting menu page controller
	private $sorting_page;

	// uninstall menu page controller
	private $uninstall_page;

	// page edit screen controller
	private $page_edit;

	// article edit screen controller
	//private $article_edit;

	/**
	 * App entry
	 */
	public function __construct() {

		// global info model
		$this->info = new MinervaKB_Info();

		// restrict access functionality
		$this->restrict = new MinervaKB_Restrict( array(
			'info' => $this->info
		) );

		// custom post types
		$this->cpt = new MinervaKB_CPT(array(
			'info' => $this->info,
			'restrict' => $this->restrict
		));

		// client or ajax
		if ($this->info->is_client() || $this->info->is_ajax()) {
			$this->content = new MinervaKB_Content(array(
				'info' => $this->info,
				'restrict' => $this->restrict
			));
		}

		if ($this->info->is_client()) {
			// content hooks
			$this->actions = new MinervaKB_ContentHooks(array(
				'info' => $this->info,
				'restrict' => $this->restrict
			));

			// inline styles module
			$this->inline_styles = new MinervaKB_DynamicStyles(array(
				'info' => $this->info
			));
		}

		//if ($this->info->is_admin()) {
			//$this->analytics = new MinervaKB_Analytics();
		//}

		// ajax manager
		$this->ajax = new MinervaKB_Ajax(array(
			'info' => $this->info,
			//'analytics' => $this->analytics,
			'restrict' => $this->restrict
		));

		// assets manager
		$this->assets = new MinervaKB_Assets(array(
			'info' => $this->info,
			'inline_styles' => $this->inline_styles,
			'ajax' => $this->ajax
		));

		// shortcodes manager
		$this->shortcodes = new MinervaKB_Shortcodes();

	}
}
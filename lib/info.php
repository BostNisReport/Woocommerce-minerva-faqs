<?php
/**
 * Project: MinervaKB.
 * Copyright: 2015-2017 @KonstruktStudio
 */

require_once(MINERVA_KB_PLUGIN_DIR . 'lib/vendor/Mobile_Detect.php');

/**
 * Class MinervaKB_Info
 * Holds and caches all needed info for currently rendered entity
 */
class MinervaKB_Info {

	private $is_ajax;

	private $is_tag;

	private $is_topic;

	private $is_article_archive;

	private $is_archive;

	private $is_single;

	private $is_search;

	private $is_home;
	
	private $is_builder_home;
	
	private $is_settings_home;

	private $is_admin;

	private $is_client;
	
	private $is_desktop;
	
	private $is_tablet;
	
	private $is_mobile;

	private $is_demo_imported;

	private $is_demo_skipped;

	private $is_wpml;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->get_initial_info();
	}

	/**
	 * Gets all non-lazy properties
	 */
	private function get_initial_info() {
		$this->get_device_info();
	}

	/**
	 * Gets device info
	 */
	private function get_device_info() {
		$detect = new KST_Mobile_Detect();

		$this->is_desktop = false;
		$this->is_tablet = false;
		$this->is_mobile = false;

		if ( $detect->isTablet() ) {
			$this->is_tablet = true;
		} else if($detect->isMobile() ) {
			$this->is_mobile = true;
		} else {
			$this->is_desktop = true;
		}

		$detect = null;
	}

	public function is_ajax() {
		if (isset($this->is_ajax)) {
			return $this->is_ajax;
		}

		$this->is_ajax = (defined('DOING_AJAX') && DOING_AJAX);

		return $this->is_ajax;
	}

	/**
	 * Detects KB home page built with plugin settings
	 * @return bool
	 */
	public function is_single() {
		if (isset($this->is_single)) {
			return $this->is_single;
		}

		global $post;

		$this->is_single = is_single() && $post->post_type == MKB_Options::option( 'article_cpt' );

		return $this->is_single;
	}

	/**
	 * Detects any KB archive page
	 * @return bool
	 */
	public function is_archive() {
		if (isset($this->is_archive)) {
			return $this->is_archive;
		}

		$this->is_archive = $this->is_topic() || $this->is_article_archive() || $this->is_tag();

		return $this->is_archive;
	}

	/**
	 * Detects topic loop
	 * @return bool
	 */
	public function is_topic() {
		if (isset($this->is_topic)) {
			return $this->is_topic;
		}

		$this->is_topic = is_tax( MKB_Options::option( 'article_cpt_category' ) );

		return $this->is_topic;
	}

	/**
	 * Detects article archive loop
	 * @return bool
	 */
	public function is_article_archive() {
		if (isset($this->is_article_archive)) {
			return $this->is_article_archive;
		}

		$this->is_article_archive = is_post_type_archive( MKB_Options::option( 'article_cpt' ) );

		return $this->is_article_archive;
	}

	/**
	 * Detects tag loop
	 * @return bool
	 */
	public function is_tag() {
		if (isset($this->is_tag)) {
			return $this->is_tag;
		}

		$this->is_tag = is_tax( MKB_Options::option( 'article_cpt_tag' ));

		return $this->is_tag;
	}

	/**
	 * Detects search results loop
	 * @return bool
	 */
	public function is_search() {
		if (isset($this->is_search)) {
			return $this->is_search;
		}

		global $wp_query;

		$this->is_search = $wp_query->is_search;

		return $this->is_search;
	}

	/**
	 * Detects any KB home page
	 * @return mixed
	 */
	public function is_home() {
		if (isset($this->is_home)) {
			return $this->is_home;
		}

		$this->is_home = $this->is_settings_home() || $this->is_builder_home();

		return $this->is_home;
	}

	/**
	 * Detects KB home page built with page builder
	 * @return bool
	 */
	public function is_builder_home() {
		if (isset($this->is_builder_home)) {
			return $this->is_builder_home;
		}

		$this->is_builder_home = get_post_type() === 'page' && MKB_PageOptions::is_builder_page();

		return $this->is_builder_home;
	}

	/**
	 * Detects KB home page built with plugin settings
	 * @return bool
	 */
	public function is_settings_home() {
		if (isset($this->is_settings_home)) {
			return $this->is_settings_home;
		}

		global $post;

		$this->is_settings_home = get_post_type() === 'page' &&
		       MKB_Options::option( 'kb_page' ) &&
		       $post->ID === (int) MKB_Options::option( 'kb_page' );

		return $this->is_settings_home;
	}

	/**
	 * Detects admin side
	 * @return bool
	 */
	public function is_admin() {
		if (isset($this->is_admin)) {
			return $this->is_admin;
		}

		$this->is_admin = is_admin();

		return $this->is_admin;
	}

	/**
	 * Detects client side
	 * @return bool
	 */
	public function is_client() {
		if (isset($this->is_client)) {
			return $this->is_client;
		}

		$this->is_client = !$this->is_admin();

		return $this->is_client;
	}

	/**
	 * Flag for desktop devices
	 * @return mixed
	 */
	public function is_desktop () {
		return $this->is_desktop;
	}

	/**
	 * Flag for desktop devices
	 * @return mixed
	 */
	public function is_tablet () {
		return $this->is_tablet;
	}

	/**
	 * Flag for desktop devices
	 * @return mixed
	 */
	public function is_mobile () {
		return $this->is_mobile;
	}

	/**
	 * Flag for dummy data imported
	 * @return bool
	 */
	public function is_demo_imported () {
		if (isset($this->is_demo_imported)) {
			return $this->is_demo_imported;
		}

		$this->is_demo_imported = MinervaKB_DemoImporter::is_imported();

		return $this->is_demo_imported;
	}

	/**
	 * Flag for dummy data skipped
	 * @return bool
	 */
	public function is_demo_skipped () {
		if (isset($this->is_demo_skipped)) {
			return $this->is_demo_skipped;
		}

		$this->is_demo_skipped = MinervaKB_DemoImporter::is_skipped();

		return $this->is_demo_skipped;
	}

	/**
	 * Returns platform string
	 * @return string
	 */
	public function platform() {
		if ($this->is_mobile()) {
			return 'mobile';
		} else if ($this->is_tablet()) {
			return 'tablet';
		} else {
			return 'desktop';
		}
	}

	/**
	 * Detects WPML
	 * @return bool
	 */
	public function is_wpml() {
		$this->is_wpml = defined('ICL_LANGUAGE_CODE');

		return $this->is_wpml;
	}
}
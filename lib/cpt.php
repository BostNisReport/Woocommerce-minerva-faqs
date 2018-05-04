<?php
/**
 * Project: Minerva KB
 * Copyright: 2015-2016 @KonstruktStudio
 */

require_once(MINERVA_KB_PLUGIN_DIR . 'lib/helpers/icon-options.php');

/**
 * Class MinervaKB_CPT
 * Manages custom post type creation and edit pages
 */
class MinervaKB_CPT {

	private $info;

	private $restrict;

	/**
	 * Constructor
	 */
	public function __construct($deps) {

		$this->setup_dependencies($deps);
		// post types
		add_action('init', array($this, 'register_post_types'), 10);

	}

	/**
	 * Sets up dependencies
	 * @param $deps
	 */
	private function setup_dependencies($deps) {
		if (isset($deps['info'])) {
			$this->info = $deps['info'];
		}

		if (isset($deps['restrict'])) {
			$this->restrict = $deps['restrict'];
		}
	}

	/**
	 * Registers all configured custom post types
	 */
	public function register_post_types() {

		// FAQ
		if (!MKB_Options::option('disable_faq')) {
			$this->register_faq_cpt();
			$this->register_faq_taxonomy();
		}
	}

	/**
	 * Flush rewrite rules if never flushed
	 */
	private function maybe_flush_rules () {
		// NOTE: needed to make CPT visible after register (force WP rewrite rules flush)
		if (MKB_Options::need_to_flush_rules()) {
			flush_rewrite_rules(false);

			MKB_Options::update_flush_flags();
		}
	}

	/**
	 * Registers KB article custom post type
	 */
	private function register_article_cpt() {
	

		if (MKB_Options::option( 'cpt_slug_switch' )) {
			$args["rewrite"] = array(
				"slug" => MKB_Options::option( 'article_slug' ),
				"with_front" => MKB_Options::option( 'cpt_slug_front_switch' )
			);
		}

		register_post_type( MKB_Options::option( 'article_cpt' ), $args );
	}

	/**
	 * Registers FAQ custom post type
	 */
	private function register_faq_cpt() {
		/**
		 * FAQ
		 */
		$faq_labels = array(
			'name' => 'FAQ',
			'singular_name' => 'FAQ',
			'menu_name' => 'FAQ',
			'all_items' => 'All Questions',
			'view_item' => 'View question',
			'add_new_item' => 'Add new question',
			'add_new' => 'Add new',
			'edit_item' => 'Edit question',
			'update_item' => 'Update question',
			'search_items' => 'Search question',
			'not_found' => 'Questions not found',
			'not_found_in_trash' => 'Questions not found in trash',
		);

		$faq_args = array(
			'description' => __( 'FAQ', 'minerva-kb' ),
			'labels' => $faq_labels,
			'supports' => array(
				'title',
				'editor',
				'author',
				'revisions'
			),
			'hierarchical' => false,
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => false,
			'show_in_admin_bar' => false,
			'menu_position' => 5,
			'menu_icon' => 'dashicons-welcome-learn-more',
			'can_export' => true,
			'has_archive' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'capability_type' => 'post',
		);

		register_post_type( 'faq', $faq_args );
	}

	/**
	 * Registers KB topic custom taxonomy
	 */
	private function register_faq_taxonomy() {
		$args = array(
			'labels' => array(
				'name' => __( 'FAQ Categories', 'minerva-kb' ),
				'add_new_item' => __( 'Add category', 'minerva-kb' ),
				'new_item_name' => __( 'New category', 'minerva-kb' )
			),
			'show_ui' => true,
			'show_tagcloud' => false,
			'hierarchical' => true
		);

		register_taxonomy(
			'faq_category',
			'faq',
			$args
		);
	}
}

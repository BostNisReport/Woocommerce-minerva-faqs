<?php
/**
 * Project: Minerva KB
 * Copyright: 2015-2016 @KonstruktStudio
 */

class MKB_Options {

	const OPTION_KEY = 'minerva-kb-options';

	const WPML_DOMAIN = 'MinervaKB';

	public function __construct() {
		self::register();
	}

	public static function register() {}

	public static function get_options_defaults() {
		return array_reduce(self::get_non_ui_options(self::get_options()), function($defaults, $option) {
			$defaults[$option["id"]] = $option["default"];
			return $defaults;
		}, array());
	}

	/**
	 * Returns all options by id key
	 * @return mixed
	 */
	public static function get_options_by_id() {
		return array_reduce(self::get_non_ui_options(self::get_options()), function($options, $option) {
			$options[$option["id"]] = $option;
			return $options;
		}, array());
	}

	public static function get_options() {
		return array(
			
			/**
			 * FAQ home
			 */
			array(
				'id' => 'faq_home_tab',
				'type' => 'tab',
				'label' => __( 'Home page: FAQ', 'minerva-kb' ),
				'icon' => 'fa-home'
			),
			array(
				'id' => 'home_faq_section_title',
				'type' => 'title',
				'label' => __( 'Home page FAQ section', 'minerva-kb' ),
				'description' => __( 'Configure the display of FAQ on home KB page', 'minerva-kb' )
			),
			array(
				'id' => 'home_faq_title',
				'type' => 'input_text',
				'label' => __( 'FAQ title', 'minerva-kb' ),
				'default' => __( 'Frequently Asked Questions', 'minerva-kb' )
			),
			array(
				'id' => 'home_faq_title_size',
				'type' => 'input',
				'label' => __( 'FAQ title font size', 'minerva-kb' ),
				'default' => __( '3em', 'minerva-kb' ),
				'description' => 'Use any CSS value, for ex. 3em or 20px',
				'dependency' => array(
					'target' => 'home_faq_title',
					'type' => 'NEQ',
					'value' => ''
				)
			),
			array(
				'id' => 'home_faq_title_color',
				'type' => 'color',
				'label' => __( 'FAQ title color', 'minerva-kb' ),
				'default' => '#333333',
				'dependency' => array(
					'target' => 'home_faq_title',
					'type' => 'NEQ',
					'value' => ''
				)
			),
			array(
				'id' => 'home_faq_layout_section_title',
				'type' => 'title',
				'label' => __( 'Home FAQ layout', 'minerva-kb' ),
				'description' => __( 'Configure FAQ layout on home page', 'minerva-kb' )
			),
			array(
				'id' => 'home_faq_margin_top',
				'type' => 'css_size',
				'label' => __( 'FAQ section top margin', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "3"),
				'description' => __( 'Distance between FAQ and previous section', 'minerva-kb' ),
			),
			array(
				'id' => 'home_faq_margin_bottom',
				'type' => 'css_size',
				'label' => __( 'FAQ section bottom margin', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "3"),
				'description' => __( 'Distance between FAQ and next sections', 'minerva-kb' ),
			),
			array(
				'id' => 'home_faq_limit_width_switch',
				'type' => 'checkbox',
				'label' => __( 'Limit FAQ container width?', 'minerva-kb' ),
				'default' => true
			),
			array(
				'id' => 'home_faq_width_limit',
				'type' => 'css_size',
				'label' => __( 'FAQ container maximum width', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "60"),
				'description' => __( 'You can make FAQ section more narrow, than your content width', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'home_faq_limit_width_switch',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'home_faq_controls_margin_top',
				'type' => 'css_size',
				'label' => __( 'FAQ controls top margin', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "2"),
				'description' => __( 'Distance between FAQ controls and title', 'minerva-kb' ),
			),
			array(
				'id' => 'home_faq_controls_margin_bottom',
				'type' => 'css_size',
				'label' => __( 'FAQ controls bottom margin', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "2"),
				'description' => __( 'Distance between FAQ controls and questions', 'minerva-kb' ),
			),
			array(
				'id' => 'home_faq_controls_section_title',
				'type' => 'title',
				'label' => __( 'Home FAQ controls', 'minerva-kb' ),
				'description' => __( 'Configure FAQ controls on home page', 'minerva-kb' )
			),
			array(
				'id' => 'home_show_faq_filter',
				'type' => 'checkbox',
				'label' => __( 'Show FAQ live filter?', 'minerva-kb' ),
				'default' => true
			),
			array(
				'id' => 'home_show_faq_toggle_all',
				'type' => 'checkbox',
				'label' => __( 'Show FAQ toggle all button?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'home_faq_categories_section_title',
				'type' => 'title',
				'label' => __( 'FAQ categories settings', 'minerva-kb' ),
				'description' => __( 'Configure FAQ categories', 'minerva-kb' )
			),
			array(
				'id' => 'home_faq_categories',
				'type' => 'term_select',
				'label' => __( 'Select FAQ categories to display on home page', 'minerva-kb' ),
				'default' => '',
				'tax' => 'faq_category',
				'description' => __( 'You can leave it empty to display all categories.', 'minerva-kb' )
			),

			array(
				'id' => 'home_show_faq_categories',
				'type' => 'checkbox',
				'label' => __( 'Show FAQ categories?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'home_show_faq_category_count',
				'type' => 'checkbox',
				'label' => __( 'Show FAQ category question count?', 'minerva-kb' ),
				'default' => true,
			),
			array(
				'id' => 'home_faq_styles_note_title',
				'type' => 'title',
				'label' => __( 'NOTE: You can configure FAQ styles in FAQ (global)', 'minerva-kb' )
			),
			/**
			 * General
			 */
			array(
				'id' => 'general_tab',
				'type' => 'tab',
				'label' => __( 'General', 'minerva-kb' ),
				'icon' => 'fa-cogs'
			),
			array(
				'id' => 'general_content_title',
				'type' => 'title',
				'label' => __( 'General settings', 'minerva-kb' ),
				'description' => __( 'Configure general KB settings', 'minerva-kb' )
			),
			array(
				'id' => 'layout_title',
				'type' => 'title',
				'label' => __( 'Layout', 'minerva-kb' ),
				'description' => __( 'Configure KB layout', 'minerva-kb' )
			),
			array(
				'id' => 'container_width',
				'type' => 'css_size',
				'label' => __( 'Root container width', 'minerva-kb' ),
				'default' => array("unit" => 'px', "size" => "1180"),
				'units' => array('px', '%'),
				'description' => __( 'Container is the top level element that limits the width of KB content', 'minerva-kb' )
			),
			array(
				'id' => 'content_width',
				'type' => 'css_size',
				'label' => __( 'Content width (%)', 'minerva-kb' ),
				'default' => array("unit" => '%', "size" => "66"),
				'units' => array('%'),
				'description' => __( 'Use this setting to configure width of content vs sidebar, when sidebar is on. Sidebar will take rest of available space', 'minerva-kb' )
			),
			array(
				'id' => 'css_title',
				'type' => 'title',
				'label' => __( 'Custom CSS', 'minerva-kb' ),
				'description' => __( 'Add custom styling', 'minerva-kb' )
			),
			array(
				'id' => 'custom_css',
				'type' => 'textarea',
				'label' => __( 'CSS to add after plugin styles', 'minerva-kb' ),
				'height' => 20,
				'width' => 80,
				'default' => __( '', 'minerva-kb' )
			),
			array(
				'id' => 'pagination_title',
				'type' => 'title',
				'label' => __( 'Pagination', 'minerva-kb' ),
				'description' => __( 'Configure KB pagination', 'minerva-kb' )
			),
			array(
				'id' => 'pagination_style',
				'type' => 'select',
				'label' => __( 'Which pagination style to use on topic, tag, archive and search results pages?', 'minerva-kb' ),
				'options' => array(
					'plugin' => __( 'Minerva', 'minerva-kb' ),
					'theme' => __( 'WordPress default', 'minerva-kb' )
				),
				'default' => 'plugin',
				'description' => __( 'When WordPress default selected, theme styled pagination should appear', 'minerva-kb' )
			),
			array(
				'id' => 'pagination_bg',
				'type' => 'color',
				'label' => __( 'Pagination item background color', 'minerva-kb' ),
				'default' => '#f7f7f7',
				'dependency' => array(
					'target' => 'pagination_style',
					'type' => 'EQ',
					'value' => 'plugin'
				)
			),
			array(
				'id' => 'pagination_color',
				'type' => 'color',
				'label' => __( 'Pagination item text color', 'minerva-kb' ),
				'default' => '#333',
				'dependency' => array(
					'target' => 'pagination_style',
					'type' => 'EQ',
					'value' => 'plugin'
				)
			),
			array(
				'id' => 'pagination_link_color',
				'type' => 'color',
				'label' => __( 'Pagination item link color', 'minerva-kb' ),
				'default' => '#007acc',
				'dependency' => array(
					'target' => 'pagination_style',
					'type' => 'EQ',
					'value' => 'plugin'
				)
			),
			/**
			 * Styles
			 */
			array(
				'id' => 'styles_tab',
				'type' => 'tab',
				'label' => __( 'Typography & Styles', 'minerva-kb' ),
				'icon' => 'fa-paint-brush'
			),
			array(
				'id' => 'typography_title',
				'type' => 'title',
				'label' => __( 'Typography', 'minerva-kb' ),
				'description' => __( 'Configure KB fonts', 'minerva-kb' )
			),
			// typography
			array(
				'id' => 'typography_on',
				'type' => 'checkbox',
				'label' => __( 'Enable typography options?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'When off, theme styles will be used', 'minerva-kb' )
			),
			array(
				'id' => 'style_font',
				'type' => 'font',
				'label' => __( 'Font', 'minerva-kb' ),
				'default' => 'Roboto',
				'description' => __( 'Select font to use for KB', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'style_font_gf_weights',
				'type' => 'google_font_weights',
				'label' => __( 'Font weights to load (for Google Fonts only)', 'minerva-kb' ),
				'default' => array('400', '600'),
				'description' => __( 'Font weights to load from Google. Use Shift or Ctrl/Cmd to select multiple values. Note: more weights mean more load time', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'style_font_gf_languages',
				'type' => 'google_font_languages',
				'label' => __( 'Font languages to load (for Google Fonts only)', 'minerva-kb' ),
				'default' => array(),
				'description' => __( 'Font languages to load from Google. Latin set is always loaded. Use Shift or Ctrl/Cmd to select multiple values. Note: more languages mean more load time', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'dont_load_font',
				'type' => 'checkbox',
				'label' => __( 'Don\'t load font?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'Can be useful if your theme or other plugin loads this font already', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'content_font_size',
				'type' => 'css_size',
				'label' => __( 'Article content font size', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "1"),
				'description' => __( 'Content font size is used to proportionally change size article text', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'content_line_height',
				'type' => 'css_size',
				'label' => __( 'Article content line-height', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "1.7"),
				'description' => __( 'Content line height', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'h1_font_size',
				'type' => 'css_size',
				'label' => __( 'H1 heading font size', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "2"),
				'description' => __( 'H1 heading', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'h2_font_size',
				'type' => 'css_size',
				'label' => __( 'H2 heading font size', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "1.8"),
				'description' => __( 'H2 heading', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'h3_font_size',
				'type' => 'css_size',
				'label' => __( 'H3 heading font size', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "1.6"),
				'description' => __( 'H3 heading', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'h4_font_size',
				'type' => 'css_size',
				'label' => __( 'H4 heading font size', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "1.4"),
				'description' => __( 'H4 heading', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'h5_font_size',
				'type' => 'css_size',
				'label' => __( 'H5 heading font size', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "1.2"),
				'description' => __( 'H5 heading', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'h6_font_size',
				'type' => 'css_size',
				'label' => __( 'H6 heading font size', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "1"),
				'description' => __( 'H6 heading', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'widget_font_size',
				'type' => 'css_size',
				'label' => __( 'Widget content font size', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "1"),
				'description' => __( 'Widget content font size', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'widget_heading_font_size',
				'type' => 'css_size',
				'label' => __( 'Widget heading font size', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "1.3"),
				'description' => __( 'Widget heading font size', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'typography_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			// text colors
			array(
				'id' => 'content_colors_title',
				'type' => 'title',
				'label' => __( 'Text styles', 'minerva-kb' ),
				'description' => __( 'Configure text and heading colors', 'minerva-kb' )
			),
			array(
				'id' => 'text_color',
				'type' => 'color',
				'label' => __( 'Article text color', 'minerva-kb' ),
				'default' => '#333'
			),
			array(
				'id' => 'text_link_color',
				'type' => 'color',
				'label' => __( 'Article text link color', 'minerva-kb' ),
				'default' => '#007acc'
			),
			array(
				'id' => 'h1_color',
				'type' => 'color',
				'label' => __( 'H1 heading color', 'minerva-kb' ),
				'default' => '#333'
			),
			array(
				'id' => 'h2_color',
				'type' => 'color',
				'label' => __( 'H2 heading color', 'minerva-kb' ),
				'default' => '#333'
			),
			array(
				'id' => 'h3_color',
				'type' => 'color',
				'label' => __( 'H3 heading color', 'minerva-kb' ),
				'default' => '#333'
			),
			array(
				'id' => 'h4_color',
				'type' => 'color',
				'label' => __( 'H4 heading color', 'minerva-kb' ),
				'default' => '#333'
			),
			array(
				'id' => 'h5_color',
				'type' => 'color',
				'label' => __( 'H5 heading color', 'minerva-kb' ),
				'default' => '#333'
			),
			array(
				'id' => 'h6_color',
				'type' => 'color',
				'label' => __( 'H6 heading color', 'minerva-kb' ),
				'default' => '#333'
			),
		
			/**
			 * FAQ
			 */
			array(
				'id' => 'faq_tab',
				'type' => 'tab',
				'label' => __( 'FAQ (global)', 'minerva-kb' ),
				'icon' => 'fa-question-circle'
			),
			array(
				'id' => 'disable_faq',
				'type' => 'checkbox',
				'label' => __( 'Disable FAQ?', 'minerva-kb' ),
				'default' => false
			),
			// cpt
			array(
				'id' => 'faq_title',
				'type' => 'title',
				'label' => __( 'FAQ global settings', 'minerva-kb' ),
				'description' => __( 'Configure FAQ settings', 'minerva-kb' )
			),
			array(
				'id' => 'faq_slow_animation',
				'type' => 'checkbox',
				'label' => __( 'Slow FAQ open animation?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'faq_toggle_mode',
				'type' => 'checkbox',
				'label' => __( 'Toggle mode?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'In toggle mode opening one item closes others', 'minerva-kb' )
			),
			array(
				'id' => 'faq_toggle_all_title',
				'type' => 'title',
				'label' => __( 'FAQ Toggle All button', 'minerva-kb' ),
				'description' => __( 'Configure toggle all styling', 'minerva-kb' )
			),
			array(
				'id' => 'faq_toggle_all_open_text',
				'type' => 'input_text',
				'label' => __( 'FAQ Toggle All open text', 'minerva-kb' ),
				'default' => __( 'Open all', 'minerva-kb' ),
			),
			array(
				'id' => 'faq_toggle_all_close_text',
				'type' => 'input_text',
				'label' => __( 'FAQ Toggle All close text', 'minerva-kb' ),
				'default' => __( 'Close all', 'minerva-kb' ),
			),
			array(
				'id' => 'show_faq_toggle_all_icon',
				'type' => 'checkbox',
				'label' => __( 'Show FAQ toggle all icon?', 'minerva-kb' ),
				'default' => true
			),
			array(
				'id' => 'faq_toggle_all_icon',
				'type' => 'icon_select',
				'label' => __( 'FAQ toggle all icon (open)', 'minerva-kb' ),
				'default' => 'fa-plus-circle',
				'dependency' => array(
					'target' => 'show_faq_toggle_all_icon',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'faq_toggle_all_icon_open',
				'type' => 'icon_select',
				'label' => __( 'FAQ toggle all icon (close)', 'minerva-kb' ),
				'default' => 'fa-minus-circle',
				'dependency' => array(
					'target' => 'show_faq_toggle_all_icon',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'faq_toggle_all_bg',
				'type' => 'color',
				'label' => __( 'FAQ toggle all background color', 'minerva-kb' ),
				'default' => '#4bb7e5'
			),
			array(
				'id' => 'faq_toggle_all_bg_hover',
				'type' => 'color',
				'label' => __( 'FAQ toggle all background color on mouse hover', 'minerva-kb' ),
				'default' => '#64bee5'
			),
			array(
				'id' => 'faq_toggle_all_color',
				'type' => 'color',
				'label' => __( 'FAQ toggle all link color', 'minerva-kb' ),
				'default' => '#ffffff'
			),
			array(
				'id' => 'faq_questions_title',
				'type' => 'title',
				'label' => __( 'FAQ Questions style', 'minerva-kb' ),
				'description' => __( 'Configure questions styling', 'minerva-kb' )
			),
			array(
				'id' => 'show_faq_question_icon',
				'type' => 'checkbox',
				'label' => __( 'Show FAQ question icon?', 'minerva-kb' ),
				'default' => true
			),
			array(
				'id' => 'faq_question_icon',
				'type' => 'icon_select',
				'label' => __( 'FAQ question icon', 'minerva-kb' ),
				'default' => 'fa-plus-circle'
			),
			array(
				'id' => 'faq_question_icon_open_action',
				'type' => 'select',
				'label' => __( 'FAQ question icon action on open', 'minerva-kb' ),
				'options' => array(
					'rotate' => __( 'Rotate', 'minerva-kb' ),
					'change' => __( 'Change', 'minerva-kb' )
				),
				'default' => 'change'
			),
			array(
				'id' => 'faq_question_open_icon',
				'type' => 'icon_select',
				'label' => __( 'FAQ question open icon', 'minerva-kb' ),
				'default' => 'fa-minus-circle',
				'dependency' => array(
					'target' => 'faq_question_icon_open_action',
					'type' => 'EQ',
					'value' => 'change'
				)
			),
			array(
				'id' => 'faq_question_bg',
				'type' => 'color',
				'label' => __( 'FAQ question background color', 'minerva-kb' ),
				'default' => '#4bb7e5'
			),
			array(
				'id' => 'faq_question_bg_hover',
				'type' => 'color',
				'label' => __( 'FAQ question background color on mouse hover', 'minerva-kb' ),
				'default' => '#64bee5'
			),
			array(
				'id' => 'faq_question_color',
				'type' => 'color',
				'label' => __( 'FAQ question text color', 'minerva-kb' ),
				'default' => '#ffffff'
			),
			array(
				'id' => 'faq_question_shadow',
				'type' => 'checkbox',
				'label' => __( 'Add FAQ question shadow?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'faq_answers_title',
				'type' => 'title',
				'label' => __( 'FAQ Answers style', 'minerva-kb' ),
				'description' => __( 'Configure answers styling', 'minerva-kb' )
			),
			array(
				'id' => 'faq_answer_bg',
				'type' => 'color',
				'label' => __( 'FAQ answer background color', 'minerva-kb' ),
				'default' => '#ffffff'
			),
			array(
				'id' => 'faq_answer_color',
				'type' => 'color',
				'label' => __( 'FAQ answer text color', 'minerva-kb' ),
				'default' => '#333'
			),
			array(
				'id' => 'faq_categories_title',
				'type' => 'title',
				'label' => __( 'FAQ Categories style', 'minerva-kb' ),
				'description' => __( 'Configure categories styling', 'minerva-kb' )
			),
			array(
				'id' => 'faq_category_margin_top',
				'type' => 'css_size',
				'label' => __( 'Category name top margin', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "1"),
				'description' => __( 'Distance between category title and previous section', 'minerva-kb' ),
			),
			array(
				'id' => 'faq_category_margin_bottom',
				'type' => 'css_size',
				'label' => __( 'Category name bottom margin', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "0.3"),
				'description' => __( 'Distance between category title and questions', 'minerva-kb' ),
			),
			array(
				'id' => 'faq_count_bg',
				'type' => 'color',
				'label' => __( 'FAQ category count background color', 'minerva-kb' ),
				'default' => '#4bb7e5',
			),
			array(
				'id' => 'faq_count_color',
				'type' => 'color',
				'label' => __( 'FAQ category count text color', 'minerva-kb' ),
				'default' => '#ffffff',
			),
			array(
				'id' => 'faq_filter_title',
				'type' => 'title',
				'label' => __( 'FAQ Live Filter style', 'minerva-kb' ),
				'description' => __( 'Configure filter styling', 'minerva-kb' )
			),
			array(
				'id' => 'faq_filter_theme',
				'type' => 'select',
				'label' => __( 'FAQ filter theme', 'minerva-kb' ),
				'options' => array(
					'minerva' => __( 'Minerva', 'minerva-kb' ),
					'invisible' => __( 'Invisible', 'minerva-kb' )
				),
				'default' => 'minerva'
			),
			array(
				'id' => 'faq_filter_placeholder',
				'type' => 'input_text',
				'label' => __( 'FAQ filter placeholder', 'minerva-kb' ),
				'default' => __( 'FAQ filter', 'minerva-kb' ),
			),
			array(
				'id' => 'show_faq_filter_icon',
				'type' => 'checkbox',
				'label' => __( 'Show FAQ filter icon?', 'minerva-kb' ),
				'default' => true
			),
			array(
				'id' => 'faq_filter_icon',
				'type' => 'icon_select',
				'label' => __( 'FAQ filter icon', 'minerva-kb' ),
				'default' => 'fa-filter',
			),
			array(
				'id' => 'faq_filter_clear_icon',
				'type' => 'icon_select',
				'label' => __( 'FAQ filter clear icon', 'minerva-kb' ),
				'default' => 'fa-times-circle',
			),
			array(
				'id' => 'faq_no_results_text',
				'type' => 'input_text',
				'label' => __( 'FAQ filter no results text', 'minerva-kb' ),
				'default' => __( 'No questions matching current filter', 'minerva-kb' ),
			),
			array(
				'id' => 'faq_no_results_bg',
				'type' => 'color',
				'label' => __( 'FAQ no results background color', 'minerva-kb' ),
				'default' => '#f7f7f7'
			),
			array(
				'id' => 'faq_no_results_color',
				'type' => 'color',
				'label' => __( 'FAQ no results text color', 'minerva-kb' ),
				'default' => '#333'
			),
			array(
				'id' => 'faq_filter_open_single',
				'type' => 'checkbox',
				'label' => __( 'Open question when single item matches filter?', 'minerva-kb' ),
				'default' => false,
			),
			/**
			 * Post type
			 */
			array(
				'id' => 'cpt_tab',
				'type' => 'tab',
				'label' => __( 'Post type & URLs', 'minerva-kb' ),
				'icon' => 'fa-address-card-o'
			),
			array(
				'id' => 'article_cpt_section_info',
				'type' => 'info',
				'label' => 'Note: this section modifies WordPress rewrite rules, which are usually cached. ' .
				               'If you experience any 404 errors after editing these settings, go to ' .
				               '<a href="' . esc_attr(admin_url('options-permalink.php')) . '">' .
				               'Settings - Permalinks' . '</a>' . ' and press Save ' .
				               'without editing to clear rewrite rules cache.',
			),
			// cpt
			array(
				'id' => 'article_cpt_title',
				'type' => 'title',
				'label' => __( 'Article URL', 'minerva-kb' ),
				'description' => __( 'Configure article post type URL', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_archive_disable_switch',
				'type' => 'checkbox',
				'label' => __( 'Disable article archive?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'By default, articles archive takes same URL as article URL base (for example, /kb), so disabling archive will allow you to use this slug for your KB home page', 'minerva-kb' ),
			),
			array(
				'id' => 'cpt_slug_switch',
				'type' => 'checkbox',
				'label' => __( 'Edit article slug (URL part)?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'article_slug',
				'type' => 'input',
				'label' => __( 'Article slug (URL part)', 'minerva-kb' ),
				'default' => 'kb',
				'description' => __( 'Use only lowercase letters, underscores and dashes. Slug must be a valid URL part', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'cpt_slug_switch',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'cpt_slug_front_switch',
				'type' => 'checkbox',
				'label' => __( 'Add global front base to article url?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'If you have configured global front base, like /blog, you can remove it for KB items with this switch', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'cpt_slug_switch',
					'type' => 'EQ',
					'value' => true
				)
			),
		
			// tags
			array(
				'id' => 'article_cpt_tag_title',
				'type' => 'title',
				'label' => __( 'Tag URL', 'minerva-kb' ),
				'description' => __( 'Configure tag taxonomy URL slug', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_tag_slug_switch',
				'type' => 'checkbox',
				'label' => __( 'Edit tag slug (URL part)', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'tag_slug',
				'type' => 'input',
				'label' => __( 'Tag slug (URL part)', 'minerva-kb' ),
				'default' => 'kbtag',
				'description' => __( 'Use only lowercase letters, underscores and dashes. Slug must be a valid URL part', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'cpt_tag_slug_switch',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'cpt_tag_slug_front_switch',
				'type' => 'checkbox',
				'label' => __( 'Add global front base to tag url?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'If you have configured global front base, like /blog, you can remove it for KB items with this switch', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'cpt_tag_slug_switch',
					'type' => 'EQ',
					'value' => true
				)
			),
			// CPT advanced
			array(
				'id' => 'article_cpt_names_title',
				'type' => 'title',
				'label' => __( 'Post type and taxonomy advanced settings', 'minerva-kb' ),
				'description' => __( 'These setting are available to resolve conflicts with other plugins', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_advanced_switch',
				'type' => 'checkbox',
				'label' => __( 'Edit post type settings?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'article_cpt_warning',
				'type' => 'warning',
				'label' => __( 'Following settings are available for compatibility with other plugins and change the actual post type and taxonomy. ' .
				               'If you change them, already added KB content will be hidden until you change it back. ' .
				               'If you need to change URL part, please use the slug settings above instead.', 'minerva-kb' ),
			),
			array(
				'id' => 'article_cpt',
				'type' => 'input',
				'label' => __( 'Article post type', 'minerva-kb' ),
				'default' => 'kb',
				'description' => __( 'Use only lowercase letters. Note, that if you have already added articles changing this setting will make them invisible.', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'cpt_advanced_switch',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'article_cpt_category',
				'type' => 'input',
				'label' => __( 'Article topic taxonomy', 'minerva-kb' ),
				'default' => 'kbtopic',
				'description' => __( 'Use only lowercase letters. Do not use "category", as it is reserved for standard posts. Note, that if you have already added topics changing this setting will make them invisible.', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'cpt_advanced_switch',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'article_cpt_tag',
				'type' => 'input',
				'label' => __( 'Article tag taxonomy', 'minerva-kb' ),
				'default' => 'kbtag',
				'description' => __( 'Use only lowercase letters. Do not use "tag", as it is reserved for standard posts. Note, that if you have already added tags changing this setting will make them invisible.', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'cpt_advanced_switch',
					'type' => 'EQ',
					'value' => true
				)
			),

			/**
			 * Search global
			 */
			array(
				'id' => 'search_global_tab',
				'type' => 'tab',
				'label' => __( 'Search (global)', 'minerva-kb' ),
				'icon' => 'fa-search'
			),
			// search global title
			array(
				'id' => 'search_global_title',
				'type' => 'title',
				'label' => __( 'Global search settings', 'minerva-kb' ),
				'description' => __( 'Configure search results page and other search options here', 'minerva-kb' )
			),
			array(
				'id' => 'search_mode',
				'type' => 'select',
				'label' => __( 'Which search mode to use?', 'minerva-kb' ),
				'options' => array(
					'blocking' => __( 'Blocking', 'minerva-kb' ),
					'nonblocking' => __( 'Non-blocking (default)', 'minerva-kb' )
				),
				'default' => 'nonblocking',
				'description' => __( 'Blocking mode does not send any requests to server until user finishes typing, can be useful for reducing load on server.', 'minerva-kb' ),
			),
			array(
				'id' => 'search_request_fe_cache',
				'type' => 'checkbox',
				'label' => __( 'Enable search requests caching on client side?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'When enabled, already received search results won\'t be send again to the server until user refreshes the page', 'minerva-kb' ),
			),
			array(
				'id' => 'search_request_icon',
				'type' => 'icon_select',
				'label' => __( 'Search request icon', 'minerva-kb' ),
				'default' => 'fa-circle-o-notch',
			),
			array(
				'id' => 'search_request_icon_color',
				'type' => 'color',
				'label' => __( 'Search request icon color', 'minerva-kb' ),
				'default' => '#2ab77b'
			),
			array(
				'id' => 'search_include_tag_matches',
				'type' => 'checkbox',
				'label' => __( 'Include tag matches in search results?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'Only exact matches are added, for ex. search for install will match articles with tag install, not installation', 'minerva-kb' ),
			),
			array(
				'id' => 'search_delay',
				'type' => 'input',
				'label' => __( 'Live Search delay/throttle (ms)', 'minerva-kb' ),
				'default' => 1000,
				'description' => __( 'Delay before search after the moment user stops typing query, in milliseconds. For non-blocking mode - minimum interval between requests', 'minerva-kb' )
			),
			array(
				'id' => 'search_needle_length',
				'type' => 'input',
				'label' => __( 'Number of characters to trigger search', 'minerva-kb' ),
				'default' => 3,
				'description' => __( 'Search will not run until user types at least this amount of characters', 'minerva-kb' )
			),
			array(
				'id' => 'live_search_disable_mobile',
				'type' => 'checkbox',
				'label' => __( 'Disable live search on mobile?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'When disabled, search page will be shown instead', 'minerva-kb' ),
			),
			array(
				'id' => 'live_search_disable_tablet',
				'type' => 'checkbox',
				'label' => __( 'Disable live search on tablet?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'When disabled, search page will be shown instead', 'minerva-kb' ),
			),
			array(
				'id' => 'live_search_disable_desktop',
				'type' => 'checkbox',
				'label' => __( 'Disable live search on desktop?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'When disabled, search page will be shown instead', 'minerva-kb' ),
			),
			/**
			 * Search results page
			 */
			array(
				'id' => 'search_results_title',
				'type' => 'title',
				'label' => __( 'Search results page settings', 'minerva-kb' ),
				'description' => __( 'Configure appearance and display mode of search results page', 'minerva-kb' )
			),
			array(
				'id' => 'search_results_top_padding',
				'type' => 'css_size',
				'label' => __( 'Search results page top padding', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "0"),
				'description' => __( 'Distance between header and search results page content', 'minerva-kb' )
			),
			array(
				'id' => 'search_results_bottom_padding',
				'type' => 'css_size',
				'label' => __( 'Search results  page bottom padding', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "0"),
				'description' => __( 'Distance between search results page content and footer', 'minerva-kb' )
			),
			array(
				'id' => 'search_sidebar',
				'type' => 'image_select',
				'label' => __( 'Search results page sidebar position', 'minerva-kb' ),
				'options' => array(
					'none' => array(
						'label' => __( 'None', 'minerva-kb' ),
						'img' => MINERVA_KB_IMG_URL . 'no-sidebar.png'
					),
					'left' => array(
						'label' => __( 'Left', 'minerva-kb' ),
						'img' => MINERVA_KB_IMG_URL . 'left-sidebar.png'
					),
					'right' => array(
						'label' => __( 'Right', 'minerva-kb' ),
						'img' => MINERVA_KB_IMG_URL . 'right-sidebar.png'
					),
				),
				'default' => 'right',
				'description' => __( 'You can add widgets to sidebars under Appearance - Widgets', 'minerva-kb' )
			),
			array(
				'id' => 'search_results_per_page',
				'type' => 'input',
				'label' => __( 'Number of search results per page. Use -1 to show all', 'minerva-kb' ),
				'default' => __( '10', 'minerva-kb' )
			),
			array(
				'id' => 'show_search_page_search',
				'type' => 'checkbox',
				'label' => __( 'Show search box on results page?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'Search settings from topic search will be used', 'minerva-kb' ),
			),
			array(
				'id' => 'show_breadcrumbs_search',
				'type' => 'checkbox',
				'label' => __( 'Show breadcrumbs on search results page?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'Enable/disable breadcrumbs for search results page', 'minerva-kb' ),
			),
			array(
				'id' => 'search_results_breadcrumbs_label',
				'type' => 'input_text',
				'label' => __( 'Search breadcrumbs label', 'minerva-kb' ),
				'default' => __( 'Search results for %s', 'minerva-kb' ),
				'description' => __( '%s will be replaced with search term', 'minerva-kb' ),
			),
			array(
				'id' => 'search_results_page_title',
				'type' => 'input_text',
				'label' => __( 'Search page title', 'minerva-kb' ),
				'default' => __( 'Found %s results for: %s', 'minerva-kb' ),
				'description' => __( '%s will be replaced with number of results and search term', 'minerva-kb' ),
			),
			array(
				'id' => 'search_results_layout',
				'type' => 'select',
				'label' => __( 'Which search results page layout to use?', 'minerva-kb' ),
				'options' => array(
					'simple' => __( 'Simple', 'minerva-kb' ),
					'detailed' => __( 'Detailed (with excerpt)', 'minerva-kb' )
				),
				'default' => 'detailed'
			),
			array(
				'id' => 'search_results_detailed_title',
				'type' => 'title',
				'label' => __( 'Search results detailed layout settings', 'minerva-kb' ),
				'description' => __( 'Configure settings of detailed mode for search results', 'minerva-kb' )
			),
			array(
				'id' => 'search_results_excerpt_length',
				'type' => 'input',
				'label' => __( 'Excerpt length (characters)', 'minerva-kb' ),
				'default' => __( '300', 'minerva-kb' )
			),
			array(
				'id' => 'search_results_match_color',
				'type' => 'color',
				'label' => __( 'Search match in excerpt color', 'minerva-kb' ),
				'default' => '#000'
			),
			array(
				'id' => 'search_results_match_bg',
				'type' => 'color',
				'label' => __( 'Search match in excerpt background color', 'minerva-kb' ),
				'default' => 'rgba(255,255,255,0)'
			),
			array(
				'id' => 'show_search_page_topic',
				'type' => 'checkbox',
				'label' => __( 'Show article topic on results page?', 'minerva-kb' ),
				'default' => true
			),
			array(
				'id' => 'show_search_page_views',
				'type' => 'checkbox',
				'label' => __( 'Show article views count?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'Views will be displayed only when > 0', 'minerva-kb' )
			),
			array(
				'id' => 'show_search_page_likes',
				'type' => 'checkbox',
				'label' => __( 'Show article likes count?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'Likes will be displayed only when > 0', 'minerva-kb' )
			),
			array(
				'id' => 'show_search_page_dislikes',
				'type' => 'checkbox',
				'label' => __( 'Show article dislikes count?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'Dislikes will be displayed only when > 0', 'minerva-kb' )
			),
			array(
				'id' => 'show_search_page_last_edit',
				'type' => 'checkbox',
				'label' => __( 'Show article last modified date?', 'minerva-kb' ),
				'default' => true
			),
			array(
				'id' => 'search_no_results_title',
				'type' => 'input_text',
				'label' => __( 'Search no results page title', 'minerva-kb' ),
				'default' => __( 'Nothing Found', 'minerva-kb' )
			),
			array(
				'id' => 'search_no_results_subtitle',
				'type' => 'input_text',
				'label' => __( 'Search no results page subtitle', 'minerva-kb' ),
				'default' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'minerva-kb' )
			),

			
			/**
			 * Tags
			 */
			array(
				'id' => 'tags_tab',
				'type' => 'tab',
				'label' => __( 'Tags', 'minerva-kb' ),
				'icon' => 'fa-tags'
			),
			array(
				'id' => 'tags_disable',
				'type' => 'checkbox',
				'label' => __( 'Disable tags archive?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'You can use tags for description purposes, but remove tags archive and tag links from articles', 'minerva-kb' ),
			),
			array(
				'id' => 'tag_template',
				'type' => 'select',
				'label' => __( 'Which tag template to use?', 'minerva-kb' ),
				'options' => array(
					'theme' => __( 'Theme archive template', 'minerva-kb' ),
					'plugin' => __( 'Plugin tag template', 'minerva-kb' )
				),
				'default' => 'plugin',
				'experimental' => __( 'This is experimental feature and depends a lot on theme styles and layout', 'minerva-kb' ),
				'description' => __( 'Note, that you can override plugin templates in your theme. See documentation for details', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'tags_disable',
					'type' => 'NEQ',
					'value' => true
				)
			),
			array(
				'id' => 'tag_articles_per_page',
				'type' => 'input',
				'label' => __( 'Number of articles per tag page. Use -1 to show all', 'minerva-kb' ),
				'default' => __( '10', 'minerva-kb' )
			),
			array(
				'id' => 'tag_sidebar',
				'type' => 'image_select',
				'label' => __( 'Tag sidebar position', 'minerva-kb' ),
				'options' => array(
					'none' => array(
						'label' => __( 'None', 'minerva-kb' ),
						'img' => MINERVA_KB_IMG_URL . 'no-sidebar.png'
					),
					'left' => array(
						'label' => __( 'Left', 'minerva-kb' ),
						'img' => MINERVA_KB_IMG_URL . 'left-sidebar.png'
					),
					'right' => array(
						'label' => __( 'Right', 'minerva-kb' ),
						'img' => MINERVA_KB_IMG_URL . 'right-sidebar.png'
					),
				),
				'default' => 'right',
				'description' => __( 'You can add widgets to sidebars under Appearance - Widgets', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'tags_disable',
					'type' => 'NEQ',
					'value' => true
				)
			),
			/**
			 * Breadcrumbs
			 */
			array(
				'id' => 'breadcrumbs_tab',
				'type' => 'tab',
				'label' => __( 'Breadcrumbs', 'minerva-kb' ),
				'icon' => 'fa-ellipsis-h'
			),
			array(
				'id' => 'breadcrumbs_home_label',
				'type' => 'input_text',
				'label' => __( 'Breadcrumbs home page label', 'minerva-kb' ),
				'default' => __( 'KB Home', 'minerva-kb' )
			),
			array(
				'id' => 'breadcrumbs_custom_home_switch',
				'type' => 'checkbox',
				'label' => __( 'Set custom home page link?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'This can be useful if you are building KB home page with shortcodes', 'minerva-kb' )
			),
			/*array(
				'id' => 'breadcrumbs_custom_home_page',
				'type' => 'select',
				'label' => __( 'Breadcrumbs custom home page', 'minerva-kb' ),
				'options' => self::get_pages_options(),
				'default' => '',
				'description' => __( 'Select breadcrumbs custom home page', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'breadcrumbs_custom_home_switch',
					'type' => 'EQ',
					'value' => true
				)
			),*/
			array(
				'id' => 'breadcrumbs_label',
				'type' => 'input_text',
				'label' => __( 'Breadcrumbs label', 'minerva-kb' ),
				'default' => __( 'You are here:', 'minerva-kb' )
			),
			array(
				'id' => 'breadcrumbs_separator_icon',
				'type' => 'icon_select',
				'label' => __( 'Breadcrumbs separator', 'minerva-kb' ),
				'default' => 'fa-caret-right'
			),
			array(
				'id' => 'breadcrumbs_font_size',
				'type' => 'css_size',
				'label' => __( 'Breadcrumbs font size', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "1"),
				'description' => __( 'Breadcrumbs font size', 'minerva-kb' )
			),
			array(
				'id' => 'breadcrumbs_align',
				'type' => 'select',
				'label' => __( 'Breadcrumbs text align', 'minerva-kb' ),
				'options' => array(
					'left' => __( 'Left', 'minerva-kb' ),
					'center' => __( 'Center', 'minerva-kb' ),
					'right' => __( 'Right', 'minerva-kb' )
				),
				'default' => 'left',
				'description' => __( 'Select text align for breadrumbs', 'minerva-kb' )
			),
			array(
				'id' => 'breadcrumbs_top_padding',
				'type' => 'css_size',
				'label' => __( 'Breadcrumbs top padding', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "0"),
				'description' => __( 'Breadcrumbs container top padding', 'minerva-kb' )
			),
			array(
				'id' => 'breadcrumbs_bottom_padding',
				'type' => 'css_size',
				'label' => __( 'Breadcrumbs bottom padding', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "0"),
				'description' => __( 'Breadcrumbs container bottom padding', 'minerva-kb' )
			),
			array(
				'id' => 'breadcrumbs_left_padding',
				'type' => 'css_size',
				'label' => __( 'Breadcrumbs left padding', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "0"),
				'description' => __( 'Breadcrumbs container left padding', 'minerva-kb' )
			),
			array(
				'id' => 'breadcrumbs_right_padding',
				'type' => 'css_size',
				'label' => __( 'Breadcrumbs right padding', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "0"),
				'description' => __( 'Breadcrumbs container right padding', 'minerva-kb' )
			),
			array(
				'id' => 'breadcrumbs_bg_color',
				'type' => 'color',
				'label' => __( 'Breadcrumbs container background color (transparent by default)', 'minerva-kb' ),
				'default' => 'rgba(255,255,255,0)'
			),
			array(
				'id' => 'breadcrumbs_image_bg',
				'type' => 'media',
				'label' => __( 'Breadcrumbs background image URL (optional)', 'minerva-kb' ),
				'default' => ''
			),
			array(
				'id' => 'breadcrumbs_add_gradient',
				'type' => 'checkbox',
				'label' => __( 'Add gradient overlay?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'breadcrumbs_gradient_from',
				'type' => 'color',
				'label' => __( 'Breadcrumbs gradient from', 'minerva-kb' ),
				'default' => '#00c1b6',
				'dependency' => array(
					'target' => 'breadcrumbs_add_gradient',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'breadcrumbs_gradient_to',
				'type' => 'color',
				'label' => __( 'Breadcrumbs gradient to', 'minerva-kb' ),
				'default' => '#136eb5',
				'dependency' => array(
					'target' => 'breadcrumbs_add_gradient',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'breadcrumbs_gradient_opacity',
				'type' => 'input',
				'label' => __( 'Breadcrumbs background gradient opacity', 'minerva-kb' ),
				'default' => 1,
				'description' => __( 'Use any CSS opacity value, for example 1 or 0.7', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'breadcrumbs_add_gradient',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'breadcrumbs_add_pattern',
				'type' => 'checkbox',
				'label' => __( 'Add pattern overlay?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'breadcrumbs_image_pattern',
				'type' => 'media',
				'label' => __( 'Breadcrumbs background pattern image URL (optional)', 'minerva-kb' ),
				'default' => '',
				'dependency' => array(
					'target' => 'breadcrumbs_add_pattern',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'breadcrumbs_image_pattern_opacity',
				'type' => 'input',
				'label' => __( 'Breadcrumbs background pattern opacity', 'minerva-kb' ),
				'default' => 1,
				'description' => __( 'Use any CSS opacity value, for example 1 or 0.7. You can also use transparent .png and set opacity to 1', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'breadcrumbs_add_pattern',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'breadcrumbs_text_color',
				'type' => 'color',
				'label' => __( 'Breadcrumbs text color', 'minerva-kb' ),
				'default' => '#888'
			),
			array(
				'id' => 'breadcrumbs_link_color',
				'type' => 'color',
				'label' => __( 'Breadcrumbs link color', 'minerva-kb' ),
				'default' => '#888'
			),
			array(
				'id' => 'breadcrumbs_add_shadow',
				'type' => 'checkbox',
				'label' => __( 'Add shadow to breadcrumbs container?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'breadcrumbs_inset_shadow',
				'type' => 'checkbox',
				'label' => __( 'Inner shadow?', 'minerva-kb' ),
				'default' => false,
				'dependency' => array(
					'target' => 'breadcrumbs_add_shadow',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'show_breadcrumbs_category',
				'type' => 'checkbox',
				'label' => __( 'Show breadcrumbs in category?', 'minerva-kb' ),
				'default' => true
			),
			array(
				'id' => 'show_breadcrumbs_single',
				'type' => 'checkbox',
				'label' => __( 'Show breadcrumbs in article?', 'minerva-kb' ),
				'default' => true
			),
			/**
			 * Rating
			 */
			array(
				'id' => 'rating_tab',
				'type' => 'tab',
				'label' => __( 'Rating', 'minerva-kb' ),
				'icon' => 'fa-star-o'
			),
			array(
				'id' => 'rating_block_label',
				'type' => 'input_text',
				'label' => __( 'Rating block label', 'minerva-kb' ),
				'default' => __( 'Was this article helpful?', 'minerva-kb' )
			),
			array(
				'id' => 'likes_title',
				'type' => 'title',
				'label' => __( 'Likes settings', 'minerva-kb' ),
				'description' => __( 'Configure rating likes', 'minerva-kb' )
			),
			array(
				'id' => 'show_likes_button',
				'type' => 'checkbox',
				'label' => __( 'Show likes button?', 'minerva-kb' ),
				'default' => true
			),
			array(
				'id' => 'like_label',
				'type' => 'input_text',
				'label' => __( 'Like label', 'minerva-kb' ),
				'default' => __( 'Like', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'show_likes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'show_likes_icon',
				'type' => 'checkbox',
				'label' => __( 'Show likes icon?', 'minerva-kb' ),
				'default' => true,
				'dependency' => array(
					'target' => 'show_likes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'like_icon',
				'type' => 'icon_select',
				'label' => __( 'Like icon', 'minerva-kb' ),
				'default' => 'fa-smile-o',
				'dependency' => array(
					'target' => 'show_likes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'like_color',
				'type' => 'color',
				'label' => __( 'Like button color (used also for messages and feedback form button)', 'minerva-kb' ),
				'default' => '#4BB651',
				'dependency' => array(
					'target' => 'show_likes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'show_likes_count',
				'type' => 'checkbox',
				'label' => __( 'Show likes count?', 'minerva-kb' ),
				'default' => true,
				'dependency' => array(
					'target' => 'show_likes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'show_like_message',
				'type' => 'checkbox',
				'label' => __( 'Show message after like?', 'minerva-kb' ),
				'default' => false,
				'dependency' => array(
					'target' => 'show_likes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'like_message_text',
				'type' => 'textarea_text',
				'label' => __( 'Like message text', 'minerva-kb' ),
				'default' => __( '<i class="fa fa-smile-o"></i> Great!<br/><strong>Thank you</strong> for your vote!', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'show_likes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'dislikes_title',
				'type' => 'title',
				'label' => __( 'Dislikes settings', 'minerva-kb' ),
				'description' => __( 'Configure rating dislikes', 'minerva-kb' )
			),
			array(
				'id' => 'show_dislikes_button',
				'type' => 'checkbox',
				'label' => __( 'Show dislikes button?', 'minerva-kb' ),
				'default' => true
			),
			array(
				'id' => 'dislike_label',
				'type' => 'input_text',
				'label' => __( 'Dislike label', 'minerva-kb' ),
				'default' => __( 'Dislike', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'show_dislikes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'show_dislikes_icon',
				'type' => 'checkbox',
				'label' => __( 'Show dislikes icon?', 'minerva-kb' ),
				'default' => true,
				'dependency' => array(
					'target' => 'show_dislikes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'dislike_icon',
				'type' => 'icon_select',
				'label' => __( 'Dislike icon', 'minerva-kb' ),
				'default' => 'fa-frown-o',
				'dependency' => array(
					'target' => 'show_dislikes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'dislike_color',
				'type' => 'color',
				'label' => __( 'Dislike button color', 'minerva-kb' ),
				'default' => '#C85C5E',
				'dependency' => array(
					'target' => 'show_dislikes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'show_dislikes_count',
				'type' => 'checkbox',
				'label' => __( 'Show dislikes count?', 'minerva-kb' ),
				'default' => true,
				'dependency' => array(
					'target' => 'show_dislikes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'show_dislike_message',
				'type' => 'checkbox',
				'label' => __( 'Show message after dislike?', 'minerva-kb' ),
				'default' => false,
				'dependency' => array(
					'target' => 'show_dislikes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'dislike_message_text',
				'type' => 'textarea_text',
				'label' => __( 'Dislike message text', 'minerva-kb' ),
				'default' => __( 'Thank you for your vote!', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'show_dislikes_button',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'rating_message_bg',
				'type' => 'color',
				'label' => __( 'Like / dislike message background color', 'minerva-kb' ),
				'default' => '#f7f7f7'
			),
			array(
				'id' => 'rating_message_color',
				'type' => 'color',
				'label' => __( 'Like / dislike message text color', 'minerva-kb' ),
				'default' => '#888'
			),
			array(
				'id' => 'rating_message_border_color',
				'type' => 'color',
				'label' => __( 'Like / dislike message border color', 'minerva-kb' ),
				'default' => '#eee'
			),
			array(
				'id' => 'show_rating_total',
				'type' => 'checkbox',
				'label' => __( 'Show rating total?', 'minerva-kb' ),
				'default' => false,
				'description' => 'A line of text, like: 3 of 10 found this article helpful'
			),
			array(
				'id' => 'rating_total_text',
				'type' => 'input_text',
				'label' => __( 'Rating total text', 'minerva-kb' ),
				'default' => __( '%d of %d found this article helpful.', 'minerva-kb' ),
				'description' => 'First %d is replaced with likes, second - with total sum of votes',
				'dependency' => array(
					'target' => 'show_rating_total',
					'type' => 'EQ',
					'value' => true
				)
			),
			/**
			 * Feedback
			 */
			array(
				'id' => 'feedback_tab',
				'type' => 'tab',
				'label' => __( 'Feedback', 'minerva-kb' ),
				'icon' => 'fa-bullhorn'
			),
			array(
				'id' => 'enable_feedback',
				'type' => 'checkbox',
				'label' => __( 'Enable article feedback?', 'minerva-kb' ),
				'default' => false,
				'description' => 'Allow users to leave feedback on articles'
			),
			array(
				'id' => 'feedback_mode',
				'type' => 'select',
				'label' => __( 'Feedback form display mode?', 'minerva-kb' ),
				'options' => array(
					'dislike' => __( 'Show after dislike', 'minerva-kb' ),
					'like' => __( 'Show after like', 'minerva-kb' ),
					'any' => __( 'Show after like or dislike', 'minerva-kb' ),
					'always' => __( 'Always present', 'minerva-kb' )
				),
				'default' => 'dislike',
				'description' => __( 'Select when to display feedback form', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'enable_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'feedback_label',
				'type' => 'input_text',
				'label' => __( 'Set feedback form label', 'minerva-kb' ),
				'default' => __( 'You can leave feedback:', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'enable_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'feedback_submit_label',
				'type' => 'input_text',
				'label' => __( 'Set feedback submit button label', 'minerva-kb' ),
				'default' => __( 'Send feedback', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'enable_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'feedback_submit_request_label',
				'type' => 'input_text',
				'label' => __( 'Set feedback submit button label to show when request in progress', 'minerva-kb' ),
				'default' => __( 'Sending...', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'enable_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'feedback_submit_bg',
				'type' => 'color',
				'label' => __( 'Feedback submit button background color', 'minerva-kb' ),
				'default' => '#4a90e2',
				'dependency' => array(
					'target' => 'enable_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'feedback_submit_color',
				'type' => 'color',
				'label' => __( 'Feedback submit button text color', 'minerva-kb' ),
				'default' => '#ffffff',
				'dependency' => array(
					'target' => 'enable_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'feedback_info_text',
				'type' => 'textarea_text',
				'label' => __( 'You can add extra description to feedback form', 'minerva-kb' ),
				'default' => __( 'We will use your feedback to improve this article', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'enable_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'feedback_sent_text',
				'type' => 'textarea_text',
				'label' => __( 'Text to display after feedback sent. You can use HTML', 'minerva-kb' ),
				'default' => __( 'Thank you for your feedback, we will do our best to fix this soon', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'enable_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'feedback_message_bg',
				'type' => 'color',
				'label' => __( 'Feedback message background color', 'minerva-kb' ),
				'default' => '#f7f7f7',
				'dependency' => array(
					'target' => 'enable_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'feedback_message_color',
				'type' => 'color',
				'label' => __( 'Feedback message text color', 'minerva-kb' ),
				'default' => '#888',
				'dependency' => array(
					'target' => 'enable_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'feedback_message_border_color',
				'type' => 'color',
				'label' => __( 'Feedback message border color', 'minerva-kb' ),
				'default' => '#eee',
				'dependency' => array(
					'target' => 'enable_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			
			// back to top
			array(
				'id' => 'toc_back_to_top_title',
				'type' => 'title',
				'label' => __( 'Back to top', 'minerva-kb' ),
				'description' => __( 'Configure Back to top links for TOC', 'minerva-kb' )
			),
			array(
				'id' => 'show_back_to_top',
				'type' => 'checkbox',
				'label' => __( 'Show back to top link in anchors?', 'minerva-kb' ),
				'default' => true
			),
			array(
				'id' => 'back_to_site_top',
				'type' => 'checkbox',
				'label' => __( 'Scroll back to site top?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'By default, back to top scrolls to article text top', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'show_back_to_top',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'back_to_top_text',
				'type' => 'input_text',
				'label' => __( 'Back to top text', 'minerva-kb' ),
				'default' => __( 'To top', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'show_back_to_top',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'show_back_to_top_icon',
				'type' => 'checkbox',
				'label' => __( 'Add back to top icon?', 'minerva-kb' ),
				'default' => true,
				'dependency' => array(
					'target' => 'show_back_to_top',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'back_to_top_icon',
				'type' => 'icon_select',
				'label' => __( 'Back to top icon', 'minerva-kb' ),
				'default' => 'fa-long-arrow-up',
				'dependency' => array(
					'target' => 'show_back_to_top',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'back_to_top_position',
				'type' => 'select',
				'label' => __( 'Where to display back to top?', 'minerva-kb' ),
				'options' => array(
					'inline' => __( 'Inline with section title', 'minerva-kb' ),
					'under' => __( 'Under section title', 'minerva-kb' )
				),
				'default' => 'inline',
				'dependency' => array(
					'target' => 'show_back_to_top',
					'type' => 'EQ',
					'value' => true
				)
			),
			// scrollspy
			array(
				'id' => 'scrollspy_title',
				'type' => 'title',
				'label' => __( 'Table of contents Widget / ScrollSpy settings', 'minerva-kb' ),
				'description' => __( 'Configure TOC widget', 'minerva-kb' )
			),
			array(
				'id' => 'toc_in_content_disable',
				'type' => 'checkbox',
				'label' => __( 'Remove table of contents from article body?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'This must be on if you plan to use table of contents widget in article sidebar.', 'minerva-kb' ),
			),
			array(
				'id' => 'scrollspy_switch',
				'type' => 'checkbox',
				'label' => __( 'Enable ScrollSpy?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'scrollspy_bg',
				'type' => 'color',
				'label' => __( 'Active link background color', 'minerva-kb' ),
				'default' => '#00aae8',
				'dependency' => array(
					'target' => 'scrollspy_switch',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'scrollspy_color',
				'type' => 'color',
				'label' => __( 'Active link text color', 'minerva-kb' ),
				'default' => '#fff',
				'dependency' => array(
					'target' => 'scrollspy_switch',
					'type' => 'EQ',
					'value' => true
				)
			),
			// manual
			array(
				'id' => 'toc_manual_title',
				'type' => 'title',
				'label' => __( 'Table of contents manual mode', 'minerva-kb' ),
			),
			array(
				'id' => 'toc_manual_info',
				'type' => 'info',
				'label' => 'Table of contents can be build using shortcodes instead of headings, in case you can not use h1-h6 tags in article text. ' .
				           'To use table of contents in manual mode you need to disable dynamic table of contents above and use mkb-anchor shortcodes, see example below.',
			),
			array(
				'id' => 'toc_manual_usage',
				'type' => 'code',
				'label' => __( 'Table of contents manual mode (shortcode) use example', 'minerva-kb' ),
				'default' => '[mkb-anchor]Section name[/mkb-anchor]'
			),
			/**
			 * Restrict content
			 */
			array(
				'id' => 'restrict_tab',
				'type' => 'tab',
				'label' => __( 'Restrict Access', 'minerva-kb' ),
				'icon' => 'fa-lock'
			),
			array(
				'id' => 'restrict_title',
				'type' => 'title',
				'label' => __( 'Content restriction settings', 'minerva-kb' ),
				'description' => __( 'You can customize who can see the knowledge base content here', 'minerva-kb' )
			),
			array(
				'id' => 'restrict_on',
				'type' => 'checkbox',
				'label' => __( 'Enable content restriction?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'By default, we disable restrict functionality, since you might use external plugin for this', 'minerva-kb' ),
			),
			array(
				'id' => 'restrict_article_role',
				'type' => 'roles_select',
				'label' => __( 'Global restriction: who can view articles?', 'minerva-kb' ),
				'default' => 'none',
				'flush' => true,
				'view_log' => true,
				'description' => __( 'Select roles, that have access to articles on client side.<br/> If you want to restrict specific articles or topics, you do so on article and topic pages', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_remove_from_archives',
				'type' => 'checkbox',
				'label' => __( 'Remove restricted articles from home page topic and archives?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'You can display or remove restricted articles from topics', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_remove_from_search',
				'type' => 'checkbox',
				'label' => __( 'Remove restricted articles from search results?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'You can display or remove restricted articles from search results', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_remove_search_for_restricted',
				'type' => 'checkbox',
				'label' => __( 'Remove search sections when user has no access to knowledge base?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'You can remove search modules completely for users who do not have access to content.', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_article_message',
				'type' => 'textarea_text',
				'label' => __( 'Restricted article message', 'minerva-kb' ),
				'description' => __( 'Message to display when unauthorized user is trying to access restricted article. You can use HTML here', 'minerva-kb' ),
				'default' => __( 'The content you are trying to access is for members only. Please login to view it.', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_message_icon',
				'type' => 'icon_select',
				'label' => __( 'Restrict message icon', 'minerva-kb' ),
				'default' => 'fa-lock',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_message_bg',
				'type' => 'color',
				'label' => __( 'Restrict message background', 'minerva-kb' ),
				'default' => '#fcf8e3',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_message_border',
				'type' => 'color',
				'label' => __( 'Restrict message border color', 'minerva-kb' ),
				'default' => '#faebcc',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_message_icon_color',
				'type' => 'color',
				'label' => __( 'Restrict message icon color', 'minerva-kb' ),
				'default' => '#8a6d3b',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_message_color',
				'type' => 'color',
				'label' => __( 'Restrict message text color', 'minerva-kb' ),
				'default' => '#333333',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_show_article_breadcrumbs',
				'type' => 'checkbox',
				'label' => __( 'Show breadcrumbs on restricted articles?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'Control the visibility of breadcrumbs on restricted articles', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_show_article_search',
				'type' => 'checkbox',
				'label' => __( 'Show articles search section on restricted articles?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'Control the visibility of search on restricted articles', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_show_article_related',
				'type' => 'checkbox',
				'label' => __( 'Show related articles section on restricted articles?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'Control the visibility of related articles section on restricted articles', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_show_article_excerpt',
				'type' => 'checkbox',
				'label' => __( 'Show excerpt for restricted articles?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'Control the teaser/excerpt for restricted articles. NOTE, the text added to excerpt box displayed, not dynamically generated', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_show_excerpt_gradient',
				'type' => 'checkbox',
				'label' => __( 'Show excerpt gradient overlay?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'A semi-transparent gradient, that hides the ending of the excerpt', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_article_excerpt_gradient_start',
				'type' => 'color',
				'label' => __( 'Start color for overlay gradient', 'minerva-kb' ),
				'default' => '#fff',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_message_before_html',
				'type' => 'textarea_text',
				'label' => __( 'Restricted article additional HTML (before login form)', 'minerva-kb' ),
				'description' => __( 'Use this field if you need to display any extra HTML content before login form', 'minerva-kb' ),
				'default' => __( '', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_message_after_html',
				'type' => 'textarea_text',
				'label' => __( 'Restricted article additional HTML (after login form)', 'minerva-kb' ),
				'description' => __( 'Use this field if you need to display any extra HTML content after messages and login form', 'minerva-kb' ),
				'default' => __( '', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_title',
				'type' => 'title',
				'label' => __( 'Restricted content login form', 'minerva-kb' ),
				'description' => __( 'Configure the appearance for the login form', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_show_login_form',
				'type' => 'checkbox',
				'label' => __( 'Show login form after restricted content message?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'Control the login form display for restricted articles', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_form_width',
				'type' => 'css_size',
				'label' => __( 'Login form width', 'minerva-kb' ),
				'default' => array("unit" => 'em', "size" => "26"),
				'description' => __( 'Minimum width for login form', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_form_align',
				'type' => 'select',
				'label' => __( 'Login form align in container', 'minerva-kb' ),
				'options' => array(
					'left' => __( 'Left', 'minerva-kb' ),
					'center' => __( 'Center', 'minerva-kb' ),
					'right' => __( 'Right', 'minerva-kb' ),
				),
				'default' => 'center',
				'description' => __( 'Select login form align', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_bg',
				'type' => 'color',
				'label' => __( 'Login form background', 'minerva-kb' ),
				'default' => '#f7f7f7',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_label_color',
				'type' => 'color',
				'label' => __( 'Login form label color', 'minerva-kb' ),
				'default' => '#999',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_input_bg',
				'type' => 'color',
				'label' => __( 'Login form input background', 'minerva-kb' ),
				'default' => '#ffffff',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_input_text_color',
				'type' => 'color',
				'label' => __( 'Login form input text color', 'minerva-kb' ),
				'default' => '#333',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_username_label_text',
				'type' => 'input_text',
				'label' => __( 'Login form username/email label text', 'minerva-kb' ),
				'default' => __( 'Username or Email Address', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_password_label_text',
				'type' => 'input_text',
				'label' => __( 'Login form password label text', 'minerva-kb' ),
				'default' => __( 'Password', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_remember_label_text',
				'type' => 'input_text',
				'label' => __( 'Login form Remember me label text', 'minerva-kb' ),
				'default' => __( 'Remember Me', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_text',
				'type' => 'input_text',
				'label' => __( 'Login button text', 'minerva-kb' ),
				'default' => __( 'Log in', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_btn_bg',
				'type' => 'color',
				'label' => __( 'Login button background', 'minerva-kb' ),
				'default' => '#F7931E',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_btn_shadow',
				'type' => 'color',
				'label' => __( 'Login button shadow', 'minerva-kb' ),
				'default' => '#e46d19',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_login_btn_color',
				'type' => 'color',
				'label' => __( 'Login button text color', 'minerva-kb' ),
				'default' => '#ffffff',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_show_register_link',
				'type' => 'checkbox',
				'label' => __( 'Show register button inside login form?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'Control the register button display in login form', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_show_or',
				'type' => 'checkbox',
				'label' => __( 'Also show separator label between login and register?', 'minerva-kb' ),
				'default' => true,
				'description' => __( 'Text between login and register buttons', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_or_text',
				'type' => 'input_text',
				'label' => __( 'Separator label text', 'minerva-kb' ),
				'default' => __( 'Or', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_register_text',
				'type' => 'input_text',
				'label' => __( 'Register button text', 'minerva-kb' ),
				'default' => __( 'Register', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_register_btn_bg',
				'type' => 'color',
				'label' => __( 'Login register button background', 'minerva-kb' ),
				'default' => '#29ABE2',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_register_btn_shadow',
				'type' => 'color',
				'label' => __( 'Register button shadow', 'minerva-kb' ),
				'default' => '#287eb1',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_register_btn_color',
				'type' => 'color',
				'label' => __( 'Register button text color', 'minerva-kb' ),
				'default' => '#ffffff',
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'restrict_disable_form_styles',
				'type' => 'checkbox',
				'label' => __( 'Disable custom form and styles?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'Default theme login form and style will apply', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'restrict_on',
					'type' => 'EQ',
					'value' => true
				)
			),

			
			// ok search
			array(
				'id' => 'track_search_with_results',
				'type' => 'checkbox',
				'label' => __( 'Track search with results?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'Search keyword will be used as Event Label', 'minerva-kb' ),
			),
			array(
				'id' => 'ga_good_search_category',
				'type' => 'input',
				'label' => __( 'Successful search: Event category', 'minerva-kb' ),
				'default' => __( 'Knowledge Base', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'track_search_with_results',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'ga_good_search_action',
				'type' => 'input',
				'label' => __( 'Successful search: Event action', 'minerva-kb' ),
				'default' => __( 'Search success', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'track_search_with_results',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'ga_good_search_value',
				'type' => 'input',
				'label' => __( 'Successful search: Event value (integer, optional)', 'minerva-kb' ),
				'default' => __( '', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'track_search_with_results',
					'type' => 'EQ',
					'value' => true
				)
			),
			// failed search
			array(
				'id' => 'track_search_without_results',
				'type' => 'checkbox',
				'label' => __( 'Track search without results?', 'minerva-kb' ),
				'default' => false,
				'description' => __( 'Search keyword will be used as Event Label', 'minerva-kb' ),
			),
			array(
				'id' => 'ga_bad_search_category',
				'type' => 'input',
				'label' => __( 'Failed search: Event category', 'minerva-kb' ),
				'default' => __( 'Knowledge Base', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'track_search_without_results',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'ga_bad_search_action',
				'type' => 'input',
				'label' => __( 'Failed search: Event action', 'minerva-kb' ),
				'default' => __( 'Search fail', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'track_search_without_results',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'ga_bad_search_value',
				'type' => 'input',
				'label' => __( 'Failed search: Event value (integer, optional)', 'minerva-kb' ),
				'default' => __( '', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'track_search_without_results',
					'type' => 'EQ',
					'value' => true
				)
			),
			
			// feedback
			array(
				'id' => 'track_article_feedback',
				'type' => 'checkbox',
				'label' => __( 'Track article feedback?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'ga_feedback_category',
				'type' => 'input',
				'label' => __( 'Feedback: Event category', 'minerva-kb' ),
				'default' => __( 'Knowledge Base', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'track_article_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'ga_feedback_action',
				'type' => 'input',
				'label' => __( 'Feedback: Event action', 'minerva-kb' ),
				'default' => __( 'Article feedback', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'track_article_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'ga_feedback_label',
				'type' => 'select',
				'label' => __( 'Feedback: Event Label', 'minerva-kb' ),
				'options' => array(
					'article_id' => __( 'Article ID', 'minerva-kb' ),
					'article_title' => __( 'Article title', 'minerva-kb' )
				),
				'default' => 'article_id',
				'dependency' => array(
					'target' => 'track_article_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),
			array(
				'id' => 'ga_feedback_value',
				'type' => 'input',
				'label' => __( 'Feedback: Event value (integer, optional)', 'minerva-kb' ),
				'default' => __( '', 'minerva-kb' ),
				'dependency' => array(
					'target' => 'track_article_feedback',
					'type' => 'EQ',
					'value' => true
				)
			),

			/**
			 * Localization
			 */
			array(
				'id' => 'localization_tab',
				'type' => 'tab',
				'label' => __( 'Localization', 'minerva-kb' ),
				'icon' => 'fa-language'
			),
			array(
				'id' => 'localization_title',
				'type' => 'title',
				'label' => __( 'Plugin localization', 'minerva-kb' ),
				'description' => __( 'Here will be general text strings used in plugin. Section specific texts are found in appropriate sections. Alternative you can use WPML or other plugin to translate KB text fields', 'minerva-kb' )
			),

			array(
				'id' => 'articles_text',
				'type' => 'input_text',
				'label' => __( 'Article plural text', 'minerva-kb' ),
				'default' => __( 'articles', 'minerva-kb' )
			),
			array(
				'id' => 'article_text',
				'type' => 'input_text',
				'label' => __( 'Article singular text', 'minerva-kb' ),
				'default' => __( 'article', 'minerva-kb' )
			),
			array(
				'id' => 'questions_text',
				'type' => 'input_text',
				'label' => __( 'Question plural text', 'minerva-kb' ),
				'default' => __( 'questions', 'minerva-kb' )
			),
			array(
				'id' => 'question_text',
				'type' => 'input_text',
				'label' => __( 'Question singular text', 'minerva-kb' ),
				'default' => __( 'question', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_labels_title',
				'type' => 'title',
				'label' => __( 'Post type labels', 'minerva-kb' ),
				'description' => __( 'Change post type labels text', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_label_name',
				'type' => 'input_text',
				'label' => __( 'Post type name', 'minerva-kb' ),
				'default' => __( 'KB Articles', 'minerva-kb' ),
			),
			array(
				'id' => 'cpt_label_singular_name',
				'type' => 'input',
				'label' => __( 'Post type singular name', 'minerva-kb' ),
				'default' => __( 'KB Article', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_label_menu_name',
				'type' => 'input',
				'label' => __( 'Post type menu name', 'minerva-kb' ),
				'default' => __( 'Knowledge Base', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_label_all_articles',
				'type' => 'input',
				'label' => __( 'Post type: All articles', 'minerva-kb' ),
				'default' => __( 'All Articles', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_label_view_item',
				'type' => 'input',
				'label' => __( 'Post type: View item', 'minerva-kb' ),
				'default' => __( 'View Article', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_label_add_new_item',
				'type' => 'input',
				'label' => __( 'Post type: Add new item', 'minerva-kb' ),
				'default' => __( 'Add New Article', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_label_add_new',
				'type' => 'input',
				'label' => __( 'Post type: Add new', 'minerva-kb' ),
				'default' => __( 'Add New Article', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_label_edit_item',
				'type' => 'input',
				'label' => __( 'Post type: Edit item', 'minerva-kb' ),
				'default' => __( 'Edit Article', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_label_update_item',
				'type' => 'input',
				'label' => __( 'Post type: Update item', 'minerva-kb' ),
				'default' => __( 'Update Article', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_label_search_items',
				'type' => 'input',
				'label' => __( 'Post type: Search items', 'minerva-kb' ),
				'default' => __( 'Search Articles', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_label_not_found',
				'type' => 'input',
				'label' => __( 'Post type: Not found', 'minerva-kb' ),
				'default' => __( 'Not Found', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_label_not_found_in_trash',
				'type' => 'input',
				'label' => __( 'Post type: Not found in trash', 'minerva-kb' ),
				'default' => __( 'Not Found In Trash', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_topic_labels_title',
				'type' => 'title',
				'label' => __( 'Post type category labels', 'minerva-kb' ),
				'description' => __( 'Change post type category labels text', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_topic_label_name',
				'type' => 'input_text',
				'label' => __( 'Post type category name', 'minerva-kb' ),
				'default' => __( 'Topics', 'minerva-kb' ),
			),
			array(
				'id' => 'cpt_topic_label_add_new',
				'type' => 'input',
				'label' => __( 'Post type category: Add new', 'minerva-kb' ),
				'default' => __( 'Add New Topic', 'minerva-kb' ),
			),
			array(
				'id' => 'cpt_topic_label_new_item_name',
				'type' => 'input',
				'label' => __( 'Post type category: New item name', 'minerva-kb' ),
				'default' => __( 'New Topic', 'minerva-kb' ),
			),
			array(
				'id' => 'cpt_tag_labels_title',
				'type' => 'title',
				'label' => __( 'Post type tag labels', 'minerva-kb' ),
				'description' => __( 'Change post type tag labels text', 'minerva-kb' )
			),
			array(
				'id' => 'cpt_tag_label_name',
				'type' => 'input',
				'label' => __( 'Post type tag name', 'minerva-kb' ),
				'default' => __( 'Tags', 'minerva-kb' ),
			),
			array(
				'id' => 'cpt_tag_label_add_new',
				'type' => 'input',
				'label' => __( 'Post type tag: Add new', 'minerva-kb' ),
				'default' => __( 'Add New Tag', 'minerva-kb' ),
			),
			array(
				'id' => 'cpt_tag_label_new_item_name',
				'type' => 'input',
				'label' => __( 'Post type tag: New item name', 'minerva-kb' ),
				'default' => __( 'New Tag', 'minerva-kb' ),
			),
			array(
				'id' => 'localization_search_title',
				'type' => 'title',
				'label' => __( 'Search labels', 'minerva-kb' )
			),
			array(
				'id' => 'search_results_text',
				'type' => 'input_text',
				'label' => __( 'Search multiple results text', 'minerva-kb' ),
				'default' => __( 'results', 'minerva-kb' )
			),
			array(
				'id' => 'search_result_text',
				'type' => 'input_text',
				'label' => __( 'Search single result text', 'minerva-kb' ),
				'default' => __( 'result', 'minerva-kb' )
			),
			array(
				'id' => 'search_no_results_text',
				'type' => 'input_text',
				'label' => __( 'Search no results text', 'minerva-kb' ),
				'default' => __( 'No results', 'minerva-kb' )
			),
			array(
				'id' => 'search_clear_icon_tooltip',
				'type' => 'input_text',
				'label' => __( 'Clear icon tooltip', 'minerva-kb' ),
				'default' => __( 'Clear search', 'minerva-kb' )
			),
			array(
				'id' => 'localization_pagination_title',
				'type' => 'title',
				'label' => __( 'Pagination labels', 'minerva-kb' )
			),
			array(
				'id' => 'pagination_prev_text',
				'type' => 'input_text',
				'label' => __( 'Previous page link text', 'minerva-kb' ),
				'default' => __( 'Previous', 'minerva-kb' )
			),
			array(
				'id' => 'pagination_next_text',
				'type' => 'input_text',
				'label' => __( 'Next page link text', 'minerva-kb' ),
				'default' => __( 'Next', 'minerva-kb' )
			),
			/**
			 * Theme compatibility
			 */
			array(
				'id' => 'compatibility_tab',
				'type' => 'tab',
				'label' => __( 'Theme options', 'minerva-kb' ),
				'icon' => 'fa-handshake-o'
			),
			array(
				'id' => 'compatibility_title',
				'type' => 'title',
				'label' => __( 'Theme compatibility tools', 'minerva-kb' ),
				'description' => __( 'MinervaKB tries to play well with most themes, but some themes need extra steps. Do not edit these settings unless you experience issues with theme templates', 'minerva-kb' )
			),
			array(
				'id' => 'font_awesome_theme_title',
				'type' => 'title',
				'label' => __( 'Font loading settings', 'minerva-kb' ),
				'description' => __( 'In case your theme loads Font Awesome, you can disable loading it from plugin', 'minerva-kb' )
			),
			array(
				'id' => 'no_font_awesome',
				'type' => 'checkbox',
				'label' => __( 'Do not load Font Awesome assets?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'compatibility_headers_title',
				'type' => 'title',
				'label' => __( 'Template headers and footers', 'minerva-kb' ),
				'description' => __( 'Most often single / category templates are used as standalone pages. But sometimes themes load them from inside other templates. In this scenario we do not need to load header and footer', 'minerva-kb' )
			),
			array(
				'id' => 'no_article_header',
				'type' => 'checkbox',
				'label' => __( 'Do not load header in article template?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'no_article_footer',
				'type' => 'checkbox',
				'label' => __( 'Do not load footer in article template?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'no_topic_header',
				'type' => 'checkbox',
				'label' => __( 'Do not load header in topic template?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'no_topic_footer',
				'type' => 'checkbox',
				'label' => __( 'Do not load footer in topic template?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'no_page_header',
				'type' => 'checkbox',
				'label' => __( 'Do not load header in page template?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'no_page_footer',
				'type' => 'checkbox',
				'label' => __( 'Do not load footer in page template?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'no_tag_header',
				'type' => 'checkbox',
				'label' => __( 'Do not load header in tag template?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'no_tag_footer',
				'type' => 'checkbox',
				'label' => __( 'Do not load footer in tag template?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'no_archive_header',
				'type' => 'checkbox',
				'label' => __( 'Do not load header in archive template?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'no_archive_footer',
				'type' => 'checkbox',
				'label' => __( 'Do not load footer in archive template?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'no_search_header',
				'type' => 'checkbox',
				'label' => __( 'Do not load header in search results template?', 'minerva-kb' ),
				'default' => false
			),
			array(
				'id' => 'no_search_footer',
				'type' => 'checkbox',
				'label' => __( 'Do not load footer in search results template?', 'minerva-kb' ),
				'default' => false
			),
			/**
			 * Demo import
			 */
			array(
				'id' => 'demo_import_tab',
				'type' => 'tab',
				'label' => __( 'Demo import', 'minerva-kb' ),
				'icon' => 'fa-cloud-download'
			),
			array(
				'id' => 'demo_import',
				'type' => 'demo_import',
				'label' => __( 'One-click Demo Import', 'minerva-kb' ),
				'default' => '',
				'description' => __( 'You can import dummy articles, topics and pages for quick testing. Press Skip if you don\'t want this tab to open by default (you will still be able to use import later)', 'minerva-kb' ),
			),
		);
	}

	
	public static function get_topics_options() {
		$saved = self::get_saved_values();
		$category = isset($saved['article_cpt_category']) ?
			$saved['article_cpt_category'] :
			'topic'; // TODO: use separate defaults

		$options = array(
			array(
				'key' => 'recent',
				'label' => __('Recent', 'minerva-kb')
			),
			array(
				'key' => 'top_views',
				'label' => __('Most viewed', 'minerva-kb')
			),
			array(
				'key' => 'top_likes',
				'label' => __('Most liked', 'minerva-kb')
			)
		);

		$topics = get_terms( $category, array(
			'hide_empty' => false,
		) );

		if (isset($topics) && !is_wp_error($topics) && !empty($topics)) {
			foreach ( $topics as $item ):
				array_push($options, array(
					'key' => $item->term_id,
					'label' => $item->name,
				));
			endforeach;
		}

		return $options;
	}
	
	public static function get_faq_categories_options() {
		$options = array();

		$categories = get_terms( 'faq_category', array(
			'hide_empty' => false,
		) );

		if (isset($categories) && !is_wp_error($categories) && !empty($categories)) {
			foreach ( $categories as $item ):
				array_push($options, array(
					'key' => $item->term_id,
					'label' => $item->name,
				));
			endforeach;
		}

		return $options;
	}

	public static function get_search_topics_options() {
		$saved = self::get_saved_values();
		$category = isset($saved['article_cpt_category']) ?
			$saved['article_cpt_category'] :
			'topic'; // TODO: use separate defaults

		$options = array();

		$topics = get_terms( $category, array(
			'hide_empty' => false,
		) );

		if (isset($topics) && !is_wp_error($topics) && !empty($topics)) {
			foreach ( $topics as $item ):
				array_push($options, array(
					'key' => $item->term_id,
					'label' => $item->name,
				));
			endforeach;
		}

		return $options;
	}

	/**
	 * To be used inside options method
	 * @param $key
	 */
	protected static function get_saved_option($key, $default = null) {
		$saved = self::get_saved_values();
		return isset($saved[$key]) ? $saved[$key] : $default;
	}

	/**
	 * @return array
	 */
	public static function get_home_sections_options() {
		$saved = self::get_saved_values();
		$faq_disable = isset($saved['disable_faq']) ? $saved['disable_faq'] : false;

		$options = array(
			array(
				'key' => 'search',
				'label' => __('Search', 'minerva-kb')
			),
			array(
				'key' => 'topics',
				'label' => __('Topics', 'minerva-kb')
			)
		);

		if (!$faq_disable) {
			array_push($options, array(
				'key' => 'faq',
				'label' => __('FAQ', 'minerva-kb')
			));
		}

		return $options;
	}

	public static function get_non_ui_options($options) {
		return array_filter($options, function($option) {
			return $option['type'] !== 'tab' &&
			       $option['type'] !== 'title' &&
			       $option['type'] !== 'description' &&
			       $option['type'] !== 'code' &&
			       $option['type'] !== 'info' &&
			       $option['type'] !== 'warning';
		});
	}

	public static function save($options) {
		self::add_wpml_string_options($options);
		update_option(self::OPTION_KEY, json_encode($options));

		global $minerva_kb;

		$minerva_kb->restrict->invalidate_restriction_cache();
	}

	/**
	 * Registers options that require translations
	 * @param $options
	 */
	private function add_wpml_string_options($options) {

		if (!function_exists ( 'icl_register_string' )) { return; }

		$all_options = self::get_options_by_id();

		foreach($options as $id => $value) {
			if (!isset($all_options[$id]) ||
			    ($all_options[$id]['type'] !== 'input_text' && $all_options[$id]['type'] !== 'textarea_text')) {
				continue;
			}

			icl_register_string(self::WPML_DOMAIN, $all_options[$id]['label'], $value);
		}
	}

	/**
	 * Translates saved values
	 * @param $options
	 *
	 * @return mixed
	 */
	private static function translate_values($options) {

		if (!function_exists( 'icl_register_string' )) {
			return $options;
		}

		$all_options = self::get_options_by_id();

		foreach($options as $id => $value) {
			if (!isset($all_options[$id]) ||
			    ($all_options[$id]['type'] !== 'input_text' && $all_options[$id]['type'] !== 'textarea_text')) {
				continue;
			}

			$options[$id] = apply_filters('wpml_translate_single_string', $value, self::WPML_DOMAIN, $all_options[$id]['label']);
		}

		return $options;
	}

	public static function save_option($key, $value) {
		$all_options = self::get();
		$all_options[$key] = $value;
		self::save($all_options);
	}

	public static function reset() {
		update_option(self::OPTION_KEY, json_encode(self::get_options_defaults()));
	}

	public static function get() {
		global $minerva_kb_options_cache;

		if (!$minerva_kb_options_cache) {
			$minerva_kb_options_cache = self::translate_values(
				wp_parse_args(self::get_saved_values(), self::get_options_defaults())
			);
		}

		return $minerva_kb_options_cache;
	}

	public static function get_saved_values() {
		$options = json_decode(get_option(self::OPTION_KEY), true);

		$options = !empty($options) ? $options : array();

		return self::normalize_values(stripslashes_deep($options));
	}

	public static function normalize_values($settings) {
		return array_map(function($value) {
			if ($value === 'true') {
				return true;
			} else if ($value === 'false') {
				return false;
			} else {
				return $value;
			}
		}, $settings);
	}

	public static function option($key) {
		$all_options = self::get();

		return isset($all_options[$key]) ? $all_options[$key] : null;
	}

	/**
	 * Detects if flush rules was called for current set of CPT slugs
	 * @return bool
	 */
	public static function need_to_flush_rules() {
		$flushed_cpt = get_option('_mkb_flushed_rewrite_cpt');
		$flushed_topic = get_option('_mkb_flushed_rewrite_topic');
		$flushed_tag = get_option('_mkb_flushed_rewrite_tag');

		$cpt_slug = self::option('cpt_slug_switch') ? self::option('article_slug') : self::option('article_cpt');
		$cpt_category_slug = self::option('cpt_category_slug_switch') ? self::option('category_slug') : self::option('article_cpt_category');
		$cpt_tag_slug = self::option('cpt_tag_slug_switch') ? self::option('tag_slug') : self::option('article_cpt_tag');

		return $cpt_slug != $flushed_cpt ||
		       $cpt_category_slug != $flushed_topic ||
		       $cpt_tag_slug != $flushed_tag;
	}

	/**
	 * Sets flush flags not to flush on every load
	 */
	public static function update_flush_flags() {
		$cpt_slug = self::option('cpt_slug_switch') ? self::option('article_slug') : self::option('article_cpt');
		$cpt_category_slug = self::option('cpt_category_slug_switch') ? self::option('category_slug') : self::option('article_cpt_category');
		$cpt_tag_slug = self::option('cpt_tag_slug_switch') ? self::option('tag_slug') : self::option('article_cpt_tag');

		update_option('_mkb_flushed_rewrite_cpt', $cpt_slug);
		update_option('_mkb_flushed_rewrite_topic', $cpt_category_slug);
		update_option('_mkb_flushed_rewrite_tag', $cpt_tag_slug);
	}

	/**
	 * Removes flags on uninstall
	 */
	public static function remove_flush_flags() {
		delete_option('_mkb_flushed_rewrite_cpt');
		delete_option('_mkb_flushed_rewrite_topic');
		delete_option('_mkb_flushed_rewrite_tag');
	}

	/**
	 * Removes all plugin data from options table
	 */
	public static function remove_data() {
		delete_option(self::OPTION_KEY);
	}
}

global $minerva_kb_options;

$minerva_kb_options = new MKB_Options();
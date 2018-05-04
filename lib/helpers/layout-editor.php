<?php
/**
 * Project: MinervaKB.
 * Copyright: 2015-2016 @KonstruktStudio
 */

class MKB_LayoutEditor {

	private $settings_builder = null;

	public function __construct($settings_builder) {
		$this->settings_builder = $settings_builder;
	}

	public function render() {
		global $post;

		$sections = array();

		if ($post) {
			$sections = get_post_meta($post->ID, '_mkb_page_sections', true);

			if (isset($sections) && !empty($sections)) {
				$sections = array_map(function($str) {
					return json_decode($str, true);
				}, $sections);
			}
		}

		?>
		<div class="mkb-layout-editor__sections">
			<?php if ( isset( $sections ) && ! empty( $sections ) ): ?>
				<?php foreach ( $sections as $index => $section ):
					if (empty($section)) {
						continue;
					}

					?>
					<div class="mkb-layout-editor__section fn-layout-editor-section"
					     data-type="<?php echo esc_attr($section["type"]); ?>">
						<div class="fn-section-inner">
							<?php $this->put_section_html( $section["type"], $index, $section["settings"] ); ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="mkb-layout-editor__actions">
				<span href="#" class="mkb-layout-editor__add-new fn-layout-editor-add mkb-action-button mkb-action-default"
				   title="<?php esc_attr_e('Save Settings', 'minerva-kb'); ?>">
					<i class="fa fa-plus"></i>
					<?php echo __( 'Add section', 'minerva-kb' ); ?>
					<ul class="mkb-layout-editor__add-new-list">
						<li>
							<a href="#" class="mkb-layout-editor__add-new-list-item fn-layout-editor-add-section" data-type="search">
								<?php esc_html_e('Search', 'minerva-kb'); ?>
							</a>
						</li>
						<li>
							<a href="#" class="mkb-layout-editor__add-new-list-item fn-layout-editor-add-section" data-type="topics">
								<?php esc_html_e('Topics', 'minerva-kb'); ?>
							</a>
						</li>
						<li>
							<a href="#" class="mkb-layout-editor__add-new-list-item fn-layout-editor-add-section" data-type="page-content">
								<?php esc_html_e('Page content', 'minerva-kb'); ?>
							</a>
						</li>
						<?php if (!MKB_Options::option('disable_faq')): ?>
						<li>
							<a href="#" class="mkb-layout-editor__add-new-list-item fn-layout-editor-add-section" data-type="faq">
								<?php esc_html_e('FAQ', 'minerva-kb'); ?>
							</a>
						</li>
						<?php endif; ?>
					</ul>
				</span>
			</div>
		</div>
	<?php
	}

	public function put_section_html($type, $index, $values = array()) {
		$types_options = $this->get_section_options();
		$section_config = $types_options[$type];
		$section_settings = isset($section_config["settings"]) ? $section_config["settings"] : array();
		$default_value = array(
			"type" => $type,
			"settings" => array()
		)

		?>
		<div class="mkb-layout-editor__section-handle fn-layout-editor-section-handle"></div>
		<div class="mkb-layout-editor__section-toolbar">
			<a class="mkb-layout-editor__section-settings-open fn-section-settings-toggle mkb-unstyled-link" href="#">
				<i class="fa fa-cogs"></i>
			</a>
			<a class="mkb-layout-editor__section-remove fn-section-remove mkb-unstyled-link" href="#">
				<i class="fa fa-close"></i>
			</a>
		</div>
		<div class="mkb-layout-editor__section-title"><?php echo esc_html($section_config["title"]); ?></div>
		<div class="mkb-section-settings-container fn-settings-block fn-section-settings-container mkb-hidden">
			<input type="hidden" name="mkb_page_section[<?php echo esc_attr($index); ?>]"
			       class="fn-section-settings-store fn-settings-block-store"
			       data-type="<?php echo esc_attr($type); ?>"
			       value="<?php echo esc_attr(json_encode($default_value)); ?>" />
			<?php
			if ( ! empty( $section_settings ) ):
				foreach ( $section_settings as $option ):
					$id_postfix = uniqid( '_' );
					$value = isset($option["default"]) ? $option["default"] : '';

					if ( isset( $values[ $option["id"] ] ) ) {
						$value = $values[ $option["id"] ];
					}

					$this->settings_builder->render_option(
						$option["type"],
						$value,
						wp_parse_args( $option, array(
							'id_postfix' => $id_postfix
						) )
					);
				endforeach;
			else:
				?>
				<div><?php echo esc_html( __( 'This section currently has no options', 'minerva-kb' ) ); ?></div>
			<?php
			endif; ?>
		</div>
		<?php
	}

	public function get_section_html($type, $index) {
		ob_start();
		$this->put_section_html($type, $index);
		$html = ob_get_clean();

		return $html;
	}

	public static function get_section_options() {
		return array(
			
			/**
			 * Page content
			 */
			'page-content' => array(
				'id' => 'page-content',
				'title' => __( 'Page content', 'minerva-kb' ),
			),
			/**
			 * FAQ
			 */
			'faq' => array(
				'id' => 'faq',
				'title' => __( 'FAQ', 'minerva-kb' ),
				'settings' => array(
					array(
						'id' => 'home_faq_title',
						'type' => 'input',
						'label' => __( 'FAQ title', 'minerva-kb' ),
						'default' => __( 'Frequently Asked Questions', 'minerva-kb' )
					),
					array(
						'id' => 'home_faq_title_size',
						'type' => 'css_size',
						'label' => __( 'FAQ title font size', 'minerva-kb' ),
						'default' => array("unit" => 'em', "size" => "3"),
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
						'label' => __( 'NOTE: You can configure FAQ styles in Settings - FAQ (global)', 'minerva-kb' )
					),
				)
			),
		);
	}
}
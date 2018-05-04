<?php
/**
 * Project: Minerva KB
 * Copyright: 2015-2016 @KonstruktStudio
 */

require_once(MINERVA_KB_PLUGIN_DIR . 'lib/helpers/table-of-contents.php');

class MKB_TemplateHelper {
	public function __construct() {
	}

	/**
	 * Determines the parent term for current term
	 * @param $term
	 * @param $taxonomy
	 *
	 * @return array|false|WP_Term
	 */
	private static function get_root_term($term, $taxonomy) {

		if (!$term) {
			return $term;
		}

		if ($term->parent != '0') { // child
			$ancestors = get_ancestors( $term->term_id, $taxonomy, 'taxonomy' );

			if (!empty($ancestors)) {
				return get_term_by( 'id', $ancestors[sizeof($ancestors) - 1], $taxonomy );
			}
		}

		return $term;
	}

	/**
	 * Gets KB home page for given term
	 * @param $term
	 * @param $taxonomy
	 *
	 * @return false|string
	 */
	public static function get_home_page_link($term, $taxonomy) {
		$root_term = self::get_root_term($term, $taxonomy);

		return get_the_permalink(self::get_topic_home_page($root_term));
	}

	/**
	 * Determines if there's a custom KB home page set for term
	 * @param $term
	 *
	 * @return null
	 */
	public static function get_topic_home_page($term) {
		// handle custom breadcrumbs link
		if (MKB_Options::option( 'breadcrumbs_custom_home_switch' ) && MKB_Options::option( 'breadcrumbs_custom_home_page' )) {
			return MKB_Options::option( 'breadcrumbs_custom_home_page' );
		}

		$home_page_id = MKB_Options::option( 'kb_page' );

		if (!$term) {
			return $home_page_id;
		}

		$id = $term->term_id;
		$term_meta = get_option('taxonomy_' . MKB_Options::option( 'article_cpt_category' ) . '_' . $id);

		if ($term_meta && isset($term_meta['topic_parent']) && $term_meta['topic_parent'] != "") {
			$home_page_id = $term_meta['topic_parent'];
		}

		return $home_page_id;
	}

	/**
	 * Renders breadcrumbs
	 * @param $term
	 * @param $taxonomy
	 * @param bool $is_single
	 */
	public static function breadcrumbs( $term, $taxonomy, $type = false ) {

		$icon = MKB_Options::option('breadcrumbs_separator_icon');

		$home_label = MKB_Options::option('breadcrumbs_home_label') ?
			MKB_Options::option('breadcrumbs_home_label') :
			__( 'KB Home', 'minerva-kb' );

		$breadcrumbs = array(
			array(
				'name' => $home_label,
				'link' => self::get_home_page_link($term, $taxonomy),
				'icon' => $icon
			)
		);

		$ancestors = null;

		if ($term) {
			$ancestors = get_ancestors( $term->term_id, $taxonomy, 'taxonomy' );
		}

		if ( ! empty( $ancestors ) ) {
			$breadcrumbs = array_merge( $breadcrumbs,
				array_reverse(
					array_map( function ( $id ) use ( $taxonomy, $icon ) {
						$parent = get_term_by( 'id', $id, $taxonomy );

						return array(
							'name' => $parent->name,
							'link' => get_term_link( $parent ),
							'icon' => $icon
						);
					}, $ancestors )
				)
			);
		}

		if ($type === 'single'):
			if ($term) {
				array_push( $breadcrumbs, array(
					'name' => $term->name,
					'link' => get_term_link( $term ),
					'icon' => $icon
				) );
			}

			array_push($breadcrumbs, array(
				'name' => get_the_title()
			));
		else:
			if ($term) {
				array_push( $breadcrumbs, array(
					'name' => $term->name,
				) );
			}
		endif;

		?>
		<div class="mkb-breadcrumbs">
			<div class="mkb-breadcrumbs__gradient"></div>
			<div class="mkb-breadcrumbs__pattern"></div>
			<span
				class="mkb-breadcrumbs__label">
				<?php echo esc_html( MKB_Options::option( 'breadcrumbs_label' ) ); ?>
			</span>
			<ul class="mkb-breadcrumbs__list">
				<?php
				foreach ( $breadcrumbs as $crumb ):
					?>
					<li>
						<?php if (array_key_exists( "link", $crumb ) && ! empty( $crumb["link"] )): ?>
						<a href="<?php echo esc_attr( $crumb["link"] ); ?>">
							<?php endif; ?>
							<?php echo esc_html( $crumb["name"] ); ?>
							<?php if (array_key_exists( "link", $crumb ) && ! empty( $crumb["link"] )): ?>
						</a>
					<?php endif; ?>
						<?php if (array_key_exists( "icon", $crumb )): ?>
					<i class="mkb-breadcrumbs-icon fa <?php echo esc_attr($crumb["icon"]); ?>"></i>
					<?php endif; ?>
					</li>
				<?php
				endforeach;
				?>
			</ul>
		</div>
	<?php
	}

	/**
	 * Search page breadcrumbs
	 * @param $needle
	 */
	public static function search_breadcrumbs( $needle ) {

		$icon = MKB_Options::option('breadcrumbs_separator_icon');

		$home_label = MKB_Options::option('breadcrumbs_home_label') ?
			MKB_Options::option('breadcrumbs_home_label') :
			__( 'KB Home', 'minerva-kb' );

		$home_page = MKB_Options::option( 'kb_page' );

		// handle custom breadcrumbs link
		if (MKB_Options::option( 'breadcrumbs_custom_home_switch' ) && MKB_Options::option( 'breadcrumbs_custom_home_page' )) {
			$home_page = MKB_Options::option( 'breadcrumbs_custom_home_page' );
		}

		$breadcrumbs = array(
			array(
				'name' => $home_label,
				'link' => get_the_permalink($home_page),
				'icon' => $icon
			),
			array(
				'name' => sprintf(MKB_Options::option( 'search_results_breadcrumbs_label' ), $needle)
			)
		);

		?>
		<div class="mkb-breadcrumbs">
			<div class="mkb-breadcrumbs__gradient"></div>
			<div class="mkb-breadcrumbs__pattern"></div>
			<span
				class="mkb-breadcrumbs__label">
				<?php echo esc_html( MKB_Options::option( 'breadcrumbs_label' ) ); ?>
			</span>
			<ul class="mkb-breadcrumbs__list">
				<?php
				foreach ( $breadcrumbs as $crumb ):
					?>
					<li>
						<?php if (isset($crumb["link"]) && ! empty($crumb["link"]) ): ?>
							<a href="<?php echo esc_attr( $crumb["link"] ); ?>">
						<?php endif; ?>
						<?php echo esc_html( $crumb["name"] ); ?>
						<?php if ( isset($crumb["link"]) && ! empty($crumb["link"]) ): ?>
							</a>
						<?php endif; ?>
						<?php if (isset( $crumb["icon"])): ?>
							<i class="mkb-breadcrumbs-icon fa <?php echo esc_attr($crumb["icon"]); ?>"></i>
						<?php endif; ?>
					</li>
				<?php
				endforeach;
				?>
			</ul>
		</div>
	<?php
	}

	/**
	 * Content class for use in templates
	 * @param string $type
	 * @return string
	 */
	public static function root_class($type = 'page') {
		$classes = array('mkb-root', 'mkb-clearfix');

		if (MKB_Options::option( $type . '_sidebar' ) !== 'none') {
			array_push($classes, 'mkb-sidebar-' . MKB_Options::option( $type . '_sidebar' ));
		}

		if ($type == 'page') {
			if ((!MKB_PageOptions::is_builder_page() && MKB_Options::option('home_page_container_switch')) || MKB_PageOptions::option('add_container')) {
				array_push($classes, 'mkb-container');
			}
		} else { // any other type, just add container
			array_push($classes, 'mkb-container');
		}

		return join(' ', $classes);
	}

	/**
	 * Content class for use in templates
	 * @param string $type
	 * @return string
	 */
	public static function content_class($type = 'page') {
		$classes = array('mkb-content-main');

		array_push($classes, 'mkb-content-main--' . $type);

		if (MKB_Options::option( $type . '_sidebar' ) !== 'none') {
			array_push($classes, 'mkb-content-main--has-sidebar');
		}

		return join(' ', $classes);
	}

	/**
	 * Left sidebar
	 * @param string $type
	 */
	public static function maybe_render_left_sidebar($type = 'page') {
		global $minerva_kb;

		if (MKB_Options::option( $type . '_sidebar' ) === 'left' && $minerva_kb->info->is_desktop()) {
			self::render_sidebar($type);
		}
	}

	/**
	 * Right sidebar
	 * @param string $type
	 */
	public static function maybe_render_right_sidebar($type = 'page') {
		global $minerva_kb;

		if (MKB_Options::option( $type . '_sidebar' ) === 'right' ||
		    (!$minerva_kb->info->is_desktop() && MKB_Options::option( $type . '_sidebar' ) === 'left')) {
			self::render_sidebar($type);
		}
	}

	

	/**
	 * FAQ
	 */
	public static function render_faq($settings = array()) {

		if (MKB_Options::option('disable_faq')) {
			return;
		}

		// parse global options
		$args = wp_parse_args(
			$settings,
			array(
				'show_faq_filter_icon' => MKB_Options::option('show_faq_filter_icon'),
				'faq_filter_icon' => MKB_Options::option('faq_filter_icon'),
				'faq_filter_theme' => MKB_Options::option('faq_filter_theme'),
				'faq_filter_placeholder' => MKB_Options::option('faq_filter_placeholder'),
				'faq_filter_clear_icon' => MKB_Options::option('faq_filter_clear_icon'),
				'faq_no_results_text' => MKB_Options::option('faq_no_results_text'),
				'show_faq_toggle_all_icon' => MKB_Options::option('show_faq_toggle_all_icon'),
				'faq_toggle_all_icon' => MKB_Options::option('faq_toggle_all_icon'),
				'faq_toggle_all_icon_open' => MKB_Options::option('faq_toggle_all_icon_open'),
				'faq_toggle_all_open_text' => MKB_Options::option('faq_toggle_all_open_text'),
				'faq_toggle_all_close_text' => MKB_Options::option('faq_toggle_all_close_text'),
			)
		);

		$categories = array();

		if ($args['home_faq_categories']) {
			$ids = explode(',', $args['home_faq_categories']);

			foreach ($ids as $id) {
				array_push($categories, get_term_by('id', (int)$id, 'faq_category'));
			}
		} else {
			$categories = get_terms( 'faq_category', array(
				'hide_empty' => true
			) );
		}

		$faq_style = '';

		$faq_style .= 'margin-top: ' . MKB_SettingsBuilder::css_size_to_string($args['home_faq_margin_top']) . ';';
		$faq_style .= 'margin-bottom: ' . MKB_SettingsBuilder::css_size_to_string($args['home_faq_margin_bottom']) . ';';

		if ($args['home_faq_limit_width_switch']) {
			$faq_style .= 'width: ' . MKB_SettingsBuilder::css_size_to_string($args['home_faq_width_limit']) . ';';
		}

		$controls_style = 'margin-top: ' .
		                  MKB_SettingsBuilder::css_size_to_string($args['home_faq_controls_margin_top']) . ';' .
						  'margin-bottom: ' .
		                  MKB_SettingsBuilder::css_size_to_string($args['home_faq_controls_margin_bottom']) . ';';

		?><div class="mkb-home-faq kb-faq fn-kb-faq-container mkb-container" style="<?php echo esc_attr($faq_style); ?>"><?php

		if ($args['home_faq_title']) :
			$title_style = 'color: ' . $args['home_faq_title_color'] . ';font-size: ' .
			               MKB_SettingsBuilder::css_size_to_string($args['home_faq_title_size']) . ';';
			?>
			<div class="mkb-section-title">
				<h3 style="<?php echo esc_attr($title_style); ?>"><?php echo esc_html($args['home_faq_title']); ?></h3>
			</div>
		<?php
		endif;

		?><div class="kb-faq__controls mkb-clearfix" style="<?php echo esc_attr($controls_style); ?>">
			<?php if($args['home_show_faq_filter']):?>
				<div class="kb-faq__filter kb-faq__filter--empty kb-faq__filter--<?php echo esc_attr($args['faq_filter_theme']); ?>-theme fn-kb-faq-filter">
					<form class="kb-faq__filter-form" action="" novalidate>
						<input type="text" class="fn-kb-faq-filter-input kb-faq__filter-input" placeholder="<?php echo esc_attr($args['faq_filter_placeholder']); ?>" />
						<a href="#" class="fn-kb-faq-filter-clear kb-faq__filter-clear">
							<i class="fa <?php echo esc_attr($args['faq_filter_clear_icon']); ?>"></i>
						</a>
						<?php if ($args['show_faq_filter_icon']): ?>
						<span class="kb-faq__filter-icon">
							<i class="fa <?php echo esc_attr($args['faq_filter_icon']); ?>"></i>
						</span>
						<?php endif; ?>
					</form>
				</div>
			<?php endif; ?>
			<?php if ($args['home_show_faq_toggle_all']): ?>
				<div class="kb-faq__toggle-all">
					<a href="#" class="kb-faq__toggle-all-link fn-kb-faq-toggle-all">
						<span class="kb-faq__toggle-all-label">
							<?php if($args['show_faq_toggle_all_icon']): ?>
							<i class="kb-faq__toggle-all-icon fa <?php echo esc_attr($args['faq_toggle_all_icon']); ?>"></i>
							<?php endif; ?>
							<span class="kb-faq__toggle-all-text">
								<?php echo esc_html($args['faq_toggle_all_open_text']); ?>
							</span>
						</span>
						<span class="kb-faq__toggle-all-label-open">
							<?php if($args['show_faq_toggle_all_icon']): ?>
							<i class="kb-faq__toggle-all-icon fa <?php echo esc_attr($args['faq_toggle_all_icon_open']); ?>"></i>
							<?php endif; ?>
							<span class="kb-faq__toggle-all-text">
								<?php echo esc_html($args['faq_toggle_all_close_text']); ?>
							</span>
						</span>
					</a>
				</div>
			<?php endif; ?>
			</div>
		<?php
			// categories loop
			if ( sizeof( $categories ) ):
				foreach ( $categories as $category ):
					self::render_faq_category($category, $args);
				endforeach; // end of terms loop
			endif; // end of topics loop
			?>
			<div class="fn-kb-faq-no-results mkb-hidden kb-faq__no-results">
				<?php echo esc_html($args['faq_no_results_text']); ?>
			</div>
		</div><?php
	}

	public static function render_faq_category($term, $settings = array()) {

		if (MKB_Options::option('disable_faq')) {
			return;
		}

		if (!$term) {
			return;
		}

		$args = wp_parse_args(
			$settings,
			array(
				'home_show_faq_categories' => MKB_Options::option('home_show_faq_categories'),
				'home_show_faq_category_count' => MKB_Options::option('home_show_faq_category_count'),
				'faq_question_shadow' => MKB_Options::option('faq_question_shadow'),
				'show_faq_question_icon' => MKB_Options::option('show_faq_question_icon'),
				'faq_question_icon' => MKB_Options::option('faq_question_icon'),
				'faq_question_icon_open_action' => MKB_Options::option('faq_question_icon_open_action'),
				'faq_question_open_icon' => MKB_Options::option('faq_question_open_icon'),
			)
		);

		$query_args = array(
			'post_type' => 'faq',
			'posts_per_page' => -1,
			'ignore_sticky_posts' => 1,
			'tax_query' => array(
				array(
					'taxonomy' => 'faq_category',
					'field'    => 'slug',
					'terms'    => $term->slug
				),
			)
		);

		$loop = new WP_Query( $query_args );

		?>
		<div class="kb-faq__category fn-kb-faq-section">
			<div class="kb-faq__category-inner">
				<?php if($args['home_show_faq_categories']): ?>
				<div class="kb-faq__category-title fn-kb-faq-category-title" data-slug="<?php echo esc_attr($term->slug); ?>">
					<?php echo esc_html( self::get_term_name($term) ); ?>
					<?php if($args['home_show_faq_category_count']): ?>
					<span class="kb-faq__count fn-kb-faq-section-count">
						<?php echo esc_html($loop->post_count); ?> <?php echo esc_html($loop->post_count == 1 ?
							MKB_Options::option( 'question_text' ) :
							MKB_Options::option( 'questions_text' )); ?>
					</span>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<div class="kb-faq__questions">
					<ul class="kb-faq__questions-list<?php if($args['faq_question_shadow']) {
						echo esc_attr(' kb-faq__questions-list--with-shadow');
					} ?>">
						<?php
						if ( $loop->have_posts() ) :
							while ( $loop->have_posts() ) : $loop->the_post();
								?>
								<li class="kb-faq__questions-list-item kb-faq__questions-list-item--<?php
									echo esc_attr($args['faq_question_icon_open_action']); ?> fn-kb-faq-item">
									<a class="fn-kb-faq-link" href="#">
										<span class="kb-faq__question-title fn-kb-faq-question">
											<?php if ($args['show_faq_question_icon']): ?>
												<i class="kb-faq__question-toggle-icon fa <?php
													echo esc_attr($args['faq_question_icon']); ?>"></i>
											<?php endif; ?>
											<?php if ($args['faq_question_icon_open_action'] === 'change'): ?>
												<i class="kb-faq__question-toggle-icon-open fa <?php
													echo esc_attr($args['faq_question_open_icon']); ?>"></i>
											<?php endif; ?>
											<?php echo esc_html(get_the_title()); ?>
										</span>
									</a>
									<div class="kb-faq__answer fn-kb-faq-answer">
										<div class="kb-faq__answer-content"><?php the_content(); ?></div>
									</div>
								</li>
							<?php endwhile;
						endif;
						?>
					</ul>
				</div>
			</div>
		</div>
	<?php
		wp_reset_postdata();
	}

	

	/**
	 * Search template
	 * @param array $settings
	 */
	public static function render_search($settings = array()) {
		/**
		 * Do not render search if globally restricted
		 */
		global $minerva_kb;

		if (MKB_Options::option('restrict_on') && MKB_Options::option('restrict_remove_search_for_restricted') && $minerva_kb->restrict->is_user_globally_restricted()) {
			return false;
		}

		$args = wp_parse_args(
			$settings,
			array(
				"search_title" => MKB_Options::option( 'search_title' ),
				"search_title_color" => MKB_Options::option( 'search_title_color' ),
				"search_title_size" => MKB_Options::option( 'search_title_size' ),
				"search_theme" => MKB_Options::option( 'search_theme' ),
				"search_border_color" => MKB_Options::option( 'search_border_color' ),
				"search_min_width" => MKB_Options::option( 'search_min_width' ),
				"search_container_padding_top" => MKB_Options::option( 'search_container_padding_top' ),
				"search_container_padding_bottom" => MKB_Options::option( 'search_container_padding_bottom' ),
				"search_placeholder" => MKB_Options::option( 'search_placeholder' ),
				"search_topics" => MKB_Options::option( 'search_topics' ),
				"search_tip_color" => MKB_Options::option( 'search_tip_color' ),
				"add_pattern_overlay" => MKB_Options::option( 'add_pattern_overlay' ),
				"search_container_image_pattern" => MKB_Options::option( 'search_container_image_pattern' ),
				"search_container_image_pattern_opacity" => MKB_Options::option( 'search_container_image_pattern_opacity' ),
				"add_gradient_overlay" => MKB_Options::option( 'add_gradient_overlay' ),
				"search_container_gradient_from" => MKB_Options::option( 'search_container_gradient_from' ),
				"search_container_gradient_to" => MKB_Options::option( 'search_container_gradient_to' ),
				"search_container_gradient_opacity" => MKB_Options::option( 'search_container_gradient_opacity' ),
				"search_icons_left" => MKB_Options::option( 'search_icons_left' ),
				"show_search_icon" => MKB_Options::option( 'show_search_icon' ),
				"search_icon" => MKB_Options::option( 'search_icon' ),
				"search_clear_icon" => MKB_Options::option( 'search_clear_icon' ),
				"search_clear_icon_tooltip" => MKB_Options::option( 'search_clear_icon_tooltip' ),
				"show_search_tip" => MKB_Options::option( 'show_search_tip' ),
				"disable_autofocus" => MKB_Options::option( 'disable_autofocus' ),
				"search_tip" => MKB_Options::option( 'search_tip' ),
				"search_request_icon" => MKB_Options::option( 'search_request_icon' ),
				"search_container_bg" => MKB_Options::option( 'search_container_bg' ),
				"search_container_image_bg" => MKB_Options::option( 'search_container_image_bg' ),
				"show_topic_in_results" => MKB_Options::option( 'show_topic_in_results' ),
				"search_result_topic_label" => MKB_Options::option( 'search_result_topic_label' ),
				"search_results_topic_bg" => MKB_Options::option( 'search_results_topic_bg' ),
				"search_results_topic_color" => MKB_Options::option( 'search_results_topic_color' ),
				"search_results_multiline" => MKB_Options::option( 'search_results_multiline' )
			)
		);

		$container_style = 'background-color: ' . $args['search_container_bg'] . ';';

		if (isset($args['search_container_padding_top']) && $args['search_container_padding_top']) {
			$container_style .= 'padding-top: ' . $args['search_container_padding_top'] . ';';
		}

		if (isset($args['search_container_padding_bottom']) && $args['search_container_padding_bottom']) {
			$container_style .= 'padding-bottom: ' . $args['search_container_padding_bottom'] . ';';
		}

		if (isset($args['search_container_image_bg']) && $args['search_container_image_bg']) {
			$container_style .= 'background: url(' . MKB_SettingsBuilder::media_url($args['search_container_image_bg']) . ') center center / cover;';
		}

		/**
		 * Gradient
		 */
		$gradient_style = '';

		if (isset($args["search_container_gradient_from"]) && $args["search_container_gradient_to"]) {
			$gradient_style = 'background: linear-gradient(45deg, ' .
			                  $args["search_container_gradient_from"] . ' 0%, ' .
			                  $args["search_container_gradient_to"] . ' 100%);';
		}

		if (isset($args["add_gradient_overlay"]) && $args["add_gradient_overlay"]) {
			if (isset($args["search_container_gradient_from"]) && $args["search_container_gradient_to"]) {
				$gradient_style = 'background: linear-gradient(45deg, ' .
				                  $args["search_container_gradient_from"] . ' 0%, ' .
				                  $args["search_container_gradient_to"] . ' 100%);';
			}

			if (isset($args["search_container_gradient_opacity"]) && $args["search_container_gradient_opacity"]) {
				$gradient_style .= 'opacity: ' . $args["search_container_gradient_opacity"] . ';';
			}
		} else {
			$gradient_style = 'display: none;';
		}

		/**
		 * Pattern
		 */
		$pattern_style = '';

		if (isset($args['search_container_image_pattern']) && $args['search_container_image_pattern']) {
			$pattern_style .= 'background-image: url(' . MKB_SettingsBuilder::media_url($args['search_container_image_pattern']) . ');';

			if (isset($args["search_container_image_pattern_opacity"]) && $args["search_container_image_pattern_opacity"]) {
				$pattern_style .= 'opacity: ' . $args["search_container_image_pattern_opacity"] . ';';
			}
		}

		$title_style = '';

		if (isset($args["search_title"]) && $args["search_title"]) {
			$title_style = 'font-size: ' . $args["search_title_size"] . ';color: ' . $args["search_title_color"] . ';';
		}

		$tip_style = '';

		if (isset($args["search_tip_color"]) && $args["search_tip_color"]) {
			$tip_style = 'color: ' . $args["search_tip_color"];
		}

		$input_wrap_extra_class = 'mkb-search-theme__' . $args['search_theme'];

		if (isset($args['search_icons_left']) && $args['search_icons_left']) {
			$input_wrap_extra_class .= ' kb-search__input-wrap--icons-left';
		}

		if (isset($args['search_results_multiline']) && $args['search_results_multiline']) {
			$input_wrap_extra_class .= ' kb-search__input-wrap--multiline-results';
		}

		$search_border_style = '';

		if (isset($args['search_border_color']) && $args['search_border_color']) {
			$search_border_style .= 'border-color: ' . $args['search_border_color'] . ';background-color: ' . $args['search_border_color'] . ';';
		}

		$input_wrap_style = '';

		if (isset($args['search_min_width']) && $args['search_min_width']) {
			$input_wrap_style = 'width: ' . $args['search_min_width'] . ';';
		}

		// Custom section CSS (shortcodes/API calls)
		$has_custom_styles = isset($settings['search_results_topic_bg']) || isset($settings['search_results_topic_color']);
		$css_id = '';

		if ($has_custom_styles) {
			$css_id = uniqid('mkb-uuid-');
		}

		?><div class="kb-header<?php
		if ($has_custom_styles) {
			?> <?php echo esc_attr($css_id); ?><?php
		}?>" style="<?php echo esc_attr($container_style); ?>"><?php

		// start of custom styles
		if ($has_custom_styles) {
		?><style><?php

			if (isset($settings['search_results_topic_bg'])) {
			?>.<?php echo esc_attr( $css_id ); ?> .kb-search .kb-search__result-topic { background: <?php echo esc_attr( $settings['search_results_topic_bg'] ); ?>; }<?php
			}

			if (isset($settings['search_results_topic_color'])) {
			?>.<?php echo esc_attr( $css_id ); ?> .kb-search .kb-search__result-topic { color: <?php echo esc_attr( $settings['search_results_topic_color'] ); ?>; }<?php
			}

		?></style><?php
		}
		// end of custom styles

		    if (isset($args["add_gradient_overlay"]) && $args["add_gradient_overlay"]): ?>
				<div class="kb-search-gradient" style="<?php echo esc_attr($gradient_style); ?>"></div>
			<?php endif; ?>
			<?php if (isset($args["add_pattern_overlay"]) && $args["add_pattern_overlay"]): ?>
				<div class="kb-search-pattern" style="<?php echo esc_attr($pattern_style); ?>"></div>
			<?php endif; ?>
			<div class="kb-search">
				<?php if (isset($args["search_title"]) && $args["search_title"]): ?>
				<div class="kb-search__title" style="<?php echo esc_attr($title_style); ?>">
					<?php echo esc_html($args["search_title"]); ?>
				</div>
				<?php endif; ?>
				<form class="kb-search__form" action="<?php echo site_url('/'); ?>" method="get" autocomplete="off" novalidate>
					<div class="kb-search__input-wrap <?php echo esc_attr($input_wrap_extra_class); ?>"
					     style="<?php echo esc_attr($search_border_style . $input_wrap_style); ?>">
						<input type="hidden" name="source" value="kb" />
						<?php if (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE !== 'all'): ?>
							<input type="hidden" name="lang" value="<?php echo esc_attr(ICL_LANGUAGE_CODE); ?>" />
						<?php endif; ?>
						<input class="kb-search__input"
						       name="s"
						       placeholder="<?php echo esc_attr( $args['search_placeholder'] ); ?>"
						       type="text"
						       data-show-results-topic="<?php echo esc_attr($args['show_topic_in_results']); ?>"
						       data-topic-label="<?php echo esc_attr($args['search_result_topic_label']); ?>"
						       data-autofocus="<?php echo esc_attr($args['disable_autofocus'] ? '0' : '1'); ?>"
						       data-topic-ids="<?php echo esc_attr($args['search_topics']); ?>"
							/>
						<span class="kb-search__results-summary">
							<i class="kb-search-request-indicator fa <?php echo esc_attr( $args['search_request_icon'] ); ?> fa-spin fa-fw"></i>
							<span class="kb-summary-text-holder"></span>
						</span>
						<?php if ( $args['show_search_icon'] ): ?>
							<span class="kb-search__icon-holder">
								<i class="kb-search__icon fa <?php echo esc_attr( $args['search_icon'] ); ?>"></i>
							</span>
						<?php endif; ?>
						<a href="#" class="kb-search__clear" title="<?php echo esc_attr($args['search_clear_icon_tooltip']); ?>">
							<i class="kb-search__clear-icon fa <?php echo esc_attr( $args['search_clear_icon'] ); ?>"></i>
						</a>

						<div class="kb-search__results<?php if ($args['show_topic_in_results'] == 1) {
							echo esc_attr(' kb-search__results--with-topics');
						}?>"></div>
					</div>
					<?php if($args['show_search_tip']): ?>
					<div class="kb-search__tip" style="<?php echo esc_attr($tip_style); ?>">
						<?php echo wp_kses_post( $args['search_tip'] ); ?>
					</div>
					<?php endif; ?>
				</form>
			</div>
		</div>
		<?php
	}

	
	/**
	 * Default WP pagination
	 */
	public static function theme_pagination() {
		the_posts_pagination( array(
			'prev_text' => MKB_Options::option('pagination_prev_text'),
			'next_text' => MKB_Options::option('pagination_next_text'),
		) );
	}

	/**
	 * Custom pagination
	 */
	public static function minerva_pagination() {

		// make sure we're not in single
		if (is_singular()) {
			return;
		}

		global $wp_query;

		$max = (int) $wp_query->max_num_pages;

		// make sure we have pages
		if ($max <= 1) {
			return;
		}

		$paged = get_query_var('paged') ? (int) get_query_var('paged') : 1;

		// Add current page to the array
		if ($paged >= 1) {
			$links[] = $paged;
		}

		// Add the pages around the current page to the array
		if ($paged >= 3) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if ($paged + 2 <= $max) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		?><div class="mkb-pagination"><ul><?php

		//	Previous Post Link
		if ( get_previous_posts_link() ) {
			printf('<li>%s</li>', get_previous_posts_link(MKB_Options::option('pagination_prev_text')));
		}

		//	Link to first page, plus ellipses if necessary
		if (!in_array(1, $links)) {
			if (1 == $paged) {
				?><li class="active"><span>1</span></li><?php
			} else {
				printf(
					'<li><a href="%s">%s</a></li>',
					esc_url(get_pagenum_link(1)),
					'1'
				);
			}

			if (!in_array(2, $links)) {
				?><li>…</li><?php
			}
		}

		sort($links);

		foreach ((array)$links as $link) {
			if ($paged == $link) {
				?><li class="active"><span><?php echo esc_html($link); ?></span></li><?php
			} else {
				printf(
					'<li><a href="%s">%s</a></li>',
					esc_url(get_pagenum_link($link)),
					$link
				);
			}
		}

		//	Link to last page, plus ellipses if necessary
		if (!in_array($max, $links)) {
			if (!in_array($max-1, $links)) {
				?><li>…</li><?php
			}

			if ($paged == $max) {
				?><li class="active"><span><?php echo esc_html($max); ?></span></li><?php
			} else {
				printf(
					'<li><a href="%s">%s</a></li>',
					esc_url(get_pagenum_link($max)),
					$max
				);
			}
		}

		//	Next Post Link
		if (get_next_posts_link()) {
			printf(
				'<li>%s</li>',
				get_next_posts_link(MKB_Options::option('pagination_next_text'))
			);
		}

		?></ul></div><?php
	}

	/**
	 * Pagination for search results page
	 */
	public static function pagination () {
		if (MKB_Options::option('pagination_style') === 'plugin') {
			self::minerva_pagination();
		} else {
			self::theme_pagination();
		}
	}

	/**
	 * Article table of contents
	 */
	public static function table_of_contents() {
		$toc = new MinervaKB_TableOfContents();
		$toc->render();
	}

	protected function hextorgb($hex, $alpha = false) {
		$hex = str_replace( '#', '', $hex );

		if ( strlen( $hex ) == 6 ) {
			$rgb['r'] = hexdec( substr( $hex, 0, 2 ) );
			$rgb['g'] = hexdec( substr( $hex, 2, 2 ) );
			$rgb['b'] = hexdec( substr( $hex, 4, 2 ) );
		} else if ( strlen( $hex ) == 3 ) {
			$rgb['r'] = hexdec( str_repeat( substr( $hex, 0, 1 ), 2 ) );
			$rgb['g'] = hexdec( str_repeat( substr( $hex, 1, 1 ), 2 ) );
			$rgb['b'] = hexdec( str_repeat( substr( $hex, 2, 1 ), 2 ) );
		} else {
			$rgb['r'] = '0';
			$rgb['g'] = '0';
			$rgb['b'] = '0';
		}
		if ( $alpha ) {
			$rgb['a'] = $alpha;
		}

		return $rgb;
	}
}
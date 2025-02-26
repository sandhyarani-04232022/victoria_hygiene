<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Counter {

	private static $_instance = null;

	private $cc_repeater_contents;
	private $cc_content_position;
	private $cc_layout;
	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {

		// Options
			$options_group = array( 'default' );
			$options['default'] = array(
				'icon'          => esc_html__( 'Icon', 'wdt-elementor-addon'),
				'title'         => esc_html__( 'Title', 'wdt-elementor-addon'),
				'sub_title'     => esc_html__( 'Sub Title', 'wdt-elementor-addon'),
				'description'   => esc_html__( 'Description', 'wdt-elementor-addon'),
				'link'          => esc_html__( 'Link', 'wdt-elementor-addon'),
				'button'        => esc_html__( 'Button', 'wdt-elementor-addon'),
				'custom'      => array (
					'title' => esc_html__( 'Pricing', 'wdt-elementor-addon'),
					'control_action' => 'wdt_widgets_custom_counter_control',
					'render_filter' => 'wdt_widgets_custom_counter_html_render',
				)
			);

		// Group 1 content positions
			$group1_content_position_elements = array(
				'icon'          => esc_html__( 'Icon', 'wdt-elementor-addon'),
				'title_sub_title' => esc_html__( 'Title and Sub Title', 'wdt-elementor-addon'),
				'separator_1'     => esc_html__( 'Separator 1', 'wdt-elementor-addon'),
				'button'          => esc_html__( 'Button', 'wdt-elementor-addon'),
				'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon')
			);
			$group1_content_positions = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);

		// Group 1 - Element Group content positions
			$group1_element_group_content_position_elements = array(
				'title'           => esc_html__( 'Title', 'wdt-elementor-addon'),
				'separator_1'     => esc_html__( 'Separator 1', 'wdt-elementor-addon'),
				'sub_title'       => esc_html__( 'Sub Title', 'wdt-elementor-addon')
			);
			$group1_element_group_content_positions = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);


		// Group 2 content positions
			$group2_content_position_elements = array(
				'title_sub_title' => esc_html__( 'Title and Sub Title', 'wdt-elementor-addon'),
				'description'     => esc_html__( 'Description', 'wdt-elementor-addon'),
				'button'          => esc_html__( 'Button', 'wdt-elementor-addon'),
				'elements_group'  => esc_html__( 'Elements Group', 'wdt-elementor-addon'),
				'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon')
			);
			$group2_content_positions = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);

		// Group 2 - Element Group content positions
			$group2_element_group_content_position_elements = array(
				'separator_2'     => esc_html__( 'Separator 2', 'wdt-elementor-addon'),
				'button'          => esc_html__( 'Button', 'wdt-elementor-addon')
			);
			$group2_element_group_content_positions = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);


		// Content position elements
			$content_position_elements = array_merge($group1_content_position_elements, $group1_element_group_content_position_elements, $group2_content_position_elements, $group2_element_group_content_position_elements);

		// Module defaults
			$option_defaults = array(
				array(
					'item_type' => 'default',
					'media_icon' => array (
						'value' => 'far fa-paper-plane',
						'library' => 'fa-regular'
					),
					'item_title' => esc_html__( 'Ut accumsan mass', 'wdt-elementor-addon' ),
					'item_sub_title' => esc_html__( 'Accumsan mass', 'wdt-elementor-addon' ),
					'item_description' => esc_html__( 'Donec sit amet turpis tincidunt eros, nam porttitor massa leo porta maecenas reque.', 'wdt-elementor-addon' ),
					'item_link'    => array (
						'url' => '#',
						'is_external' => true,
						'nofollow' => true,
						'custom_attributes' => ''
					),
					'item_button_text' => esc_html__( 'Click Here', 'wdt-elementor-addon' )
				),
				array(
					'item_type' => 'default',
					'media_icon' => array (
						'value' => 'far fa-paper-plane',
						'library' => 'fa-regular'
					),
					'item_title' => esc_html__( 'Pellentesque ornare', 'wdt-elementor-addon' ),
					'item_sub_title' => esc_html__( 'Tesque ornare', 'wdt-elementor-addon' ),
					'item_description' => esc_html__( 'Donec sit amet turpis tincidunt eros, nam porttitor massa leo porta maecenas reque.', 'wdt-elementor-addon' ),
					'item_link'    => array (
						'url' => '#',
						'is_external' => true,
						'nofollow' => true,
						'custom_attributes' => ''
					),
					'item_button_text' => esc_html__( 'Click Here', 'wdt-elementor-addon' )
				)
			);

		// Module Details
			$module_details = array(
				'content_positions'    => array ( 'group1', 'group1_element_group', 'group2', 'group2_element_group', 'title_subtitle_position'),
				'group1_title'         => esc_html__( 'Media Group', 'wdt-elementor-addon'),
				'group2_title'         => esc_html__( 'Content Group', 'wdt-elementor-addon'),
				'group_cp_label'       => esc_html__( 'Content Positions', 'wdt-elementor-addon'),
				'group_eg_cp_label'    => esc_html__( 'Element Group - Content Positions', 'wdt-elementor-addon'),
				'jsSlug'               => 'wdtRepeaterCounterContent',
				'title'                => esc_html__( 'Counter Items', 'wdt-elementor-addon' ),
				'icon_default_library' => array (
					'value'               => 'far fa-paper-plane',
					'library'             => 'fa-regular'
				),
				'description'          => ''
			);

		// Initialize depandant class
			$this->cc_repeater_contents = new WeDesignTech_Common_Controls_Repeater_Contents($options_group, $options, $option_defaults, $module_details);
			$this->cc_content_position = new WeDesignTech_Common_Controls_Content_Position($content_position_elements, $group1_content_positions, $group1_element_group_content_positions, $group2_content_positions, $group2_element_group_content_positions, $module_details);
			$this->cc_layout = new WeDesignTech_Common_Controls_Layout('both');
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

		// Actions
			add_action('wdt_widgets_custom_counter_control', array ( $this, 'wdt_widgets_custom_counter_control_register' ), 10, 1);
			add_filter('wdt_widgets_custom_counter_html_render', array ( $this, 'wdt_widgets_custom_counter_html_render_register' ), 10, 7);


	}

	public function name() {
		return 'wdt-counter';
	}

	public function title() {
		return esc_html__( 'Counter', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'eicon-apps';
	}

	public function init_styles() {
		return array_merge(
			$this->cc_layout->init_styles(),
			$this->cc_repeater_contents->init_styles(),
			array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/counter/assets/css/style.css'
			)
		);
	}

	public function init_inline_styles() {
		if(!\Elementor\Plugin::$instance->preview->is_preview_mode()) {
			return array (
				$this->name() => $this->cc_layout->get_column_css()
			);
		}
		return array ();
	}

	public function init_scripts() {
		return array_merge(
			$this->cc_layout->init_scripts(),
			array (
				'jquery-countTo' => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/widgets/counter/assets/js/jquery.countTo.js',
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/widgets/counter/assets/js/script.js'
			)
		);
	}

	public function create_elementor_controls($elementor_object) {

		$this->cc_repeater_contents->get_controls($elementor_object);
		$this->cc_layout->get_controls($elementor_object);

		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Settings', 'wdt-elementor-addon'),
		));

			$elementor_object->add_control( 'template', array(
				'label'   => esc_html__( 'Template', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'default' => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default', 'wdt-elementor-addon' ),
					'icon-aside-content' => esc_html__( 'Icon Aside Content', 'wdt-elementor-addon' ),
					'icon-aside-counter' => esc_html__( 'Icon Aside Counter', 'wdt-elementor-addon' ),
					'icon-back-counter' => esc_html__( 'Icon Back Counter', 'wdt-elementor-addon' ),
					'icon-pop-in-counter' => esc_html__( 'Icon Pop-in Counter', 'wdt-elementor-addon' ),
					'classic' => esc_html__( 'Classic', 'wdt-elementor-addon' ),
					'minimal' => esc_html__( 'Minimal', 'wdt-elementor-addon' ),
					'modern' => esc_html__( 'Modern', 'wdt-elementor-addon' ),
					'standard' => esc_html__( 'Standard', 'wdt-elementor-addon' ),
					'custom-template' => esc_html__( 'Custom Template', 'wdt-elementor-addon' )
				)
			) );

		$elementor_object->end_controls_section();

		$this->cc_content_position->get_controls($elementor_object, array ( 'template' => 'custom-template' ));

		// Item
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'item',
			'title' => esc_html__( 'Item', 'wdt-elementor-addon' ),
			'styles' => array (
				'alignment' => array (
					'field_type' => 'alignment',
                    'control_type' => 'responsive',
                    'default' => 'center',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item, {{WRAPPER}} .wdt-content-item .wdt-content-title h5, {{WRAPPER}} .wdt-content-item .wdt-content-title h5 > a, {{WRAPPER}} .wdt-content-item .wdt-content-subtitle, {{WRAPPER}} .wdt-content-item .wdt-social-icons-list li a, {{WRAPPER}} .wdt-content-item .wdt-rating li span, {{WRAPPER}} .wdt-content-item ul li, {{WRAPPER}} .wdt-content-item span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover, {{WRAPPER}} .wdt-content-item:hover .wdt-content-title h5, {{WRAPPER}} .wdt-content-item:hover .wdt-content-title h5 > a, {{WRAPPER}} .wdt-content-item:hover .wdt-content-subtitle, {{WRAPPER}} .wdt-content-item:hover .wdt-social-icons-list li a, {{WRAPPER}} .wdt-content-item:hover .wdt-rating li span, {{WRAPPER}} .wdt-content-item:hover ul li, {{WRAPPER}} .wdt-content-item:hover span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Title
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'title',
			'title' => esc_html__( 'Title', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-title h5',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-title-group, {{WRAPPER}} .wdt-content-item div:not(.wdt-content-title-group) .wdt-content-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-title h5, {{WRAPPER}} .wdt-content-item .wdt-content-title h5 > a' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-title h5, {{WRAPPER}} .wdt-content-item:hover .wdt-content-title h5 > a:hover, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group:hover .wdt-content-title h5 > a:hover, .wdt-content-item:hover .wdt-content-elements-group.wdt-media-image-cover > .wdt-media-image-cover-container > div h5 > a:hover, .wdt-content-item:hover .wdt-content-elements-group.wdt-media-image-overlay > .wdt-media-image-overlay-container > div h5 > a:hover' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						)
					)
				)
			)
		));

		// Sub Title
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'sub_title',
			'title' => esc_html__( 'Sub Title', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-subtitle',
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-subtitle' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-subtitle' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						)
					)
				)
			)
		));

		// Icon
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'icon',
			'title' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
			'styles' => array (
				'font_size' => array (
					'field_type' => 'font_size',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span' => 'font-size: {{SIZE}}{{UNIT}};'
                    ),
					'condition' => array ()
				),
				'width' => array (
					'field_type' => 'width',
					'default' => array (
						'unit' => 'px'
					),
					'size_units' => array ( 'px' ),
					'range' => array (
                        'px' => array (
                            'min' => 10,
                            'max' => 500,
                        )
                    ),
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span' => 'width: {{SIZE}}{{UNIT}};'
					)
				),
				'height' => array (
					'field_type' => 'height',
					'default' => array (
						'unit' => 'px'
					),
					'size_units' => array ( 'px' ),
					'range' => array (
                        'px' => array (
                            'min' => 10,
                            'max' => 500,
                        )
                    ),
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span' => 'height: {{SIZE}}{{UNIT}};',

						'{{WRAPPER}} .wdt-rc-template-default .wdt-content-item .wdt-content-media-group .wdt-content-image-wrapper + .wdt-content-icon-wrapper,
						{{WRAPPER}} .wdt-rc-template-ico-boxed-overlap .wdt-content-item .wdt-content-detail-group .wdt-content-group .wdt-content-icon-wrapper,
						{{WRAPPER}} .wdt-rc-template-ico-stage-over .wdt-content-item .wdt-content-media-group .wdt-media-group .wdt-content-icon-wrapper,
						{{WRAPPER}} .wdt-rc-template-ico-side-overlap .wdt-content-item .wdt-content-media-group .wdt-content-icon-wrapper' => 'font-size: {{SIZE}}{{UNIT}};',

						'{{WRAPPER}} .wdt-rc-template-ico-boxed-overlap .wdt-content-item' => 'margin-top: calc({{SIZE}}{{UNIT}} / 2);',

						'{{WRAPPER}} .wdt-rc-template-ico-side-overlap .wdt-content-item' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2);',

						'{{WRAPPER}} .wdt-rc-template-ico-side-overlap .wdt-content-item .wdt-content-media-group .wdt-content-icon-wrapper' => 'margin-left: calc({{SIZE}}{{UNIT}} / -2);'
					)
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs_default' => array (
					'field_type' => 'tabs',
					'unique_key' => 'default',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}}  .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-icon-wrapper .wdt-content-icon span',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-icon-wrapper .wdt-content-icon span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-icon-wrapper .wdt-content-icon span',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-icon-wrapper .wdt-content-icon span',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-icon-wrapper .wdt-content-icon span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-icon-wrapper .wdt-content-icon span',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Counter
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'counter',
			'title' => esc_html__( 'Counter', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter',
					'condition' => array ()
				),
				'width' => array (
					'field_type' => 'width',
					'default' => array (
						'unit' => 'px'
					),
					'size_units' => array ( 'px' ),
					'range' => array (
                        'px' => array (
                            'min' => 10,
                            'max' => 500,
                        )
                    ),
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter' => 'width: {{SIZE}}{{UNIT}};'
					)
				),
				'height' => array (
					'field_type' => 'height',
					'default' => array (
						'unit' => 'px'
					),
					'size_units' => array ( 'px' ),
					'range' => array (
                        'px' => array (
                            'min' => 10,
                            'max' => 500,
                        )
                    ),
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter' => 'height: {{SIZE}}{{UNIT}};'
					)
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs_default' => array (
					'field_type' => 'tabs',
					'unique_key' => 'default',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter',
									'color_selector' => array (
										'{{WRAPPER}} .wdt-counter-holder.wdt-rc-template-minimal .wdt-content-item .wdt-media-group:before, {{WRAPPER}} .wdt-counter-holder.wdt-rc-template-standard .wdt-content-item .wdt-media-group:before' => 'color: {{VALUE}};',
                                        '{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter',
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-counter-wrapper .wdt-content-counter',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-counter-wrapper .wdt-content-counter' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-counter-wrapper .wdt-content-counter',
									'color_selector' => array (
										'{{WRAPPER}} .wdt-counter-holder.wdt-rc-template-minimal .wdt-content-item:hover .wdt-media-group:before, {{WRAPPER}} .wdt-counter-holder.wdt-rc-template-standard .wdt-content-item:hover .wdt-media-group:before' => 'color: {{VALUE}};',
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-counter-wrapper .wdt-content-counter' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-counter-wrapper .wdt-content-counter',
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-counter-wrapper .wdt-content-counter',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Description
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'description',
			'title' => esc_html__( 'Description', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-description',
					'condition' => array ()
				),
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-description' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-description' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-description',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-description',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-description',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-description' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-description',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-description',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-description',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Button
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'button',
			'title' => esc_html__( 'Button', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-button > a',
					'condition' => array ()
				),
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-button' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-button > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-button > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-button > a' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-button > a',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-button > a',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-button > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-button > a',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-button > a:focus, {{WRAPPER}} .wdt-content-item:hover .wdt-content-button > a:hover' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-button > a:focus, {{WRAPPER}} .wdt-content-item:hover .wdt-content-button > a:hover',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-button > a:focus, {{WRAPPER}} .wdt-content-item:hover .wdt-content-button > a:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-button > a:focus, {{WRAPPER}} .wdt-content-item:hover .wdt-content-button > a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-button > a:focus, {{WRAPPER}} .wdt-content-item:hover .wdt-content-button > a:hover',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

        // Separator
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'separator',
			'title' => esc_html__( 'Separator', 'wdt-elementor-addon' ),
			'styles' => array (
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-separator.separator-1 span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
                'width' => array (
					'field_type' => 'width',
					'default' => array (
						'unit' => '%'
					),
					'size_units' => array ( '%', 'px' ),
					'range' => array (
                        '%' => array (
                            'min' => 0,
                            'max' => 100,
                        ),
                        'px' => array (
                            'min' => 10,
                            'max' => 500,
                        )
                    ),
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-separator.separator-1 span' => 'width: {{SIZE}}{{UNIT}};'
					)
				),
				'height' => array (
					'field_type' => 'height',
					'default' => array (
						'unit' => 'px'
					),
					'size_units' => array ( '%', 'px' ),
					'range' => array (
                        '%' => array (
                            'min' => 0,
                            'max' => 100,
                        ),
                        'px' => array (
                            'min' => 10,
                            'max' => 500,
                        )
                    ),
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-separator.separator-1 span' => 'height: {{SIZE}}{{UNIT}};'
					)
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
                                'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-separator.separator-1 span',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
                                'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-separator.separator-1 span',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Elements Group - Media
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'group1_elementsgroup',
			'title' => esc_html__( 'Elements Group - Media', 'wdt-elementor-addon' ),
			'styles' => array (
				'media_image_type' => array (
					'field_type' => 'media_image_type',
					'options' => array(
						'default' => esc_html__( 'Default', 'wdt-elementor-addon' ),
						'cover' => esc_html__( 'Cover', 'wdt-elementor-addon' ),
						'overlay' => esc_html__( 'Overlay', 'wdt-elementor-addon' ),
                    ),
					'condition' => array (
						'template' => array ('default', 'custom-template')
					)
				),
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-image-cover > .wdt-media-image-cover-container, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-image-overlay > .wdt-media-image-overlay-container' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
                'vertical_align_image_eg' => array (
                    'field_type' => 'vertical_align',
                    'unique_key' => 'image_eg',
                    'label' => esc_html__( 'Vertical Position', 'wdt-elementor-addon' ),
                    'options' => array (
                        'flex-start' => array (
                            'title' => esc_html__( 'Top', 'wdt-elementor-addon' ),
                            'icon' => 'eicon-v-align-top',
                        ),
                        'flex-end' => array (
                            'title' => esc_html__( 'Bottom', 'wdt-elementor-addon' ),
                            'icon' => 'eicon-v-align-bottom',
                        )
                    ),
                    'default' => 'middle',
                    'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-media-image-overlay > .wdt-content-image-wrapper, {{WRAPPER}} .wdt-content-item .wdt-media-image-overlay > .wdt-media-image-overlay-container, {{WRAPPER}} .wdt-content-item .wdt-media-image-cover > .wdt-content-image-wrapper, {{WRAPPER}} .wdt-content-item .wdt-media-image-cover > .wdt-media-image-cover-container' => 'align-content: {{VALUE}};',
                    ),
                    'condition' => array (
						'media_image_type' => array ('cover', 'overlay')
					)
                ),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group .wdt-content-title h5, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group .wdt-content-title h5 > a, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group .wdt-content-subtitle, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-group .wdt-social-icons-list li a, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group .wdt-rating li span, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group ul li, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group:not(.wdt-media-image-cover):not(.wdt-media-image-overlay), {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-image-cover .wdt-content-image-wrapper:before, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-image-overlay .wdt-content-image-wrapper:before, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-image-cover .wdt-content-image-wrapper:after, .wdt-rc-template-minimal .wdt-content-item .wdt-content-media-group .wdt-content-elements-group.wdt-media-group:before, .wdt-rc-template-ico-minimal .wdt-content-item .wdt-content-media-group .wdt-content-elements-group.wdt-media-group:before',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group, .wdt-rc-template-minimal .wdt-content-item .wdt-content-media-group .wdt-content-elements-group.wdt-media-group:before, .wdt-rc-template-ico-minimal .wdt-content-item .wdt-content-media-group .wdt-content-elements-group.wdt-media-group:before',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-media-group, .wdt-rc-template-minimal .wdt-content-item .wdt-content-media-group .wdt-content-elements-group.wdt-media-group:before, .wdt-rc-template-ico-minimal .wdt-content-item .wdt-content-media-group .wdt-content-elements-group.wdt-media-group:before',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-group, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-group .wdt-content-title h5, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-group .wdt-content-title h5 > a, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-group .wdt-content-subtitle, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-group .wdt-social-icons-list li a:hover, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-group .wdt-rating li span, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-group ul li, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-group span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-group:not(.wdt-media-image-cover):not(.wdt-media-image-overlay), {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-image-cover .wdt-content-image-wrapper:before, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-image-overlay .wdt-content-image-wrapper:before, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-image-cover .wdt-content-image-wrapper:after, .wdt-rc-template-minimal .wdt-content-item .wdt-content-media-group .wdt-content-elements-group.wdt-media-group:after, .wdt-rc-template-ico-minimal .wdt-content-item .wdt-content-media-group .wdt-content-elements-group.wdt-media-group:after',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-group, .wdt-rc-template-minimal .wdt-content-item .wdt-content-media-group .wdt-content-elements-group.wdt-media-group:after, .wdt-rc-template-ico-minimal .wdt-content-item .wdt-content-media-group .wdt-content-elements-group.wdt-media-group:after',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-group' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-media-group, .wdt-rc-template-minimal .wdt-content-item .wdt-content-media-group .wdt-content-elements-group.wdt-media-group:after, .wdt-rc-template-ico-minimal .wdt-content-item .wdt-content-media-group .wdt-content-elements-group.wdt-media-group:after',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Elements Group - Content
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'group2_elementsgroup',
			'title' => esc_html__( 'Elements Group - Content', 'wdt-elementor-addon' ),
			'styles' => array (
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group .wdt-content-title h5, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group .wdt-content-title h5 > a, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group .wdt-content-subtitle, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group .wdt-social-icons-list li a, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group .wdt-rating li span, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group ul li, {{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item .wdt-content-elements-group.wdt-content-group',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-content-group, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-content-group .wdt-content-title h5, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-content-group .wdt-content-title h5 > a, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-content-group .wdt-content-subtitle, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-content-group .wdt-social-icons-list li a, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-content-group .wdt-rating li span, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-content-group ul li, {{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-content-group span' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-content-group',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-content-group',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-content-group' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-content-item:hover .wdt-content-elements-group.wdt-content-group',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Arrow
		$this->cc_layout->get_carousel_style_controls($elementor_object, array ('layout' => 'carousel'));

	}

	public function wdt_widgets_custom_counter_control_register($elementor_object) {

		$elementor_object->add_control(
			'counter_heading',
			array (
				'label' => esc_html__( 'Numbers', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before'
			)
		);

		$elementor_object->add_control(
			'start_digit',
			 array(
				'label'   => esc_html__( 'Start Digit', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'default' => 0
			)
		);

		$elementor_object->add_control(
			'end_digit',
			 array(
				'label' => esc_html__( 'End Digit', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'default' => 100
			)
		);

		$elementor_object->add_control(
			'speed',
			 array(
				'label' => esc_html__( 'Speed', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'default' => 1000
			)
		);

		$elementor_object->add_control(
			'refresh_interval',
			 array(
				'label' => esc_html__( 'Refresh Interval', 'wdt-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'default' => 100,
				'description' => esc_html__('How often the element should be updated', 'wdt-elementor-addon')
			)
		);

		$elementor_object->add_control(
			'prefix',
			array(
				'type'      => \Elementor\Controls_Manager::TEXT,
				'label'     => esc_html__('Prefix', 'wdt-elementor-addon')
			)
		);

		$elementor_object->add_control(
			'suffix',
			array(
				'type'      => \Elementor\Controls_Manager::TEXT,
				'label'     => esc_html__('Suffix', 'wdt-elementor-addon')
			)
		);

	}

	public function wdt_widgets_custom_counter_html_render_register($output, $widget_object, $key, $item, $link_start, $link_end, $settings) {
		$output .= '<div class="wdt-content-counter-wrapper">';
			$output .= '<div class="wdt-content-counter">';
				if($item['prefix'] != '') {
					$output .= '<span class="wdt-content-counter-prefix">'.esc_attr($item['prefix']).'</span>';
				}
				$output .= '<span class="wdt-content-counter-number" data-from="'.esc_attr($item['start_digit']).'" data-to="'.esc_attr($item['end_digit']).'" data-speed="'.esc_attr($item['speed']).'" data-refresh-interval="'.esc_attr($item['refresh_interval']).'"></span>';
				if($item['suffix'] != '') {
					$output .= '<span class="wdt-content-counter-suffix">'.esc_attr($item['suffix']).'</span>';
				}
			$output .= '</div>';
		$output .= '</div>';
		return $output;
	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		if( count( $settings['item_contents'] ) > 0 ):

			$classes = array ();
			array_push($classes, 'wdt-rc-template-'.$settings['template']);

			$settings['module_id'] = $widget_object->get_id();
			$settings['module_class'] = 'counter';
			$settings['classes'] = $classes;
			$this->cc_layout->set_settings($settings);
			$settings['module_layout_class'] = $this->cc_layout->get_item_class();

			$output .= $this->cc_layout->get_wrapper_start();
				if($settings['template'] == 'custom-template') {
					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);
				} else if($settings['template'] == 'default') {

					$group1_content_position_elements = array(
						'icon'  => esc_html__( 'Icon', 'wdt-elementor-addon')
					);
					$group1_element_group_content_position_elements = array();
					$group2_content_position_elements = array(
						'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon'),
						'title' 		  => esc_html__( 'Title', 'wdt-elementor-addon'),
						'separator_1'     => esc_html__( 'Separator 1', 'wdt-elementor-addon'),
					);
					$group2_element_group_content_position_elements = array();

					$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
					$settings['group1_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);
					$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);
					$settings['group2_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

				} else if($settings['template'] == 'icon-aside-content') {

					$group1_content_position_elements = array(
						'icon'  		  => esc_html__( 'Icon', 'wdt-elementor-addon'),
					);
					$group1_element_group_content_position_elements = array();
					$group2_content_position_elements = array(
						'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon'),
						'title' => esc_html__( 'Title', 'wdt-elementor-addon'),
						'separator_1'     => esc_html__( 'Separator 1', 'wdt-elementor-addon'),
						'description'     => esc_html__( 'Description', 'wdt-elementor-addon'),
					);
					$group2_element_group_content_position_elements = array();

					$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
					$settings['group1_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);
					$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);
					$settings['group2_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

				} else if($settings['template'] == 'icon-aside-counter') {

					$group1_content_position_elements = array(
					);
					$group1_element_group_content_position_elements = array();
					$group2_content_position_elements = array(
						'elements_group'  => esc_html__( 'Elements Group', 'wdt-elementor-addon'),
						'title' 		  => esc_html__( 'Title & Sub Title', 'wdt-elementor-addon'),
						'separator_1'     => esc_html__( 'Separator 1', 'wdt-elementor-addon'),
						'description'     => esc_html__( 'Description', 'wdt-elementor-addon')
					);
					$group2_element_group_content_position_elements = array(
						'icon'  		  => esc_html__( 'Icon', 'wdt-elementor-addon'),
						'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon')
					);

					$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
					$settings['group1_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);
					$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);
					$settings['group2_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

				} else if($settings['template'] == 'icon-back-counter') {

					$group1_content_position_elements = array(
						'elements_group'  => esc_html__( 'Elements Group', 'wdt-elementor-addon')
					);
					$group1_element_group_content_position_elements = array(
						'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon'),
						'icon'  		  => esc_html__( 'Icon', 'wdt-elementor-addon')
					);
					$group2_content_position_elements = array(
						'title' 		  => esc_html__( 'Title', 'wdt-elementor-addon'),
						'separator_1'     => esc_html__( 'Separator 1', 'wdt-elementor-addon'),
						'sub_title' 	  => esc_html__( 'Sub Title', 'wdt-elementor-addon'),
						'description'     => esc_html__( 'Description', 'wdt-elementor-addon')
					);
					$group2_element_group_content_position_elements = array();

					$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
					$settings['group1_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);
					$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);
					$settings['group2_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

				} else if($settings['template'] == 'icon-pop-in-counter') {

					$group1_content_position_elements = array(
						'elements_group'  => esc_html__( 'Elements Group', 'wdt-elementor-addon')
					);
					$group1_element_group_content_position_elements = array(
						'icon'  		  => esc_html__( 'Icon', 'wdt-elementor-addon'),
						'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon')
					);
					$group2_content_position_elements = array(
						'title' 		  => esc_html__( 'Title', 'wdt-elementor-addon'),
						'separator_1'     => esc_html__( 'Separator 1', 'wdt-elementor-addon'),
						'sub_title' 	  => esc_html__( 'Sub Title', 'wdt-elementor-addon')
					);
					$group2_element_group_content_position_elements = array();

					$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
					$settings['group1_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);
					$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);
					$settings['group2_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

				} else if($settings['template'] == 'minimal') {

					$group1_content_position_elements = array(
						'elements_group'  	=> esc_html__( 'Elements Group', 'wdt-elementor-addon')
					);
					$group1_element_group_content_position_elements = array(
						'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon')
					);
					$group2_content_position_elements = array(
						'separator_1'     => esc_html__( 'Separator 1', 'wdt-elementor-addon'),
						'title' 		  => esc_html__( 'Title', 'wdt-elementor-addon'),
						'description'  => esc_html__( 'Description', 'wdt-elementor-addon')
					);
					$group2_element_group_content_position_elements = array();

					$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
					$settings['group1_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);
					$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);
					$settings['group2_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

				} else if($settings['template'] == 'classic') {
					$group1_content_position_elements = array(
						'elements_group'  => esc_html__( 'Elements Group', 'wdt-elementor-addon')
					);
					$group1_element_group_content_position_elements = array(
						'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon')
					);
					$group2_content_position_elements = array(
						'title' 		  => esc_html__( 'Title', 'wdt-elementor-addon'),
						'separator_1'     => esc_html__( 'Separator 1', 'wdt-elementor-addon'),
						'sub_title' 	  => esc_html__( 'Sub Title', 'wdt-elementor-addon'),
						'description'     => esc_html__( 'Description', 'wdt-elementor-addon')
					);

					$group2_element_group_content_position_elements = array();

					$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
					$settings['group1_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);
					$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);
					$settings['group2_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

				} else if($settings['template'] == 'modern') {

					$group1_content_position_elements = array(
						'elements_group'  => esc_html__( 'Elements Group', 'wdt-elementor-addon')
					);
					$group1_element_group_content_position_elements = array(
						'icon'  		  => esc_html__( 'Icon', 'wdt-elementor-addon'),
						'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon'),
						'separator_1'     => esc_html__( 'Separator 1', 'wdt-elementor-addon'),
						'title' 		  => esc_html__( 'Title', 'wdt-elementor-addon'),
						'sub_title' 	  => esc_html__( 'Sub Title', 'wdt-elementor-addon')
					);
					$group2_content_position_elements = array( );
					$group2_element_group_content_position_elements = array();

					$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
					$settings['group1_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);
					$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);
					$settings['group2_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

				} else if($settings['template'] == 'standard') {

					$group1_content_position_elements = array(
						'elements_group'  => esc_html__( 'Elements Group', 'wdt-elementor-addon')
					);
					$group1_element_group_content_position_elements = array(
						'icon'  		  => esc_html__( 'Icon', 'wdt-elementor-addon'),
						'custom'          => esc_html__( 'Counter', 'wdt-elementor-addon')
					);
					$group2_content_position_elements = array(
						'title' 		  => esc_html__( 'Title', 'wdt-elementor-addon'),
						'separator_1'     => esc_html__( 'Separator 1', 'wdt-elementor-addon'),
						'sub_title' 	  => esc_html__( 'Sub Title', 'wdt-elementor-addon')
					);
					$group2_element_group_content_position_elements = array();

					$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
					$settings['group1_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);
					$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);
					$settings['group2_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

					$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

				}
				$output .= $this->cc_layout->get_column_edit_mode_css();
			$output .= $this->cc_layout->get_wrapper_end();

		else:
			$output .= '<div class="wdt-counter-container no-records">';
				$output .= esc_html__('No records found!', 'wdt-elementor-addon');
			$output .= '</div>';
		endif;

		return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_counter' ) ) {
    function wedesigntech_widget_base_counter() {
        return WeDesignTech_Widget_Base_Counter::instance();
    }
}
<?php

namespace MezanElementor\Widgets;
use MezanElementor\Widgets\Mezan_Shop_Widget_Product_Summary;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;


class Mezan_Shop_Widget_Product_Summary_Extend extends Mezan_Shop_Widget_Product_Summary {

	function dynamic_register_controls() {

		$this->start_controls_section( 'product_summary_extend_section', array(
			'label' => esc_html__( 'Social Options', 'mezan-pro' ),
		) );

			$this->add_control( 'share_follow_type', array(
				'label'   => esc_html__( 'Share / Follow Type', 'mezan-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'share',
				'options' => array(
					''       => esc_html__('None', 'mezan-pro'),
					'share'  => esc_html__('Share', 'mezan-pro'),
					'follow' => esc_html__('Follow', 'mezan-pro'),
				),
				'description' => esc_html__( 'Choose between Share / Follow you would like to use.', 'mezan-pro' ),
			) );

			$this->add_control( 'social_icon_style', array(
				'label'   => esc_html__( 'Social Icon Style', 'mezan-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'simple'        => esc_html__( 'Simple', 'mezan-pro' ),
					'bgfill'        => esc_html__( 'BG Fill', 'mezan-pro' ),
					'brdrfill'      => esc_html__( 'Border Fill', 'mezan-pro' ),
					'skin-bgfill'   => esc_html__( 'Skin BG Fill', 'mezan-pro' ),
					'skin-brdrfill' => esc_html__( 'Skin Border Fill', 'mezan-pro' ),
				),
				'description' => esc_html__( 'This option is applicable for all buttons used in product summary.', 'mezan-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

			$this->add_control( 'social_icon_radius', array(
				'label'   => esc_html__( 'Social Icon Radius', 'mezan-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'square'  => esc_html__( 'Square', 'mezan-pro' ),
					'rounded' => esc_html__( 'Rounded', 'mezan-pro' ),
					'circle'  => esc_html__( 'Circle', 'mezan-pro' ),
				),
				'condition'   => array(
					'social_icon_style' => array ('bgfill', 'brdrfill', 'skin-bgfill', 'skin-brdrfill'),
					'share_follow_type' => array ('share', 'follow')
				),
			) );

			$this->add_control( 'social_icon_inline_alignment', array(
				'label'        => esc_html__( 'Social Icon Inline Alignment', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'mezan-pro' ),
				'label_off'    => esc_html__( 'no', 'mezan-pro' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'This option is applicable for all buttons used in product summary.', 'mezan-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

		$this->end_controls_section();

	}

}
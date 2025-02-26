<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Shop_Metabox_Single_Upsell_Related' ) ) {
    class Mezan_Shop_Metabox_Single_Upsell_Related {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

			add_filter( 'mezan_shop_product_custom_settings', array( $this, 'mezan_shop_product_custom_settings' ), 10 );

		}

        function mezan_shop_product_custom_settings( $options ) {

			$ct_dependency      = array ();
			$upsell_dependency  = array ( 'show-upsell', '==', 'true');
			$related_dependency = array ( 'show-related', '==', 'true');
			if( function_exists('mezan_shop_single_module_custom_template') ) {
				$ct_dependency['dependency'] 	= array ( 'product-template', '!=', 'custom-template');
				$upsell_dependency 				= array ( 'product-template|show-upsell', '!=|==', 'custom-template|true');
				$related_dependency 			= array ( 'product-template|show-related', '!=|==', 'custom-template|true');
			}

			$product_options = array (

				array_merge (
					array(
						'id'         => 'show-upsell',
						'type'       => 'select',
						'title'      => esc_html__('Show Upsell Products', 'mezan'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-upsell' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'mezan' ),
							'true'         => esc_html__( 'Show', 'mezan'),
							null           => esc_html__( 'Hide', 'mezan'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'upsell-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Column', 'mezan'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'mezan' ),
						1              => esc_html__( 'One Column', 'mezan' ),
						2              => esc_html__( 'Two Columns', 'mezan' ),
						3              => esc_html__( 'Three Columns', 'mezan' ),
						4              => esc_html__( 'Four Columns', 'mezan' ),
					),
					'dependency' => $upsell_dependency
				),

				array(
					'id'         => 'upsell-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Limit', 'mezan'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'mezan' ),
						1              => esc_html__( 'One', 'mezan' ),
						2              => esc_html__( 'Two', 'mezan' ),
						3              => esc_html__( 'Three', 'mezan' ),
						4              => esc_html__( 'Four', 'mezan' ),
						5              => esc_html__( 'Five', 'mezan' ),
						6              => esc_html__( 'Six', 'mezan' ),
						7              => esc_html__( 'Seven', 'mezan' ),
						8              => esc_html__( 'Eight', 'mezan' ),
						9              => esc_html__( 'Nine', 'mezan' ),
						10              => esc_html__( 'Ten', 'mezan' ),
					),
					'dependency' => $upsell_dependency
				),

				array_merge (
					array(
						'id'         => 'show-related',
						'type'       => 'select',
						'title'      => esc_html__('Show Related Products', 'mezan'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-related' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'mezan' ),
							'true'         => esc_html__( 'Show', 'mezan'),
							null           => esc_html__( 'Hide', 'mezan'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'related-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Column', 'mezan'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'mezan' ),
						2              => esc_html__( 'Two Columns', 'mezan' ),
						3              => esc_html__( 'Three Columns', 'mezan' ),
						4              => esc_html__( 'Four Columns', 'mezan' ),
					),
					'dependency' => $related_dependency
				),

				array(
					'id'         => 'related-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Limit', 'mezan'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'mezan' ),
						1              => esc_html__( 'One', 'mezan' ),
						2              => esc_html__( 'Two', 'mezan' ),
						3              => esc_html__( 'Three', 'mezan' ),
						4              => esc_html__( 'Four', 'mezan' ),
						5              => esc_html__( 'Five', 'mezan' ),
						6              => esc_html__( 'Six', 'mezan' ),
						7              => esc_html__( 'Seven', 'mezan' ),
						8              => esc_html__( 'Eight', 'mezan' ),
						9              => esc_html__( 'Nine', 'mezan' ),
						10              => esc_html__( 'Ten', 'mezan' ),
					),
					'dependency' => $related_dependency
				)

			);

			$options = array_merge( $options, $product_options );

			return $options;

		}

    }
}

Mezan_Shop_Metabox_Single_Upsell_Related::instance();
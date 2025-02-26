<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Pro_Metabox_Single' ) ) {
    class Mezan_Pro_Metabox_Single {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'mezan_layout_posts', array( $this, 'mezan_layout_posts' ) );
            add_filter( 'cs_metabox_options', array( $this, 'product_options' ) );
        }

        function mezan_layout_posts( $post_types ) {

			array_push( $post_types, 'product' );
			return $post_types;

		}

        function product_options( $options ) {

			$product_custom_settings = apply_filters( 'mezan_shop_product_custom_settings', array () );

			if( is_array($product_custom_settings) && !empty($product_custom_settings) ) {

				$product_custom_settings_section = array (
					'name'   => 'general_section',
					'title'  => esc_html__('General', 'mezan-pro'),
					'icon'   => 'fa fa-angle-double-right',
					'fields' =>  $product_custom_settings
				);

				$options[] = array (
					'id'        => '_custom_settings',
					'title'     => esc_html__('Product Settings','mezan-pro'),
					'post_type' => 'product',
					'context'   => 'advanced',
					'priority'  => 'high',
					'sections'  => array (
						$product_custom_settings_section
					)
				);

			}

			return $options;

        }
    }
}

Mezan_Pro_Metabox_Single::instance();
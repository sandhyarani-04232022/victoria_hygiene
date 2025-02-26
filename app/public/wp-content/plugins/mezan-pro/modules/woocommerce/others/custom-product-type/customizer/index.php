<?php

/**
 * WooCommerce - Others - Cart Notification - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Shop_Customizer_Others_Custom_Product_Type' ) ) {

    class Mezan_Shop_Customizer_Others_Custom_Product_Type {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'mezan_woo_others_settings', array( $this, 'others_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function others_settings( $settings ) {

            $custom_product_types                   = mezan_customizer_settings('wdt-woo-custom-product-types' );
            $settings['custom_product_types']       = $custom_product_types;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
             * Option : Custom Product Types
             */

                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[wdt-woo-custom-product-types]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-custom-product-types]', array(
                            'type'        => 'textarea',
                            'label'       => esc_html__( 'Custom Product Types', 'mezan-shop' ),
                            'description'       => esc_html__( 'Add custom product types separated by commas.', 'mezan-shop' ),
                            'section'     => 'woocommerce-others-section'
                        )
                    )
                );

        }

    }

}


if( !function_exists('mezan_shop_customizer_others_custom_product_type') ) {
	function mezan_shop_customizer_others_custom_product_type() {
		return Mezan_Shop_Customizer_Others_Custom_Product_Type::instance();
	}
}

mezan_shop_customizer_others_custom_product_type();
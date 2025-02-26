<?php

/**
 * WooCommerce - Single - Module - Ajax Cart - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Shop_Customizer_Single_Ajax_Cart' ) ) {

    class Mezan_Shop_Customizer_Single_Ajax_Cart {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'mezan_woo_single_page_settings', array( $this, 'single_page_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function single_page_settings( $settings ) {

            $product_enable_ajax_addtocart             = mezan_customizer_settings('wdt-single-product-enable-ajax-addtocart' );
            $settings['product_enable_ajax_addtocart'] = $product_enable_ajax_addtocart;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
            * Option : Enable Ajax Add To Cart
            */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[wdt-single-product-enable-ajax-addtocart]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Switch(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-single-product-enable-ajax-addtocart]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Enable Ajax Add To Cart', 'mezan-pro'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'mezan-pro' ),
                                'off' => esc_attr__( 'No', 'mezan-pro' )
                            )
                        )
                    )
                );

        }

    }

}


if( !function_exists('mezan_shop_customizer_single_ajax_cart') ) {
	function mezan_shop_customizer_single_ajax_cart() {
		return Mezan_Shop_Customizer_Single_Ajax_Cart::instance();
	}
}

mezan_shop_customizer_single_ajax_cart();
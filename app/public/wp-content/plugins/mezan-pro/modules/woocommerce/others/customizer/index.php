<?php

/**
 * Customizer - Others Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Pro_Customizer_Others' ) ) {

    class Mezan_Pro_Customizer_Others {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'mezan_shop_pro_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function default( $option ) {

            $settings = mezan_woo_others()->woo_default_settings();
            extract($settings);

            $option['wdt-woo-addtocart-custom-action'] = $addtocart_custom_action;

            $option['wdt-woo-cross-sell-column'] = $cross_sell_column;
            $option['wdt-woo-cross-sell-title'] = $cross_sell_title;

            if( $cross_sell_style_template == 'predefined' ) {
                $option['wdt-woo-cross-sell-style-template'] = 'predefined-template-'.$cross_sell_style_custom_template;
            } else {
                $option['wdt-woo-cross-sell-style-template'] = $cross_sell_style_custom_template;
            }


            return $option;

        }

        function register( $wp_customize ) {

            /**
             * Others Panel
             */
                $wp_customize->add_section(
                    new Mezan_Customize_Section(
                        $wp_customize,
                        'woocommerce-others-section',
                        array(
                            'title'    => esc_html__('Others', 'mezan-pro'),
                            'panel'    => 'woocommerce-main-section',
                            'priority' => 50,
                        )
                    )
                );

        }

    }

}


if( !function_exists('mezan_customizer_others') ) {
	function mezan_customizer_others() {
		return Mezan_Pro_Customizer_Others::instance();
	}
}

mezan_customizer_others();
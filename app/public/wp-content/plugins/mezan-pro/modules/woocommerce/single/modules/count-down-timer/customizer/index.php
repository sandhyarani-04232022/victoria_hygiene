<?php

/**
 * WooCommerce - Single - Module - Count Down Timer - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Shop_Customizer_Single_Count_Down_Timer' ) ) {

    class Mezan_Shop_Customizer_Single_Count_Down_Timer {

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

            $product_sale_countdown_timer              = mezan_customizer_settings('wdt-single-product-sale-countdown-timer' );
            $settings['product_sale_countdown_timer']  = $product_sale_countdown_timer;

            return $settings;

        }

        function register( $wp_customize ) {

             /**
            * Option : Enable Sale Countdown Timer
            */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[wdt-single-product-sale-countdown-timer]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Switch(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-single-product-sale-countdown-timer]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Enable Sale Countdown Timer', 'mezan-pro'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'mezan-pro' ),
                                'off' => esc_attr__( 'No', 'mezan-pro' )
                            ),
                            'description'   => esc_html__('This option is applicable only for "WooCommerce Default" single page.', 'mezan-pro')
                        )
                    )
                );

        }

    }

}


if( !function_exists('mezan_shop_customizer_single_count_down_timer') ) {
	function mezan_shop_customizer_single_count_down_timer() {
		return Mezan_Shop_Customizer_Single_Count_Down_Timer::instance();
	}
}

mezan_shop_customizer_single_count_down_timer();
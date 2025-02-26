<?php

/**
 * WooCommerce - Others - Cart - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Shop_Customizer_Others_Cart' ) ) {

    class Mezan_Shop_Customizer_Others_Cart {

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

            $cross_sell_title              = mezan_customizer_settings('wdt-woo-cross-sell-title' );
            $settings['cross_sell_title']  = $cross_sell_title;

            $cross_sell_column             = mezan_customizer_settings('wdt-woo-cross-sell-column' );
            $settings['cross_sell_column'] = $cross_sell_column;

            $cross_sell_style_custom_template = mezan_customizer_settings('wdt-woo-cross-sell-style-template' );
            if( isset($cross_sell_style_custom_template) && !empty($cross_sell_style_custom_template) ) {
                $settings['cross_sell_style_template']        = 'custom';
                $settings['cross_sell_style_custom_template'] = $cross_sell_style_custom_template;
            }

            return $settings;

        }

        function register( $wp_customize ) {

            /**
             * Option : Cross Sell Title
             */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[wdt-woo-cross-sell-title]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    MEZAN_CUSTOMISER_VAL . '[wdt-woo-cross-sell-title]', array(
                        'type'       => 'text',
                        'section'    => 'woocommerce-others-section',
                        'label'      => esc_html__( 'Cross Sell Title', 'mezan-pro' )
                    )
                );

            /**
             * Option : Cross Sell Column
             */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[wdt-woo-cross-sell-column]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control( new Mezan_Customize_Control_Radio_Image(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-cross-sell-column]', array(
                        'type' => 'wdt-radio-image',
                        'label' => esc_html__( 'Cross Sell Column', 'mezan-pro'),
                        'section' => 'woocommerce-others-section',
                        'choices' => apply_filters( 'mezan_woo_crosssell_columns_options', array(
                            1 => array(
                                'label' => esc_html__( 'One Column', 'mezan-pro' ),
                                'path' => mezan_shop_others_cart()->module_dir_url() . 'customizer/images/one-column.png'
                            ),
                            2 => array(
                                'label' => esc_html__( 'One Half Column', 'mezan-pro' ),
                                'path' => mezan_shop_others_cart()->module_dir_url() . 'customizer/images/one-half-column.png'
                            ),
                            3 => array(
                                'label' => esc_html__( 'One Third Column', 'mezan-pro' ),
                                'path' => mezan_shop_others_cart()->module_dir_url() . 'customizer/images/one-third-column.png'
                            ),
                            4 => array(
                                'label' => esc_html__( 'One Fourth Column', 'mezan-pro' ),
                                'path' => mezan_shop_others_cart()->module_dir_url() . 'customizer/images/one-fourth-column.png'
                            )
                        ))
                    )
                ));

            /**
             * Option : Product Style Template
             */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[wdt-woo-cross-sell-style-template]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-cross-sell-style-template]', array(
                            'type'     => 'select',
                            'label'    => esc_html__( 'Product Style Template', 'mezan-pro'),
                            'section'  => 'woocommerce-others-section',
                            'choices'  => mezan_woo_listing_customizer_settings()->product_templates_list()
                        )
                    )
                );

        }

    }

}


if( !function_exists('mezan_shop_customizer_others_cart') ) {
	function mezan_shop_customizer_others_cart() {
		return Mezan_Shop_Customizer_Others_Cart::instance();
	}
}

mezan_shop_customizer_others_cart();
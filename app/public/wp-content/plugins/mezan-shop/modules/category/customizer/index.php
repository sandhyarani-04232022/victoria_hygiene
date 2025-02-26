<?php

/**
 * Listing Customizer - Category Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Shop_Listing_Customizer_Category' ) ) {

    class Mezan_Shop_Listing_Customizer_Category {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'mezan_woo_category_page_default_settings', array( $this, 'category_page_default_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 40);
            add_action( 'mezan_hook_content_before', array( $this, 'woo_handle_product_breadcrumb' ), 10);

        }

        function category_page_default_settings( $settings ) {

            $disable_breadcrumb             = mezan_customizer_settings('wdt-woo-category-page-disable-breadcrumb' );
            $settings['disable_breadcrumb'] = $disable_breadcrumb;

            $show_sorter_on_header              = mezan_customizer_settings('wdt-woo-category-page-show-sorter-on-header' );
            $settings['show_sorter_on_header']  = $show_sorter_on_header;

            $sorter_header_elements             = mezan_customizer_settings('wdt-woo-category-page-sorter-header-elements' );
            $settings['sorter_header_elements'] = (is_array($sorter_header_elements) && !empty($sorter_header_elements) ) ? $sorter_header_elements : array ();

            $show_sorter_on_footer              = mezan_customizer_settings('wdt-woo-category-page-show-sorter-on-footer' );
            $settings['show_sorter_on_footer']  = $show_sorter_on_footer;

            $sorter_footer_elements             = mezan_customizer_settings('wdt-woo-category-page-sorter-footer-elements' );
            $settings['sorter_footer_elements'] = (is_array($sorter_footer_elements) && !empty($sorter_footer_elements) ) ? $sorter_footer_elements : array ();

            return $settings;

        }

        function register( $wp_customize ) {

                /**
                * Option : Disable Breadcrumb
                */
                    $wp_customize->add_setting(
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-category-page-disable-breadcrumb]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Mezan_Customize_Control_Switch(
                            $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-category-page-disable-breadcrumb]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Disable Breadcrumb', 'mezan-shop'),
                                'section' => 'woocommerce-category-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'mezan-shop' ),
                                    'off' => esc_attr__( 'No', 'mezan-shop' )
                                )
                            )
                        )
                    );


                /**
                 * Option : Show Sorter On Header
                 */
                    $wp_customize->add_setting(
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-category-page-show-sorter-on-header]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Mezan_Customize_Control_Switch(
                            $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-category-page-show-sorter-on-header]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Header', 'mezan-shop'),
                                'section' => 'woocommerce-category-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'mezan-shop' ),
                                    'off' => esc_attr__( 'No', 'mezan-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Header Elements
                 */
                    $wp_customize->add_setting(
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-category-page-sorter-header-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Mezan_Customize_Control_Sortable(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-category-page-sorter-header-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Header Elements', 'mezan-shop'),
                            'section' => 'woocommerce-category-page-section',
                            'choices' => apply_filters( 'mezan_category_header_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter - OrderBy', 'mezan-shop' ),
                                'filters_widget_area'  => esc_html__( 'Filters - Widget Area', 'mezan-shop' ),
                                'result_count'         => esc_html__( 'Result Count', 'mezan-shop' ),
                                'pagination'           => esc_html__( 'Pagination', 'mezan-shop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'mezan-shop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'mezan-shop' )
                            )),
                        )
                    ));

                /**
                 * Option : Show Sorter On Footer
                 */
                    $wp_customize->add_setting(
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-category-page-show-sorter-on-footer]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Mezan_Customize_Control_Switch(
                            $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-category-page-show-sorter-on-footer]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Footer', 'mezan-shop'),
                                'section' => 'woocommerce-category-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'mezan-shop' ),
                                    'off' => esc_attr__( 'No', 'mezan-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Footer Elements
                 */
                    $wp_customize->add_setting(
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-category-page-sorter-footer-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Mezan_Customize_Control_Sortable(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-category-page-sorter-footer-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Footer Elements', 'mezan-shop'),
                            'section' => 'woocommerce-category-page-section',
                            'choices' => apply_filters( 'mezan_category_footer_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter', 'mezan-shop' ),
                                'result_count'         => esc_html__( 'Result Count', 'mezan-shop' ),
                                'pagination'           => esc_html__( 'Pagination', 'mezan-shop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'mezan-shop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'mezan-shop' )
                            )),
                        )
                    ));

        }

        function woo_handle_product_breadcrumb() {

            if(is_product_category() && mezan_customizer_settings('wdt-woo-category-page-disable-breadcrumb' )) {
                remove_action('mezan_breadcrumb', 'mezan_breadcrumb_template');
            }

        }

    }

}


if( !function_exists('mezan_shop_listing_customizer_category') ) {
	function mezan_shop_listing_customizer_category() {
		return Mezan_Shop_Listing_Customizer_Category::instance();
	}
}

mezan_shop_listing_customizer_category();
<?php

/**
 * Listing Customizer - Shop Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Shop_Listing_Customizer_Shop' ) ) {

    class Mezan_Shop_Listing_Customizer_Shop {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'mezan_woo_shop_page_default_settings', array( $this, 'shop_page_default_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 40);
            add_action( 'mezan_hook_content_before', array( $this, 'woo_handle_product_breadcrumb' ), 10);

        }

        function shop_page_default_settings( $settings ) {

            $disable_breadcrumb             = mezan_customizer_settings('wdt-woo-shop-page-disable-breadcrumb' );
            $settings['disable_breadcrumb'] = $disable_breadcrumb;

            $apply_isotope                  = mezan_customizer_settings('wdt-woo-shop-page-apply-isotope' );
            $settings['apply_isotope']      = $apply_isotope;

            $show_sorter_on_header              = mezan_customizer_settings('wdt-woo-shop-page-show-sorter-on-header' );
            $settings['show_sorter_on_header']  = $show_sorter_on_header;

            $sorter_header_elements             = mezan_customizer_settings('wdt-woo-shop-page-sorter-header-elements' );
            $settings['sorter_header_elements'] = (is_array($sorter_header_elements) && !empty($sorter_header_elements) ) ? $sorter_header_elements : array ();

            $show_sorter_on_footer              = mezan_customizer_settings('wdt-woo-shop-page-show-sorter-on-footer' );
            $settings['show_sorter_on_footer']  = $show_sorter_on_footer;

            $sorter_footer_elements             = mezan_customizer_settings('wdt-woo-shop-page-sorter-footer-elements' );
            $settings['sorter_footer_elements'] = (is_array($sorter_footer_elements) && !empty($sorter_footer_elements) ) ? $sorter_footer_elements : array ();

            return $settings;

        }

        function register( $wp_customize ) {

                /**
                * Option : Disable Breadcrumb
                */
                    $wp_customize->add_setting(
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-disable-breadcrumb]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Mezan_Customize_Control_Switch(
                            $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-disable-breadcrumb]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Disable Breadcrumb', 'mezan-shop'),
                                'section' => 'woocommerce-shop-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'mezan-shop' ),
                                    'off' => esc_attr__( 'No', 'mezan-shop' )
                                )
                            )
                        )
                    );

                /**
                * Option : Apply Isotope
                */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-apply-isotope]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Switch(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-apply-isotope]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Apply Isotope', 'mezan-shop'),
                            'section' => 'woocommerce-shop-page-section',
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
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-show-sorter-on-header]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Mezan_Customize_Control_Switch(
                            $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-show-sorter-on-header]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Header', 'mezan-shop'),
                                'section' => 'woocommerce-shop-page-section',
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
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-sorter-header-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Mezan_Customize_Control_Sortable(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-sorter-header-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Header Elements', 'mezan-shop'),
                            'section' => 'woocommerce-shop-page-section',
                            'choices' => apply_filters( 'mezan_shop_header_sorter_elements', array(
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
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-show-sorter-on-footer]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Mezan_Customize_Control_Switch(
                            $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-show-sorter-on-footer]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Footer', 'mezan-shop'),
                                'section' => 'woocommerce-shop-page-section',
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
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-sorter-footer-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Mezan_Customize_Control_Sortable(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-sorter-footer-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Footer Elements', 'mezan-shop'),
                            'section' => 'woocommerce-shop-page-section',
                            'choices' => apply_filters( 'mezan_shop_footer_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter', 'mezan-shop' ),
                                'result_count'         => esc_html__( 'Result Count', 'mezan-shop' ),
                                'pagination'           => esc_html__( 'Pagination', 'mezan-shop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'mezan-shop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'mezan-shop' )
                            )),
                        )
                    ));

                /**
                 * Option : Hooks - Page Top
                 */
                    $wp_customize->add_setting(
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-page-top]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Mezan_Customize_Control(
                            $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-page-top]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Template Hooks - Page Top', 'mezan-shop'),
                                'description'   => esc_html__('Choose elementor template that you want to display in Shop page top position.', 'mezan-shop'),
                                'section'  => 'woocommerce-shop-page-section',
                                'choices'  => mezan_elementor_page_list()
                            )
                        )
                    );

                /**
                 * Option : Hooks - Page Bottom
                 */
                    $wp_customize->add_setting(
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-page-bottom]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Mezan_Customize_Control(
                            $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-page-bottom]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Template Hooks - Page Bottom', 'mezan-shop'),
                                'description'   => esc_html__('Choose elementor template that you want to display in Shop page bottom position.', 'mezan-shop'),
                                'section'  => 'woocommerce-shop-page-section',
                                'choices'  => mezan_elementor_page_list()
                            )
                        )
                    );

                /**
                 * Option : Hooks - Content Top
                 */
                    $wp_customize->add_setting(
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-content-top]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Mezan_Customize_Control(
                            $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-content-top]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Template Hooks - Content Top', 'mezan-shop'),
                                'description'   => esc_html__('Choose elementor template that you want to display in Shop page content top position.', 'mezan-shop'),
                                'section'  => 'woocommerce-shop-page-section',
                                'choices'  => mezan_elementor_page_list()
                            )
                        )
                    );

                /**
                 * Option : Hooks - Content Bottom
                 */
                    $wp_customize->add_setting(
                        MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-content-bottom]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Mezan_Customize_Control(
                            $wp_customize, MEZAN_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-content-bottom]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Template Hooks - Content Bottom', 'mezan-shop'),
                                'description'   => esc_html__('Choose elementor template that you want to display in Shop page content bottom position.', 'mezan-shop'),
                                'section'  => 'woocommerce-shop-page-section',
                                'choices'  => mezan_elementor_page_list()
                            )
                        )
                    );

        }

        function woo_handle_product_breadcrumb() {

            if(is_shop() && mezan_customizer_settings('wdt-woo-shop-page-disable-breadcrumb' )) {
                remove_action('mezan_breadcrumb', 'mezan_breadcrumb_template');
            }

        }

    }

}


if( !function_exists('mezan_shop_listing_customizer_shop') ) {
	function mezan_shop_listing_customizer_shop() {
		return Mezan_Shop_Listing_Customizer_Shop::instance();
	}
}

mezan_shop_listing_customizer_shop();
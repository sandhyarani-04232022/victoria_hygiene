<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusCustomizerSiteJS' ) ) {
    class MezanPlusCustomizerSiteJS {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            add_filter( 'mezan_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function default( $option ) {
            $option['additional_js'] = '';
            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Main Section
             */
            $wp_customize->add_section(
                new Mezan_Customize_Section(
                    $wp_customize,
                    'site-js-main-section',
                    array(
                        'title'    => esc_html__('Additional JS', 'mezan-plus'),
                        'priority' => mezan_customizer_panel_priority( 'js' )
                    )
                )
            );


                /**
                 * Option : Additional JS
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[additional_js]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[additional_js]', array(
                            'type'        => 'textarea',
                            'section'     => 'site-js-main-section',
                            'label'       => esc_html__( 'Additional JS', 'mezan-plus' ),
                            'description' => esc_html__('Add your own JS code here to customize your theme.', 'mezan-plus'),
                        )
                    )
                );
        }
    }
}

MezanPlusCustomizerSiteJS::instance();
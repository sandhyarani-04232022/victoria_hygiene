<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusCustomizerSite404' ) ) {
    class MezanPlusCustomizerSite404 {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function register( $wp_customize ) {

            /**
             * 404 Page
             */
            $wp_customize->add_section(
                new Mezan_Customize_Section(
                    $wp_customize,
                    'site-404-page-section',
                    array(
                        'title'    => esc_html__('404 Page', 'mezan-plus'),
                        'priority' => mezan_customizer_panel_priority( '404' )
                    )
                )
            );

            if ( ! defined( 'MEZAN_PRO_VERSION' ) ) {
                $wp_customize->add_control(
                    new Mezan_Customize_Control_Separator(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[mezan-plus-site-404-separator]',
                        array(
                            'type'        => 'wdt-separator',
                            'section'     => 'site-404-page-section',
                            'settings'    => array(),
                            'caption'     => MEZAN_PLUS_REQ_CAPTION,
                            'description' => MEZAN_PLUS_REQ_DESC,
                        )
                    )
                );
            }

        }

    }
}

MezanPlusCustomizerSite404::instance();
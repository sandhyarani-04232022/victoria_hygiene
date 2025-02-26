<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanProCustomizerSiteTagline' ) ) {
    class MezanProCustomizerSiteTagline {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'mezan_google_fonts_list', array( $this, 'fonts_list' ) );
        }

        function register( $wp_customize ) {

            /**
             * Option :Site Tagline Typography
             */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[site_tagline_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Typography(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[site_tagline_typo]', array(
                            'type'    => 'wdt-typography',
                            'section' => 'site-tagline-section',
                            'label'   => esc_html__( 'Typography', 'mezan-pro'),
                        )
                    )
                );


            /**
             * Option : Site Title Color
             */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[site_tagline_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[site_tagline_color]', array(
                            'label'   => esc_html__( 'Color', 'mezan-pro' ),
                            'section' => 'site-tagline-section',
                        )
                    )
                );
        }

        function fonts_list( $fonts ) {
            $settings = mezan_customizer_settings( 'site_tagline_typo' );
            return mezan_customizer_frontend_font( $settings, $fonts );
        }

    }
}

MezanProCustomizerSiteTagline::instance();
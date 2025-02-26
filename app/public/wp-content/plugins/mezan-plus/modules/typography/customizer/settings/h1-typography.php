<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusH1Settings' ) ) {
    class MezanPlusH1Settings {

        private static $_instance = null;
        private $settings         = null;
        private $selector         = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->selector = apply_filters( 'mezan_h1_selector', array( 'h1' ) );
            $this->settings = mezan_customizer_settings('h1_typo');

            add_filter( 'mezan_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 20);

            add_filter( 'mezan_h1_typo_customizer_update', array( $this, 'h1_typo_customizer_update' ) );

            add_filter( 'mezan_google_fonts_list', array( $this, 'fonts_list' ) );
            add_filter( 'mezan_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'mezan_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'mezan_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'mezan_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );
        }

        function default( $option ) {
            $theme_defaults = function_exists('mezan_theme_defaults') ? mezan_theme_defaults() : array ();
            $option['h1_typo'] = $theme_defaults['h1_typo'];
            return $option;
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new Mezan_Customize_Section(
                    $wp_customize,
                    'site-h1-section',
                    array(
                        'title'    => esc_html__('H1 Typography', 'mezan-plus'),
                        'panel'    => 'site-typography-main-panel',
                        'priority' => 5,
                    )
                )
            );

            /**
             * Option :H1 Typo
             */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[h1_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Typography(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[h1_typo]', array(
                            'type'    => 'wdt-typography',
                            'section' => 'site-h1-section',
                            'label'   => esc_html__( 'H1 Tag', 'mezan-plus')
                        )
                    )
                );

            /**
             * Option : H1 Color
             */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[h1_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[h1_color]', array(
                            'label'   => esc_html__( 'Color', 'mezan-plus' ),
                            'section' => 'site-h1-section',
                        )
                    )
                );

        }

        function h1_typo_customizer_update( $defaults ) {
            $h1_typo = mezan_customizer_settings( 'h1_typo' );
            if( !empty( $h1_typo ) ) {
                return  $h1_typo;
            }
            return $defaults;
        }

        function fonts_list( $fonts ) {
            return mezan_customizer_frontend_font( $this->settings, $fonts );
        }

        function base_style( $style ) {
            $css   = '';
            $color = mezan_customizer_settings('h1_color');

            $css .= mezan_customizer_typography_settings( $this->settings );
            $css .= mezan_customizer_color_settings( $color );

            $css = mezan_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function tablet_landscape_style( $style ) {
            $css = mezan_customizer_responsive_typography_settings( $this->settings, 'tablet-ls' );
            $css = mezan_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function tablet_portrait( $style ) {
            $css = mezan_customizer_responsive_typography_settings( $this->settings, 'tablet' );
            $css = mezan_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function mobile_style( $style ) {
            $css = mezan_customizer_responsive_typography_settings( $this->settings, 'mobile' );
            $css = mezan_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

    }
}

MezanPlusH1Settings::instance();
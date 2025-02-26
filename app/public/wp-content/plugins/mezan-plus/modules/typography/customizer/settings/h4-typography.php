<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusH4Settings' ) ) {
    class MezanPlusH4Settings {

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
            $this->selector = apply_filters( 'mezan_h4_selector', array( 'h4' ) );
            $this->settings = mezan_customizer_settings('h4_typo');

            add_filter( 'mezan_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 20);

            add_filter( 'mezan_h4_typo_customizer_update', array( $this, 'h4_typo_customizer_update' ) );

            add_filter( 'mezan_google_fonts_list', array( $this, 'fonts_list' ) );
            add_filter( 'mezan_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'mezan_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'mezan_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'mezan_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );
        }

        function default( $option ) {
            $theme_defaults = function_exists('mezan_theme_defaults') ? mezan_theme_defaults() : array ();
            $option['h4_typo'] = $theme_defaults['h4_typo'];
            return $option;
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new Mezan_Customize_Section(
                    $wp_customize,
                    'site-h4-section',
                    array(
                        'title'    => esc_html__('H4 Typography', 'mezan-plus'),
                        'panel'    => 'site-typography-main-panel',
                        'priority' => 20,
                    )
                )
            );

            /**
             * Option :H4 Typo
             */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[h4_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Typography(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[h4_typo]', array(
                            'type'    => 'wdt-typography',
                            'section' => 'site-h4-section',
                            'label'   => esc_html__( 'H4 Tag', 'mezan-plus'),
                        )
                    )
                );

            /**
             * Option : H4 Color
             */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[h4_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[h4_color]', array(
                            'label'   => esc_html__( 'Color', 'mezan-plus' ),
                            'section' => 'site-h4-section',
                        )
                    )
                );

        }

        function h4_typo_customizer_update( $defaults ) {
            $h4_typo = mezan_customizer_settings( 'h4_typo' );
            if( !empty( $h4_typo ) ) {
                return  $h4_typo;
            }
            return $defaults;
        }

        function fonts_list( $fonts ) {
            return mezan_customizer_frontend_font( $this->settings, $fonts );
        }

        function base_style( $style ) {
            $css   = '';
            $color = mezan_customizer_settings('h4_color');

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

MezanPlusH4Settings::instance();
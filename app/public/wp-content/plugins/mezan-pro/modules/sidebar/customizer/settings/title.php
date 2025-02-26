<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanProWidgetTitleSettings' ) ) {
    class MezanProWidgetTitleSettings {

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
            $this->selector = apply_filters( 'mezan_widget_title_selector', array( '.secondary-sidebar .widgettitle' ) );
            $this->settings = mezan_customizer_settings('widget_title_typo');

            add_filter( 'mezan_pro_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

            add_filter( 'mezan_google_fonts_list', array( $this, 'fonts_list' ) );
            add_filter( 'mezan_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'mezan_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'mezan_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'mezan_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );

            add_filter( 'mezan_widget_before_title_tag', array( $this, 'before_title' ));
            add_filter( 'mezan_widget_after_title_tag', array( $this, 'after_title' ));
        }

        function default( $option ) {
            $option['widget_title_tag']   = 'h2';
            $option['widget_title_color'] = '';
            $option['widget_title_typo']  = array();
            return $option;
        }

        function register( $wp_customize ){

            /**
             * Option: Title Tag
             */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[widget_title_tag]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    MEZAN_CUSTOMISER_VAL . '[widget_title_tag]', array(
                        'type'    => 'select',
                        'section' => 'site-widgets-title-style-section',
                        'label'   => esc_html__( 'Title Tag', 'mezan-pro' ),
                        'choices' => array(
                            'h2'   => 'h2',
                            'h3'   => 'h3',
                            'h4'   => 'h4',
                            'h5'   => 'h5',
                            'h6'   => 'h6',
                            'span' => 'span',
                            'div'  => 'div',
                            'p'    => 'p',
                        )
                    )
                );

            /**
             * Option : Title Color
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[widget_title_color]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new Mezan_Customize_Control_Color(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[widget_title_color]', array(
                        'section' => 'site-widgets-title-style-section',
                        'label'   => esc_html__( 'Title Color', 'mezan-pro' ),
                    )
                )
            );

            /**
             * Option :Title Typo
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[widget_title_typo]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new Mezan_Customize_Control_Typography(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[widget_title_typo]', array(
                        'type'    => 'wdt-typography',
                        'section' => 'site-widgets-title-style-section',
                        'label'   => esc_html__( 'Title Typography', 'mezan-pro'),
                    )
                )
            );

        }

        function fonts_list( $fonts ) {
            return mezan_customizer_frontend_font( $this->settings, $fonts );
        }

        function base_style( $style ) {
            $css   = '';
            $color = mezan_customizer_settings('widget_title_color');

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

        function before_title( $tag ) {
            $t = mezan_customizer_settings('widget_title_tag');
            if( !empty( $t ) ){
                $align = isset( $this->settings['text-align'] ) ? $this->settings['text-align'] : '';
                $align = 'align'.$align;

                $tag = '<'.$t .' class="widgettitle '.$align.'">';
            }

            return $tag;
        }

        function after_title( $tag ) {
            $t = mezan_customizer_settings('widget_title_tag');
            if( !empty( $t ) ){
                $tag = '</'.$t .'>';
            }

            return $tag;
        }
    }
}

MezanProWidgetTitleSettings::instance();
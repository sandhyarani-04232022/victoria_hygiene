<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusStandardFooter' ) ) {
    class MezanPlusStandardFooter {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'mezan_footer_layouts', array( $this, 'add_standard_footer_option' ) );
            add_filter( 'mezan_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 30 );

            add_action( 'widgets_init', array( $this, 'register_footer_widgets' ) );

            $footer_type = mezan_customizer_settings( 'site_footer' );
            $footer_type = apply_filters( 'mezan_plus_final_footer', $footer_type );

            if( $footer_type == 'standard-footer' ) {
                $this->frontend();
            }
        }

        function add_standard_footer_option( $options ) {
            $options['standard-footer'] = esc_html__('Standard Footer', 'mezan-plus');
            return $options;
        }

        function default( $option ) {
            $option['standard_footer_column']     = 3;
            $option['standard_footer_background'] = array(
                'background-color'      => '#fde6e1',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'cover',
                'background-attachment' => 'inherit'
            );

            $option['standard_footer_title_typo']             = '';
            $option['standard_footer_title_color']            = '';
            $option['standard_footer_content_typo']           = '';
            $option['standard_footer_content_color']          = '';
            $option['standard_footer_content_a_color']        = '';
            $option['standard_footer_content_a_hover_color']  = '';

            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Section : Standard Footer
             */

                /**
                 * Option : Footer Column
                 */
                    $wp_customize->add_setting(
                        MEZAN_CUSTOMISER_VAL . '[standard_footer_column]', array(
                            'type'    => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Mezan_Customize_Control(
                            $wp_customize, MEZAN_CUSTOMISER_VAL . '[standard_footer_column]', array(
                                'type'    => 'select',
                                'section' => 'site-footer-section',
                                'label'   => esc_html__( 'Footer Column', 'mezan-plus' ),
                                'dependency' => array( 'site_footer', '==', 'standard-footer' ),
                                'choices' => array(
                                    '1' => esc_html__('One Column', 'mezan-plus' ),
                                    '2' => esc_html__('Two Column', 'mezan-plus' ),
                                    '3' => esc_html__('Three Column', 'mezan-plus' ),
                                    '4' => esc_html__('Four Column', 'mezan-plus' ),
                                    '5' => esc_html__('Five Column', 'mezan-plus' ),
                                )
                            )
                        )
                    );

                /**
                 * Option : Standard Footer Background
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[standard_footer_background]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Background(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[standard_footer_background]', array(
                            'type'       => 'wdt-background',
                            'section'    => 'site-footer-section',
                            'dependency' => array( 'site_footer|standard_footer_column', '==|!=', 'standard-footer|' ),
                            'label'      => esc_html__( 'Background', 'mezan-plus' ),
                        )
                    )
                );

                /**
                 * Option :Standard Footer Title Typo
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[standard_footer_title_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Typography(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[standard_footer_title_typo]', array(
                            'type'       => 'wdt-typography',
                            'section'    => 'site-footer-section',
                            'dependency' => array( 'site_footer|standard_footer_column', '==|!=', 'standard-footer|' ),
                            'label'      => esc_html__( 'Title Typography', 'mezan-plus'),
                        )
                    )
                );

                /**
                 * Option : Standard Footer Title Color
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[standard_footer_title_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Color(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[standard_footer_title_color]', array(
                            'label'      => esc_html__( 'Color', 'mezan-plus' ),
                            'dependency' => array( 'site_footer|standard_footer_column', '==|!=', 'standard-footer|' ),
                            'section'    => 'site-footer-section',
                        )
                    )
                );


                /**
                 * Option :Standard Footer content Typo
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[standard_footer_content_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Typography(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[standard_footer_content_typo]', array(
                            'type'       => 'wdt-typography',
                            'section'    => 'site-footer-section',
                            'dependency' => array( 'site_footer|standard_footer_column', '==|!=', 'standard-footer|' ),
                            'label'      => esc_html__( 'Content Typography', 'mezan-plus'),
                        )
                    )
                );

                /**
                 * Option : Standard Footer content Color
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[standard_footer_content_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Color(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[standard_footer_content_color]', array(
                            'label'      => esc_html__( 'Color', 'mezan-plus' ),
                            'dependency' => array( 'site_footer|standard_footer_column', '==|!=', 'standard-footer|' ),
                            'section'    => 'site-footer-section',
                        )
                    )
                );

                /**
                 * Option : Standard Footer content anchor Color
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[standard_footer_content_a_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Color(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[standard_footer_content_a_color]', array(
                            'label'      => esc_html__( 'Anchor Color', 'mezan-plus' ),
                            'dependency' => array( 'site_footer|standard_footer_column', '==|!=', 'standard-footer|' ),
                            'section'    => 'site-footer-section',
                        )
                    )
                );

                /**
                 * Option : Standard Footer content anchor hover Color
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[standard_footer_content_a_hover_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Color(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[standard_footer_content_a_hover_color]', array(
                            'label'      => esc_html__( 'Anchor Hover Color', 'mezan-plus' ),
                            'dependency' => array( 'site_footer|standard_footer_column', '==|!=', 'standard-footer|' ),
                            'section'    => 'site-footer-section',
                        )
                    )
                );
        }

        function register_footer_widgets() {
            $count = mezan_customizer_settings( 'standard_footer_column' );
            for( $i=1; $i<=$count; $i++ ) {
                register_sidebar( array(
                    'id'            => 'footer_'.$i,
                    'name'          => sprintf( esc_html__( 'Footer Widget Area - Column %s', 'mezan-plus' ), $i ),
                    'description'   => sprintf( esc_html__( 'Widgets added here will appear in the %s column of footer area', 'mezan-plus' ), $i ),
                    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h2 class="widgettitle">',
                    'after_title'   => '</h2>'
                ) );
            }
        }

        function frontend() {

            add_filter( 'mezan_google_fonts_list', array( $this, 'fonts_list' ) );

            add_filter( 'mezan_footer_get_template_part', array( $this, 'load_template' ), 20 );
            add_action( 'mezan_after_main_css', array( $this, 'enqueue_assets' ) );

            add_filter( 'mezan_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'mezan_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'mezan_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'mezan_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );
        }

        function fonts_list( $fonts ) {

            $title = mezan_customizer_frontend_font( mezan_customizer_settings('standard_footer_title_typo'), array() );
            if( count( $title ) ) {
                array_push( $fonts, $title[0] );
            }

            $content = mezan_customizer_frontend_font( mezan_customizer_settings('standard_footer_content_typo'), array() );
            if( count( $content ) ) {
                array_push( $fonts, $content[0] );
            }

            return $fonts;
        }

        function load_template( $template ) {

            $footer_type = mezan_customizer_settings( 'site_footer' );
            if( $footer_type == 'standard-footer' ) :

                $count     = mezan_customizer_settings( 'standard_footer_column' );
                $col_class = '';

                switch( $count ) {
                    case '1':
                        $col_class = 'column wdt-one-column';
                    break;

                    case '2':
                        $col_class = 'column wdt-one-half';
                    break;

                    case '3':
                        $col_class = 'column wdt-one-third';
                    break;

                    case '4':
                        $col_class = 'column wdt-one-fourth';
                    break;

                    case '5':
                        $col_class = 'column wdt-one-fifth';
                    break;
                }

                return mezan_get_template_part( 'footer', 'layouts/standard-footer/template', '', array( 'count' => $count, 'class' => $col_class ) );

            endif;

            return $template;

        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-footer', MEZAN_PLUS_DIR_URL . 'modules/footer/layouts/standard-footer/assets/css/standard-footer.css', MEZAN_PLUS_VERSION );
        }

        function base_style( $style ) {
            $bg                = mezan_customizer_settings('standard_footer_background');
            $title_typo        = mezan_customizer_settings('standard_footer_title_typo');
            $title_color       = mezan_customizer_settings('standard_footer_title_color');
            $content_typo      = mezan_customizer_settings('standard_footer_content_typo');
            $content_color     = mezan_customizer_settings('standard_footer_content_color');
            $content_a_color   = mezan_customizer_settings('standard_footer_content_a_color');
            $content_a_h_color = mezan_customizer_settings('standard_footer_content_a_hover_color');

            $title_css  = mezan_customizer_typography_settings( $title_typo );
            $title_css .= mezan_customizer_color_settings( $title_color );
            if( !empty( $title_css ) ) {
                $style .= mezan_customizer_dynamic_style( '#footer.standard-footer .widgettitle', $title_css );
            }

            $content_css  = mezan_customizer_typography_settings( $content_typo );
            $content_css .= mezan_customizer_color_settings( $content_color );
            if( !empty( $content_css ) ) {
                $style .= mezan_customizer_dynamic_style( '#footer.standard-footer .widget, .footer-copyright', $content_css );
            }

            $content_a_css = mezan_customizer_color_settings( $content_a_color );
            if( !empty( $content_a_css ) ) {
                $style .= mezan_customizer_dynamic_style( '#footer.standard-footer .widget a,#footer.standard-footer .widget ul li a', $content_a_css );
            }

            $content_a_h_css = mezan_customizer_color_settings( $content_a_h_color );
            if( !empty( $content_a_h_css ) ) {
                $style .= mezan_customizer_dynamic_style( '#footer.standard-footer .widget a:hover,#footer.standard-footer .widget ul li a:hover', $content_a_h_css );
            }

            $bg_css = mezan_customizer_bg_settings( $bg );
            if( !empty( $bg_css ) ) {
                $style .= mezan_customizer_dynamic_style( '#footer.standard-footer', $bg_css );
            }

            return $style;
        }

        function tablet_landscape_style( $style ) {
            $title_typo     = mezan_customizer_settings('standard_footer_title_typo');
            $title_typo_css = mezan_customizer_responsive_typography_settings( $title_typo, 'tablet-ls' );
            if( !empty( $title_typo_css) ) {
                $style .= mezan_customizer_dynamic_style( '#footer.standard-footer .widgettitle', $title_typo_css );
            }

            $content_typo     = mezan_customizer_settings('standard_footer_content_typo');
            $content_typo_css = mezan_customizer_responsive_typography_settings( $content_typo, 'tablet-ls' );
            if( !empty( $content_typo_css) ) {
                $style .= mezan_customizer_dynamic_style( '#footer.standard-footer .widget', $content_typo_css );
            }

            return $style;
        }

        function tablet_portrait( $style ) {
            $title_typo     = mezan_customizer_settings('standard_footer_title_typo');
            $title_typo_css = mezan_customizer_responsive_typography_settings( $title_typo, 'tablet' );
            if( !empty( $title_typo_css) ) {
                $style .= mezan_customizer_dynamic_style( '#footer.standard-footer .widgettitle', $title_typo_css );
            }

            $content_typo     = mezan_customizer_settings('standard_footer_content_typo');
            $content_typo_css = mezan_customizer_responsive_typography_settings( $content_typo, 'tablet' );
            if( !empty( $content_typo_css) ) {
                $style .= mezan_customizer_dynamic_style( '#footer.standard-footer .widget', $content_typo_css );
            }

            return $style;
        }

        function mobile_style( $style ) {
            $title_typo     = mezan_customizer_settings('standard_footer_title_typo');
            $title_typo_css = mezan_customizer_responsive_typography_settings( $title_typo, 'mobile' );
            if( !empty( $title_typo_css) ) {
                $style .= mezan_customizer_dynamic_style( '#footer.standard-footer .widgettitle', $title_typo_css );
            }

            $content_typo     = mezan_customizer_settings('standard_footer_content_typo');
            $content_typo_css = mezan_customizer_responsive_typography_settings( $content_typo, 'mobile' );
            if( !empty( $content_typo_css) ) {
                $style .= mezan_customizer_dynamic_style( '#footer.standard-footer .widget', $content_typo_css );
            }

            return $style;
        }

    }
}

MezanPlusStandardFooter::instance();
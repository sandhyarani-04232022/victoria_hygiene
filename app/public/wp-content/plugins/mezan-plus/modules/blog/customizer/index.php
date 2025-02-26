<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusCustomizerSiteBlog' ) ) {
    class MezanPlusCustomizerSiteBlog {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'mezan_plus_customizer_default', array( $this, 'default' ) );
        }

        function default( $option ) {

            $blog_defaults = array();
            if( function_exists('mezan_archive_blog_post_defaults') ) {
                $blog_defaults = mezan_archive_blog_post_defaults();
            }

            $option['blog-post-layout']          = $blog_defaults['post-layout'];
            $option['blog-post-cover-style']     = $blog_defaults['post-cover-style'];
            $option['blog-post-grid-list-style'] = $blog_defaults['post-gl-style'];
            $option['blog-list-thumb']           = $blog_defaults['list-type'];
            $option['blog-image-hover-style']    = $blog_defaults['hover-style'];
            $option['blog-image-overlay-style']  = $blog_defaults['overlay-style'];
            $option['blog-alignment']            = $blog_defaults['post-align'];
            $option['blog-post-columns']         = $blog_defaults['post-column'];

            $blog_misc_defaults = array();
            if( function_exists('mezan_archive_blog_post_misc_defaults') ) {
                $blog_misc_defaults = mezan_archive_blog_post_misc_defaults();
            }

            $option['enable-equal-height']       = $blog_misc_defaults['enable-equal-height'];
            $option['enable-no-space']           = $blog_misc_defaults['enable-no-space'];

            $blog_params = array();
            if( function_exists('mezan_archive_blog_post_params_default') ) {
                $blog_params = mezan_archive_blog_post_params_default();
            }

            $option['enable-post-format']        = $blog_params['enable_post_format'];
            $option['enable-video-audio']        = $blog_params['enable_video_audio'];
            $option['enable-gallery-slider']     = $blog_params['enable_gallery_slider'];
            $option['blog-elements-position']    = $blog_params['archive_post_elements'];
            $option['blog-meta-position']        = $blog_params['archive_meta_elements'];
            $option['blog-readmore-text']        = $blog_params['archive_readmore_text'];
            $option['enable-excerpt-text']       = $blog_params['enable_excerpt_text'];
            $option['blog-excerpt-length']       = $blog_params['archive_excerpt_length'];
            $option['blog-pagination']           = $blog_params['archive_blog_pagination'];


            return $option;

        }

        function register( $wp_customize ) {

            /**
             * Panel
             */
            $wp_customize->add_panel(
                new Mezan_Customize_Panel(
                    $wp_customize,
                    'site-blog-main-panel',
                    array(
                        'title'    => esc_html__('Blog Settings', 'mezan-plus'),
                        'priority' => mezan_customizer_panel_priority( 'blog' )
                    )
                )
            );

            $wp_customize->add_section(
                new Mezan_Customize_Section(
                    $wp_customize,
                    'site-blog-archive-section',
                    array(
                        'title'    => esc_html__('Blog Archives', 'mezan-plus'),
                        'panel'    => 'site-blog-main-panel',
                        'priority' => 10,
                    )
                )
            );


            /**
             * Option : Archive Post Layout
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Mezan_Customize_Control_Radio_Image(
                $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'Post Layout', 'mezan-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'mezan_blog_archive_layout_options', array(
                        'entry-grid' => array(
                            'label' => esc_html__( 'Grid', 'mezan-plus' ),
                            'path' => MEZAN_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-grid.png'
                        ),
                        'entry-list' => array(
                            'label' => esc_html__( 'List', 'mezan-plus' ),
                            'path' => MEZAN_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-list.png'
                        ),
                        'entry-cover' => array(
                            'label' => esc_html__( 'Cover', 'mezan-plus' ),
                            'path' => MEZAN_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-cover.png'
                        ),
                    ))
                )
            ));

            /**
             * Option : Post Grid, List Style
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[blog-post-grid-list-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Mezan_Customize_Control(
                $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-post-grid-list-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Post Style', 'mezan-plus' ),
                    'choices' => apply_filters('blog_post_grid_list_style_update', array(
                        'wdt-classic' => esc_html__('Classic', 'mezan-plus'),
                    )),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' )
                )
            ));

            /**
             * Option : Post Cover Style
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[blog-post-cover-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Mezan_Customize_Control(
                $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-post-cover-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Post Style', 'mezan-plus' ),
                    'choices' => apply_filters('blog_post_cover_style_update', array(
                        'wdt-classic' => esc_html__('Classic', 'mezan-plus')
                    )),
                    'dependency'   => array( 'blog-post-layout', '==', 'entry-cover' )
                )
            ));

            /**
             * Option : Post Columns
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Mezan_Customize_Control_Radio_Image(
                $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'Columns', 'mezan-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'mezan_blog_archive_columns_options', array(
                        'one-column' => array(
                            'label' => esc_html__( 'One Column', 'mezan-plus' ),
                            'path' => MEZAN_PLUS_DIR_URL . 'modules/blog/customizer/images/one-column.png'
                        ),
                        'one-half-column' => array(
                            'label' => esc_html__( 'One Half Column', 'mezan-plus' ),
                            'path' => MEZAN_PLUS_DIR_URL . 'modules/blog/customizer/images/one-half-column.png'
                        ),
                        'one-third-column' => array(
                            'label' => esc_html__( 'One Third Column', 'mezan-plus' ),
                            'path' => MEZAN_PLUS_DIR_URL . 'modules/blog/customizer/images/one-third-column.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                )
            ));

            /**
             * Option : List Thumb
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Mezan_Customize_Control_Radio_Image(
                $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'List Type', 'mezan-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'mezan_blog_archive_list_thumb_options', array(
                        'entry-left-thumb' => array(
                            'label' => esc_html__( 'Left Thumb', 'mezan-plus' ),
                            'path' => MEZAN_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-left-thumb.png'
                        ),
                        'entry-right-thumb' => array(
                            'label' => esc_html__( 'Right Thumb', 'mezan-plus' ),
                            'path' => MEZAN_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-right-thumb.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', '==', 'entry-list' ),
                )
            ));

            /**
             * Option : Post Alignment
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Mezan_Customize_Control(
                $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Elements Alignment', 'mezan-plus' ),
                    'choices' => array(
                      'alignnone'   => esc_html__('None', 'mezan-plus'),
                      'alignleft'   => esc_html__('Align Left', 'mezan-plus'),
                      'aligncenter' => esc_html__('Align Center', 'mezan-plus'),
                      'alignright'  => esc_html__('Align Right', 'mezan-plus'),
                    ),
                    'dependency'   => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                )
            ));

            /**
             * Option : Equal Height
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[enable-equal-height]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Mezan_Customize_Control_Switch(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[enable-equal-height]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable Equal Height', 'mezan-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'mezan-plus' ),
                            'off' => esc_attr__( 'No', 'mezan-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                    )
                )
            );

            /**
             * Option : No Space
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[enable-no-space]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Mezan_Customize_Control_Switch(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[enable-no-space]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable No Space', 'mezan-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'mezan-plus' ),
                            'off' => esc_attr__( 'No', 'mezan-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                    )
                )
            );

            /**
             * Option : Gallery Slider
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Mezan_Customize_Control_Switch(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Display Gallery Slider', 'mezan-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'mezan-plus' ),
                            'off' => esc_attr__( 'No', 'mezan-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Divider : Blog Gallery Slider Bottom
             */
            $wp_customize->add_control(
                new Mezan_Customize_Control_Separator(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-gallery-slider-bottom-separator]', array(
                        'type'     => 'wdt-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );

            /**
             * Option : Blog Elements
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Mezan_Customize_Control_Sortable(
                $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'wdt-sortable',
                    'label' => esc_html__( 'Elements Positioning', 'mezan-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'mezan_archive_post_elements_options', array(
                        'feature_image' => esc_html__('Feature Image', 'mezan-plus'),
                        'title'         => esc_html__('Title', 'mezan-plus'),
                        'content'       => esc_html__('Content', 'mezan-plus'),
                        'read_more'     => esc_html__('Read More', 'mezan-plus'),
                        'meta_group'    => esc_html__('Meta Group', 'mezan-plus'),
                        'author'        => esc_html__('Author', 'mezan-plus'),
                        'date'          => esc_html__('Date', 'mezan-plus'),
                        'comment'       => esc_html__('Comments', 'mezan-plus'),
                        'category'      => esc_html__('Categories', 'mezan-plus'),
                        'tag'           => esc_html__('Tags', 'mezan-plus'),
                        'social'        => esc_html__('Social Share', 'mezan-plus'),
                        'likes_views'   => esc_html__('Likes & Views', 'mezan-plus'),
                    )),
                )
            ));

            /**
             * Option : Blog Meta Elements
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Mezan_Customize_Control_Sortable(
                $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'wdt-sortable',
                    'label' => esc_html__( 'Meta Group Positioning', 'mezan-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'mezan_blog_archive_meta_elements_options', array(
                        'author'        => esc_html__('Author', 'mezan-plus'),
                        'date'          => esc_html__('Date', 'mezan-plus'),
                        'comment'       => esc_html__('Comments', 'mezan-plus'),
                        'category'      => esc_html__('Categories', 'mezan-plus'),
                        'tag'           => esc_html__('Tags', 'mezan-plus'),
                        'social'        => esc_html__('Social Share', 'mezan-plus'),
                        'likes_views'   => esc_html__('Likes & Views', 'mezan-plus'),
                    )),
                    'description' => esc_html__('Note: Use max 3 items for better results.', 'mezan-plus'),
                )
            ));

            /**
             * Divider : Blog Meta Elements Bottom
             */
            $wp_customize->add_control(
                new Mezan_Customize_Control_Separator(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-meta-elements-bottom-separator]', array(
                        'type'     => 'wdt-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );

            /**
             * Option : Post Format
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[enable-post-format]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Mezan_Customize_Control_Switch(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[enable-post-format]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable Post Format', 'mezan-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'mezan-plus' ),
                            'off' => esc_attr__( 'No', 'mezan-plus' )
                        )
                    )
                )
            );

            /**
             * Option : Enable Excerpt
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Mezan_Customize_Control_Switch(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable Excerpt Text', 'mezan-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'mezan-plus' ),
                            'off' => esc_attr__( 'No', 'mezan-plus' )
                        )
                    )
                )
            );

            /**
             * Option : Excerpt Text
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Mezan_Customize_Control(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Excerpt Length', 'mezan-plus' ),
                        'description' => esc_html__('Put Excerpt Length', 'mezan-plus'),
                        'input_attrs' => array(
                            'value' => 25,
                        ),
                        'dependency'  => array( 'enable-excerpt-text', '==', 'true' ),
                    )
                )
            );

            /**
             * Option : Enable Video Audio
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[enable-video-audio]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Mezan_Customize_Control_Switch(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[enable-video-audio]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Display Video & Audio for Posts', 'mezan-plus'),
                        'description' => esc_html__('YES! to display video & audio, instead of feature image for posts', 'mezan-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'mezan-plus' ),
                            'off' => esc_attr__( 'No', 'mezan-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Option : Readmore Text
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Mezan_Customize_Control(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Read More Text', 'mezan-plus' ),
                        'description' => esc_html__('Put the read more text here', 'mezan-plus'),
                        'input_attrs' => array(
                            'value' => esc_html__('Read More', 'mezan-plus'),
                        )
                    )
                )
            );

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Mezan_Customize_Control(
                $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Hover Style', 'mezan-plus' ),
                    'choices' => array(
                      'wdt-default'     => esc_html__('Default', 'mezan-plus'),
                      'wdt-blur'        => esc_html__('Blur', 'mezan-plus'),
                      'wdt-bw'          => esc_html__('Black and White', 'mezan-plus'),
                      'wdt-brightness'  => esc_html__('Brightness', 'mezan-plus'),
                      'wdt-fadeinleft'  => esc_html__('Fade InLeft', 'mezan-plus'),
                      'wdt-fadeinright' => esc_html__('Fade InRight', 'mezan-plus'),
                      'wdt-hue-rotate'  => esc_html__('Hue-Rotate', 'mezan-plus'),
                      'wdt-invert'      => esc_html__('Invert', 'mezan-plus'),
                      'wdt-opacity'     => esc_html__('Opacity', 'mezan-plus'),
                      'wdt-rotate'      => esc_html__('Rotate', 'mezan-plus'),
                      'wdt-rotate-alt'  => esc_html__('Rotate Alt', 'mezan-plus'),
                      'wdt-scalein'     => esc_html__('Scale In', 'mezan-plus'),
                      'wdt-scaleout'    => esc_html__('Scale Out', 'mezan-plus'),
                      'wdt-sepia'       => esc_html__('Sepia', 'mezan-plus'),
                      'wdt-tint'        => esc_html__('Tint', 'mezan-plus'),
                    ),
                    'description' => esc_html__('Choose image hover style to display archives pages.', 'mezan-plus'),
                )
            ));

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Mezan_Customize_Control(
                $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Overlay Style', 'mezan-plus' ),
                    'choices' => array(
                      'wdt-default'           => esc_html__('None', 'mezan-plus'),
                      'wdt-fixed'             => esc_html__('Fixed', 'mezan-plus'),
                      'wdt-tb'                => esc_html__('Top to Bottom', 'mezan-plus'),
                      'wdt-bt'                => esc_html__('Bottom to Top', 'mezan-plus'),
                      'wdt-rl'                => esc_html__('Right to Left', 'mezan-plus'),
                      'wdt-lr'                => esc_html__('Left to Right', 'mezan-plus'),
                      'wdt-middle'            => esc_html__('Middle', 'mezan-plus'),
                      'wdt-middle-radial'     => esc_html__('Middle Radial', 'mezan-plus'),
                      'wdt-tb-gradient'       => esc_html__('Gradient - Top to Bottom', 'mezan-plus'),
                      'wdt-bt-gradient'       => esc_html__('Gradient - Bottom to Top', 'mezan-plus'),
                      'wdt-rl-gradient'       => esc_html__('Gradient - Right to Left', 'mezan-plus'),
                      'wdt-lr-gradient'       => esc_html__('Gradient - Left to Right', 'mezan-plus'),
                      'wdt-radial-gradient'   => esc_html__('Gradient - Radial', 'mezan-plus'),
                      'wdt-flash'             => esc_html__('Flash', 'mezan-plus'),
                      'wdt-circle'            => esc_html__('Circle', 'mezan-plus'),
                      'wdt-hm-elastic'        => esc_html__('Horizontal Elastic', 'mezan-plus'),
                      'wdt-vm-elastic'        => esc_html__('Vertical Elastic', 'mezan-plus'),
                    ),
                    'description' => esc_html__('Choose image overlay style to display archives pages.', 'mezan-plus'),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                )
            ));

            /**
             * Option : Pagination
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Mezan_Customize_Control(
                $wp_customize, MEZAN_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Pagination Style', 'mezan-plus' ),
                    'choices' => array(
                      'pagination-default'        => esc_html__('Older & Newer', 'mezan-plus'),
                      'pagination-numbered'       => esc_html__('Numbered', 'mezan-plus'),
                      'pagination-loadmore'       => esc_html__('Load More', 'mezan-plus'),
                      'pagination-infinite-scroll'=> esc_html__('Infinite Scroll', 'mezan-plus'),
                    ),
                    'description' => esc_html__('Choose pagination style to display archives pages.', 'mezan-plus')
                )
            ));

        }
    }
}

MezanPlusCustomizerSiteBlog::instance();
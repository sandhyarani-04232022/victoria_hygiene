<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MetaboxSidebar' ) ) {
    class MetaboxSidebar {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'cs_metabox_options', array( $this, 'layout' ) );
        }

        function layout( $options ) {

            $post_types = apply_filters( 'mezan_layout_posts', array( 'post', 'page' ) );

            $options[] = array(
                'id'        => '_mezan_layout_settings',
                'title'     => esc_html('Layout', 'mezan-pro'),
                'post_type' => $post_types,
                'context'   => 'advanced',
                'priority'  => 'high',
                'sections'  => array(
                    array(
                        'name'   => 'layout_section',
                        'fields' => array(
                            array(
                                'id'      => 'layout',
                                'type'    => 'image_select',
                                'title'   => esc_html__('Sidebar Layout?', 'mezan-pro'),
                                'options' => array(
                                    'global-sidebar-layout' => MEZAN_PRO_DIR_URL . 'modules/sidebar/customizer/images/global-sidebar.png',
                                    'content-full-width'    => MEZAN_PRO_DIR_URL . 'modules/sidebar/customizer/images/without-sidebar.png',
                                    'with-left-sidebar'     => MEZAN_PRO_DIR_URL . 'modules/sidebar/customizer/images/left-sidebar.png',
                                    'with-right-sidebar'    => MEZAN_PRO_DIR_URL . 'modules/sidebar/customizer/images/right-sidebar.png',
                                ),
                                'default'    => 'global-sidebar-layout',
                                'attributes' => array( 'data-depend-id' => 'page-layout' )
                            ),
                            array(
                                'id'         => 'sidebars',
                                'type'       => 'select',
                                'title'      => esc_html__('Select sidebar(s)?', 'mezan-pro'),
                                'class'      => 'chosen',
                                'options'    => $this->registered_widget_areas(),
                                'attributes' => array(
                                    'multiple'         => 'multiple',
                                    'data-placeholder' => esc_html__('Select Widget Area(s)','mezan-pro'),
                                    'style'            => 'width: 400px;'
                                ),
                                'dependency' => array( 'page-layout', 'any', 'with-left-sidebar,with-right-sidebar' ),
                            ),
                            array(
                                'id'    => 'sticky_sidebar',
                                'type'  => 'switcher',
                                'title' => esc_html__('Sticky Side Bar', 'mezan-pro' ),
                                'info'  => esc_html__('YES! to sticky side bar content.','mezan-pro')
                            ),
                        )
                    )
                )
            );

            return $options;
        }

        function registered_widget_areas() {

            $widgets = array ();

            $widgets['mezan-standard-sidebar-1'] = esc_html__( 'Standard Sidebar', 'mezan-pro' );

            $widget_areas = get_option( 'mezan-widget-areas' );
            if( $widget_areas ) {
                $widget_areas = $widget_areas['widget-areas'];

                if( is_array( $widget_areas ) && count( $widget_areas ) > 0 ) {
                    foreach ( $widget_areas as $widget ){
                        $id = mb_convert_case($widget, MB_CASE_LOWER, "UTF-8");
                        $id = str_replace(" ", "", $id);
                        $widgets[$id] = $widget;
                    }
                    return $widgets;
                }
            }

            return $widgets;

        }
    }
}

MetaboxSidebar::instance();
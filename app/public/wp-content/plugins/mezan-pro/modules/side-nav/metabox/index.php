<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MetaboxSideNav' ) ) {
    class MetaboxSideNav {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'cs_metabox_options', array( $this, 'sidenav' ) );
        }

        function sidenav( $options ) {
            $options[] = array(
                'id'        => '_mezan_sidenav_settings',
                'title'     => esc_html('Side Navigation Template', 'mezan-pro'),
                'post_type' => 'page',
                'context'   => 'advanced',
                'priority'  => 'high',
                'sections'  => array(
                    array(
                        'name'   => 'sidenav_section',
                        'fields' => array(
                            array(
                                'id'      => 'sidenav-tpl-notice',
                                'type'    => 'notice',
                                'class'   => 'success',
                                'content' => esc_html__('Side Navigation Tab Works only if page template set to Side Navigation Template in Page Attributes','mezan-pro'),
                                'class'   => 'margin-30 cs-success'
                            ),
                            array(
                                'id'      => 'style',
                                'type'    => 'select',
                                'title'   => esc_html__('Side Navigation Style', 'mezan-pro' ),
                                'options' => array(
                                    'type1' => esc_html__('Type1','mezan-pro'),
                                    'type2' => esc_html__('Type2','mezan-pro'),
                                    'type3' => esc_html__('Type3','mezan-pro'),
                                    'type4' => esc_html__('Type4','mezan-pro'),
                                    'type5' => esc_html__('Type5','mezan-pro')
                                ),
                            ),
                            array(
                                'id'    => 'icon_prefix',
                                'type'  => 'image',
                                'title' => esc_html__('Icon Prefix', 'mezan-pro' ),
                                'info'  => esc_html__('You can choose image here which will be displayed along with your title','mezan-pro'),
                                'dependency' => array( 'style', '==', 'type4' )
                            ),
                            array(
                                'id'    => 'align',
                                'type'  => 'switcher',
                                'title' => esc_html__('Align Right', 'mezan-pro' ),
                                'info'  => esc_html__('YES! to align right of side navigation.','mezan-pro')
                            ),
                            array(
                                'id'    => 'sticky',
                                'type'  => 'switcher',
                                'title' => esc_html__('Sticky Side Navigation', 'mezan-pro' ),
                                'info'  => esc_html__('YES! to sticky side navigation content.','mezan-pro')
                            ),
                            array(
                                'id'    => 'show_content',
                                'type'  => 'switcher',
                                'title' => esc_html__('Show Content', 'mezan-pro' ),
                                'info'  => esc_html__('YES! to show content in below side navigation.','mezan-pro')
                            ),
                            array(
                                'id'         => 'content',
                                'type'       => 'select',
                                'title'      => esc_html__('Content', 'mezan-pro' ),
                                'options'    => $this->elementor_library_list(),
                                'dependency' => array( 'show_content', '==', 'true' ),
                            ),
                            array(
                                'id'    => 'show_bottom_content',
                                'type'  => 'switcher',
                                'title' => esc_html__('Show Bottom Content', 'mezan-pro' ),
                                'info'  => esc_html__('YES! to show content at very bottom of side navigation tempalte page.','mezan-pro')
                            ),
                            array(
                                'id'         => 'bottom_content',
                                'type'       => 'select',
                                'title'      => esc_html__('Bottom Content', 'mezan-pro' ),
                                'options'    => $this->elementor_library_list(),
                                'dependency' => array( 'show_bottom_content', '==', 'true' ),
                            ),
                        )
                    )
                )
            );

            return $options;
        }

        function elementor_library_list() {
            $pagelist = get_posts( array(
                'post_type' => 'elementor_library',
                'showposts' => -1,
            ));

            if ( ! empty( $pagelist ) && ! is_wp_error( $pagelist ) ) {

                foreach ( $pagelist as $post ) {
                    $options[ $post->ID ] = $post->post_title;
                }

                $options[0] = esc_html__('Select Elementor Library', 'mezan-pro');
                asort($options);

                return $options;
            }
        }

    }
}

MetaboxSideNav::instance();
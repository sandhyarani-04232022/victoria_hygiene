<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Woo_Listing_Option_Hover_Secondary_Image_Effect' ) ) {

    class Mezan_Woo_Listing_Option_Hover_Secondary_Image_Effect extends Mezan_Woo_Listing_Option_Core {

        private static $_instance = null;

        public $option_slug;

        public $option_name;

        public $option_type;

        public $option_default_value;

        public $option_value_prefix;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->option_slug          = 'product-hover-secondary-image-effect';
            $this->option_name          = esc_html__('Hover Secondary Image Effect', 'mezan');
            $this->option_default_value = 'product-hover-secimage-fade';
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_value_prefix  = 'product-hover-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'mezan_woo_custom_product_template_hover_options', array( $this, 'woo_custom_product_template_hover_options'), 15, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_hover_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'hover';
        }

        /**
         * Setting Args
         */
        function setting_args() {
            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'select';
            $settings['title']   =  $this->option_name;
            $settings['options'] =  array (
                'product-hover-secimage-fade'         => esc_html__('Fade', 'mezan'),
                'product-hover-secimage-zoomin'       => esc_html__('Zoom In', 'mezan'),
                'product-hover-secimage-zoomout'      => esc_html__('Zoom Out', 'mezan'),
                'product-hover-secimage-zoomoutup'    => esc_html__('Zoom Out Up', 'mezan'),
                'product-hover-secimage-zoomoutdown'  => esc_html__('Zoom Out Down', 'mezan'),
                'product-hover-secimage-zoomoutleft'  => esc_html__('Zoom Out Left', 'mezan'),
                'product-hover-secimage-zoomoutright' => esc_html__('Zoom Out Right', 'mezan'),
                'product-hover-secimage-pushup'       => esc_html__('Push Up', 'mezan'),
                'product-hover-secimage-pushdown'     => esc_html__('Push Down', 'mezan'),
                'product-hover-secimage-pushleft'     => esc_html__('Push Left', 'mezan'),
                'product-hover-secimage-pushright'    => esc_html__('Push Right', 'mezan'),
                'product-hover-secimage-slideup'      => esc_html__('Slide Up', 'mezan'),
                'product-hover-secimage-slidedown'    => esc_html__('Slide Down', 'mezan'),
                'product-hover-secimage-slideleft'    => esc_html__('Slide Left', 'mezan'),
                'product-hover-secimage-slideright'   => esc_html__('Slide Right', 'mezan'),
                'product-hover-secimage-hingeup'      => esc_html__('Hinge Up', 'mezan'),
                'product-hover-secimage-hingedown'    => esc_html__('Hinge Down', 'mezan'),
                'product-hover-secimage-hingeleft'    => esc_html__('Hinge Left', 'mezan'),
                'product-hover-secimage-hingeright'   => esc_html__('Hinge Right', 'mezan'),
                'product-hover-secimage-foldup'       => esc_html__('Fold Up', 'mezan'),
                'product-hover-secimage-folddown'     => esc_html__('Fold Down', 'mezan'),
                'product-hover-secimage-foldleft'     => esc_html__('Fold Left', 'mezan'),
                'product-hover-secimage-foldright'    => esc_html__('Fold Right', 'mezan'),
                'product-hover-secimage-fliphoriz'    => esc_html__('Flip Horizontal', 'mezan'),
                'product-hover-secimage-flipvert'     => esc_html__('Flip Vertical', 'mezan')
            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('mezan_woo_listing_option_hover_secondary_image_effect') ) {
	function mezan_woo_listing_option_hover_secondary_image_effect() {
		return Mezan_Woo_Listing_Option_Hover_Secondary_Image_Effect::instance();
	}
}

mezan_woo_listing_option_hover_secondary_image_effect();
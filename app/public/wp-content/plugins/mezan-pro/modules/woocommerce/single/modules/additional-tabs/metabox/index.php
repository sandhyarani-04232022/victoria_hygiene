<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Shop_Metabox_Single_Additional_Tabs' ) ) {
    class Mezan_Shop_Metabox_Single_Additional_Tabs {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'mezan_shop_product_custom_settings', array( $this, 'mezan_shop_product_custom_settings' ), 10 );
        }

        function mezan_shop_product_custom_settings( $options ) {

			$elementor_template_args = array (
				'numberposts' => -1,
				'post_type'   => 'elementor_library',
				'fields'      => 'ids'
			);

			$elementor_templates_arr = get_posts ($elementor_template_args);

			$elementor_templates = array ( '' => esc_html__('None', 'mezan-pro'), 'custom-description' => esc_html__('Custom Description', 'mezan-pro') );
			foreach($elementor_templates_arr as $elementor_template) {
				$elementor_templates[$elementor_template] = get_the_title($elementor_template);
			}

			$product_options = array (

				array (
					'id'              => 'product-additional-tabs',
					'type'            => 'group',
					'title'           => esc_html__('Additional Tabs', 'mezan-pro'),
					'info'            => esc_html__('Click button to add title and description.', 'mezan-pro'),
					'button_title'    => esc_html__('Add New Tab', 'mezan-pro'),
					'accordion_title' => esc_html__('Adding New Tab Field', 'mezan-pro'),
					'fields'          => array (

						array (
							'id'          => 'tab_title',
							'type'        => 'text',
							'title'       => esc_html__('Title', 'mezan-pro'),
						),

						array (
							'id'         => 'tab_description',
							'type'       => 'select',
							'title'      => esc_html__('Description', 'mezan-pro'),
							'options'    => $elementor_templates,
							'info'       => esc_html__('Choose "Elementor Templates" here to use for "Description", if you choose "Custom Description" option you can provide your own content below.', 'mezan-pro'),
							'attributes' => array ( 'data-depend-id' => 'tab_description' )
						),

						array (
							'id'         => 'tab_custom_description',
							'type'       => 'textarea',
							'title'      => esc_html__('Custom Description', 'mezan-pro'),
							'dependency' => array ( 'tab_description', '==', 'custom-description' )
						)

					)
				)

			);

			$options = array_merge( $options, $product_options );

			return $options;

		}

    }
}

Mezan_Shop_Metabox_Single_Additional_Tabs::instance();
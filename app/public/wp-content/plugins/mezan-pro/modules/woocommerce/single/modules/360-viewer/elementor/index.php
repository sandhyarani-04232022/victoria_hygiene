<?php

/**
 * WooCommerce - Elementor Single Widgets Core Class
 */

namespace MezanElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Mezan_Shop_Elementor_Single_360_Viewer_Widgets {

	/**
	 * A Reference to an instance of this class
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	function __construct() {

		$this->mezan_shop_load_modules();

		add_action( 'mezan_shop_register_widgets', array( $this, 'mezan_shop_register_widgets' ), 10, 1 );

		add_action( 'mezan_shop_register_widget_styles', array( $this, 'mezan_shop_register_widget_styles' ), 10, 1 );
		add_action( 'mezan_shop_register_widget_scripts', array( $this, 'mezan_shop_register_widget_scripts' ), 10, 1 );

		add_action( 'mezan_shop_preview_styles', array( $this, 'mezan_shop_preview_styles') );

	}

	/**
	 * Init
	 */
	function mezan_shop_load_modules() {

		require mezan_shop_single_module_360_viewer()->module_dir_path() . 'elementor/utils.php';

	}

	/**
	 * Register widgets
	 */
	function mezan_shop_register_widgets( $widgets_manager ) {

		require mezan_shop_single_module_360_viewer()->module_dir_path() . 'elementor/widgets/360-image-viewer/class-product-360-image-viewer.php';
		$widgets_manager->register( new Mezan_Shop_Widget_Product_360_Image_Viewer() );

	}

	/**
	 * Register widgets styles
	 */
	function mezan_shop_register_widget_styles( $suffix ) {


		# 360 Image Viewer

			wp_register_style( 'wdt-shop-product-single-images-360-viewer',
				mezan_shop_single_module_360_viewer()->module_dir_url() . 'elementor/widgets/360-image-viewer/assets/css/style'.$suffix.'.css',
				array()
			);

	}

	/**
	 * Register widgets scripts
	 */
	function mezan_shop_register_widget_scripts( $suffix ) {

		# 360 Image Viewer

			wp_register_script( 'jquery-360viewer',
				mezan_shop_single_module_360_viewer()->module_dir_url() . 'elementor/widgets/360-image-viewer/assets/js/360-viewer'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

			wp_register_script( 'wdt-shop-product-single-images-360-viewer',
				mezan_shop_single_module_360_viewer()->module_dir_url() . 'elementor/widgets/360-image-viewer/assets/js/script'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

	}

	/**
	 * Editor Preview Style
	 */
	function mezan_shop_preview_styles() {

		# 360 Image Viewer
			wp_enqueue_style( 'wdt-shop-product-single-images-360-viewer' );

	}

}

Mezan_Shop_Elementor_Single_360_Viewer_Widgets::instance();
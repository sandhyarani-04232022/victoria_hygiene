<?php

/**
 * WooCommerce - Elementor Search Widgets Core Class
 */

namespace MezanElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Mezan_Shop_Elementor_Search_Widgets {

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

		add_action( 'mezan_shop_register_widgets', array( $this, 'mezan_shop_register_widgets' ), 10, 1 );

		add_action( 'mezan_shop_register_widget_styles', array( $this, 'mezan_shop_register_widget_styles' ), 10, 1 );
		add_action( 'mezan_shop_register_widget_scripts', array( $this, 'mezan_shop_register_widget_scripts' ), 10, 1 );

		add_action( 'mezan_shop_preview_styles', array( $this, 'mezan_shop_preview_styles') );

	}

	/**
	 * Register widgets
	 */
	function mezan_shop_register_widgets( $widgets_manager ) {

		require mezan_shop_others_search()->module_dir_path() . 'elementor/widgets/product-search/class-product-search.php';
		$widgets_manager->register( new Mezan_Shop_Widget_Product_Search() );

	}

	/**
	 * Register widgets styles
	 */
	function mezan_shop_register_widget_styles( $suffix ) {

		# Product Search

			wp_register_style( 'wdt-shop-product-search',
				mezan_shop_others_search()->module_dir_url() . 'elementor/widgets/product-search/assets/css/style'.$suffix.'.css',
				array()
			);

	}

	/**
	 * Register widgets scripts
	 */
	function mezan_shop_register_widget_scripts( $suffix ) {


	}

	/**
	 * Editor Preview Style
	 */
	function mezan_shop_preview_styles() {

		# Product Search
			wp_enqueue_style( 'wdt-shop-product-search-chosen' );
			wp_enqueue_style( 'wdt-shop-product-search' );

	}

}

Mezan_Shop_Elementor_Search_Widgets::instance();
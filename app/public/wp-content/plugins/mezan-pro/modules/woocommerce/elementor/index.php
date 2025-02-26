<?php

/**
 * WooCommerce - Elementor Core Class
 */

namespace MezanElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Mezan_Pro_Elementor {

	/**
	 * A Reference to an instance of this class
	 */
	private static $_instance = null;

	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	const MINIMUM_PHP_VERSION = '7.2';

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
	public function __construct() {

		$this->load_modules();

	}

	/**
	 * Requirement Verification
	 */
	public function load_modules() {

		add_action( 'elementor/elements/categories_registered', array( $this, 'mezan_shop_register_category' ) );

		add_action( 'elementor/widgets/register', array( $this, 'mezan_shop_register_widgets' ) );

		add_action( 'elementor/frontend/after_register_styles', array( $this, 'mezan_shop_register_widget_styles' ) );
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'mezan_shop_register_widget_scripts' ) );

		add_action( 'elementor/preview/enqueue_styles', array( $this, 'mezan_shop_preview_styles') );
		add_action( 'elementor/preview/enqueue_scripts', array( $this, 'mezan_shop_preview_scripts') );

	}

	/**
	 * Register category
	 * Add plugin category in elementor
	 */
	public function mezan_shop_register_category( $elements_manager ) {

		$elements_manager->add_category(
			'wdt-shop-widgets', array(
				'title' => esc_html__( 'Mezan Shop', 'mezan-pro' ),
				'icon'  => 'font'
			)
		);

	}

	/**
	 * Register Mezan widgets
	 */
	public function mezan_shop_register_widgets( $widgets_manager ) {

		do_action( 'mezan_shop_register_widgets', $widgets_manager );

	}

	/**
	 * Register Mezan widgets styles
	 */
	public function mezan_shop_register_widget_styles() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '';

		do_action( 'mezan_shop_register_widget_styles', $suffix );

	}

	/**
	 * Register Mezan widgets scripts
	 */
	public function mezan_shop_register_widget_scripts() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '';

		do_action( 'mezan_shop_register_widget_scripts', $suffix );

	}

	/**
	 * Editor Preview Style
	 */
	public function mezan_shop_preview_styles() {

		do_action( 'mezan_shop_preview_styles' );

	}

	/**
	 * Editor Preview Scripts
	 */
	public function mezan_shop_preview_scripts() {

		do_action( 'mezan_shop_preview_scripts' );

	}

}

Mezan_Pro_Elementor::instance();
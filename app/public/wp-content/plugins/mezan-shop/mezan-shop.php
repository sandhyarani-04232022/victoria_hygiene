<?php
/**
 * Plugin Name:	Mezan Shop
 * Description: Adds shop features for Mezan Theme.
 * Version: 1.0.0
 * Author: the WeDesignTech team
 * Author URI: https://wedesignthemes.com/
 * Text Domain: mezan-shop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The main class that initiates and runs the plugin.
 */
final class Mezan_Shop {

	/**
	 * Instance variable
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
	public function __construct() {

		add_action( 'init', array( $this, 'mezan_shop_i18n' ) );
		add_filter( 'mezan_required_plugins_list', array( $this, 'upadate_required_plugins_list' ) );
		add_action( 'plugins_loaded', array( $this, 'mezan_shop_plugins_loaded' ) );

	}

	/**
	 * Load Textdomain
	 */
		public function mezan_shop_i18n() {

			load_plugin_textdomain( 'mezan-shop', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

	/**
	 * Update required plugins list
	 */
		function upadate_required_plugins_list($plugins_list) {

            $required_plugins = array(
                array(
                    'name'				=> 'WooCommerce',
                    'slug'				=> 'woocommerce',
                    'required'			=> true,
                    'force_activation'	=> false,
                )
            );
            $new_plugins_list = array_merge($plugins_list, $required_plugins);

            return $new_plugins_list;

        }

	/**
	 * Initialize the plugin
	 */
		public function mezan_shop_plugins_loaded() {

			// Check for WooCommerce plugin
				if( !function_exists( 'is_woocommerce' ) ) {
					add_action( 'admin_notices', array( $this, 'mezan_shop_woo_plugin_req' ) );
					return;
				}

			// Check for Mezan Theme plugin
				if( !function_exists( 'mezan_pro' ) ) {
					add_action( 'admin_notices', array( $this, 'mezan_shop_dttheme_plugin_req' ) );
					return;
				}

			// Setup Constants
				$this->mezan_shop_setup_constants();

			// Load Modules & Helper
				$this->mezan_shop_load_modules();
                $this->load_helper();

			// Locate Module Files
				add_filter( 'mezan_woo_pro_locate_file',  array( $this, 'mezan_woo_pro_shop_locate_file' ), 10, 2 );

			// Load WooCommerce Template Files
				add_filter( 'woocommerce_locate_template',  array( $this, 'mezan_shop_woocommerce_locate_template' ), 30, 3 );

		}


	/**
	 * Admin notice
	 * Warning when the site doesn't have WooCommerce plugin.
	 */
		public function mezan_shop_woo_plugin_req() {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: Required plugin name */
				esc_html__( '"%1$s" requires "%2$s" plugin to be installed and activated.', 'mezan-shop' ),
				'<strong>' . esc_html__( 'Mezan Shop', 'mezan-shop' ) . '</strong>',
				'<strong>' . esc_html__( 'WooCommerce - excelling eCommerce', 'mezan-shop' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

	/**
	 * Admin notice
	 * Warning when the site doesn't have Mezan Theme plugin.
	 */
		public function mezan_shop_dttheme_plugin_req() {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: Required plugin name */
				esc_html__( '"%1$s" requires "%2$s" plugin to be installed and activated.', 'mezan-shop' ),
				'<strong>' . esc_html__( 'Mezan Shop', 'mezan-shop' ) . '</strong>',
				'<strong>' . esc_html__( 'Mezan Pro', 'mezan-shop' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

	/**
	 * Define constant if not already set.
	 */
		public function mezan_shop_define_constants( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

	/**
	 * Configure Constants
	 */
		public function mezan_shop_setup_constants() {

			$this->mezan_shop_define_constants( 'MEZAN_SHOP_VERSION', '1.0' );
			$this->mezan_shop_define_constants( 'MEZAN_SHOP_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
			$this->mezan_shop_define_constants( 'MEZAN_SHOP_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
			$this->mezan_shop_define_constants( 'MEZAN_SHOP_NAME', esc_html__('Mezan Shop', 'mezan-shop') );

			$this->mezan_shop_define_constants( 'MEZAN_SHOP_MODULE_PATH', trailingslashit( MEZAN_SHOP_PATH . 'modules' ) );
			$this->mezan_shop_define_constants( 'MEZAN_SHOP_MODULE_URL', trailingslashit( MEZAN_SHOP_URL . 'modules' ) );

		}

	/**
	 * Load Modules
	 */
		public function mezan_shop_load_modules() {

			foreach( glob( MEZAN_SHOP_MODULE_PATH. '*/index.php' ) as $module ) {
				include_once $module;
			}

		}

	/**
	 * Locate Module Files
	 */
		public function mezan_woo_pro_shop_locate_file( $file_path, $module ) {

			$file_path = MEZAN_SHOP_PATH . 'modules/' . $module .'.php';

			$located_file_path = false;
			if ( $file_path && file_exists( $file_path ) ) {
				$located_file_path = $file_path;
			}

			return $located_file_path;

		}

	/**
	 * Override WooCommerce default template files
	 */
		public function mezan_shop_woocommerce_locate_template( $template, $template_name, $template_path ) {

			global $woocommerce;

			$_template = $template;

			if ( ! $template_path ) $template_path = $woocommerce->template_url;

			$plugin_path  = MEZAN_SHOP_PATH . 'templates/';

			// Look within passed path within the theme - this is priority
			$template = locate_template(
				array(
					$template_path . $template_name,
					$template_name
				)
			);

			// Modification: Get the template from this plugin, if it exists
			if ( ! $template && file_exists( $plugin_path . $template_name ) )
			$template = $plugin_path . $template_name;

			// Use default template
			if ( ! $template )
			$template = $_template;

			// Return what we found
			return $template;

		}

	/**
	 * Load helper
	 */
        function load_helper() {
            require_once MEZAN_SHOP_PATH . 'functions.php';
        }

}

if( !function_exists('mezan_shop_instance') ) {
	function mezan_shop_instance() {
		return Mezan_Shop::instance();
	}
}

mezan_shop_instance();
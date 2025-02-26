<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusSiteLoader' ) ) {
    class MezanPlusSiteLoader {

        private static $_instance = null;

        private $show_site_loader = false;
        private $site_loader = '';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->show_site_loader = mezan_customizer_settings( 'show_site_loader' );
            $this->site_loader = mezan_customizer_settings( 'site_loader' );
            $this->load_loader_layouts();
            $this->load_modules();
            $this->frontend();
        }

        function load_loader_layouts() {
            foreach( glob( MEZAN_PLUS_DIR_PATH. 'modules/site-loader/layouts/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function load_modules() {
            include_once MEZAN_PLUS_DIR_PATH.'modules/site-loader/customizer/index.php';
        }

        function frontend() {
            if( $this->show_site_loader ) {
                add_action( 'mezan_after_main_css', array( $this, 'enqueue_assets' ) );
                add_action( 'mezan_hook_top', array( $this, 'load_template' ) );
            }
        }

        function enqueue_assets() {
            if($this->show_site_loader) {
                if(in_array($this->site_loader, array ('loader-1', 'loader-2', 'custom-loader'))) {
                    wp_enqueue_script( 'site-loader', MEZAN_PLUS_DIR_URL . 'modules/site-loader/assets/js/site-loader.js', array('jquery'), MEZAN_PLUS_VERSION, true );
                }
            }
        }

        function load_template() {
            if($this->show_site_loader) {
                if(in_array($this->site_loader, array ('loader-1', 'loader-2', 'custom-loader'))) {
                    echo mezan_get_template_part( 'site-loader/layouts/'.esc_attr($this->site_loader), '/template', '', array() );
                }
            }
        }

    }
}

MezanPlusSiteLoader::instance();

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusCustomJS' ) ) {
    class MezanPlusCustomJS {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
            $this->frontend();
        }

        function load_modules() {
            include_once MEZAN_PLUS_DIR_PATH.'modules/add-js/customizer/index.php';
        }

        function frontend() {
            $js = mezan_customizer_settings('additional_js');
            if( !empty( $js ) ) {
                add_action( 'wp_footer', array( $this, 'load_js' ), 9999 );
            }
        }

        function load_js(){
            $js = mezan_customizer_settings('additional_js');
            echo '<!-- customizer additional_js -->';
                echo '<script type="text/javascript">'.esc_js($js).'</script>';
            echo '<!-- customizer additional_js -->';
        }

    }
}

MezanPlusCustomJS::instance();
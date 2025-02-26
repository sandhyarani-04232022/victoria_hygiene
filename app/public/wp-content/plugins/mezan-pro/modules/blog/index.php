<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanProSiteBlog' ) ) {
    class MezanProSiteBlog extends MezanPlusSiteBlog {

        private static $_instance = null;
        public $element_position = array();

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_widgets();
            add_action( 'mezan_after_main_css', array( $this, 'enqueue_css_assets' ), 20 );
            add_filter('blog_post_grid_list_style_update', array( $this, 'blog_post_grid_list_style_update' ));
            add_filter('blog_post_cover_style_update', array( $this, 'blog_post_cover_style_update' ));
        }

        function enqueue_css_assets() {
            wp_enqueue_style( 'mezan-pro-blog', MEZAN_PRO_DIR_URL . 'modules/blog/assets/css/blog.css', false, MEZAN_PRO_VERSION, 'all');

            $post_style = mezan_get_archive_post_style();
            $file_path = MEZAN_PRO_DIR_PATH . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css';
            if ( file_exists( $file_path ) ) {
                wp_enqueue_style( 'wdt-blog-archive-'.esc_attr($post_style), MEZAN_PRO_DIR_URL . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css', false, MEZAN_PRO_VERSION, 'all');
            }

        }

        function load_widgets() {
            add_action( 'widgets_init', array( $this, 'register_widgets_init' ) );
        }

        function register_widgets_init() {
            include_once MEZAN_PRO_DIR_PATH.'modules/blog/widget/widget-recent-posts.php';
            register_widget('Mezan_Widget_Recent_Posts');
        }

        function blog_post_grid_list_style_update($list) {

            $pro_list = array (
                'wdt-simple'        => esc_html__('Simple', 'mezan-pro'),
                'wdt-overlap'       => esc_html__('Overlap', 'mezan-pro'),
                'wdt-thumb-overlap' => esc_html__('Thumb Overlap', 'mezan-pro'),
                'wdt-minimal'       => esc_html__('Minimal', 'mezan-pro'),
                'wdt-fancy-box'     => esc_html__('Fancy Box', 'mezan-pro'),
                'wdt-bordered'      => esc_html__('Bordered', 'mezan-pro'),
                'wdt-magnificent'   => esc_html__('Magnificent', 'mezan-pro')
            );

            return array_merge( $list, $pro_list );

        }

        function blog_post_cover_style_update($list) {

            $pro_list = array ();
            return array_merge( $list, $pro_list );

        }

    }
}

MezanProSiteBlog::instance();

if( !class_exists( 'MezanProSiteRelatedBlog' ) ) {
    class MezanProSiteRelatedBlog extends MezanProSiteBlog {
        function __construct() {}
    }
}
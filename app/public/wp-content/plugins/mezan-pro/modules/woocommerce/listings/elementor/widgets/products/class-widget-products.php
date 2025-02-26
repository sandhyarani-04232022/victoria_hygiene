<?php
namespace MezanElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Mezan_Shop_Widget_Products extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-products';
	}

	public function get_title() {
		return esc_html__( 'Products', 'mezan-pro' );
	}

	public function get_style_depends() {
		return array( 'css-swiper', 'wdt-shop-products-carousel', 'wdt-shop-products' );
	}

	public function get_script_depends() {
		return array( 'jquery-swiper', 'isotope-pkgd', 'wdt-shop-products' );
	}

	public function product_cats() {

		$categories = get_categories( array(
			'hide_empty' =>  0,
			'taxonomy'   =>  'product_cat'
		) );

		$categories_array = array ();

		foreach( $categories as $category ){
			$categories_array[ $category->term_id  ] = $category->name;
		}

		return $categories_array;
	}

	public function product_tags() {

		$tags = get_categories( array(
			'hide_empty' =>  0,
			'taxonomy'   =>  'product_tag'
		) );

		$tags_array = array ();

		foreach( $tags as $tag ){

			$tags_array[ $tag->term_id ] = $tag->name;
		}

		return $tags_array;
	}

	public function product_posts() {

		$product_posts = get_posts( array(
			'posts_per_page' => -1,
			'post_type'      => 'product'
		) );

		$product_title_array = array ();

		foreach($product_posts as $product_post){
			$product_title_array[ $product_post->ID ] = $product_post->post_title;
		}

		return $product_title_array;
	}

	public function product_style_templates() {

		$product_templates_list = array ();
		$product_templates_list[-1] = esc_html__('Admin Option', 'mezan-pro');

		$cs_options = get_option( CS_OPTION );

		if( is_array( $cs_options ) && !empty( $cs_options ) ) {
			foreach( $cs_options as $cs_option_key => $cs_option ) {

				if( strpos($cs_option_key, 'mezan-woo-product-style-template-') !== false ) {

					$product_templates_list[str_replace('mezan-woo-product-style-template-', 'predefined-template-', $cs_option_key)] = $cs_option[0]['product-template-id'];

				} else if( strpos($cs_option_key, 'mezan-woo-product-style-templates') !== false ) {

					if( is_array( $cs_option ) && !empty( $cs_option ) ) {
						foreach( $cs_option as $cs_custom_option_key => $cs_custom_option ) {
							$product_templates_list['custom-template-'.$cs_custom_option_key] = $cs_custom_option['product-template-id'];
						}
					}

				}

			}
		}

		return $product_templates_list;

	}

	protected function register_controls() {

		$this->general_section();
		$this->filter_section();
		$this->carousel_section();
	}

	public function general_section() {

		$this->start_controls_section( 'products_section', array(
			'label' => esc_html__( 'General', 'mezan-pro' ),
		) );

			$this->add_control( 'data_source', array(
				'label'       => esc_html__( 'Data Source', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''           => esc_html__('All Products', 'mezan-pro'),
					'featured'   => esc_html__('Featured Products', 'mezan-pro'),
					'recent'     => esc_html__('Recent Products', 'mezan-pro'),
					'sale'       => esc_html__('Sale Products', 'mezan-pro'),
					'bestseller' => esc_html__('Bestsellers', 'mezan-pro'),
				),
	        ) );

			$this->add_control( 'show_pagination', array(
				'label'        => esc_html__( 'Show Pagination', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'True', 'mezan-pro' ),
				'label_off'    => esc_html__( 'False', 'mezan-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'apply_isotope', array(
				'label'        => esc_html__( 'Apply Isotope', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'True', 'mezan-pro' ),
				'label_off'    => esc_html__( 'False', 'mezan-pro' ),
				'default'      => '',
				'return_value' => 'true',
				'condition'   => array(),
			) );

			$this->add_control( 'enable_carousel', array(
				'label'        => esc_html__( 'Enable Carousel', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'True', 'mezan-pro' ),
				'label_off'    => esc_html__( 'False', 'mezan-pro' ),
				'default'      => '',
				'return_value' => 'true',
				'condition'   => array( 'show_pagination' => '', 'apply_isotope' => '' ),
			) );

			$this->add_control( 'post_per_page', array(
				'label'   => esc_html__( 'Post Per Page', 'mezan-pro' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 12
			) );

			$this->add_control( 'display_mode', array(
				'label'       => esc_html__( 'Display Mode', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'grid' => esc_html__('Grid', 'mezan-pro'),
					'list' => esc_html__('List', 'mezan-pro'),
				),
				'default'     => 'grid',
	        ) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
				'default'     => 4,
				'condition'   => array(),
	        ) );

			$this->add_control( 'list_options', array(
				'label'       => esc_html__( 'List Options', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'left-thumb'  => esc_html__('Left Thumb', 'mezan-pro'),
					'right-thumb' => esc_html__('Right Thumb', 'mezan-pro'),
				),
				'default'     => 'left-thumb',
				'condition'   => array( 'display_mode' => 'list' ),
	        ) );

			$this->add_control( 'product_style_template', array(
				'label'       => esc_html__( 'Product Style Template', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose number of products that you like to display.', 'mezan-pro' ),
				'options'     => $this->product_style_templates(),
				'default'     => '-1',
	        ) );

			$this->add_control(
				'class',
				array (
					'label' => esc_html__( 'Class', 'mezan-pro' ),
					'type'  => Controls_Manager::TEXT
				)
			);

			$this->add_control(
				'current_page',
				array (
					'label' => esc_html__( 'Current Page', 'mezan-pro' ),
					'type'  => Controls_Manager::HIDDEN,
					'default' => 1
				)
			);

			$this->add_control(
				'offset',
				array (
					'label' => esc_html__( 'Offset', 'mezan-pro' ),
					'type'  => Controls_Manager::HIDDEN,
					'default' => 0
				)
			);

		$this->end_controls_section();

	}

	public function filter_section() {

		$this->start_controls_section( 'filter_section', array(
			'label' => esc_html__( 'Filters', 'mezan-pro' ),
		) );

			$this->add_control( 'categories', array(
				'label'       => esc_html__( 'Categories', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'description' => esc_html__( 'Choose categories that you want to display.', 'mezan-pro' ),
				'options'     => $this->product_cats(),
	        ) );

			$this->add_control( 'tags', array(
				'label'       => esc_html__( 'Tags', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'description' => esc_html__( 'Choose tags that you want to display.', 'mezan-pro' ),
				'options'     => $this->product_tags(),
	        ) );

			$this->add_control( 'include', array(
				'label'       => esc_html__( 'Include', 'mezan-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Choose product that you want to display.', 'mezan-pro' ),
	        ) );

			$this->add_control( 'exclude', array(
				'label'       => esc_html__( 'Exclude', 'mezan-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Choose product that you don\'t want to display.', 'mezan-pro' ),
	        ) );

		$this->end_controls_section();

	}

	public function carousel_section() {

		$this->start_controls_section( 'product_carousel_section', array(
			'label'     => esc_html__( 'Carousel Settings', 'mezan-pro' ),
			'condition' => array( 'enable_carousel' => 'true' ),
		) );
			$this->add_control( 'carousel_effect', array(
				'label'       => esc_html__( 'Effect', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'mezan-pro' ),
				'default'     => '',
				'options'     => array(
					''     => esc_html__( 'Default', 'mezan-pro' ),
					'fade' => esc_html__( 'Fade', 'mezan-pro' ),
					'multirow' => esc_html__( 'Multi Row', 'mezan-pro' ),
	            ),
	        ) );

			$this->add_responsive_control( 'carousel_slidesperview', array(
				'label'       => esc_html__( 'Slides Per View', 'luvly-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show in view port.', 'luvly-pro' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6 ),
				'desktop_default'      => 4,
				'laptop_default'       => 4,
				'tablet_default'       => 2,
				'tablet_extra_default' => 2,
				'mobile_default'       => 1,
				'mobile_extra_default' => 1,
				'frontend_available'   => true,
				'condition'   => array( 'carousel_effect' => array ( '', 'multirow' ) ),
	        ) );

			$this->add_control( 'carousel_slidespercolumn', array(
				'label'       => esc_html__( 'Slides Per Column', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show per column.', 'mezan-pro' ),
				'options'     => array( 2 => 2, 3 => 3 ),
				'default'     => 2,
				'condition'   => array( 'carousel_effect' => array ('multirow' ) ),
	        ) );

			$this->add_control( 'carousel_loopmode', array(
				'label'        => esc_html__( 'Enable Loop Mode', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable continuous loop mode for your carousel.', 'mezan-pro'),
				'label_on'     => esc_html__( 'yes', 'mezan-pro' ),
				'label_off'    => esc_html__( 'no', 'mezan-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_mousewheelcontrol', array(
				'label'        => esc_html__( 'Enable Mousewheel Control', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable mouse wheel control for your carousel.', 'mezan-pro'),
				'label_on'     => esc_html__( 'yes', 'mezan-pro' ),
				'label_off'    => esc_html__( 'no', 'mezan-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_bulletpagination', array(
				'label'        => esc_html__( 'Enable Bullet Pagination', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable bullet pagination.', 'mezan-pro'),
				'label_on'     => esc_html__( 'yes', 'mezan-pro' ),
				'label_off'    => esc_html__( 'no', 'mezan-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_arrowpagination', array(
				'label'        => esc_html__( 'Enable Arrow Pagination', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable arrow pagination.', 'mezan-pro'),
				'label_on'     => esc_html__( 'yes', 'mezan-pro' ),
				'label_off'    => esc_html__( 'no', 'mezan-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_arrowpagination_type', array(
				'label'       => esc_html__( 'Arrow Type', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose arrow pagination type for your carousel.', 'mezan-pro' ),
				'options'     => array(
					''      => esc_html__('Default', 'mezan-pro'),
					'type2' => esc_html__('Type 2', 'mezan-pro'),
				),
				'condition'   => array( 'carousel_arrowpagination' => 'true' ),
				'default'     => '',
	        ) );

			$this->add_control( 'carousel_scrollbar', array(
				'label'        => esc_html__( 'Enable Scrollbar', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable scrollbar for your carousel.', 'mezan-pro'),
				'label_on'     => esc_html__( 'yes', 'mezan-pro' ),
				'label_off'    => esc_html__( 'no', 'mezan-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_spacebetween', array(
				'label'       => esc_html__( 'Space Between Sliders', 'mezan-pro' ),
				'type'        => Controls_Manager::HIDDEN,
				'description' => esc_html__('Space between sliders can be given here.', 'mezan-pro'),
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$settings['module_id'] = $this->get_id();
		$output = mezan_shop_products_render_html($settings);

		echo $output;

	}

}
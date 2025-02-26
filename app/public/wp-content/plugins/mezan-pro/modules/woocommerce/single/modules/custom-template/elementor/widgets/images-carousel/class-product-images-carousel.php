<?php
namespace MezanElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Mezan_Shop_Widget_Product_Images_Carousel extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-product-single-images-carousel';
	}

	public function get_title() {
		return esc_html__( 'Product Single - Images Carousel', 'mezan-pro' );
	}

	public function get_style_depends() {
		return array( 'css-swiper', 'wdt-shop-products-carousel', 'wdt-shop-product-single-images-carousel' );
	}

	public function get_script_depends() {
		return array( 'jquery-swiper', 'wdt-shop-product-single-images-carousel' );
	}

	protected function register_controls() {

		$this->product_section();
		$this->carousel_section();
	}

	public function product_section() {

		$this->start_controls_section( 'product_images_carousel_section', array(
			'label' => esc_html__( 'General', 'mezan-pro' ),
		) );

			$this->add_control( 'product_id', array(
				'label'       => esc_html__( 'Product Id', 'mezan-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Provide product id for which you have to display product iamges carousel. No need to provide ID if it is used in Product single page.', 'mezan-pro'),
			) );

			$this->add_control( 'include_featured_image', array(
				'label'        => esc_html__( 'Include Feature Image', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can include featured image in this gallery.', 'mezan-pro'),
				'label_on'     => esc_html__( 'yes', 'mezan-pro' ),
				'label_off'    => esc_html__( 'no', 'mezan-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'include_product_labels', array(
				'label'        => esc_html__( 'Include Product Labels', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can include product labels in this gallery.', 'mezan-pro'),
				'label_on'     => esc_html__( 'yes', 'mezan-pro' ),
				'label_off'    => esc_html__( 'no', 'mezan-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'enable_thumb_enlarger', array(
				'label'        => esc_html__( 'Enable Thumb Enlarger', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable thumbnail enlarger in this gallery.', 'mezan-pro'),
				'label_on'     => esc_html__( 'yes', 'mezan-pro' ),
				'label_off'    => esc_html__( 'no', 'mezan-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control(
				'class',
				array (
					'label' => esc_html__( 'Class', 'mezan-pro' ),
					'type'  => Controls_Manager::TEXT
				)
			);

		$this->end_controls_section();
	}

	public function carousel_section() {

		$this->start_controls_section( 'product_carousel_section', array(
			'label' => esc_html__( 'Carousel Settings', 'mezan-pro' ),
		) );

			$this->add_control( 'carousel_effect', array(
				'label'       => esc_html__( 'Effect', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'mezan-pro' ),
				'default'     => '',
				'options'     => array(
					''     => esc_html__( 'Default', 'mezan-pro' ),
					'fade' => esc_html__( 'Fade', 'mezan-pro' ),
	            ),
	        ) );

			$this->add_responsive_control( 'carousel_slidesperview', array(
				'label'       => esc_html__( 'Slides Per View', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show in view port.', 'mezan-pro' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
				'desktop_default'      => 4,
				'laptop_default'       => 4,
				'tablet_default'       => 2,
				'tablet_extra_default' => 2,
				'mobile_default'       => 1,
				'mobile_extra_default' => 1,
				'frontend_available'   => true,
				'condition'   => array( 'carousel_verticaldirection' => '' ),
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

			$this->add_control( 'carousel_verticaldirection', array(
				'label'        => esc_html__( 'Enable Vertical Direction', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To make your slides to navigate vertically.', 'mezan-pro'),
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

			$this->add_control( 'carousel_thumbnailpagination', array(
				'label'        => esc_html__( 'Enable Thumbnail Pagination', 'mezan-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable thumbnail pagination.', 'mezan-pro'),
				'label_on'     => esc_html__( 'yes', 'mezan-pro' ),
				'label_off'    => esc_html__( 'no', 'mezan-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_thumbnail_position', array(
				'label'       => esc_html__( 'Thumbnail Position', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show in view port.', 'mezan-pro' ),
				'options'     => array(
					''      => esc_html__('Bottom', 'mezan-pro'),
					'left'  => esc_html__('Left', 'mezan-pro'),
					'right' => esc_html__('Right', 'mezan-pro'),
				),
				'condition'   => array( 'carousel_thumbnailpagination' => 'true' ),
				'default'     => '',
	        ) );

			$this->add_control( 'carousel_slidesperview_thumbnail', array(
				'label'       => esc_html__( 'Number Of Images - Thumbnail', 'mezan-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number of images to show in thumbnails.', 'mezan-pro' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
				'condition'   => array( 'carousel_thumbnailpagination' => 'true' ),
				'default'     => '4',
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
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Space between sliders can be given here.', 'mezan-pro'),
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		$settings['module_id'] = $this->get_id();

		if($settings['product_id'] == '' && is_singular('product')) {
			global $post;
			$settings['product_id'] = $post->ID;
		}

		$slides_to_show = $settings['carousel_slidesperview'];
				$slides_to_scroll = 1;
		
				extract($settings);
					// Responsive control carousel
					$carousel_settings = array (
						'carousel_slidesperview' 			=> $slides_to_show
					);
			
					$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
					$breakpoint_keys = array_keys($active_breakpoints);
		
					$swiper_breakpoints = array ();
					$swiper_breakpoints[] = array (
						'breakpoint' => 319
					);
					$swiper_breakpoints_slides = array ();
					
					foreach($breakpoint_keys as $breakpoint) {
						$breakpoint_show_str = 'carousel_slidesperview_'.$breakpoint;
						$breakpoint_toshow = $$breakpoint_show_str;
						if($breakpoint_toshow == '') {
							if($breakpoint == 'mobile') {
								$breakpoint_toshow = 1;
							} else if($breakpoint == 'mobile_extra') {
								$breakpoint_toshow = 1;
							} else if($breakpoint == 'tablet') {
								$breakpoint_toshow = 2;
							} else if($breakpoint == 'tablet_extra') {
								$breakpoint_toshow = 2;
							} else if($breakpoint == 'laptop') {
								$breakpoint_toshow = 4;
							} else if($breakpoint == 'widescreen') {
								$breakpoint_toshow = 4;
							} else {
								$breakpoint_toshow = 4;
							}
						}

						$breakpoint_toscroll = 1;

						array_push($swiper_breakpoints, array (
								'breakpoint' => $active_breakpoints[$breakpoint]->get_value() + 1
							)
						);
						array_push($swiper_breakpoints_slides, array (
								'toshow' => (int)$breakpoint_toshow,
								'toscroll' => (int)$breakpoint_toscroll
							)
						);

					}

					array_push($swiper_breakpoints_slides, array (
							'toshow' => (int)$slides_to_show,
							'toscroll' => (int)$slides_to_scroll
						)
					);
		
					$responsive_breakpoints = array ();
		
					if(is_array($swiper_breakpoints) && !empty($swiper_breakpoints)) {
						foreach($swiper_breakpoints as $key => $swiper_breakpoint) {
							$responsive_breakpoints[] = array_merge($swiper_breakpoint, $swiper_breakpoints_slides[$key]);
						}
					}
		
					$carousel_settings['responsive'] = $responsive_breakpoints;
		
					$carousel_settings_value = wp_json_encode($carousel_settings);

		if($settings['product_id'] != '') {

			$media_carousel_attributes = array ();

			array_push($media_carousel_attributes, 'data-carouseleffect="'.$settings['carousel_effect'].'"');
			array_push($media_carousel_attributes, 'data-carouselslidesperview="'.$settings['carousel_slidesperview'].'"');
			array_push($media_carousel_attributes, 'data-carouselloopmode="'.$settings['carousel_loopmode'].'"');
			array_push($media_carousel_attributes, 'data-carouselmousewheelcontrol="'.$settings['carousel_mousewheelcontrol'].'"');
			array_push($media_carousel_attributes, 'data-carouselverticaldirection="'.$settings['carousel_verticaldirection'].'"');
			array_push($media_carousel_attributes, 'data-carouselbulletpagination="'.$settings['carousel_bulletpagination'].'"');
			array_push($media_carousel_attributes, 'data-carouselthumbnailpagination="'.$settings['carousel_thumbnailpagination'].'"');
			array_push($media_carousel_attributes, 'data-carouselthumbnailposition="'.$settings['carousel_thumbnail_position'].'"');
			array_push($media_carousel_attributes, 'data-carouselslidesperviewthumbnail="'.$settings['carousel_slidesperview_thumbnail'].'"');
			array_push($media_carousel_attributes, 'data-carouselarrowpagination="'.$settings['carousel_arrowpagination'].'"');
			array_push($media_carousel_attributes, 'data-carouselscrollbar="'.$settings['carousel_scrollbar'].'"');
			array_push($media_carousel_attributes, 'data-carouselspacebetween="'.$settings['carousel_spacebetween'].'"');
			array_push($media_carousel_attributes, 'data-moduleid="'.$settings['module_id'].'"');
			array_push($media_carousel_attributes, 'data-carouselresponsive="'.esc_js($carousel_settings_value).'"');

			if(!empty($media_carousel_attributes)) {
				$media_carousel_attributes_string = implode(' ', $media_carousel_attributes);
			}

			$product = wc_get_product( $settings['product_id'] );

			$gallery_holder_class = '';
			if($settings['carousel_thumbnailpagination'] == 'true' && ($settings['carousel_thumbnail_position'] == 'left' || $settings['carousel_thumbnail_position'] == 'right')) {
				$gallery_holder_class = 'wdt-product-vertical-thumb';
			}
			$gallery_holder_thumb_class = '';
			if($settings['carousel_thumbnail_position'] == 'left' || $settings['carousel_thumbnail_position'] == 'right') {
				$gallery_holder_thumb_class = 'wdt-product-vertical-thumb-'.$settings['carousel_thumbnail_position'];
			}

			$output .= '<div class="wdt-product-image-gallery-holder '.$settings['class'].' '.$gallery_holder_class.' '.$gallery_holder_thumb_class.'">';

				// Gallery Images
				$output .= '<div class="wdt-product-image-gallery-container wdt-product-image-gallery-'.$settings['module_id'].' swiper-container" '.$media_carousel_attributes_string.'>';

			    	if($settings['enable_thumb_enlarger'] == 'true') {
						$output .= '<div class="wdt-product-image-gallery-thumb-enlarger"></div>';
					}

			    	if($settings['include_product_labels'] == 'true') {

						ob_start();
						mezan_shop_woo_show_product_additional_labels($product);
						$product_sale_flash = ob_get_clean();

						$output .= $product_sale_flash;

					}

				    $output .= '<div class="wdt-product-image-gallery swiper-wrapper">';

	    				if($settings['include_featured_image'] == 'true') {

							$output .= '<div class="wdt-product-image swiper-slide">';

								$attachment_id = '';
								if(!empty($product)){    
									$attachment_id = $product->get_image_id();
								}

								$image_size               = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
								$full_size                = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
								$full_src                 = wp_get_attachment_image_src( $attachment_id, $full_size );
								$image                    = wp_get_attachment_image( $attachment_id, $image_size, false, array(
									'title'                   => get_post_field( 'post_title', $attachment_id ),
									'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
									'data-src'                => $full_src[0],
									'data-large_image'        => $full_src[0],
									'data-large_image_width'  => $full_src[1],
									'data-large_image_height' => $full_src[2],
									'class'                   => 'wp-post-image',
								) );

								$output .= $image;

							$output .= '</div>';

						}

						$attachment_ids = '';
						if(!empty($product)){  
							$attachment_ids = $product->get_gallery_image_ids();
						}

	                    if(is_array($attachment_ids) && !empty($attachment_ids)) {
	                        $i = 0;
	                        foreach($attachment_ids as $attachment_id) {

                               	$output .= '<div class="wdt-product-image swiper-slide">';

									$image_size               = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
									$full_size                = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
									$full_src                 = wp_get_attachment_image_src( $attachment_id, $full_size );
									$image                    = wp_get_attachment_image( $attachment_id, $image_size, false, array(
										'title'                   => get_post_field( 'post_title', $attachment_id ),
										'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
										'data-src'                => $full_src[0],
										'data-large_image'        => $full_src[0],
										'data-large_image_width'  => $full_src[1],
										'data-large_image_height' => $full_src[2],
										'class'                   => '',
									) );

									$output .= $image;

                               	$output .= '</div>';

                                $i++;

	                        }
	                    }

		    		$output .= '</div>';

					$output .= '<div class="wdt-product-image-gallery-pagination-holder">';

						if($settings['carousel_bulletpagination'] == 'true') {
							$output .= '<div class="wdt-product-image-gallery-bullet-pagination"></div>';
						}

						if($settings['carousel_scrollbar'] == 'true') {
							$output .= '<div class="wdt-product-image-gallery-scrollbar"></div>';
						}

						if($settings['carousel_arrowpagination'] == 'true') {
							$output .= '<div class="wdt-product-image-gallery-arrow-pagination '.$settings['carousel_arrowpagination_type'].'">';
								$output .= '<a href="#" class="wdt-product-image-gallery-arrow-prev">'.esc_html__('Prev', 'mezan-pro').'</a>';
								$output .= '<a href="#" class="wdt-product-image-gallery-arrow-next">'.esc_html__('Next', 'mezan-pro').'</a>';
							$output .= '</div>';
						}

					$output .= '</div>';
		   		$output .= '</div>';

		   		if($settings['carousel_thumbnailpagination'] == 'true') {

			   		// Gallery Thumb
					$output .= '<div class="wdt-product-image-gallery-thumb-container swiper-container">';
					    $output .= '<div class="wdt-product-image-gallery-thumb swiper-wrapper">';

		    				if($settings['include_featured_image'] == 'true') {
								$featured_image_id = get_post_thumbnail_id($settings['product_id']);
								$image_details = wp_get_attachment_image_src($featured_image_id, 'woocommerce_single');

								$output .= '<div class="swiper-slide"><img src="'.esc_url($image_details[0]).'" title="'.esc_html__('Gallery Thumb', 'mezan-pro').'" alt="'.esc_html__('Gallery Thumb', 'mezan-pro').'" /></div>';
							}

		                    if(is_array($attachment_ids) && !empty($attachment_ids)) {
		                        $i = 0;
		                        foreach($attachment_ids as $attachment_id) {
	                                $image_details = wp_get_attachment_image_src($attachment_id, 'woocommerce_single');
	                               	$output .= '<div class="swiper-slide"><img src="'.esc_url($image_details[0]).'" alt="'.esc_html__('Gallery Thumb', 'mezan-pro').'" /></div>';
	                                $i++;
		                        }
		                    }

			    		$output .= '</div>';
			    	$output .= '</div>';

			    }

		   	$output .= '</div>';

		} else {

			$output .= esc_html__('Please provide product id to display corresponding data!', 'mezan-pro');

		}

		echo $output;

	}

}
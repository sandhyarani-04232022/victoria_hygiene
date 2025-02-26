<?php

// Frontend Listing - Search Filter

add_action( 'wp_ajax_wdt_generate_load_search_data_ouput', 'wdt_generate_load_search_data_ouput' );
add_action( 'wp_ajax_nopriv_wdt_generate_load_search_data_ouput', 'wdt_generate_load_search_data_ouput' );
function wdt_generate_load_search_data_ouput() {

	// Pagination script Start
	$current_page = isset($_REQUEST['current_page']) ? wdt_sanitize_fields($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? wdt_sanitize_fields($_REQUEST['offset']) : 0;
	$post_per_page =  isset($_REQUEST['post_per_page']) ? wdt_sanitize_fields($_REQUEST['post_per_page']) : -1;
	// Pagination script End


	// Default options
	$type = (isset($_REQUEST['type']) && $_REQUEST['type'] != '') ? wdt_sanitize_fields($_REQUEST['type']) : 'type1';
	$gallery = (isset($_REQUEST['gallery']) && $_REQUEST['gallery'] != '') ? wdt_sanitize_fields($_REQUEST['gallery']) : 'featured_image';
	$columns =  isset($_REQUEST['columns']) ? wdt_sanitize_fields($_REQUEST['columns']) : 1;

	// Location options
	$user_latitude = wdt_sanitize_fields($_REQUEST['user_latitude']);
	$user_longitude = wdt_sanitize_fields($_REQUEST['user_longitude']);

	// Radius options
	$use_radius = wdt_sanitize_fields($_REQUEST['use_radius']);
	$radius = wdt_sanitize_fields($_REQUEST['radius']);
	$radius_unit = wdt_sanitize_fields($_REQUEST['radius_unit']);

	// Carousel
	$enable_carousel = (isset($_REQUEST['enable_carousel']) && $_REQUEST['enable_carousel'] == 'true') ? true: false;

	// Module Id
	$module_id = (isset($_REQUEST['module_id']) && !empty($_REQUEST['module_id'])) ? $_REQUEST['module_id']: '8888';

	// Featured Items
	$featured_items = (isset($_REQUEST['featured_items']) && $_REQUEST['featured_items'] == 'true') ? true: false;

	// Ad Items
	$ad_items = (isset($_REQUEST['ad_items']) && $_REQUEST['ad_items'] != '') ? wdt_sanitize_fields($_REQUEST['ad_items']) : '';

	// Ad Location
	$ad_location = (isset($_REQUEST['ad_location']) && $_REQUEST['ad_location'] != '') ? wdt_sanitize_fields($_REQUEST['ad_location']) : '';

	// Single Post Id
	$single_post_id = (isset($_REQUEST['single_post_id']) && $_REQUEST['single_post_id'] != '') ? wdt_sanitize_fields($_REQUEST['single_post_id']) : '';

	// Excerpt Length
	$excerpt_length = (isset($_REQUEST['excerpt_length']) && !empty($_REQUEST['excerpt_length'])) ? wdt_sanitize_fields($_REQUEST['excerpt_length']) : 20;

	// Features Image or Icon
	$features_image_or_icon = (isset($_REQUEST['features_image_or_icon']) && !empty($_REQUEST['features_image_or_icon'])) ? wdt_sanitize_fields($_REQUEST['features_image_or_icon']) :'';

	// Features Count
	$features_include = (isset($_REQUEST['features_include']) && !empty($_REQUEST['features_include'])) ? wdt_sanitize_fields($_REQUEST['features_include']) : '';

	// Custom Options
	$custom_options = (isset($_REQUEST['custom_options']) && !empty($_REQUEST['custom_options'])) ? json_decode(stripslashes(wdt_sanitize_fields($_REQUEST['custom_options'])), true) : array ();

	// Updating Custom Options with Price fields
	$pricerange_start = isset($_REQUEST['pricerange_start']) ? wdt_sanitize_fields($_REQUEST['pricerange_start']) : '';
	$pricerange_end = isset($_REQUEST['pricerange_end']) ? wdt_sanitize_fields($_REQUEST['pricerange_end']) : '';

	$custom_options['pricerange_start'] = $pricerange_start;
	$custom_options['pricerange_end']   = $pricerange_end;


	// Query to retrieve data based on filter options

	$args = array (
		'posts_per_page' => -1,
		'post_type'      => 'wdt_listings',
		'meta_query'     => array (),
		'tax_query'      => array (),
		'post_status'    => 'publish'
	);

	// Keyword Filter
	$keyword = isset($_REQUEST['keyword']) ? wdt_sanitize_fields($_REQUEST['keyword']) : '';
	if($keyword != '') {
		$args['s'] = $keyword;
	}

	// List Item Ids
	$list_items = isset($_REQUEST['list_items']) ? wdt_sanitize_fields($_REQUEST['list_items']) : '';
	if(!empty($list_items)) {
		$args['post__in'] = $list_items;
	}

	// Category Filter
	$categories = isset($_REQUEST['categories']) ? wdt_sanitize_fields($_REQUEST['categories']) : '';
	if(!empty($categories)) {
		$args['tax_query'][] = array (
			'taxonomy' => 'wdt_listings_category',
			'field'    => 'id',
			'terms'    => $categories,
			'operator' => 'IN'
		);
	}

	// Tags Filter
	$tags = isset($_REQUEST['tags']) ? wdt_sanitize_fields($_REQUEST['tags']) : '';
	if(!empty($tags)) {
		$args['tax_query'][] = array (
			'taxonomy' => 'wdt_listings_amenity',
			'field'    => 'id',
			'terms'    => $tags,
			'operator' => 'IN'
		);
	}

	// Start Date
	$startdate = isset($_REQUEST['startdate']) ? wdt_sanitize_fields($_REQUEST['startdate']) : '';
	if($startdate != '') {
		$date_to_compare = date('Ymd', strtotime($startdate));
		$args['meta_query'][] = array (
			'key'     => 'wdt_start_date_compare_format',
			'value'   => $date_to_compare,
			'compare' => '>=',
		);
	}

	// Features
	$use_features_query   = '';
	$features_compare_id  = 0;
	$features_start       = 20;
	$features_end         = 60;
	$features_query       = isset($_REQUEST['features_query']) ? wdt_sanitize_fields($_REQUEST['features_query']) : array ();
	$features_total_query = isset($_REQUEST['features_total_query']) ? wdt_sanitize_fields($_REQUEST['features_total_query']) : 0;
	if(is_array($features_query) && !empty($features_query)) {
		$use_features_query = 'true';
	}

	// Order By
	$orderby = isset($_REQUEST['orderby']) ? wdt_sanitize_fields($_REQUEST['orderby']) : '';
	if($orderby == 'alphabetical') {

		$args['orderby'] = 'title';
		$args['order'] = 'ASC';

	} else if($orderby == 'highest-rated') {

		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = 'wdt_average_ratings';

	} else if($orderby == 'most-reviewed') {

		$args['orderby'] = 'comment_count';

	} else if($orderby == 'most-viewed') {

		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = 'wdt_total_views';

	}

	// Featured Items
	if($featured_items) {
		$args['meta_query'][] = array (
			'key'     => 'wdt_featured_item',
			'value'   => 'true',
			'compare' => '=',
		);
	}

	// MLS Number Filter
	$mls_number = isset($_REQUEST['mls_number']) ? wdt_sanitize_fields($_REQUEST['mls_number']) : '';
	if($mls_number != '') {
		$args['meta_query'][] = array (
			'key'     => 'wdt_mls_number',
			'value'   => $mls_number,
			'compare' => 'LIKE',
		);
	}

	// To modify arguments from modules
	$args = apply_filters('wdt_modify_listings_args_from_modules', $args, $custom_options);

	// Others
	$use_opennow_query = '';
	$others = (isset($_REQUEST['others']) && !empty($_REQUEST['others'])) ? wdt_sanitize_fields($_REQUEST['others']) : array ();
	if(in_array ('opennow', $others)) {
		$use_opennow_query = 'true';
	}

	// Configure settings

	$filtered_item_ids = array ();

	$listings_filtered_query = new WP_Query( $args );

	if ( $listings_filtered_query->have_posts() ) :

		$i = 1;
		while ( $listings_filtered_query->have_posts() ) :
			$listings_filtered_query->the_post();

			$listing_id = get_the_ID();

			// Filtering listings

				$wdt_latitude = get_post_meta($listing_id, 'wdt_latitude', true);
				$wdt_longitude = get_post_meta($listing_id, 'wdt_longitude', true);

				$radius_filter_enabled   = $radius_filter = false;
				$features_filter_enabled = $features_filter = false;
				$opennow_filter_enabled  = $opennow_filter = false;


			// Radius Filter

				if($use_radius == 'true') {

					$radius_calculated = wdt_calculate_distance_between_location($user_latitude, $user_longitude, $wdt_latitude, $wdt_longitude, $radius_unit);

					if($radius_calculated > -1 && $radius_calculated < $radius) {
						$radius_filter = true;
					}

					$radius_filter_enabled = true;

				}


			// Features Filter

				if($use_features_query == 'true') {

					$filtered_featured_custom_item_ids  = array ();

					foreach($features_query as $feature_query_key => $feature_query) {

						$wdt_features_value = get_post_meta($listing_id, 'wdt_features_value', true);
						$item_feature_value = isset($wdt_features_value[$feature_query_key]) ? $wdt_features_value[$feature_query_key] : -1;

						if($feature_query['field_type'] == 'range') {

							if($item_feature_value >= $feature_query['start'] && $item_feature_value <= $feature_query['end']) {
								array_push($filtered_featured_custom_item_ids, $listing_id);
							}

						} else if($feature_query['field_type'] == 'dropdown' || $feature_query['field_type'] == 'list') {

							if(isset($feature_query['item_values']) && in_array($item_feature_value, $feature_query['item_values'])) {
								array_push($filtered_featured_custom_item_ids, $listing_id);
							}

						}

					}

					if($features_total_query == count($filtered_featured_custom_item_ids)) {
						$features_filter = true;
					}

					$features_filter_enabled = true;

				}

			// Open Now Filter

				if($use_opennow_query == 'true') {

					$wdt_business_hours  = get_post_meta($listing_id, 'wdt_business_hours', true);

					$start_time = $wdt_business_hours[strtolower(date('l'))]['start_time'][0];
					$end_time = $wdt_business_hours[strtolower(date('l'))]['end_time'][0];

					if(isset($start_time) && !empty($start_time)) {

						$start_time = strtotime($start_time);
						$end_time = strtotime($end_time);

						$current_timestamp = current_time( 'timestamp' );

						if (($current_timestamp > $start_time) && ($current_timestamp < $end_time)) {
							$opennow_filter = true;
						}

					}

					$opennow_filter_enabled = true;

				}

			// Filter Combination

				if($radius_filter_enabled || $features_filter_enabled || $opennow_filter_enabled) {

					if(($radius_filter_enabled && $features_filter_enabled && $opennow_filter_enabled) && ($radius_filter && $features_filter && $opennow_filter)) {

						array_push($filtered_item_ids, $listing_id);

					} else if(($radius_filter_enabled && !$features_filter_enabled && !$opennow_filter_enabled) && ($radius_filter)) {

						array_push($filtered_item_ids, $listing_id);

					} else if((!$radius_filter_enabled && $features_filter_enabled && !$opennow_filter_enabled) && ($features_filter)) {

						array_push($filtered_item_ids, $listing_id);

					} else if((!$radius_filter_enabled && !$features_filter_enabled && $opennow_filter_enabled) && ($opennow_filter)) {

						array_push($filtered_item_ids, $listing_id);

					} else if(($radius_filter_enabled && $features_filter_enabled && !$opennow_filter_enabled) && ($radius_filter && $features_filter)) {

						array_push($filtered_item_ids, $listing_id);

					} else if(($radius_filter_enabled && !$features_filter_enabled && $opennow_filter_enabled) && ($radius_filter && $opennow_filter)) {

						array_push($filtered_item_ids, $listing_id);

					} else if((!$radius_filter_enabled && $features_filter_enabled && $opennow_filter_enabled) && ($features_filter && $opennow_filter)) {

						array_push($filtered_item_ids, $listing_id);

					}

				} else  {

					array_push($filtered_item_ids, $listing_id);

				}

		endwhile;
		wp_reset_postdata();

	endif;

	// Data Output

	$load_data = (isset($_REQUEST['load_data']) && $_REQUEST['load_data'] == 'true') ? 'true' : '';
	$load_map = (isset($_REQUEST['load_map']) && $_REQUEST['load_map'] == 'true') ? 'true' : '';

	if($load_data == 'true') {

		$apply_isotope = (isset($_REQUEST['apply_isotope']) && $_REQUEST['apply_isotope'] == 'true') ? 'true' : '';
		$isotope_filter = '';
		if($apply_isotope == 'true') {
			$isotope_filter = (isset($_REQUEST['isotope_filter']) && $_REQUEST['isotope_filter'] != '') ? wdt_sanitize_fields($_REQUEST['isotope_filter']) : '';
		}

		$data_result = wdt_generate_listing_output_loop($filtered_item_ids, $_REQUEST);

	} else if($load_map == 'true') {

		$paginated_item_ids = array ();

		if(!empty($filtered_item_ids)) {

			$args = array (
				'offset'         => $offset,
				'paged'          => $current_page ,
				'posts_per_page' => $post_per_page,
				'post__in'       => $filtered_item_ids,
				'post_type'      => 'wdt_listings',
				'orderby'        => 'post__in',
				'post_status'    => 'publish'
			);

			$listings_paginated_query = new WP_Query( $args );

			if ( $listings_paginated_query->have_posts() ) :

				$i = 1;
				while ( $listings_paginated_query->have_posts() ) :
					$listings_paginated_query->the_post();

					$listing_id = get_the_ID();

					array_push($paginated_item_ids, $listing_id);

				endwhile;
				wp_reset_postdata();

			endif;

		}

    	$data_result = array (
			'data' => '',
			'dataids' => $paginated_item_ids,
            'taxcounts' => ''
		);
	}


    // Print Output
    echo json_encode(array(
		'data' => $data_result['data'],
		'dataids' => $data_result['dataids'],
		'taxcounts' => $data_result['taxcounts']
	));

	die();

}

// Frontend Listing - Loop

function wdt_generate_listing_output_loop($filtered_item_ids, $output_options) {
	// Options
	extract($output_options);

    $dynamic_pagination = (isset($_REQUEST['dynamic_pagination']) && $_REQUEST['dynamic_pagination']) ? filter_var($_REQUEST['dynamic_pagination'], FILTER_VALIDATE_BOOLEAN) : false;
    $show_isotope_filter_count = (isset($_REQUEST['show_isotope_filter_count']) && $_REQUEST['show_isotope_filter_count'] == 'true') ? true : false;
	$enable_carousel = (isset($_REQUEST['enable_carousel']) && $_REQUEST['enable_carousel'] == 'true') ? true: false;
	$module_id = (isset($_REQUEST['module_id']) && !empty($_REQUEST['module_id'])) ? $_REQUEST['module_id']: '8888';

	// Query to retrieve data based on pagination
	$paginated_item_ids = $tax_ids = $tax_ids_count = array ();
	$content = '';

	if(!empty($filtered_item_ids)) {

        $masonary_one_items = isset($_REQUEST['masonary_one_items']) ? wdt_sanitize_fields($_REQUEST['masonary_one_items']) : array ();
        $masonary_one_half_items = isset($_REQUEST['masonary_one_half_items']) ? wdt_sanitize_fields($_REQUEST['masonary_one_half_items']) : array ();
        $masonary_one_third_items = isset($_REQUEST['masonary_one_third_items']) ? wdt_sanitize_fields($_REQUEST['masonary_one_third_items']) : array ();
        $masonary_two_third_items = isset($_REQUEST['masonary_two_third_items']) ? wdt_sanitize_fields($_REQUEST['masonary_two_third_items']) : array ();
        $masonary_one_fourth_items = isset($_REQUEST['masonary_one_fourth_items']) ? wdt_sanitize_fields($_REQUEST['masonary_one_fourth_items']) : array ();
        $masonary_three_fourth_items = isset($_REQUEST['masonary_three_fourth_items']) ? wdt_sanitize_fields($_REQUEST['masonary_three_fourth_items']) : array ();

		if($columns == 6) {
			$column_class = array ( 'wdt-column', 'wdt-one-sixth' );
		} else if($columns == 5) {
			$column_class = array ( 'wdt-column', 'wdt-one-fifth' );
		} else if($columns == 4) {
			$column_class = array ( 'wdt-column', 'wdt-one-fourth' );
		} else if($columns == 3) {
			$column_class = array ( 'wdt-column', 'wdt-one-third' );
		} else if($columns == 2) {
			$column_class = array ( 'wdt-column', 'wdt-one-half' );
		} else {
			$column_class = array ( 'wdt-column', 'wdt-one-column' );
		}

		$args = array (
			'offset'         => $offset,
			'paged'          => $current_page,
			'posts_per_page' => $post_per_page,
			'post__in'       => $filtered_item_ids,
			'post_type'      => 'wdt_listings',
			'orderby'        => 'post__in',
			'post_status'    => 'publish'
		);

		if($enable_carousel) {
			$output_options['carousel_class'] = 'swiper-slide';
		} else {
			$output_options['carousel_class'] = '';
		}

		$listings_paginated_query = new WP_Query( $args );

		if ( $listings_paginated_query->have_posts() ) :

			if($apply_isotope == 'true' && !$dynamic_pagination) {
				$gs_class = implode(' ', $column_class);
				$content .= '<div class="grid-sizer '.esc_attr( $gs_class ).'"></div>';
			}

			$i = 1;
            if($dynamic_pagination) {
                $j = (($current_page - 1) * $post_per_page) + 1;
            } else {
                $j = 1;
            }
			while ( $listings_paginated_query->have_posts() ) :
				$listings_paginated_query->the_post();

				$listing_id = get_the_ID();
				$listing_title = get_the_title();
				$listing_permalink = get_permalink();

				$output_options['listing_id'] = $listing_id;
				$output_options['listing_title'] = $listing_title;
				$output_options['listing_permalink'] = $listing_permalink;

				if($i == 1) { $first_class = 'first';  } else { $first_class = ''; }
				if($i == $columns) { $i = 1; } else { $i = $i + 1; }

                if(!empty($masonary_one_items) && in_array($j, $masonary_one_items)){
                    $output_options['column_class'] = array ( 'wdt-column', 'wdt-one-column' );
                } else if(!empty($masonary_one_half_items) && in_array($j, $masonary_one_half_items)){
                    $output_options['column_class'] = array ( 'wdt-column', 'wdt-one-half' );
                } else if(!empty($masonary_one_third_items) && in_array($j, $masonary_one_third_items)){
                    $output_options['column_class'] = array ( 'wdt-column', 'wdt-one-third' );
                } else if(!empty($masonary_two_third_items) && in_array($j, $masonary_two_third_items)){
                    $output_options['column_class'] = array ( 'wdt-column', 'wdt-two-third' );
                } else if(!empty($masonary_one_fourth_items) && in_array($j, $masonary_one_fourth_items)){
                    $output_options['column_class'] = array ( 'wdt-column', 'wdt-one-fourth' );
                } else if(!empty($masonary_three_fourth_items) && in_array($j, $masonary_three_fourth_items)){
                    $output_options['column_class'] = array ( 'wdt-column', 'wdt-three-fourth' );
                } else {
                    $output_options['column_class'] = $column_class;
                }
                $j++;

				$output_options['first_class'] = $first_class;

				$content .= wdt_generate_listing_item_html($output_options);

				array_push($paginated_item_ids, $listing_id);

                // Terms count
                if($show_isotope_filter_count) {
                    if($apply_isotope == 'true' && $isotope_filter != '') {

                        if($isotope_filter == 'category') {
                            $tax_items = get_the_terms( $listing_id, 'wdt_listings_category' );
                        }

                        if(is_object($tax_items) || is_array($tax_items)) {
                            foreach ($tax_items as $tax_item) {
                                array_push($tax_ids, $tax_item->term_id);
                            }
                        }

                    }
                }

			endwhile;
			wp_reset_postdata();

		else :

			$content .= esc_html__('No records found!','wdt-portfolio');

		endif;

		$total_count = $listings_paginated_query->found_posts;

	} else {
		$total_count = 0;
	}

    $tax_ids_count = array_count_values($tax_ids);

	// Building output html

	$output = '';

	$swiper_wrapper_class = $swiper_container_class = '';
	if($enable_carousel) {
		$swiper_wrapper_class = 'swiper-wrapper';
		$swiper_container_class = 'swiper-container';
	}

	$isotope_class = '';
	if($apply_isotope == 'true') {
		$isotope_class = 'wdt-listings-item-apply-isotope';
	}

	$gallery_image_popup = '';
	if($show_image_popup == 'yes') {
		$gallery_image_popup = 'wdt-listings-item-image-gallery-popup-enable';
	}

    if(!$dynamic_pagination) {
	    $output .= '<div class="wdt-listings-container '.esc_attr($swiper_container_class).' '.esc_attr($isotope_class).' '.esc_attr($gallery_image_popup).' wdt-portfolio-module-id-'.esc_attr($module_id).'">';
    }

		if($apply_isotope == 'true' && $isotope_filter != '') {

			$apply_child_of = (isset($_REQUEST['apply_child_of']) && $_REQUEST['apply_child_of'] == 'true') ? true : false;

			$filter_items = array ();

			if($isotope_filter == 'category') {

				$tax_args = array ('taxonomy' => 'wdt_listings_category', 'hide_empty' => 1);

				if(is_array($categories) && !empty($categories)) {
					if($apply_child_of && count($categories) == 1) {
						$tax_args['child_of'] = $categories[0];
					} else {
						$tax_args['include'] = $categories;
					}
				} else {
					$tax_args['parent'] = 0;
				}

				$filter_items = get_categories($tax_args);

			}

			if(is_array($filter_items) && !empty($filter_items) && !$dynamic_pagination) {
                $filter_class = '';
                if($show_isotope_filter_count) {
                    $filter_class = 'with-count';
                }
		        $output .= '<div class="wdt-listings-item-isotope-filter '.esc_attr($filter_class).'">';
			        $output .= '<a href="#" class="active-sort" data-filter=".all-sort" data-catid="-1">'.esc_html__('All','wdt-portfolio');
                        if($show_isotope_filter_count) {
                            $output .= '<span>'.esc_html($post_per_page).'</span>';
                        }
			        $output .= '</a>';
            		foreach( $filter_items as $filter_item ) {
                		$output .= '<a href="#" data-filter=".'.esc_attr($filter_item->category_nicename).'-sort" data-catid="'.esc_attr($filter_item->term_id).'">'.esc_html($filter_item->cat_name);
                        if($show_isotope_filter_count) {
                            if(is_array($tax_ids_count) && !empty($tax_ids_count)) {
                                if(isset($tax_ids_count[$filter_item->term_id]) && !empty($tax_ids_count[$filter_item->term_id])) {
                                    $output .= '<span>'.esc_html($tax_ids_count[$filter_item->term_id]).'</span>';
                                }
                            }
                        }
                		$output .= '</a>';
                	}
		        $output .= '</div>';
			}

		}

		if($content != '') {

            if(!$dynamic_pagination) {
			    $output .= '<div class="wdt-listings-item-container '.esc_attr($swiper_wrapper_class).'">';
            }
				$output .= $content;
            if(!$dynamic_pagination) {
			    $output .= '</div>';
            }

			if(!$enable_carousel && !$dynamic_pagination) {

				// Pagination script Start
				$max_num_pages = $listings_paginated_query->max_num_pages;

				$output_options['loader']         = 'true';
				$output_options['loader_parent']  = '.wdt-listing-output-data-container';

                if($pagination_type != '') {
                    $output .= wdt_listing_ajax_pagination($max_num_pages, $current_page, 'wdt_generate_load_search_data_ouput', 'wdt-listing-output-data-holder', $output_options);
                }
				// Pagination script End

			}

		} else {

            if(!$dynamic_pagination) {
			    $output .= '<div class="wdt-info-box">'.esc_html__('No records found!','wdt-portfolio').'</div>';
            }

		}

    if(!$dynamic_pagination) {
	    $output .= '</div>';
    }


    $output = array (
		'data' => $output,
		'dataids' => $paginated_item_ids,
		'taxcounts' => $tax_ids_count
	);

	return $output;

}

// Frontend Listing - Generate Html

function wdt_generate_listing_item_html($data_listing_attributes) {

	$output = '';

	extract($data_listing_attributes);


	$item_classes = array ('wdt-listings-item-wrapper');
	array_push($item_classes, $carousel_class);

	if($first_class != '') {
		array_push($column_class, $first_class);
	}

	if($apply_isotope == 'true' && $isotope_filter != '') {

		array_push($column_class, 'all-sort');
		if($isotope_filter == 'category') {
			$tax_items = get_the_terms( $listing_id, 'wdt_listings_category' );
		}

		if(is_object($tax_items) || is_array($tax_items)) {
			foreach ($tax_items as $tax_item) {
				array_push($column_class, $tax_item->slug.'-sort');
			}
		}

	}

	if($type == 'type9') {
		array_push($item_classes, 'type3 wdt-list');
	} else if($type == 'type10') {
		array_push($item_classes, 'type5 wdt-widget-stlye');
	} else {
		array_push($item_classes, $type);
	}

	// Custom HTML update from modules
	$wdt_listing_custom_html = apply_filters('wdt_listing_custom_html_from_modules', '', $listing_id);

	// Featured Item Label
	$wdt_featured_item_html = '';
	$wdt_featured_item = get_post_meta($listing_id, 'wdt_featured_item', true);
	if($wdt_featured_item == 'true') {
		$wdt_featured_item_html .= '<div class="wdt-listings-featured-item-container">';
			$wdt_featured_item_html .= '<a href="'.esc_url( get_permalink($listing_id) ).'">';
				$wdt_featured_item_html .= '<span>'.esc_html__('Featured','wdt-portfolio').'</span>';
			$wdt_featured_item_html .= '</a>';
		$wdt_featured_item_html .= '</div>';
	}

	// Excerpt
	$custom_excerpt = wdt_custom_excerpt($excerpt_length, $listing_id);

    $post_classes = get_post_class($item_classes, $listing_id);
    unset($post_classes[array_search('blog-entry', $post_classes)]);

	if($apply_isotope == 'true') {
		$output .= '<div class="'.esc_attr( implode(' ', $column_class) ).'">';
			$output .= '<div class="'.esc_attr( implode(' ', $post_classes) ).'">';
	} else {
		$post_classes = array_merge($post_classes, $column_class);
		$output .= '<div class="'.esc_attr( implode(' ', $post_classes) ).'">';
	}

		if($type == 'type1') {

			$output .= '<div class="wdt-listings-item-top-section">';

				$output .= $wdt_listing_custom_html;
				$output .= $wdt_featured_item_html;

				$wdt_media_images_ids = $wdt_media_galleries = array ();
				if($listing_id > 0) {
					$wdt_media_images_ids    = get_post_meta($listing_id, 'wdt_media_images_ids', true);
					if(is_array($wdt_media_images_ids) && !empty($wdt_media_images_ids)) {
						foreach($wdt_media_images_ids as $wdt_media_attachments_id) {
							$thumbnail_url = wp_get_attachment_image_src($wdt_media_attachments_id, 'full');
							$wdt_media_galleries[] = $thumbnail_url[0];
						}
					}
				}

                $output .= '<div class="wdt-listings-item-image-gallery" data-media-gallery="'.esc_js( wp_json_encode($wdt_media_galleries) ).'">';
                    $output .= do_shortcode('[wdt_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" /]');
                $output .= '</div>';

				$output .= '<div class="wdt-listings-item-top-section-content">';

					$output .= do_shortcode('[wdt_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="wdt_listings_category" type="type1" splice="'.esc_attr($no_of_cat_to_display).'" /]');

                    $output .= '<div class="wdt-listings-item-title">';
						$output .= '<div class="wdt-listing-item-title-icon"><svg xmlns="http://www.w3.org/2000/svg"
							xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
							<style type="text/css">
							.wdt-right-cross-arrow{fill:currentColor;}
							</style>
							<path class="wdt-right-cross-arrow" d="M97.7,30c0.6-2.1-0.7-4.3-2.8-4.9l-34.6-9.3c-2.1-0.6-4.3,0.7-4.9,2.8c-0.6,2.1,0.7,4.3,2.8,4.9L89,31.8
							l-8.2,30.8c-0.6,2.1,0.7,4.3,2.8,4.9c2.1,0.6,4.3-0.7,4.9-2.8L97.7,30z M6.2,84.2l89.7-51.8l-4-6.9L2.2,77.3L6.2,84.2z"/>
						</svg></div>';
                        $output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
                    $output .= '</div>';

					if($custom_excerpt != '') {
						$output .= '<div class="wdt-listings-excerpt">';
							$output .= '<p>';
								$e_title = 	get_post_meta($listing_id, 'wdt_excerpt_title', true);
								if(  $e_title != '' ) {
									$output .= '<span>'.esc_html( $e_title ).'</span>';
								}
								$output .= $custom_excerpt;
							$output .= '</p>';
						$output .= '</div>';
					}

					$view_details_btn = '<span class="detail-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 159 95.6" style="enable-background:new 0 0 159 95.6;" xml:space="preserve"><g class="eye-wrap"><path class="eye-inner" d="M79.5,19.3C63.8,19.3,51,32.1,51,47.8s12.8,28.5,28.5,28.5S108,63.5,108,47.8C108,32.1,95.2,19.3,79.5,19.3z M79.5,67.3 C68.7,67.3,60,58.6,60,47.8s8.7-19.5,19.5-19.5S99,37,99,47.8l0,0C99,58.6,90.3,67.3,79.5,67.3z"/><path class="eye-outer" d="M158.4,45.6C133.2,2,77.5-12.9,33.9,12.2c-13.8,8-25.3,19.5-33.3,33.3c-0.8,1.4-0.8,3.1,0,4.5 c25.2,43.6,80.9,58.5,124.5,33.3c13.8-8,25.3-19.5,33.3-33.3C159.2,48.7,159.2,47,158.4,45.6z M79.5,86.6 c-28.4,0-54.7-14.7-69.8-38.8C33.7,9.3,84.3-2.5,122.8,21.4c10.7,6.7,19.8,15.7,26.4,26.4C134.2,71.9,107.9,86.5,79.5,86.6 L79.5,86.6z"/></g></svg></span>';
					if( $enable_view_details_btn == 'yes' ) {
						$view_details_btn = $view_details_btn;
					} else {
						$view_details_btn = '';
					}
					$output .= '<div class="wdt-listings-group-button-hover-icon">';
						$output .= '<a class="custom-button-style wdt-listing-view-details" href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html__('View Details','wdt-portfolio').''.$view_details_btn.'</a>';

						if( $show_image_popup == 'yes' ) {
							$output .= '<div class="wdt-listings-hover-image-icon"><svg class="wdt-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 560 560" style="enable-background:new 0 0 560 560;" xml:space="preserve"><path d="M184.4,336L56,464.4V336H0v224h224v-56H95.6L224,375.6L184.4,336z M336,0v56h128.4L336,184.4l39.6,39.6L504,95.6V224h56V0 L336,0z M504,464.4L375.6,336L336,375.6L464.4,504H336v56h224V336h-56L504,464.4z M0,0v224h56V95.6L183.4,223l39.6-39.6L95.6,56H224 V0L0,0z"/></svg></div>';
						}
					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

		} else if($type == 'type2' || $type == 'type3') {

            $output .= '<div class="wdt-listings-item-top-section">';

                $output .= $wdt_listing_custom_html;
                $output .= $wdt_featured_item_html;

                $wdt_media_images_ids = $wdt_media_galleries = array ();
				if($listing_id > 0) {
					$wdt_media_images_ids    = get_post_meta($listing_id, 'wdt_media_images_ids', true);
					if(is_array($wdt_media_images_ids) && !empty($wdt_media_images_ids)) {
						foreach($wdt_media_images_ids as $wdt_media_attachments_id) {
							$thumbnail_url = wp_get_attachment_image_src($wdt_media_attachments_id, 'full');
							$wdt_media_galleries[] = $thumbnail_url[0];
						}
					}
				}

                $output .= '<div class="wdt-listings-item-image-gallery" data-media-gallery="'.esc_js( wp_json_encode($wdt_media_galleries) ).'">';
				if( $show_image_popup == 'yes' ) {
					$output .= '<div class="wdt-listings-hover-image-icon"><svg class="wdt-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 560 560" style="enable-background:new 0 0 560 560;" xml:space="preserve"><path d="M184.4,336L56,464.4V336H0v224h224v-56H95.6L224,375.6L184.4,336z M336,0v56h128.4L336,184.4l39.6,39.6L504,95.6V224h56V0 L336,0z M504,464.4L375.6,336L336,375.6L464.4,504H336v56h224V336h-56L504,464.4z M0,0v224h56V95.6L183.4,223l39.6-39.6L95.6,56H224 V0L0,0z"/></svg></div>';
				}
                    $output .= do_shortcode('[wdt_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" /]');
                $output .= '</div>';

                $output .= '<div class="wdt-listings-item-top-section-content">';

                    $output .= do_shortcode('[wdt_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="wdt_listings_category" type="type1" splice="'.esc_attr($no_of_cat_to_display).'" /]');

                    $output .= '<div class="wdt-listings-item-title">';
                        $output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
                    $output .= '</div>';

					$view_details_btn = '<span class="detail-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 159 95.6" style="enable-background:new 0 0 159 95.6;" xml:space="preserve"><g class="eye-wrap"><path class="eye-inner" d="M79.5,19.3C63.8,19.3,51,32.1,51,47.8s12.8,28.5,28.5,28.5S108,63.5,108,47.8C108,32.1,95.2,19.3,79.5,19.3z M79.5,67.3 C68.7,67.3,60,58.6,60,47.8s8.7-19.5,19.5-19.5S99,37,99,47.8l0,0C99,58.6,90.3,67.3,79.5,67.3z"/><path class="eye-outer" d="M158.4,45.6C133.2,2,77.5-12.9,33.9,12.2c-13.8,8-25.3,19.5-33.3,33.3c-0.8,1.4-0.8,3.1,0,4.5 c25.2,43.6,80.9,58.5,124.5,33.3c13.8-8,25.3-19.5,33.3-33.3C159.2,48.7,159.2,47,158.4,45.6z M79.5,86.6 c-28.4,0-54.7-14.7-69.8-38.8C33.7,9.3,84.3-2.5,122.8,21.4c10.7,6.7,19.8,15.7,26.4,26.4C134.2,71.9,107.9,86.5,79.5,86.6 L79.5,86.6z"/></g></svg></span>';
					if( $enable_view_details_btn == 'yes' ) {
						$view_details_btn = $view_details_btn;
					} else {
						$view_details_btn = '';
					}
					$output .= '<a class="custom-button-style wdt-listing-view-details" href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html__('View Details','wdt-portfolio').''.$view_details_btn.'</a>';

                $output .= '</div>';

            $output .= '</div>';

		} else if($type == 'type4') {

			$output .= '<div class="wdt-listings-item-top-section">';

				$output .= $wdt_listing_custom_html;
				$output .= $wdt_featured_item_html;

				$wdt_media_images_ids = $wdt_media_galleries = array ();
				if($listing_id > 0) {
					$wdt_media_images_ids    = get_post_meta($listing_id, 'wdt_media_images_ids', true);
					if(is_array($wdt_media_images_ids) && !empty($wdt_media_images_ids)) {
						foreach($wdt_media_images_ids as $wdt_media_attachments_id) {
							$thumbnail_url = wp_get_attachment_image_src($wdt_media_attachments_id, 'full');
							$wdt_media_galleries[] = $thumbnail_url[0];
						}
					}
				}

                $output .= '<div class="wdt-listings-item-image-gallery" data-media-gallery="'.esc_js( wp_json_encode($wdt_media_galleries) ).'">';
                    $output .= do_shortcode('[wdt_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" /]');
                $output .= '</div>';

				$output .= '<div class="wdt-listings-item-top-section-content">';

					$output .= do_shortcode('[wdt_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="wdt_listings_category" type="type1" splice="'.esc_attr($no_of_cat_to_display).'" /]');

                    $output .= '<div class="wdt-listings-item-title">';
                        $output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
                    $output .= '</div>';

					$view_details_btn = '<span class="detail-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 159 95.6" style="enable-background:new 0 0 159 95.6;" xml:space="preserve"><g class="eye-wrap"><path class="eye-inner" d="M79.5,19.3C63.8,19.3,51,32.1,51,47.8s12.8,28.5,28.5,28.5S108,63.5,108,47.8C108,32.1,95.2,19.3,79.5,19.3z M79.5,67.3 C68.7,67.3,60,58.6,60,47.8s8.7-19.5,19.5-19.5S99,37,99,47.8l0,0C99,58.6,90.3,67.3,79.5,67.3z"/><path class="eye-outer" d="M158.4,45.6C133.2,2,77.5-12.9,33.9,12.2c-13.8,8-25.3,19.5-33.3,33.3c-0.8,1.4-0.8,3.1,0,4.5 c25.2,43.6,80.9,58.5,124.5,33.3c13.8-8,25.3-19.5,33.3-33.3C159.2,48.7,159.2,47,158.4,45.6z M79.5,86.6 c-28.4,0-54.7-14.7-69.8-38.8C33.7,9.3,84.3-2.5,122.8,21.4c10.7,6.7,19.8,15.7,26.4,26.4C134.2,71.9,107.9,86.5,79.5,86.6 L79.5,86.6z"/></g></svg></span>';
					if( $enable_view_details_btn == 'yes' ) {
						$view_details_btn = $view_details_btn;
					} else {
						$view_details_btn = '';
					}
					$output .= '<div class="wdt-listings-group-button-hover-icon">';
						$output .= '<a class="custom-button-style wdt-listing-view-details" href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html__('View Details','wdt-portfolio').''.$view_details_btn.'</a>';

						if( $show_image_popup == 'yes' ) {
							$output .= '<div class="wdt-listings-hover-image-icon"><svg class="wdt-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 560 560" style="enable-background:new 0 0 560 560;" xml:space="preserve"><path d="M184.4,336L56,464.4V336H0v224h224v-56H95.6L224,375.6L184.4,336z M336,0v56h128.4L336,184.4l39.6,39.6L504,95.6V224h56V0 L336,0z M504,464.4L375.6,336L336,375.6L464.4,504H336v56h224V336h-56L504,464.4z M0,0v224h56V95.6L183.4,223l39.6-39.6L95.6,56H224 V0L0,0z"/></svg></div>';
						}
					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

		} else if($type == 'type5') {

			$output .= '<div class="wdt-listings-item-top-section">';

				$output .= $wdt_listing_custom_html;

				$wdt_media_images_ids = $wdt_media_galleries = array ();
				if($listing_id > 0) {
					$wdt_media_images_ids    = get_post_meta($listing_id, 'wdt_media_images_ids', true);
					if(is_array($wdt_media_images_ids) && !empty($wdt_media_images_ids)) {
						foreach($wdt_media_images_ids as $wdt_media_attachments_id) {
							$thumbnail_url = wp_get_attachment_image_src($wdt_media_attachments_id, 'full');
							$wdt_media_galleries[] = $thumbnail_url[0];
						}
					}
				}

                $output .= '<div class="wdt-listings-item-image-gallery" data-media-gallery="'.esc_js( wp_json_encode($wdt_media_galleries) ).'">';
                    $output .= do_shortcode('[wdt_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" /]');
                $output .= '</div>';

			$output .= '</div>';

			$output .= '<div class="wdt-listings-item-bottom-section">';

				$output .= '<div class="wdt-listings-item-bottom-section-content">';

					$output .= '<div class="wdt-listings-item-bottom-left-content">';

						$output .= '<div class="wdt-listings-item-title">';
							$output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
						$output .= '</div>';

                        $output .= do_shortcode('[wdt_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="wdt_listings_category" type="type1" splice="'.esc_attr($no_of_cat_to_display).'" /]');

					$output .= '</div>';

					if( $show_image_popup == 'yes' ) {
						$output .= '<div class="wdt-listings-hover-image-icon"><svg class="wdt-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 560 560" style="enable-background:new 0 0 560 560;" xml:space="preserve"><path d="M184.4,336L56,464.4V336H0v224h224v-56H95.6L224,375.6L184.4,336z M336,0v56h128.4L336,184.4l39.6,39.6L504,95.6V224h56V0 L336,0z M504,464.4L375.6,336L336,375.6L464.4,504H336v56h224V336h-56L504,464.4z M0,0v224h56V95.6L183.4,223l39.6-39.6L95.6,56H224 V0L0,0z"/></svg></div>';
					}

				$output .= '</div>';

			$output .= '</div>';

		} else if($type == 'type6') {

			$output .= '<div class="wdt-listings-item-top-section">';

				$output .= $wdt_listing_custom_html;

				$wdt_media_images_ids = $wdt_media_galleries = array ();
				if($listing_id > 0) {
					$wdt_media_images_ids    = get_post_meta($listing_id, 'wdt_media_images_ids', true);
					if(is_array($wdt_media_images_ids) && !empty($wdt_media_images_ids)) {
						foreach($wdt_media_images_ids as $wdt_media_attachments_id) {
							$thumbnail_url = wp_get_attachment_image_src($wdt_media_attachments_id, 'full');
							$wdt_media_galleries[] = $thumbnail_url[0];
						}
					}
				}

                $output .= '<div class="wdt-listings-item-image-gallery" data-media-gallery="'.esc_js( wp_json_encode($wdt_media_galleries) ).'">';
                    $output .= do_shortcode('[wdt_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" /]');
					if( $show_image_popup == 'yes' ) {
						$output .= '<div class="wdt-listings-hover-image-icon"><svg class="wdt-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 560 560" style="enable-background:new 0 0 560 560;" xml:space="preserve"><path d="M184.4,336L56,464.4V336H0v224h224v-56H95.6L224,375.6L184.4,336z M336,0v56h128.4L336,184.4l39.6,39.6L504,95.6V224h56V0 L336,0z M504,464.4L375.6,336L336,375.6L464.4,504H336v56h224V336h-56L504,464.4z M0,0v224h56V95.6L183.4,223l39.6-39.6L95.6,56H224 V0L0,0z"/></svg></div>';
					}
                $output .= '</div>';

			$output .= '</div>';

			$output .= '<div class="wdt-listings-item-bottom-section">';

				$output .= '<div class="wdt-listings-item-bottom-section-content">';

					$output .= '<div class="wdt-listings-item-bottom-left-content">';

						$output .= '<div class="wdt-listings-item-title">';
							$output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
						$output .= '</div>';

                        if($custom_excerpt != '') {
                            $output .= '<div class="wdt-listings-excerpt">';
                                $output .= '<p>';
                                    $e_title = 	get_post_meta($listing_id, 'wdt_excerpt_title', true);
                                    if(  $e_title != '' ) {
                                        $output .= '<span>'.esc_html( $e_title ).'</span>';
                                    }
                                    $output .= $custom_excerpt;
                                $output .= '</p>';
                            $output .= '</div>';
                        }

						$view_details_btn = '<span class="detail-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 159 95.6" style="enable-background:new 0 0 159 95.6;" xml:space="preserve"><g class="eye-wrap"><path class="eye-inner" d="M79.5,19.3C63.8,19.3,51,32.1,51,47.8s12.8,28.5,28.5,28.5S108,63.5,108,47.8C108,32.1,95.2,19.3,79.5,19.3z M79.5,67.3 C68.7,67.3,60,58.6,60,47.8s8.7-19.5,19.5-19.5S99,37,99,47.8l0,0C99,58.6,90.3,67.3,79.5,67.3z"/><path class="eye-outer" d="M158.4,45.6C133.2,2,77.5-12.9,33.9,12.2c-13.8,8-25.3,19.5-33.3,33.3c-0.8,1.4-0.8,3.1,0,4.5 c25.2,43.6,80.9,58.5,124.5,33.3c13.8-8,25.3-19.5,33.3-33.3C159.2,48.7,159.2,47,158.4,45.6z M79.5,86.6 c-28.4,0-54.7-14.7-69.8-38.8C33.7,9.3,84.3-2.5,122.8,21.4c10.7,6.7,19.8,15.7,26.4,26.4C134.2,71.9,107.9,86.5,79.5,86.6 L79.5,86.6z"/></g></svg></span>';
						if( $enable_view_details_btn == 'yes' ) {
							$view_details_btn = $view_details_btn;
						} else {
							$view_details_btn = '';
						}
                        $output .= '<a class="custom-button-style wdt-listing-view-details" href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html__('View Details','wdt-portfolio').''.$view_details_btn.'</a>';

					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

		} else if($type == 'type7') {

			$output .= '<div class="wdt-listings-item-top-section">';

				$output .= $wdt_listing_custom_html;

                $output .= '<div class="wdt-listings-item-image-gallery">';
                    $output .= do_shortcode('[wdt_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" with_link="true" /]');
                $output .= '</div>';

			$output .= '</div>';

			$output .= '<div class="wdt-listings-item-hover-section">';
				$output .= '<h6 class="wdt-listings-item-title">'.esc_html( get_the_title($listing_id) ).'</h6>';
				$output .= do_shortcode('[wdt_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="wdt_listings_category" type="type7" splice="'.esc_attr($no_of_cat_to_display).'" /]');
			$output .= '</div>';

		}

	if($apply_isotope == 'true') {
			$output .= '</div>';
		$output .= '</div>';
	} else {
		$output .= '</div>';
	}

	return $output;

}

// Favourite marker html

function wdt_favourite_marker_html($listing_id) {

	$favourite_marker = '';

	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;

	$favourite_items = get_user_meta($user_id, 'favourite_items', true);
	$favourite_items = (is_array($favourite_items) && !empty($favourite_items)) ? $favourite_items : array();

	$favourite_attr = 'data-listingid="'.$listing_id.'"';
	if($user_id > 0) {
		if(in_array($listing_id, $favourite_items)) {
			$favourite_class = 'removefavourite';
			$favourite_icon_class = 'fa fa-heart';
		} else {
			$favourite_class = 'addtofavourite';
			$favourite_icon_class = 'far fa-heart';
		}
		$favourite_attr .= ' data-userid="'.$user_id.'"';
	} else {
		$favourite_class = 'wdt-login-link';
		$favourite_attr = '';
		$favourite_icon_class = 'far fa-heart';
	}

	$favourite_marker .= '<div class="wdt-listings-utils-item wdt-listings-utils-favourite">';
		$favourite_marker .= '<a class="wdt-listings-utils-favourite-item '.esc_attr( $favourite_class ).'" '.$favourite_attr.'><span class="'.esc_attr( $favourite_icon_class ).'"></span></a>';
	$favourite_marker .= '</div>';

	return $favourite_marker;

}


// Ajax Pagination

function wdt_listing_ajax_pagination($max_num_pages, $current_page, $function_call, $output_div, $item_ids) {

	$output = '';

	if($max_num_pages > 1) {

		unset($item_ids['_wpnonce']);
		unset($item_ids['column_class']);
		unset($item_ids['carousel_class']);
		unset($item_ids['offset']);
		unset($item_ids['current_page']);
		unset($item_ids['function_call']);
		unset($item_ids['output_div']);
		unset($item_ids['woocommerce-login-nonce']);
		unset($item_ids['woocommerce-reset-password-nonce']);

		$listing_options = json_encode($item_ids);

        $class = '';
        if($item_ids['pagination_type'] == 'loadmore') {
            $class = 'wdt-loadmore-pagination';
        } else if($item_ids['pagination_type'] == 'infinity') {
            $class = 'wdt-infinity-pagination';
        }

		$output .= '<div class="wdt-pagination wdt-listing-pagination wdt-ajax-pagination '.esc_attr($class).'"  data-functioncall="'.esc_attr( $function_call ).'" data-outputdiv="'.esc_attr( $output_div ).'" data-listing-options="'.esc_js($listing_options).'">';

            if($item_ids['pagination_type'] == 'loadmore') {

                $output .= '<a href="#" data-currentpage="'.esc_attr( $current_page ).'">'.esc_html__('Load More','wdt-portfolio').'</a>';

            } else if($item_ids['pagination_type'] == 'infinity') {

                $output .= '<a href="#" data-currentpage="'.esc_attr( $current_page ).'">'.esc_html__('Scroll to view more items','wdt-portfolio').'</a>';

            } else if($item_ids['pagination_type'] == 'numbered') {

                if($current_page > 1) {
                    $output .= '<div class="prev-post"><a href="#" data-currentpage="'.esc_attr( $current_page ).'"><span class="fa fa-caret-left"></span>&nbsp;'.esc_html__('Prev','wdt-portfolio').'</a></div>';
                }

                $output .= paginate_links ( array (
                    'base' 		 => '#',
                    'format' 		 => '',
                    'current' 	 => $current_page,
                    'type'     	 => 'list',
                    'end_size'     => 2,
                    'mid_size'     => 3,
                    'prev_next'    => false,
                    'total' 		 => $max_num_pages
                ) );

                if ($current_page < $max_num_pages) {
                    $output .= '<div class="next-post"><a href="#" data-currentpage="'.esc_attr( $current_page ).'">'.esc_html__('Next','wdt-portfolio').'&nbsp;<span class="fa fa-caret-right"></span></a></div>';
                }

            }

		$output .= '</div>';

    }

    return $output;

}


// Listing item favourite marker

add_action( 'wp_ajax_wdt_listing_favourite_marker', 'wdt_listing_favourite_marker' );
add_action( 'wp_ajax_nopriv_wdt_listing_favourite_marker', 'wdt_listing_favourite_marker' );
function wdt_listing_favourite_marker() {

	$listing_id = isset($_REQUEST['listing_id']) ? wdt_sanitize_fields($_REQUEST['listing_id']) : -1;
	$user_id = isset($_REQUEST['user_id']) ? wdt_sanitize_fields($_REQUEST['user_id']) : -1;

	if($listing_id > 0 && $user_id > 0) {

		$favourite_items = get_user_meta($user_id, 'favourite_items', true);
		$favourite_items = (is_array($favourite_items) && !empty($favourite_items)) ? $favourite_items : array();

		if(in_array($listing_id, $favourite_items)) {
			unset($favourite_items[array_search($listing_id, $favourite_items)]);
		} else {
			array_push($favourite_items, $listing_id);
		}

		update_user_meta($user_id, 'favourite_items', $favourite_items);

	}

	die();

}

// Listing Page View Counter

function wdt_listing_page_view_counter_overall_update($listing_id, $user_id) {

	$restrict_counter_overuserip = wdt_option('general', 'restrict-counter-overuserip');

	// Update views if not restricted over ip
	if($restrict_counter_overuserip != 'true') {
		wdt_listing_page_view_counter_update($listing_id, $user_id);
	}


    // Update views over over user ip and date
    $user_ip = $_SERVER['REMOTE_ADDR'];

	$wdt_user_ips = get_post_meta($listing_id, 'wdt_user_ips', true);
	$wdt_user_ips = (is_array($wdt_user_ips) && !empty($wdt_user_ips)) ? $wdt_user_ips : array ();

	if(!in_array($user_ip, $wdt_user_ips)) {

		array_push($wdt_user_ips, $user_ip);
		update_post_meta($listing_id, 'wdt_user_ips', $wdt_user_ips);

		if($restrict_counter_overuserip == 'true') {
		    wdt_listing_page_view_counter_update($listing_id, $user_id);
		}

	}

}

function wdt_listing_page_view_counter_update($listing_id, $user_id) {


	// Total views update
    $total_views = get_post_meta($listing_id, 'wdt_total_views', true);
    $total_views = ($total_views != '') ? $total_views : 0;

	$total_views++;

	update_post_meta($listing_id, 'wdt_total_views', $total_views);

	// Datewise view
    $today = current_time('d-m-Y');

    $wdt_detailed_views =  get_post_meta($listing_id, 'wdt_detailed_views', true);
    $wdt_detailed_views = (is_array($wdt_detailed_views) && !empty($wdt_detailed_views)) ? $wdt_detailed_views : array ();

    if(empty($wdt_detailed_views)) {

        $wdt_detailed_views[$today] = 1;

    } else {

        if(!isset($wdt_detailed_views[$today])) {
            $wdt_detailed_views[$today] = 1;
        } else {
            $wdt_detailed_views[$today] = intval($wdt_detailed_views[$today])+1;
        }

    }

    update_post_meta($listing_id, 'wdt_detailed_views', $wdt_detailed_views);

}


// Listing item contact form

add_action( 'wp_ajax_wdt_process_listing_contactform', 'wdt_process_listing_contactform' );
add_action( 'wp_ajax_nopriv_wdt_process_listing_contactform', 'wdt_process_listing_contactform' );
function wdt_process_listing_contactform() {

	$wdt_contactform_nonce = wdt_sanitize_fields( $_POST['wdt_contactform_nonce'] );
	$listing_id             = isset($_REQUEST['wdt_contactform_listingid']) ? wdt_sanitize_fields($_REQUEST['wdt_contactform_listingid'])      : -1;
	$user_id                = isset($_REQUEST['wdt_contactform_userid']) ? wdt_sanitize_fields($_REQUEST['wdt_contactform_userid'])            : -1;
	$contact_point          = isset($_REQUEST['wdt_contactform_contactpoint']) ? wdt_sanitize_fields($_REQUEST['wdt_contactform_contactpoint']) : '';
	$include_admin          = isset($_REQUEST['wdt_contactform_includeadmin']) ? wdt_sanitize_fields($_REQUEST['wdt_contactform_includeadmin']) : '';

	$errors = false;
	$error_msg = $error_msg1 = array ();
	$flag = 0;

    if(!wp_verify_nonce( $wdt_contactform_nonce, 'contact_listing_'.$listing_id)) {
    	$errors = true;
    	array_push($error_msg, esc_html__('Unverified Nonce!','wdt-portfolio'));
    }

	if($user_id > 0) {

		$contactform_name  = get_the_author_meta( 'display_name' , $user_id );
		$contactform_email = get_the_author_meta( 'user_email' , $user_id );
		$contactform_phone = '';

	} else {

		$contactform_name = wdt_sanitize_fields($_REQUEST['wdt_contactform_name']);
		if(empty($contactform_name)) {
			$errors = true; $flag = 1;
			array_push($error_msg, esc_html__('Name','wdt-portfolio'));
		}

		$contactform_email = sanitize_email($_REQUEST['wdt_contactform_email']);
		if(empty($contactform_email)) {
			$errors = true; $flag = 1;
			array_push($error_msg, esc_html__('Email','wdt-portfolio'));
		} else if (!filter_var($contactform_email, FILTER_VALIDATE_EMAIL)) {
			$errors = true;
			array_push($error_msg1, esc_html__('Email field is not valid!','wdt-portfolio'));
		}

		$contactform_phone = wdt_sanitize_fields($_REQUEST['wdt_contactform_phone']);
		if(empty($contactform_phone)) {
			$errors = true; $flag = 1;
			array_push($error_msg, esc_html__('Phone','wdt-portfolio'));
		} else {
			$contactform_phone = str_replace(array('-','(',')', ' ', '+'), '', $contactform_phone);
			if(is_numeric($contactform_phone) === FALSE) {
				$errors = true;
				array_push($error_msg1, esc_html__('Phone field is not valid!','wdt-portfolio'));
			}
		}

	}

    $contactform_message = wp_kses_post($_REQUEST['wdt_contactform_message']);
    if(empty($contactform_message)) {
     	$errors = true; $flag = 1;
    	array_push($error_msg, esc_html__('Message','wdt-portfolio'));
    }

    // Retrieving target emails

    $target_emails = array ();

    if($contact_point == 'author-email') {

        $listing_post = get_post($listing_id);
        $author_id = $listing_post->post_author;

        $wdt_author_email = get_the_author_meta( 'user_email' , $author_id );
        if($wdt_author_email != '') {
            array_push($target_emails, $wdt_author_email);
        }

    } else {

    	$wdt_listing_email = get_post_meta($listing_id, 'wdt_email', true);
    	if($wdt_listing_email != '') {
	    	array_push($target_emails, $wdt_listing_email);
		}

    }

    if($include_admin == 'true') {
    	$admin_email = get_option('admin_email');
    	array_push($target_emails, $admin_email);
    }

	if(empty($target_emails)) {
     	$errors = true;
    	array_push($error_msg1, esc_html__('No contact emails found, contact administrator!','wdt-portfolio'));
	}


    // Throw error message
    if($errors) {

    	$error_content = '<div class="wdt-contactform-errorlist">';
    	$error_content .= implode(' / ', $error_msg);
	    if( $flag ){
	    	$error_content .= esc_html__(' fields are Empty!','wdt-portfolio');
	    }

	    if( !empty($error_msg1) ){
	    	array_walk($error_msg1, function(&$value, &$key) {
   				$value = '<span>'.$value.'</span>';
			});
			$error_content .= implode('', $error_msg1);
	    }

    	$error_content .= '</div>';

        echo json_encode(array(
            'success' => false,
            'message' => $error_content
        ));
        wp_die();

    }


	// Leads Data Update

	if($contact_point == 'author-email' && $wdt_author_email != '') {

		// Update Leads Count

		$leads_count = get_user_meta($author_id, 'wdt_leads_count', true);
		$leads_count = isset($leads_count) ? ((int)$leads_count + 1) : 1;
		update_user_meta($author_id, 'wdt_leads_count', $leads_count);


		// Update Leads Message

		$leadDate = date(get_option('date_format').' '.get_option('time_format'));

		$leadData['user_id']       = $user_id;
		$leadData['name'] 		   = $contactform_name;
		$leadData['phone']         = $contactform_phone;
		$leadData['extras']        = $newFormData;

		$leadConversation['leadData']['message'] = $contactform_message;
		$leadConversation['leadData']['date']    = $leadDate;
		$leadConversation['status']              = 'unread';


		$wdt_lead_messages = get_user_meta($author_id, 'wdt_lead_messages', true);

		if(!empty($wdt_lead_messages)) {

			if (array_key_exists($listing_id, $wdt_lead_messages)) { // If message already exists

				$existing_lead_messages = $wdt_lead_messages[$listing_id];

				if(array_key_exists($contactform_email, $existing_lead_messages)) {

					$prevConversation = $wdt_lead_messages[$listing_id][$contactform_email]['leads']['conversation'];
					array_push($prevConversation, $leadConversation);

					$wdt_lead_messages[$listing_id][$contactform_email]['leads'] = $leadData;
					$wdt_lead_messages[$listing_id][$contactform_email]['leads']['conversation'] = $prevConversation;
				} else {

					$wdt_lead_messages[$listing_id][$contactform_email]['leads'] = $leadData;
					$wdt_lead_messages[$listing_id][$contactform_email]['leads']['conversation'][0] = $leadConversation;
				}

			} else {

				$wdt_lead_messages[$listing_id][$contactform_email]['leads'] = $leadData;
				$wdt_lead_messages[$listing_id][$contactform_email]['leads']['conversation'][0] = $leadConversation;
			}

		} else { // For first message

			$wdt_lead_messages = array ();
			$wdt_lead_messages[$listing_id][$contactform_email]['leads'] = $leadData;
			$wdt_lead_messages[$listing_id][$contactform_email]['leads']['conversation'][0] = $leadConversation;
		}

		update_user_meta($author_id, 'wdt_lead_messages', $wdt_lead_messages);


		// Update Recent Activities

		$recentActivitiesData['type']          = 'contact';
		$recentActivitiesData['date']          = date(get_option('date_format').' '.get_option('time_format'));
		$recentActivitiesData['user_id']       = $user_id;
		$recentActivitiesData['name'] 		   = $contactform_name;
		$recentActivitiesData['phone']         = $contactform_phone;
		$recentActivitiesData['email']         = $contactform_email;
		$recentActivitiesData['listing_id']    = $listing_id;

		$wdt_recent_activities = get_user_meta($author_id, 'wdt_recent_activities', true);
		$wdt_recent_activities = (is_array($wdt_recent_activities) && !empty($wdt_recent_activities)) ? $wdt_recent_activities : array ();

		if(!empty($wdt_recent_activities)) {

			if(count($wdt_recent_activities) >= 20) {
				$wdt_recent_activities = array_slice($wdt_recent_activities, 0, 20);
				array_unshift($wdt_recent_activities, $recentActivitiesData);
			} else {
				array_unshift($wdt_recent_activities, $recentActivitiesData);
			}

		} else {

			array_unshift($wdt_recent_activities, $recentActivitiesData);

		}

		update_user_meta($author_id, 'wdt_recent_activities', $wdt_recent_activities);

	}



    // Composing mail

    $wdt_subject = sprintf(esc_html__('New message from %1$s - %2$s','wdt-portfolio'), $contactform_name, get_bloginfo('name'));

    $wdt_body = esc_html__('You have received a message from: ','wdt-portfolio') . $contactform_name . " <br/>";
    $wdt_body .= esc_html__('Phone Number : ','wdt-portfolio') . $contactform_phone . " <br/><br/>";
    $wdt_body .= wpautop( $contactform_message ) . " <br/>";
    $wdt_body .= sprintf(esc_html__( 'You can contact %1$s via email %2$s','wdt-portfolio'), $contactform_name, $contactform_email);

    $wdt_header = 'Content-type: text/html; charset=utf-8' . "\r\n";
    $wdt_header .= 'From: ' . $contactform_name . " <" . $contactform_email . "> \r\n";

    if (wp_mail($target_emails, $wdt_subject, $wdt_body, $wdt_header)) {

        echo json_encode(array (
            'success' => true,
            'message' => esc_html__('Message Sent Successfully!','wdt-portfolio')
		));

		wp_die();

    } else {
        echo json_encode(array (
                'success' => false,
                'message' => esc_html__('Something went wrong!. Please check your settings!.','wdt-portfolio')
            )
        );
        wp_die();
    }

	wp_die();

}

// Contact details request process

add_action( 'wp_ajax_wdt_listing_contactdetails_request', 'wdt_listing_contactdetails_request' );
add_action( 'wp_ajax_nopriv_wdt_listing_contactdetails_request', 'wdt_listing_contactdetails_request' );
function wdt_listing_contactdetails_request() {


    $listing_id = isset($_REQUEST['listing_id']) ? wdt_sanitize_fields($_REQUEST['listing_id']) : -1;

    $errors = false;
    $error_msg = array ();

    if($listing_id > 0) {

        $listing_singular_label = apply_filters( 'listing_label', 'singular' );

        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;

        if(function_exists('wdt_check_user_buyer_package_is_active') && wdt_check_user_buyer_package_is_active($user_id, -1)) {

            $wdt_buyer_package_listings = get_user_meta($user_id, 'wdt_buyer_package_listings', true);
            $wdt_buyer_package_listings = (is_array($wdt_buyer_package_listings) && !empty($wdt_buyer_package_listings)) ? $wdt_buyer_package_listings : array ();
            $wdt_buyer_package_listings = array_unique($wdt_buyer_package_listings);


            $wdt_buyer_active_package_id = get_user_meta($user_id, 'wdt_buyer_active_package_id', true);
            $wdt_buyer_active_package_id = (isset($wdt_buyer_active_package_id) && !empty($wdt_buyer_active_package_id)) ? $wdt_buyer_active_package_id : -1;


            // Available counts
            $wdt_buyer_package_listings_count = get_user_meta($user_id, 'wdt_buyer_package_listings_count', true);
            $wdt_buyer_package_listings_count = (isset($wdt_buyer_package_listings_count) && !empty($wdt_buyer_package_listings_count)) ? $wdt_buyer_package_listings_count : 0;


            // Used counts
            $wdt_buyer_package_used_listings_count = get_user_meta($user_id, 'wdt_buyer_package_used_listings_count', true);
            $wdt_buyer_package_used_listings_count = (isset($wdt_buyer_package_used_listings_count) && !empty($wdt_buyer_package_used_listings_count)) ? $wdt_buyer_package_used_listings_count : 0;


            // Remaining counts
            $wdt_buyer_allow_listings = false;
            if($wdt_buyer_package_listings_count == -1) {
                $wdt_buyer_allow_listings = true;
            } else {
                $wdt_buyer_remaining_listings_count = ($wdt_buyer_package_listings_count - $wdt_buyer_package_used_listings_count);
            }

            if(!in_array($listing_id, $wdt_buyer_package_listings)) {

                if($wdt_buyer_remaining_listings_count > 0 || $wdt_buyer_allow_listings) {

                    array_push($wdt_buyer_package_listings, $listing_id);
                    update_user_meta($user_id, 'wdt_buyer_package_listings', $wdt_buyer_package_listings);

                    $wdt_buyer_package_used_listings_count = get_user_meta($user_id, 'wdt_buyer_package_used_listings_count', true);
                    $wdt_buyer_package_used_listings_count++;
                    update_user_meta($user_id, 'wdt_buyer_package_used_listings_count', $wdt_buyer_package_used_listings_count);

                    echo json_encode(array(
                        'success' => true
                    ));
                    wp_die();

                } else {

                    echo json_encode(array (
                            'success' => false,
                            'message' => sprintf(esc_html__('Your subscribtion limit have been reached, please check your dashboard.','wdt-portfolio'), strtolower($listing_singular_label))
                        )
                    );
                    wp_die();

                }

            } else {

                echo json_encode(array (
                        'success' => false,
                        'message' => sprintf(esc_html__('You have already subscribed this %1$s.','wdt-portfolio'), strtolower($listing_singular_label))
                    )
                );
                wp_die();

            }

        } else {

            echo json_encode(array (
                    'success' => false,
                    'message' => sprintf(esc_html__('You don\'t have any active package to send request.','wdt-portfolio'), strtolower($listing_singular_label))
                )
            );
            wp_die();
        }

    }

    wp_die();

}

// Activity Tracker - Website Visit
add_action( 'wp_ajax_wdt_listing_activity_tracker_contactdetails', 'wdt_listing_activity_tracker_contactdetails' );
add_action( 'wp_ajax_nopriv_wdt_listing_activity_tracker_contactdetails', 'wdt_listing_activity_tracker_contactdetails' );
function wdt_listing_activity_tracker_contactdetails() {

	$activity_type = isset($_REQUEST['activity_type']) ? wdt_sanitize_fields($_REQUEST['activity_type']) : '';
	$listing_id    = isset($_REQUEST['listing_id']) ? wdt_sanitize_fields($_REQUEST['listing_id']) : -1;
	$user_id       = (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] > 0) ? wdt_sanitize_fields($_REQUEST['user_id']) : -1;
	$country       = isset($_REQUEST['country']) ? wdt_sanitize_fields($_REQUEST['country']) : '';
	$city          = isset($_REQUEST['city']) ? wdt_sanitize_fields($_REQUEST['city']) : '';
	$zip           = isset($_REQUEST['zip']) ? wdt_sanitize_fields($_REQUEST['zip']) : '';

	$listing_post = get_post($listing_id);
	$author_id = $listing_post->post_author;

	if($author_id > 0 && $listing_id > 0 && $activity_type != '') {

		// Update Leads Count

		$leads_count = get_user_meta($author_id, 'wdt_leads_count', true);
		$leads_count = isset($leads_count) ? ((int)$leads_count + 1) : 1;
		update_user_meta($author_id, 'wdt_leads_count', $leads_count);


		// Update Recent Activities

		$recentActivitiesData['type']       = $activity_type;
		$recentActivitiesData['date']       = date(get_option('date_format').' '.get_option('time_format'));
		$recentActivitiesData['user_id']    = $user_id;
		$recentActivitiesData['country'] 	= $country;
		$recentActivitiesData['city']       = $city;
		$recentActivitiesData['zip']        = $zip;
		$recentActivitiesData['listing_id'] = $listing_id;

		$wdt_recent_activities = get_user_meta($author_id, 'wdt_recent_activities', true);
		$wdt_recent_activities = (is_array($wdt_recent_activities) && !empty($wdt_recent_activities)) ? $wdt_recent_activities : array ();

		if(!empty($wdt_recent_activities)) {

			if(count($wdt_recent_activities) >= 20) {
				$wdt_recent_activities = array_slice($wdt_recent_activities, 0, 20);
				array_unshift($wdt_recent_activities, $recentActivitiesData);
			} else {
				array_unshift($wdt_recent_activities, $recentActivitiesData);
			}

		} else {

			array_unshift($wdt_recent_activities, $recentActivitiesData);

		}

		update_user_meta($author_id, 'wdt_recent_activities', $wdt_recent_activities);

	}

	wp_die();
}

if(!function_exists('breadcrumbs_portfolio_module')) {
    function breadcrumbs_portfolio_module( $breadcrumbs ) {

        if (is_singular( 'wdt_listings' )) {

            global $post;

            $terms = get_the_terms(
                $post->ID,
                'wdt_listings_category'
            );

            if(isset($terms[0]) && !empty($terms[0])) {
                $breadcrumbs[] = '<a href="'.get_term_link( $terms[0] ).'">'.$terms[0]->name.'</a>';
            }
            $breadcrumbs[] = '<span class="current">'.get_the_title($post->ID).'</span>';

        } elseif (is_tax ( 'wdt_listings_category' )) {

            $breadcrumbs[] = '<span class="current">'.single_term_title( '', false ).'</span>';

        } elseif (is_tax ( 'wdt_listings_amenity' )) {

            $breadcrumbs[] = '<span class="current">'.single_term_title( '', false ).'</span>';

        }


        return $breadcrumbs;

    }
    add_filter( 'wedesigntech_breadcrumbs', 'breadcrumbs_portfolio_module', 10, 1 );
}

?>
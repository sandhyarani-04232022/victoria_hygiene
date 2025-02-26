<?php
/**
 * Customizer Control: Typography
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mezan_Customize_Control_Typography extends WP_Customize_Control {

	public $type       = 'wdt-typography';
	public $dependency = array();

	/**
	 * Enqueue control related scripts/styles.
	 *
	 */
	public function enqueue() {

		wp_enqueue_script( 'mezan-plus-typography-control', MEZAN_PLUS_DIR_URL.'customizer/controls/typography/typography.js', array( 'jquery', 'customize-base' ), MEZAN_PLUS_VERSION, true );
		wp_enqueue_style( 'mezan-plus-typography-control',  MEZAN_PLUS_DIR_URL.'customizer/controls/typography/typography.css', null, MEZAN_PLUS_VERSION );

		$typo_localize = array(
			'inherit' => esc_html__( 'Inherit', 'mezan-plus' ),
			'100'     => esc_html__( 'Thin 100', 'mezan-plus' ),
			'200'     => esc_html__( 'Extra-Light 200', 'mezan-plus' ),
			'300'     => esc_html__( 'Light 300', 'mezan-plus' ),
			'400'     => esc_html__( 'Normal 400', 'mezan-plus' ),
			'500'     => esc_html__( 'Medium 500', 'mezan-plus' ),
			'600'     => esc_html__( 'Semi-Bold 600', 'mezan-plus' ),
			'700'     => esc_html__( 'Bold 700', 'mezan-plus' ),
			'800'     => esc_html__( 'Extra-Bold 800', 'mezan-plus' ),
			'900'     => esc_html__( 'Ultra-Bold 900', 'mezan-plus' ),
			'normal'  => esc_html__( 'Normal', 'mezan-plus' ),
			'normal'  => esc_html__( 'Normal', 'mezan-plus' ),
			'bold'    => esc_html__( 'Bold', 'mezan-plus' ),
			''        => esc_html__('Default', 'mezan-plus' ),
		);

		wp_localize_script( 'mezan-plus-typography-control', 'wdtPlusTypoObject', $typo_localize );
	}

	/**
	 * Get a specific property of an array without needing to check if that property exists.
	 *
	 * Provide a default value if you want to return a specific value if the property is not set.
	 *
	 * @param array  $array   Array from which the property's value should be retrieved.
	 * @param string $prop    Name of the property to be retrieved.
	 * @param string $default Optional. Value that should be returned if the property is not set or empty. Defaults to null.
	 *
	 * @return null|string|mixed The value
	 */
	public function fonts_util( $array, $prop, $default = null ) {

		if ( ! is_array( $array ) && ! ( is_object( $array ) && $array instanceof ArrayAccess ) ) {
			return $default;
		}

		if ( isset( $array[ $prop ] ) ) {
			$value = $array[ $prop ];
		} else {
			$value = '';
		}

		return empty( $value ) && null !== $default ? $default : $value;
	}

	public function get_system_fonts() {
		$fonts = array(
			'Helvetica' => array(
				'fallback' => 'Verdana, Arial, sans-serif',
				'weights'  => array(
					'300',
					'400',
					'700',
				),
			),
			'Verdana'   => array(
				'fallback' => 'Helvetica, Arial, sans-serif',
				'weights'  => array(
					'300',
					'400',
					'700',
				),
			),
			'Arial'     => array(
				'fallback' => 'Helvetica, Verdana, sans-serif',
				'weights'  => array(
					'300',
					'400',
					'700',
				),
			),
			'Times'     => array(
				'fallback' => 'Georgia, serif',
				'weights'  => array(
					'300',
					'400',
					'700',
				),
			),
			'Georgia'   => array(
				'fallback' => 'Times, serif',
				'weights'  => array(
					'300',
					'400',
					'700',
				),
			),
			'Courier'   => array(
				'fallback' => 'monospace',
				'weights'  => array(
					'300',
					'400',
					'700',
				),
			),
		);

		return $fonts;
	}

	public function get_custom_fonts() {
		$fonts = apply_filters( 'mezan_customizer_custom_fonts', array() );
		return $fonts;
	}

	public function get_google_fonts() {
		$fonts = array();

		$google_fonts_file = MEZAN_PLUS_DIR_PATH . 'customizer/controls/typography/google-fonts.json';
		if( !file_exists( $google_fonts_file ) ) {
			return $fonts;
		}

		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		$file_contants     = $wp_filesystem->get_contents( $google_fonts_file );
		$google_fonts_json = json_decode( $file_contants, 1 );

		foreach ( $google_fonts_json as $key => $font ) {

			$name = key( $font );

			foreach ( $font[ $name ] as $font_key => $single_font ) {

				if ( 'variants' === $font_key ) {

					foreach ( $single_font as $variant_key => $variant ) {

						if ( stristr( $variant, 'italic' ) ) {
							unset( $font[ $name ][ $font_key ][ $variant_key ] );
						}

						if ( 'regular' == $variant ) {
							$font[ $name ][ $font_key ][ $variant_key ] = '400';
						}
					}
				}

				$fonts[ $name ] = array_values( $font[ $name ] );
			}
		}

		return $fonts;
	}

	public function get_subset( $font_family ) {
		$subset = array();

		$google_fonts_file = MEZAN_PLUS_DIR_PATH . 'customizer/controls/typography/google-fonts.json';
		if( !file_exists( $google_fonts_file ) ) {
			return $fonts;
		}

		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		$file_contants     = $wp_filesystem->get_contents( $google_fonts_file );
		$google_fonts_json = json_decode( $file_contants, 1 );

		foreach ( $google_fonts_json as $key => $font ) {

			$name = key( $font );
			if( $name == $font_family ) {

				$values = array_values( $font[ $name ] );
				$subset = isset( $values[2] ) ? $values[2] : $subset;
			}
		}

		return $subset;
	}

	/**
	 * Get the data to export to the client via JSON.
	 *
	 */
	public function to_json() {
		parent::to_json();

		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}

		$val = maybe_unserialize( $this->value() );
		if ( ! is_array( $val ) ) {
			$val = array();
		}

		$choices = maybe_unserialize( $this->choices );

		if ( ! is_array( $choices ) || empty( $choices ) ) {

			$this->choices = array(
				'font_family'     => esc_html__( 'Font Family', 'mezan-plus'),
				'font_weight'     => esc_html__( 'Font Weight', 'mezan-plus'),
				'text_transform'  => esc_html__( 'Text Transform', 'mezan-plus'),
				'text_align'      => esc_html__( 'Text Align', 'mezan-plus'),
				'text_decoration' => esc_html__( 'Text Decoration', 'mezan-plus'),
				'font_style'      => esc_html__( 'Font Style', 'mezan-plus'),
				'font_size'       => esc_html__( 'Font Size', 'mezan-plus'),
				'line_height'     => esc_html__( 'Line Height', 'mezan-plus'),
				'letter_spacing'  => esc_html__( 'Letter Spacing', 'mezan-plus'),
			);
		}

		$this->json['value']   = $val;
		$this->json['id']      = $this->id;
		$this->json['label']   = esc_html( $this->label );
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();

		$system_fonts     = array();
		$get_system_fonts = $this->get_system_fonts();
		foreach ( $get_system_fonts as $name => $value ) {

			$fallback = $value['fallback'];
			$weights  = implode(",", $value['weights'] );

			$system_fonts[ $name ] = array(
				'fallback' => $name .', '. $fallback,
				'weights'  => $weights,
			);
		}
		$this->json['system_fonts'] = $system_fonts;

		$custom_fonts = array();
		$this->json['has_custom_fonts'] = array("item" => "no");
		$get_custom_fonts = $this->get_custom_fonts();

		if( is_array($get_custom_fonts ) && !empty( $get_custom_fonts ) ) {

			foreach ( $get_custom_fonts as $name => $value ) {

				$fallback = $value['fallback'];
				$weights  = implode(",", $value['variants'] );


				$custom_fonts[ $name ] = array(
					'fallback' => $name .', '. $fallback,
					'weights'  => $weights,
				);
			}
			$this->json['custom_fonts'] = $custom_fonts;
			$this->json['has_custom_fonts'] = array('item'=>'yes');
		}

		$google_fonts     = array();
		$get_google_fonts = $this->get_google_fonts();

		if( is_array( $get_google_fonts ) && !empty( $get_google_fonts ) ) {

			foreach ( $get_google_fonts as $name => $single_font ) {

				$category = $this->fonts_util( $single_font, '0' );
				$variants = $this->fonts_util( $single_font, '1' );
				$weights  = implode(",", $variants );

				$google_fonts[ $name ] = array(
					'fallback' => "'".$name ."', ". $category,
					'weights'  => $weights,
				);
			}
			$this->json['google_fonts'] = $google_fonts;

		}

	}

	/**
	 * Renders the control wrapper and calls $this->render_content() for the internals.
	 */
	protected function render() {

		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control has-responsive-switchers customize-control-' . esc_attr($this->type);

		$d_controller = $d_condition = $d_value = '';
		$dependency   = $this->dependency;
		if( !empty( $dependency ) ) {
			$d_controller = "data-controller='" . esc_attr( $dependency[0] )."'";
			$d_condition  = "data-condition='" . esc_attr( $dependency[1] )."'";
			$d_value      = "data-value='". esc_attr( $dependency[2] )."'";
		}

		printf( '<li id="%s" class="%s" %s %s %s>', esc_attr( $id ), esc_attr( $class ), $d_controller, $d_condition, $d_value );
		$this->render_content();
		echo '</li>';
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<span class="customize-control-title">
			<#  if ( data.label ) { #>
				<label> <span>{{{ data.label }}}</span> </label>
			<# } #>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</span>
		<div class="wrapper">

			<# if( !_.isUndefined( data.choices['font_family'] ) ) { #>
			<div class="full-width">
				<span class="customize-control-title">
					<label>{{{  data.choices['font_family'] }}}</label>
				</span>

				<select class="font-family">
					<option value=""><?php esc_html_e( 'Inherit', 'mezan-plus' );?></option>
					<optgroup label="<?php esc_html_e( 'Other System Fonts', 'mezan-plus' );?>">
						<# _.each( data.system_fonts, function( element, index ) { #>
							<option
								value = "{{{ index }}}"
								data-fallback = "{{{ element.fallback }}}"
								data-weight = "{{{ element.weights }}}"
								data-fonttype ="system"
								<# if( data.value['font-family'] === index ) { #>selected<#}#>
							>{{{ index }}}</option>
						<# }); #>
					</optgroup>

					<# if( _.isEqual( data.has_custom_fonts, {'item':'yes' } ) ) { #>
						<optgroup label="<?php esc_html_e( 'Custom Fonts', 'mezan-plus' );?>">
							<# _.each( data.custom_fonts, function( element, index ) { #>
								<option
									value = "{{{ index }}}"
									data-fallback = "{{{ element.fallback }}}"
									data-weight = "{{{ element.weights }}}"
									data-fonttype ="custom"
									<# if( data.value['font-family'] === index ) { #>selected<#}#>
								>{{{ index }}}</option>
							<# }); #>
						</optgroup>
					<# } #>

					<optgroup label="<?php esc_html_e( 'Google', 'mezan-plus' );?>">
						<# _.each( data.google_fonts, function( element, index ) { #>
							<option
								value = "{{{ index }}}"
								data-fallback = "{{{ element.fallback }}}"
								data-weight = "{{{ element.weights }}}"
								data-fonttype ="google"
								<# if( data.value['font-family'] === index ) { #>selected<#}#>
							>{{{ index }}}</option>
						<# }); #>
					</optgroup>
				</select>
			</div>
			<# } #>

			<div class="full-width">

				<# if( !_.isUndefined( data.choices['font_weight'] ) ) { #>
					<div class="one-half">
						<span class="customize-control-title">
							<label>{{{  data.choices['font_weight'] }}}</label>
						</span>
						<select class="font-weight">
							<option value="inherit"><?php esc_html_e( 'Inherit', 'mezan-plus' );?></option>
						</select>
					</div>
				<# } #>

				<# if( !_.isUndefined( data.choices['font_style'] ) ) { #>
					<div class="one-half">
						<span class="customize-control-title">
							<label>{{{  data.choices['font_style'] }}}</label>
						</span>
						<select class="font-style">
							<option value=""<# if ( '' === data.value['font-style'] ) { #>selected<# } #>></option>
							<option value="normal"<# if ( 'none' === data.value['font-style'] ) { #>selected<# } #>><?php esc_attr_e( 'Normal', 'mezan-plus' ); ?></option>
							<option value="italic"<# if ( 'italic' === data.value['font-style'] ) { #>selected<# } #>><?php esc_attr_e( 'Italic', 'mezan-plus' ); ?></option>
							<option value="oblique"<# if ( 'oblique' === data.value['font-style'] ) { #>selected<# } #>><?php esc_attr_e( 'Oblique', 'mezan-plus' ); ?></option>
							<option value="inherit"<# if ( 'inherit' === data.value['font-style'] ) { #>selected<# } #>><?php esc_attr_e( 'Inherit', 'mezan-plus' ); ?></option>
						</select>
					</div>
				<# } #>
			</div>

			<# if( !_.isUndefined( data.choices['text_transform'] ) ) { #>
				<div class="full-width">
					<span class="customize-control-title">
						<label>{{{  data.choices['text_transform'] }}}</label>
					</span>
					<select class="text-transform">
						<option value=""<# if ( '' === data.value['text-transform'] ) { #>selected<# } #>></option>
						<option value="none"<# if ( 'none' === data.value['text-transform'] ) { #>selected<# } #>><?php esc_attr_e( 'None', 'mezan-plus' ); ?></option>
						<option value="capitalize"<# if ( 'capitalize' === data.value['text-transform'] ) { #>selected<# } #>><?php esc_attr_e( 'Capitalize', 'mezan-plus' ); ?></option>
						<option value="uppercase"<# if ( 'uppercase' === data.value['text-transform'] ) { #>selected<# } #>><?php esc_attr_e( 'Uppercase', 'mezan-plus' ); ?></option>
						<option value="lowercase"<# if ( 'lowercase' === data.value['text-transform'] ) { #>selected<# } #>><?php esc_attr_e( 'Lowercase', 'mezan-plus' ); ?></option>
						<option value="initial"<# if ( 'initial' === data.value['text-transform'] ) { #>selected<# } #>><?php esc_attr_e( 'Initial', 'mezan-plus' ); ?></option>
						<option value="inherit"<# if ( 'inherit' === data.value['text-transform'] ) { #>selected<# } #>><?php esc_attr_e( 'Inherit', 'mezan-plus' ); ?></option>
					</select>
				</div>
			<# } #>

			<div class="full-width">
				<# if( !_.isUndefined( data.choices['text_align'] ) ) { #>
					<div class="one-half">
						<span class="customize-control-title">
							<label>{{{  data.choices['text_align'] }}}</label>
						</span>
						<select class="text-align">
							<option value=""<# if ( '' === data.value['text-align'] ) { #>selected<# } #>></option>
							<option value="unset"<# if ( 'unset' === data.value['text-align'] ) { #>selected<# } #>><?php esc_attr_e( 'Unset', 'mezan-plus' ); ?></option>
							<option value="left"<# if ( 'left' === data.value['text-align'] ) { #>selected<# } #>><?php esc_attr_e( 'Left', 'mezan-plus' ); ?></option>
							<option value="center"<# if ( 'center' === data.value['text-align'] ) { #>selected<# } #>><?php esc_attr_e( 'Center', 'mezan-plus' ); ?></option>
							<option value="right"<# if ( 'right' === data.value['text-align'] ) { #>selected<# } #>><?php esc_attr_e( 'Right', 'mezan-plus' ); ?></option>
							<option value="justify"<# if ( 'justify' === data.value['text-align'] ) { #>selected<# } #>><?php esc_attr_e( 'Justify', 'mezan-plus' ); ?></option>
							<option value="inherit"<# if ( 'inherit' === data.value['text-align'] ) { #>selected<# } #>><?php esc_attr_e( 'Inherit', 'mezan-plus' ); ?></option>
						</select>
					</div>
				<# } #>

				<# if( !_.isUndefined( data.choices['text_decoration'] ) ) { #>
					<div class="one-half">
						<span class="customize-control-title">
							<label>{{{  data.choices['text_decoration'] }}}</label>
						</span>
						<select class="text-decoration">
							<option value=""<# if ( '' === data.value['text-decoration'] ) { #>selected<# } #>></option>
							<option value="none"<# if ( 'none' === data.value['text-decoration'] ) { #>selected<# } #>><?php esc_attr_e( 'None', 'mezan-plus' ); ?></option>
							<option value="underline"<# if ( 'underline' === data.value['text-decoration'] ) { #>selected<# } #>><?php esc_attr_e( 'Underline', 'mezan-plus' ); ?></option>
							<option value="overline"<# if ( 'overline' === data.value['text-decoration'] ) { #>selected<# } #>><?php esc_attr_e( 'Overline', 'mezan-plus' ); ?></option>
							<option value="line-through"<# if ( 'line-through' === data.value['text-decoration'] ) { #>selected<# } #>><?php esc_attr_e( 'Line Through', 'mezan-plus' ); ?></option>
							<option value="inherit"<# if ( 'inherit' === data.value['text-decoration'] ) { #>selected<# } #>><?php esc_attr_e( 'Inherit', 'mezan-plus' ); ?></option>
						</select>
					</div>
				<# } #>
			</div>

			<div class="full-width font-size">
				<# if( !_.isUndefined( data.choices['font_size'] ) ) { #>
					<span class="customize-control-title">
						<label>{{{  data.choices['font_size'] }}}</label>
						<ul class="wdt-typography-switcher wdt-responsive-switchers">
							<li class="desktop active">
								<button type="button" class="preview-desktop active" data-device="desktop">
									<i class="dashicons dashicons-desktop"></i>
								</button>
							</li>
							<li class="tablet-landscape">
								<button type="button" class="preview-tablet-landscape" data-device="tablet-landscape">
									<i class="dashicons dashicons-tablet"></i>
								</button>
							</li>
							<li class="tablet">
								<button type="button" class="preview-tablet" data-device="tablet">
									<i class="dashicons dashicons-tablet"></i>
								</button>
							</li>
							<li class="mobile">
								<button type="button" class="preview-mobile" data-device="mobile">
									<i class="dashicons dashicons-smartphone"></i>
								</button>
							</li>
						</ul>
						<span class="item-reset dashicons dashicons-image-rotate"></span>
					</span>

					<div class="desktop control-wrap active">
						<input type="number" data-id='desktop' class="wdt-responsive-input" value="{{{ data.value['fs-desktop'] }}}"/>
						<select class="wdt-responsive-select" data-id='desktop-unit'>
							<option value="px" <# if ( data.value['fs-desktop-unit'] === 'px' ) { #> selected="selected" <# } #>>px</option>
							<option value="em" <# if ( data.value['fs-desktop-unit'] === 'em' ) { #> selected="selected" <# } #>>em</option>
						</select>
					</div>

					<div class="tablet control-wrap">
						<input type="number" data-id='tablet' class="wdt-responsive-input" value="{{{ data.value['fs-tablet'] }}}"/>
						<select class="wdt-responsive-select" data-id='tablet-unit'>
							<option value="px" <# if ( data.value['fs-tablet-unit'] === 'px' ) { #> selected="selected" <# } #>>px</option>
							<option value="em" <# if ( data.value['fs-tablet-unit'] === 'em' ) { #> selected="selected" <# } #>>em</option>
						</select>
					</div>

					<div class="tablet-landscape control-wrap">
						<input type="number" data-id='tablet-ls' class="wdt-responsive-input" value="{{{ data.value['fs-tablet-ls'] }}}"/>
						<select class="wdt-responsive-select" data-id='tablet-ls-unit'>
							<option value="px" <# if ( data.value['fs-tablet-ls-unit'] === 'px' ) { #> selected="selected" <# } #>>px</option>
							<option value="em" <# if ( data.value['fs-tablet-ls-unit'] === 'em' ) { #> selected="selected" <# } #>>em</option>
						</select>
					</div>

					<div class="mobile control-wrap">
						<input type="number" data-id='mobile' class="wdt-responsive-input" value="{{{ data.value['fs-mobile'] }}}"/>
						<select class="wdt-responsive-select" data-id='mobile-unit'>
							<option value="px" <# if ( data.value['fs-mobile-unit'] === 'px' ) { #> selected="selected" <# } #>>px</option>
							<option value="em" <# if ( data.value['fs-mobile-unit'] === 'em' ) { #> selected="selected" <# } #>>em</option>
						</select>
					</div>
				<# } #>
			</div>

			<# if( !_.isUndefined( data.choices['line_height'] ) ) { #>
				<div class="line-height full-width">
					<span class="customize-control-title">
						<label>{{{  data.choices['line_height'] }}}</label>
						<ul class="wdt-typography-switcher wdt-responsive-switchers">
							<li class="desktop active">
								<button type="button" class="preview-desktop active" data-device="desktop">
									<i class="dashicons dashicons-desktop"></i>
								</button>
							</li>
							<li class="tablet-landscape">
								<button type="button" class="preview-tablet-landscape" data-device="tablet-landscape">
									<i class="dashicons dashicons-tablet"></i>
								</button>
							</li>
							<li class="tablet">
								<button type="button" class="preview-tablet" data-device="tablet">
									<i class="dashicons dashicons-tablet"></i>
								</button>
							</li>
							<li class="mobile">
								<button type="button" class="preview-mobile" data-device="mobile">
									<i class="dashicons dashicons-smartphone"></i>
								</button>
							</li>
						</ul>
						<span class="item-reset dashicons dashicons-image-rotate"></span>
					</span>

					<div class="desktop control-wrap active">
						<div class="input-field-range">
							<input type="range" class="range-field" data-id='desktop' value="{{{ data.value['lh-desktop'] }}}"/>
						</div>
						<div class="wdt-slider-range-value">
							<input type="number" class="number-field" data-id='desktop' value="{{{ data.value['lh-desktop'] }}}"/>
						</div>
						<select class="wdt-responsive-select" data-id='desktop-unit'>
							<option value="" <# if ( data.value['lh-desktop-unit'] === '' ) { #> selected="selected" <# } #>></option>
							<option value="px" <# if ( data.value['lh-desktop-unit'] === 'px' ) { #> selected="selected" <# } #>>px</option>
							<option value="em" <# if ( data.value['lh-desktop-unit'] === 'em' ) { #> selected="selected" <# } #>>em</option>
						</select>
					</div>

					<div class="tablet control-wrap">
						<div class="input-field-range">
							<input type="range" class="range-field" data-id='tablet' value="{{{ data.value['lh-tablet'] }}}"/>
						</div>
						<div class="wdt-slider-range-value">
							<input type="number" class="number-field" data-id='tablet' value="{{{ data.value['lh-tablet'] }}}"/>
						</div>
						<select class="wdt-responsive-select" data-id='tablet-unit'>
							<option value="px" <# if ( data.value['lh-tablet-unit'] === 'px' ) { #> selected="selected" <# } #>>px</option>
							<option value="em" <# if ( data.value['lh-tablet-unit'] === 'em' ) { #> selected="selected" <# } #>>em</option>
						</select>
					</div>

					<div class="tablet-landscape control-wrap">
						<div class="input-field-range">
							<input type="range" class="range-field" data-id='tablet-ls' value="{{{ data.value['lh-tablet-ls'] }}}"/>
						</div>
						<div class="wdt-slider-range-value">
							<input type="number" class="number-field" data-id='tablet-ls' value="{{{ data.value['lh-tablet-ls'] }}}"/>
						</div>
						<select class="wdt-responsive-select" data-id='tablet-ls-unit'>
							<option value="px" <# if ( data.value['lh-tablet-ls-unit'] === 'px' ) { #> selected="selected" <# } #>>px</option>
							<option value="em" <# if ( data.value['lh-tablet-ls-unit'] === 'em' ) { #> selected="selected" <# } #>>em</option>
						</select>
					</div>

					<div class="mobile control-wrap">
						<div class="input-field-range">
							<input type="range" class="range-field" data-id='mobile' value="{{{ data.value['lh-mobile'] }}}"/>
						</div>
						<div class="wdt-slider-range-value">
							<input type="number" class="number-field" data-id='mobile' value="{{{ data.value['lh-mobile'] }}}"/>
						</div>
						<select class="wdt-responsive-select" data-id='mobile-unit'>
							<option value="px" <# if ( data.value['lh-mobile-unit'] === 'px' ) { #> selected="selected" <# } #>>px</option>
							<option value="em" <# if ( data.value['lh-mobile-unit'] === 'em' ) { #> selected="selected" <# } #>>em</option>
						</select>
					</div>
				</div>
			<# } #>

			<# if( !_.isUndefined( data.choices['letter_spacing'] ) ) { #>
				<div class="letter-spacing full-width">
					<span class="customize-control-title">
						<label>{{{  data.choices['letter_spacing'] }}}</label>
						<ul class="wdt-typography-switcher wdt-responsive-switchers">
							<li class="desktop active">
								<button type="button" class="preview-desktop active" data-device="desktop">
									<i class="dashicons dashicons-desktop"></i>
								</button>
							</li>
							<li class="tablet-landscape">
								<button type="button" class="preview-tablet-landscape" data-device="tablet-landscape">
									<i class="dashicons dashicons-tablet"></i>
								</button>
							</li>
							<li class="tablet">
								<button type="button" class="preview-tablet" data-device="tablet">
									<i class="dashicons dashicons-tablet"></i>
								</button>
							</li>
							<li class="mobile">
								<button type="button" class="preview-mobile" data-device="mobile">
									<i class="dashicons dashicons-smartphone"></i>
								</button>
							</li>
						</ul>
						<span class="item-reset dashicons dashicons-image-rotate"></span>
					</span>

					<div class="desktop control-wrap active">
						<input type="number" data-id='desktop' class="wdt-responsive-input" min="0" max="2" step="0.1" value="{{{ data.value['ls-desktop'] }}}"/>
						<select class="wdt-responsive-select" data-id='desktop-unit'>
							<option value="px" <# if ( data.value['ls-desktop-unit'] === 'px' ) { #> selected="selected" <# } #>>px</option>
							<option value="em" <# if ( data.value['ls-desktop-unit'] === 'em' ) { #> selected="selected" <# } #>>em</option>
						</select>
					</div>

					<div class="tablet control-wrap">
						<input type="number" data-id='tablet' class="wdt-responsive-input" min="0" max="2" step="0.1" value="{{{ data.value['ls-tablet'] }}}"/>
						<select class="wdt-responsive-select" data-id='tablet-unit'>
							<option value="px" <# if ( data.value['ls-tablet-unit'] === 'px' ) { #> selected="selected" <# } #>>px</option>
							<option value="em" <# if ( data.value['ls-tablet-unit'] === 'em' ) { #> selected="selected" <# } #>>em</option>
						</select>
					</div>

					<div class="tablet-landscape control-wrap">
						<input type="number" data-id='tablet-ls' class="wdt-responsive-input" min="0" max="2" step="0.1" value="{{{ data.value['ls-tablet-ls'] }}}"/>
						<select class="wdt-responsive-select" data-id='tablet-ls-unit'>
							<option value="px" <# if ( data.value['ls-tablet-ls-unit'] === 'px' ) { #> selected="selected" <# } #>>px</option>
							<option value="em" <# if ( data.value['ls-tablet-ls-unit'] === 'em' ) { #> selected="selected" <# } #>>em</option>
						</select>
					</div>

					<div class="mobile control-wrap">
						<input type="number" data-id='mobile' class="wdt-responsive-input" min="0" max="2" step="0.1" value="{{{ data.value['ls-mobile'] }}}"/>
						<select class="wdt-responsive-select" data-id='mobile-unit'>
							<option value="px" <# if ( data.value['ls-mobile-unit'] === 'px' ) { #> selected="selected" <# } #>>px</option>
							<option value="em" <# if ( data.value['ls-mobile-unit'] === 'em' ) { #> selected="selected" <# } #>>em</option>
						</select>
					</div>
				</div>
			<# } #>

			<input class="typography-hidden-value" type="hidden" {{{ data.link }}}>
		</div>
		<?php
	}
}
<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Icon
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_icon extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    echo apply_filters( 'cs_element_before', $this->element_before() );

    $value  = $this->element_value();
    $hidden = ( empty( $value ) ) ? ' hidden' : '';

    echo '<div class="cs-icon-select">';
    echo '<span class="cs-icon-preview'. $hidden .'"><i class="'. esc_attr($value) .'"></i></span>';
    echo '<a href="#" class="button button-primary cs-icon-add">'. esc_html__( 'Add Icon', 'mezan-pro' ) .'</a>';
    echo '<a href="#" class="button cs-warning-primary cs-icon-remove'. $hidden .'">'. esc_html__( 'Remove Icon', 'mezan-pro' ) .'</a>';
    echo '<input type="text" name="'. esc_attr($this->element_name()) .'" value="'. esc_attr($value) .'"'. mezan_html_output($this->element_class( 'cs-icon-value' )) . $this->element_attributes() .' />';
    echo '</div>';

    echo apply_filters( 'cs_element_after', $this->element_after() );
  }

}

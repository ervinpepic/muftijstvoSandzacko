<?php
/* ------------------------------------------------------------------------- *
 *  LOAD AND REGISTER IMAGE MODULE
/* ------------------------------------------------------------------------- */
//Fired in add_action( 'after_setup_theme', 'sek_register_modules', 50 );
function sek_get_module_params_for_czr_image_module() {
    $css_selectors = '.sek-module-inner img';
    return array(
        'dynamic_registration' => true,
        'module_type' => 'czr_image_module',
        'is_father' => true,
        'children' => array(
            'main_settings'   => 'czr_image_main_settings_child',
            'borders_corners' => 'czr_image_borders_corners_child'
        ),
        'name' => __('Image', 'nimble-builder'),
        'starting_value' => array(
            'main_settings' => array(
                'img' =>  NIMBLE_BASE_URL . '/assets/img/default-img.png',
                'custom_width' => ''
            )
        ),
        'sanitize_callback' => '\Nimble\sanitize_cb__czr_image_module',
        // 'validate_callback' => '\Nimble\czr_image_module_sanitize_validate',
        'render_tmpl_path' => "image_module_tmpl.php",
        'placeholder_icon' => 'short_text'
    );
}


/* ------------------------------------------------------------------------- *
 *  SANITIZATION
/* ------------------------------------------------------------------------- */
// convert into a json to prevent emoji breaking global json data structure
// fix for https://github.com/presscustomizr/nimble-builder/issues/544
    function sanitize_cb__czr_image_module( $value ) {
        if ( !is_array( $value ) )
            return $value;
            if ( is_array( $value ) && !empty($value['main_settings']) && is_array( $value['main_settings'] ) && array_key_exists( 'heading_title', $value['main_settings'] ) ) {
                //$value['content'][ 'button_text' ] = sanitize_text_field( $value['content'][ 'button_text' ] );
                // convert into a json to prevent emoji breaking global json data structure
                // fix for https://github.com/presscustomizr/nimble-builder/issues/544
                $value['main_settings']['heading_title'] = sek_maybe_encode_richtext($value['main_settings']['heading_title']);
            }
        return $value;
    }




/* ------------------------------------------------------------------------- *
 *  MAIN SETTINGS
/* ------------------------------------------------------------------------- */
function sek_get_module_params_for_czr_image_main_settings_child() {
    $pro_text = '';
    if ( !sek_is_pro() ) {
        $pro_text = sek_get_pro_notice_for_czr_input( __('set a specific header logo on mobiles, shrink header logo when scrolling down the page, ...', 'nimble-builder') );
    }
    return array(
        'dynamic_registration' => true,
        'module_type' => 'czr_image_main_settings_child',
        'name' => __( 'Image main settings', 'nimble-builder' ),
        //'sanitize_callback' => '\Nimble\sanitize_callback__czr_simple_form_module',
        // 'starting_value' => array(
        //     'button_text' => __('Click me','nimble-builder'),
        //     'color_css'  => '#ffffff',
        //     'bg_color_css' => '#020202',
        //     'bg_color_hover' => '#151515', //lighten 15%,
        //     'use_custom_bg_color_on_hover' => 0,
        //     'border_radius_css' => '2',
        //     'h_alignment_css' => 'center',
        //     'use_box_shadow' => 1,
        //     'push_effect' => 1
        // ),
        //'css_selectors' => array( '.sek-module-inner .sek-simple-form-wrapper' ),
        'tmpl' => array(
            'item-inputs' => array(
                'img' => array(
                    'input_type'  => 'upload',
                    'title'       => __('Pick an image', 'nimble-builder'),
                    'default'     => ''
                ),
                'use-post-thumb' => array(
                    'input_type'  => 'nimblecheck',
                    'title'       => __('Use the contextual post thumbnail', 'nimble-builder'),
                    'title_width' => 'width-80',
                    'input_width' => 'width-20',
                    'refresh_markup' => true,
                    'default'     => 0,
                    'notice_after' => __('When enabled and possible, Nimble will use the post thumbnail.', 'nimble-builder'),
                ),
                'img-size' => array(
                    'input_type'  => 'simpleselect',
                    'title'       => __('Select the image size', 'nimble-builder'),
                    'default'     => 'large',
                    'choices'     => sek_get_select_options_for_input_id( 'img-size' ),
                    'notice_before' => __('Select a size for this image among those generated by WordPress.', 'nimble-builder' )
                ),
                'link-to' => array(
                    'input_type'  => 'simpleselect',
                    'title'       => __('Schedule an action on click or tap', 'nimble-builder'),
                    'default'     => 'no-link',
                    'choices'     => array(
                        'no-link' => __('No click action', 'nimble-builder' ),
                        'img-lightbox' =>__('Lightbox : enlarge the image, and dim out the rest of the content', 'nimble-builder' ),
                        'url' => __('Link to site content or custom url', 'nimble-builder' ),
                        'img-file' => __('Link to image file', 'nimble-builder' ),
                        'img-page' =>__('Link to image page', 'nimble-builder' )
                    ),
                    'title_width' => 'width-100',
                    'width-100'   => true,
                    'notice_after' => __('Note that some click actions are disabled during customization.', 'nimble-builder' ),
                ),
                'link-pick-url' => array(
                    'input_type'  => 'content_picker',
                    'title'       => __('Link url', 'nimble-builder'),
                    'default'     => array()
                ),
                'link-custom-url' => array(
                    'input_type'  => 'text',
                    'title'       => __('Custom link url', 'nimble-builder'),
                    'default'     => ''
                ),
                'link-target' => array(
                    'input_type'  => 'nimblecheck',
                    'title'       => __('Open link in a new browser tab', 'nimble-builder'),
                    'default'     => false,
                    'title_width' => 'width-80',
                    'input_width' => 'width-20',
                ),
                'h_alignment_css' => array(
                    'input_type'  => 'horizAlignmentWithDeviceSwitcher',
                    'title'       => __('Alignment', 'nimble-builder'),
                    'default'     => array( 'desktop' => 'center' ),
                    'refresh_markup' => false,
                    'refresh_stylesheet' => true,
                    'css_identifier' => 'h_alignment',
                    'title_width' => 'width-100',
                    'width-100'   => true,
                    'css_selectors'=> 'figure'
                ),
                'use_custom_title_attr' => array(
                    'input_type'  => 'nimblecheck',
                    'title'       => __('Set the text displayed when the mouse is held over', 'nimble-builder'),
                    'default'     => false,
                    'title_width' => 'width-80',
                    'input_width' => 'width-20',
                    'notice_after' => __('If not specified, Nimble will use by order of priority the caption, the description, and the image title. Those properties can be edited for each image in the media library.')
                ),
                'heading_title' => array(
                    'input_type'         => 'text',
                    'title' => __('Custom text displayed on mouse hover', 'nimble-builder' ),
                    'default'            => '',
                    'title_width' => 'width-100',
                    'width-100'         => true
                ),
                'use_custom_width' => array(
                    'input_type'  => 'nimblecheck',
                    'title'       => __( 'Custom image width', 'nimble-builder' ),
                    'default'     => 0,
                    'refresh_stylesheet' => true,
                    'html_before' => '<hr/>'
                ),
                'custom_width' => array(
                    'input_type'  => 'range_with_unit_picker_device_switcher',
                    'title'       => __('Width', 'nimble-builder'),
                    'min' => 1,
                    'max' => 100,
                    //'unit' => '%',
                    'default'     => array( 'desktop' => '100%' ),
                    'max'     => 500,
                    'width-100'   => true,
                    'title_width' => 'width-100',
                    'refresh_markup' => false,
                    'refresh_stylesheet' => true
                ),
                'use_custom_height' => array(
                    'input_type'  => 'nimblecheck',
                    'title'       => __( 'Custom image max height', 'nimble-builder' ),
                    'default'     => 0,
                    'refresh_stylesheet' => true
                ),
                'custom_height' => array(
                    'input_type'  => 'range_with_unit_picker_device_switcher',
                    'title'       => __('Height', 'nimble-builder'),
                    'min' => 1,
                    'max' => 100,
                    //'unit' => '%',
                    'default'     => array( 'desktop' => '100%' ),
                    'max'     => 500,
                    'width-100'   => true,
                    'title_width' => 'width-100',
                    'refresh_markup' => false,
                    'refresh_stylesheet' => true
                ),
                'use_box_shadow' => array(
                    'input_type'  => 'nimblecheck',
                    'title'       => __( 'Apply a shadow', 'nimble-builder' ),
                    'default'     => 0,
                    'html_before' => '<hr/>'
                ),
                'img_hover_effect' => array(
                    'input_type'  => 'simpleselect',
                    'title'       => __('Mouse over effect', 'nimble-builder'),
                    'default'     => 'none',
                    'choices'     => sek_get_select_options_for_input_id( 'img_hover_effect' ),
                    'html_after' => $pro_text
                )
            )
        ),
        'render_tmpl_path' => '',
    );
}






/* ------------------------------------------------------------------------- *
 *  IMAGE BORDERS AND BORDER RADIUS
/* ------------------------------------------------------------------------- */
function sek_get_module_params_for_czr_image_borders_corners_child() {
    $css_selectors = '.sek-module-inner img';
    return array(
        'dynamic_registration' => true,
        'module_type' => 'czr_image_borders_corners_child',
        'name' => __( 'Borders and corners', 'nimble-builder' ),
        //'sanitize_callback' => '\Nimble\sanitize_callback__czr_simple_form_module',
        // 'starting_value' => array(
        //     'button_text' => __('Click me','nimble-builder'),
        //     'color_css'  => '#ffffff',
        //     'bg_color_css' => '#020202',
        //     'bg_color_hover' => '#151515', //lighten 15%,
        //     'use_custom_bg_color_on_hover' => 0,
        //     'border_radius_css' => '2',
        //     'h_alignment_css' => 'center',
        //     'use_box_shadow' => 1,
        //     'push_effect' => 1
        // ),
        //'css_selectors' => array( '.sek-module-inner .sek-simple-form-wrapper' ),
        'tmpl' => array(
            'item-inputs' => array(
                'border-type' => array(
                    'input_type'  => 'simpleselect',
                    'title'       => __('Border', 'nimble-builder'),
                    'default' => 'none',
                    'choices'     => sek_get_select_options_for_input_id( 'border-type' ),
                    'refresh_markup' => false,
                    'refresh_stylesheet' => true
                ),
                'borders' => array(
                    'input_type'  => 'borders',
                    'title'       => __('Borders', 'nimble-builder'),
                    'min' => 0,
                    'max' => 100,
                    'default' => array(
                        '_all_' => array( 'wght' => '1px', 'col' => '#000000' )
                    ),
                    'refresh_markup' => false,
                    'refresh_stylesheet' => true,
                    'width-100'   => true,
                    'title_width' => 'width-100',
                    'css_selectors'=> $css_selectors
                ),
                'border_radius_css'       => array(
                    'input_type'  => 'border_radius',
                    'title'       => __( 'Rounded corners', 'nimble-builder' ),
                    'default' => array( '_all_' => '0px' ),
                    'width-100'   => true,
                    'title_width' => 'width-100',
                    'min'         => 0,
                    'max'         => 500,
                    'refresh_markup' => false,
                    'refresh_stylesheet' => true,
                    'css_identifier' => 'border_radius',
                    'css_selectors'=> $css_selectors
                ),
            )
        ),
        'render_tmpl_path' => '',
    );
}








/* ------------------------------------------------------------------------- *
 *  SCHEDULE CSS RULES FILTERING
/* ------------------------------------------------------------------------- */
add_filter( 'sek_add_css_rules_for_module_type___czr_image_module', '\Nimble\sek_add_css_rules_for_czr_image_module', 10, 2 );
// filter documented in Sek_Dyn_CSS_Builder::sek_css_rules_sniffer_walker
// Note : $complete_modul_model has been normalized
// @return populated $rules
function sek_add_css_rules_for_czr_image_module( $rules, $complete_modul_model ) {
    if ( empty( $complete_modul_model['value'] ) )
      return $rules;

    $value = $complete_modul_model['value'];
    $main_settings = $complete_modul_model['value']['main_settings'];
    $borders_corners_settings = $complete_modul_model['value']['borders_corners'];

    // WIDTH
    if ( sek_booleanize_checkbox_val( $main_settings['use_custom_width'] ) ) {
        $width = $main_settings[ 'custom_width' ];
        $css_rules = '';
        if ( isset( $width ) && FALSE !== $width ) {
            $numeric = sek_extract_numeric_value( $width );
            if ( !empty( $numeric ) ) {
                $unit = sek_extract_unit( $width );
                $css_rules .= 'width:' . $numeric . $unit . ';';
            }
            // same treatment as in sek_add_css_rules_for_css_sniffed_input_id() => 'width'
            if ( is_string( $width ) ) {
                  $numeric = sek_extract_numeric_value($width);
                  if ( !empty( $numeric ) ) {
                      $unit = sek_extract_unit( $width );
                      $css_rules .= 'width:' . $numeric . $unit . ';';
                  }
            } else if ( is_array( $width ) ) {
                  $width = wp_parse_args( $width, array(
                      'desktop' => '100%',
                      'tablet' => '',
                      'mobile' => ''
                  ));
                  // replace % by vh when needed
                  $ready_value = $width;
                  foreach ($width as $device => $num_unit ) {
                      $numeric = sek_extract_numeric_value( $num_unit );
                      if ( !empty( $numeric ) ) {
                          $unit = sek_extract_unit( $num_unit );
                          $ready_value[$device] = $numeric . $unit;
                      }
                  }

                  $rules = sek_set_mq_css_rules(array(
                      'value' => $ready_value,
                      'css_property' => 'width',
                      'selector' => '[data-sek-id="'.$complete_modul_model['id'].'"] .sek-module-inner img',
                      'is_important' => false,
                      'level_id' => $complete_modul_model['id']
                  ), $rules );

                  // to fix https://github.com/presscustomizr/nimble-builder/issues/754
                  $rules = sek_set_mq_css_rules(array(
                      'value' => $ready_value,
                      'css_property' => 'max-width',
                      'selector' => '[data-sek-id="'.$complete_modul_model['id'].'"] .sek-module-inner img',
                      'is_important' => false,
                      'level_id' => $complete_modul_model['id']
                  ), $rules );
            }
        }//if


        if ( !empty( $css_rules ) ) {
            $rules[] = array(
                'selector' => '[data-sek-id="'.$complete_modul_model['id'].'"] .sek-module-inner img',
                'css_rules' => $css_rules,
                'mq' =>null
            );
        }
    }// Width


    // HEIGHT
    if ( sek_booleanize_checkbox_val( $main_settings['use_custom_height'] ) ) {
        $height = $main_settings[ 'custom_height' ];
        $css_rules = '';
        if ( isset( $height ) && FALSE !== $height ) {
            $numeric = sek_extract_numeric_value( $height );
            if ( !empty( $numeric ) ) {
                $unit = sek_extract_unit( $height );
                $css_rules .= 'max-height:' . $numeric . $unit . ';';
            }
            // same treatment as in sek_add_css_rules_for_css_sniffed_input_id() => 'width'
            if ( is_string( $height ) ) {
                  $numeric = sek_extract_numeric_value($height);
                  if ( !empty( $numeric ) ) {
                      $unit = sek_extract_unit( $height );
                      $css_rules .= 'max-height:' . $numeric . $unit . ';';
                  }
            } else if ( is_array( $height ) ) {
                  $height = wp_parse_args( $height, array(
                      'desktop' => '100%',
                      'tablet' => '',
                      'mobile' => ''
                  ));
                  // replace % by vh when needed
                  $ready_value = $height;
                  foreach ($height as $device => $num_unit ) {
                      $numeric = sek_extract_numeric_value( $num_unit );
                      if ( !empty( $numeric ) ) {
                          $unit = sek_extract_unit( $num_unit );
                          $ready_value[$device] = $numeric . $unit;
                      }
                  }

                  $rules = sek_set_mq_css_rules(array(
                      'value' => $ready_value,
                      'css_property' => 'max-height',
                      'selector' => '[data-sek-id="'.$complete_modul_model['id'].'"] .sek-module-inner figure',
                      'is_important' => false,
                      'level_id' => $complete_modul_model['id']
                  ), $rules );
            }
        }//if


        if ( !empty( $css_rules ) ) {
            $rules[] = array(
                'selector' => '[data-sek-id="'.$complete_modul_model['id'].'"] .sek-module-inner img',
                'css_rules' => $css_rules,
                'mq' =>null
            );
        }
    }// height


    // BORDERS
    $border_settings = $borders_corners_settings[ 'borders' ];
    $border_type = $borders_corners_settings[ 'border-type' ];
    $has_border_settings  = 'none' != $border_type && !empty( $border_type );

    //border width + type + color
    if ( $has_border_settings ) {
        $rules = sek_generate_css_rules_for_multidimensional_border_options(
            $rules,
            $border_settings,
            $border_type,
            '[data-sek-id="'.$complete_modul_model['id'].'"] .sek-module-inner img'
        );
    }

    return $rules;
}
?>
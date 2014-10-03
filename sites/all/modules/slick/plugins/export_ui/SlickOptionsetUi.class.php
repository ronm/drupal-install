<?php

/**
 * @file
 * Contains the CTools Export UI integration code.
 */

/**
 * CTools Export UI class handler for Slick Optionset UI.
 */
class SlickOptionsetUi extends ctools_export_ui {

  function edit_form(&$form, &$form_state) {
    parent::edit_form($form, $form_state);

    $module_path = drupal_get_path('module', 'slick');
    $optionset = $form_state['item'];

    $options = $optionset->options;

    $form['#attached']['css'][] = $module_path . '/css/admin/slick.admin--ui.css';
    $form['#attached']['css'][] = $module_path . '/css/admin/slick.admin--vertical-tabs.css';
    $form['#attached']['js'][] = $module_path . '/js/slick.admin.ui.js';
    $form['#attributes']['class'][] = 'no-js';
    $form['#attributes']['class'][] = 'form--slick';
    $form['#attributes']['class'][] = 'form--compact';
    $form['#attributes']['class'][] = 'form--optionset';
    $form['#attributes']['class'][] = 'clearfix';

    $form['info']['label']['#attributes']['class'][] = 'is-tooltip';
    $form['info']['name']['#attributes']['class'][] = 'is-tooltip';

    $form['info']['label']['#prefix'] = '<div class="form--slick__header has-tooltip clearfix">';

    // Skins.
    $skins = slick_skins(TRUE);
    $form['skin'] = array(
      '#type' => 'select',
      '#title' => t('Skin'),
      '#options' => $skins,
      '#default_value' => $optionset->skin,
      '#description' => t('Skins allow swappable layouts like next/prev links, split image and caption, etc. Make sure to provide a dedicated slide layout per field. However a combination of skins and options may lead to unpredictable layouts, get dirty yourself. Some default complex layout skins applied to desktop only, adjust for the mobile accordingly. Use the Slick API hook_slick_skins_info() to add your own skins here.'),
      '#attributes' => array('class' => array('is-tooltip')),
    );

    $form['breakpoints'] = array(
      '#title' => t('Breakpoints'),
      '#type' => 'textfield',
      '#description' => t('The number of breakpoints added to Responsive display.'),
      '#default_value' => isset($form_state['values']['breakpoints']) ? $form_state['values']['breakpoints'] : $optionset->breakpoints,
      '#suffix' => '</div>',
      '#ajax' => array(
        'callback' => 'slick_add_breakpoints_ajax_callback',
        'wrapper' => 'breakpoints-ajax-wrapper',
        'event' => 'change',
      ),
      '#attributes' => array('class' => array('is-tooltip')),
    );

    // Options.
    $form['options'] = array(
      '#type' => 'vertical_tabs',
      '#tree' => TRUE,
    );

    // Image styles.
    $image_styles = image_style_options(FALSE);
    $form['options']['general'] = array(
      '#type' => 'fieldset',
      '#title' => t('General'),
      '#attributes' => array('class' => array('has-tooltip', 'fieldset--no-checkboxes-label')),
    );

    $form['options']['general']['normal'] = array(
      '#type' => 'select',
      '#title' => t('Image style'),
      '#description' => t('Image style for the main/background image, overriden by field. Thumbnails are defined per field basis.'),
      '#empty_option' => t('None (original image)'),
      '#options' => $image_styles,
      '#default_value' => isset($options['general']['normal']) ? $options['general']['normal'] : '',
      '#attributes' => array('class' => array('is-tooltip')),
    );

    /*
    @todo drop it or test elementTransition.js
    $form['options']['general']['transition'] = array(
      '#type' => 'select',
      '#title' => t('Transition effect'),
      '#description' => t('Custom CSS3 transition effect.'),
      '#empty_option' => t('- None -'),
      '#options' => _slick_transition_options(),
      '#default_value' => isset($options['general']['transition']) ? $options['general']['transition'] : '',
    );
    */

    $form['options']['general']['template_class'] = array(
      '#type' => 'textfield',
      '#title' => t('Wrapper class'),
      '#description' => t('Additional template wrapper classes separated by spaces to gain more control per optionset.'),
      '#default_value' => isset($options['general']['template_class']) ? $options['general']['template_class'] : '',
      '#attributes' => array('class' => array('is-tooltip')),
    );

    $form['options']['general']['goodies'] = array(
      '#type' => 'checkboxes',
      '#title' => t('Goodies'),
      '#default_value' => !empty($options['general']['goodies']) ? array_values((array) $options['general']['goodies']) : array(),
      '#options' => array(
        'pattern' => t('Use pattern overlay'),
        'arrow-down' => t('Use arrow down'),
      ),
      '#description' => t('<ol><li>Pattern overlay is background image with pattern placed over the main stage.</li><li>Arrow down to scroll down into a certain page section, make sure to provide target selector.</li></ol>'),
      '#attributes' => array('class' => array('is-tooltip')),
    );

    $form['options']['general']['arrow_down_target'] = array(
      '#type' => 'textfield',
      '#title' => t('Arrow down target'),
      '#description' => t('Valid CSS selector to scroll to, e.g.: #main, or #content.'),
      '#default_value' => isset($options['general']['arrow_down_target']) ? $options['general']['arrow_down_target'] : '',
      '#states' => array(
        'visible' => array(
          ':input[name*=arrow-down]' => array('checked' => TRUE),
        ),
      ),
      '#attributes' => array('class' => array('is-tooltip')),
    );

    $form['options']['general']['arrow_down_offset'] = array(
      '#type' => 'textfield',
      '#title' => t('Arrow down offset'),
      '#description' => t('Offset when scrolled down from the top.'),
      '#default_value' => isset($options['general']['arrow_down_offset']) ? $options['general']['arrow_down_offset'] : '',
      '#states' => array(
        'visible' => array(
          ':input[name*=arrow-down]' => array('checked' => TRUE),
        ),
      ),
      '#attributes' => array('class' => array('is-tooltip')),
    );

    // Add empty suffix to style checkboxes like iOS.
    foreach ($form['options']['general']['goodies']['#options'] as $key => $value) {
      $form['options']['general']['goodies'][$key]['#field_suffix'] = '';
      $form['options']['general']['goodies'][$key]['#title_display'] = 'before';
    }

    // Main options.
    $slick_options = slick_get_options();
    $form['options']['settings'] = array(
      '#title' => t('Settings'),
      '#type' => 'fieldset',
      '#collapsible' => FALSE,
      '#tree' => TRUE,
      '#attributes' => array('class' => array('fieldset--settings', 'has-tooltip')),
    );

    foreach ($slick_options as $name => $values) {
      $form['options']['settings'][$name] = array(
        '#title' => $values['title'],
        '#description' => $values['description'],
        '#type' => $values['type'],
        '#default_value' => isset($options['settings'][$name]) ? $options['settings'][$name] : $values['default'],
        '#attributes' => array('class' => array('is-tooltip')),
      );

      if (isset($values['field_suffix'])) {
        $form['options']['settings'][$name]['#field_suffix'] = $values['field_suffix'];
      }

      if ($values['type'] == 'textfield') {
        $form['options']['settings'][$name]['#size'] = 20;
        $form['options']['settings'][$name]['#maxlength'] = 255;
      }
      if (!isset($values['field_suffix']) && $values['cast'] == 'bool') {
        $form['options']['settings'][$name]['#field_suffix'] = '';
        $form['options']['settings'][$name]['#title_display'] = 'before';
      }
      if ($values['cast'] == 'int') {
        $form['options']['settings'][$name]['#maxlength'] = 60;
        $form['options']['settings'][$name]['#attributes']['class'][] = 'form-text--int';
      }

      if (isset($values['states'])) {
        $form['options']['settings'][$name]['#states'] = $values['states'];
      }

      if (isset($values['options'])) {
        $form['options']['settings'][$name]['#options'] = $values['options'];
      }
    }

    // Responsive options.
    $form['options']['responsives'] = array(
      '#title' => t('Responsive display'),
      '#type' => 'fieldset',
      '#description' => t('Containing breakpoints and settings objects. Enables settings sets at given screen width. Currently only supports Desktop first: starts breakpoint from the largest to smallest.'),
      '#collapsible' => FALSE,
      '#tree' => TRUE,
    );

    $form['options']['responsives']['responsive'] = array(
      '#title' => t('Responsive'),
      '#type' => 'fieldset',
      '#collapsible' => FALSE,
      '#attributes' => array('class' => array('has-tooltip', 'fieldset--responsive--ajax')),
      '#prefix' => '<div id="breakpoints-ajax-wrapper">',
      '#suffix' => '</div>',
    );

  $breakpoints_count = isset($form_state['values']['breakpoints']) ? $form_state['values']['breakpoints'] : $optionset->breakpoints;
  $form_state['breakpoints_count'] = $breakpoints_count;

   if ($form_state['breakpoints_count'] > 0) {
      $slick_options = slick_get_responsive_options($form_state['breakpoints_count']);
      foreach ($slick_options as $i => $values) {
        if ($values['type'] == 'fieldset') {
          $fieldset_class = drupal_clean_css_identifier(drupal_strtolower($values['title']));
          $form['options']['responsives']['responsive'][$i] = array(
            '#title' => $values['title'],
            '#type' => $values['type'],
            // '#description' => $values['description'],
            '#collapsible' => TRUE,
            '#collapsed' => TRUE,
            '#attributes' => array('class' => array('fieldset--responsive', 'fieldset--' . $fieldset_class, 'has-tooltip')),
          );

          foreach ($values as $key => $vals) {
            if (is_array($vals)) {
              if ($vals['type'] == 'fieldset') {
                if (!isset($vals['default']) && $vals['type'] == 'fieldset') {
                  $form['options']['responsives']['responsive'][$i][$key] = array(
                    '#title' => $vals['title'],
                    '#type' => $vals['type'],
                    // '#description' => $vals['description'],
                    '#collapsible' => FALSE,
                    '#collapsed' => FALSE,
                    '#attributes' => array('class' => array('fieldset--settings', 'fieldset--' . $fieldset_class, 'has-tooltip')),
                  );
                }

                foreach ($vals as $k => $value) {
                  if ($value && is_array($value)) {
                    $form['options']['responsives']['responsive'][$i][$key][$k] = array(
                      '#title' => $value['title'],
                      '#description' => $value['description'],
                      '#type' => $value['type'],
                      '#attributes' => array('class' => array('is-tooltip')),
                    );
                    if ($value['type'] != 'fieldset') {
                      $form['options']['responsives']['responsive'][$i][$key][$k]['#default_value'] = isset($options['responsives']['responsive'][$i][$key][$k]) ? $options['responsives']['responsive'][$i][$key][$k] : $value['default'];
                    }
                    if (isset($value['states'])) {
                      $form['options']['responsives']['responsive'][$i][$key][$k]['#states'] = $value['states'];
                    }
                    if (isset($value['options'])) {
                      $form['options']['responsives']['responsive'][$i][$key][$k]['#options'] = $value['options'];
                    }
                    if (isset($value['field_suffix'])) {
                      $form['options']['responsives']['responsive'][$i][$key][$k]['#field_suffix'] = $value['field_suffix'];
                    }
                    if (!isset($value['field_suffix']) && $value['cast'] == 'bool') {
                      $form['options']['responsives']['responsive'][$i][$key][$k]['#field_suffix'] = '';
                      $form['options']['responsives']['responsive'][$i][$key][$k]['#title_display'] = 'before';
                    }
                  }
                }
              }
              // Breakpoints.
              else {
                $form['options']['responsives']['responsive'][$i][$key] = array(
                  '#title' => $vals['title'],
                  '#description' => $vals['description'],
                  '#type' => $vals['type'],
                  '#default_value' => isset($options['responsives']['responsive'][$i][$key]) ? $options['responsives']['responsive'][$i][$key] : $vals['default'],
                  '#attributes' => array('class' => array('is-tooltip')),
                );

                if ($vals['type'] == 'textfield') {
                  $form['options']['responsives']['responsive'][$i][$key]['#size'] = 20;
                  $form['options']['responsives']['responsive'][$i][$key]['#maxlength'] = 255;
                }
                if ($vals['cast'] == 'int') {
                  $form['options']['responsives']['responsive'][$i][$key]['#maxlength'] = 60;
                }
                if (isset($vals['states'])) {
                  $form['options']['responsives']['responsive'][$i][$key]['#states'] = $vals['states'];
                }
                if (isset($vals['options'])) {
                  $form['options']['responsives']['responsive'][$i][$key]['#options'] = $vals['options'];
                }
                if (isset($vals['field_suffix'])) {
                  $form['options']['responsives']['responsive'][$i][$key]['#field_suffix'] = $vals['field_suffix'];
                }
                if (!isset($vals['field_suffix']) && $vals['cast'] == 'bool') {
                  $form['options']['responsives']['responsive'][$i][$key]['#field_suffix'] = '';
                  $form['options']['responsives']['responsive'][$i][$key]['#title_display'] = 'before';
                }
              }
            }
          }
        }
      }
    }
  }
}

/**
 * Callback for ajax-enabled breakpoint textfield.
 *
 * Selects and returns the fieldset with the names in it.
 */
function slick_add_breakpoints_ajax_callback($form, $form_state) {
  return $form['options']['responsives']['responsive'];
}

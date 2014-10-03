<?php
/**
 * Implements hook_form_FORM_ID_alter().
 *
 * @param $form
 *   The form.
 * @param $form_state
 *   The form state.
 */
function ronzoni_form_system_theme_settings_alter(&$form, &$form_state) {
	
	$form['zurb_foundation']['general']['theme_settings']['toggle_breadcrumbs'] = array(
		'#type' => 'checkbox',
		'#title' => t('Breadcrumbs'),
		'#default_value' => theme_get_setting('toggle_breadcrumbs', 'ronzoni'),
	);
	
	return $form;
}

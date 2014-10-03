<?php
/**
 * @file
 * Enables modules and site configuration for a standard site installation.
 */

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form.
 */
function default_form_install_configure_form_alter(&$form, $form_state) {  	  	
	$form = _install_profile_install_configure_form_modify($form);	
}
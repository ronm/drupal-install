<?php
/**
 * Implements template_preprocess_page
 *
 */
function ronzoni_preprocess_page(&$variables) {

    // Convenience variables
    if (!empty($variables['page']['sidebar_first'])){
    	$left = $variables['page']['sidebar_first'];
    }

    if (!empty($variables['page']['sidebar_second'])) {
    	$right = $variables['page']['sidebar_second'];
    }	

    // Dynamic sidebars	
    if (!empty($left) && !empty($right)) {
    	$variables['main_grid_class'] = 'large-6 large-push-3';
    	$variables['sidebar_first_grid_class'] = 'large-3 large-pull-9';
    	$variables['sidebar_sec_grid_class'] = 'large-3';
    } elseif (empty($left) && !empty($right)) {
    	$variables['main_grid_class'] = ( drupal_is_front_page() ? 'large-8' : 'large-9' );
    	$variables['sidebar_first_grid_class'] = '';
    	$variables['sidebar_sec_grid_class'] = ( drupal_is_front_page() ? 'large-4' : 'large-3' );
    } elseif (!empty($left) && empty($right)) {
    	$variables['main_grid_class'] = ( drupal_is_front_page() ? 'large-8 large-push-4' : 'large-8 large-push-4' );
    	$variables['sidebar_first_grid_class'] = ( drupal_is_front_page() ? 'large-4 large-pull-8' : 'large-4 large-pull-8' );
    	$variables['sidebar_sec_grid_class'] = '';
    } else {
    	$variables['main_grid_class'] = 'large-12';
    	$variables['sidebar_first_grid_class'] = '';
    	$variables['sidebar_sec_grid_class'] = '';
    }    
}

/**
 * Implements theme_breadcrumb().
 */
function ronzoni_breadcrumb(&$variables) {
	if ( !theme_get_setting('toggle_breadcrumbs', 'ronzoni') ) { 
		unset($variables);
	}
}
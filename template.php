<?php
/**
 * Override or insert variables into the page templates.
 *
 * @param array $variables
 *   Variables to pass to the theme template.
 * @param string $hook
 *   The name of the template being rendered ("page" in this case.)
 */

function pld_preprocess_page(&$variables, $hook) {
  $variables['library_name'] = t('Providence Public Library');
  $variables['dc'] = t('Digital Collections');
}

function pld_preprocess_islandora_basic_collection_wrapper__islandora_sp_basic_image_collection(&$variables) {
	$variables['template_preprocess_function_variable'] = "TESTING THE TEMPLATE PREPROCESS FUNCTION, UNIQUE TO BASIC IMAGE";
}

?>
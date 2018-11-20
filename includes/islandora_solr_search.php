<?php

/**
* Overrides to the display and functionality of the islandora solr search pages and search form
*/

function pld_form_islandora_solr_simple_search_form_alter(&$form, &$form_state, $form_id) {

	$form['simple']['islandora_simple_search_query'] = array(
		'#size' => '30',
		'#type' => 'textfield',
		'#attributes' => array(
			'class' => array(
				'pld-collections-search',
			),
			'placeholder' => t('Search Collections'),
		),
		'#title' => '',
	);
	$form['simple']['submit'] = array(
		'#type' => 'submit',
		'#value' => t('search'),
		'#attributes' => array(
			'class' => array(
				'pld-simple-search-submit',
			),
		),
	);
}

/**
 * Returns HTML for an islandora_solr_facet_wrapper.
 *
 * @param array $variables
 *   An associative array containing:
 *   - title: A string to use as the header/title.
 *   - content: A string containing the content being wrapped.
 *
 * @ingroup themeable
 */
function pld_islandora_solr_facet_wrapper($variables) {
  $output = '<div class="islandora-solr-facet-wrapper">';
  $output .= '<h3>' . $variables['title'] . '<span class="down-arrow"><i class="fas fa-arrow-down"></i></span></h3>';
  $output .= $variables['content'];
  $output .= '</div>';
  return $output;
}

?>
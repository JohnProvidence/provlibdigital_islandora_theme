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
 * Prepares variables for islandora_solr templates.
 *
 * Default template: theme/islandora-solr.tpl.php.
 */
function pld_preprocess_islandora_solr(&$variables) {
	
  $results = $variables['results'];
  foreach ($results as $key => $result) {
    // Thumbnail.
    $path = url($result['thumbnail_url'], array('query' => $result['thumbnail_url_params']));
    $image_params = array(
      'path' => $path,
    );
    if (isset($result['object_label'])) {
      $image_params['alt'] = $result['object_label'];
    }
    $image = theme('image', $image_params);
    $options = array('html' => TRUE);
    if (isset($result['object_label'])) {
      $options['attributes']['title'] = $result['object_label'];
    }
    if (isset($result['object_url_params'])) {
      $options['query'] = $result['object_url_params'];
    }
    if (isset($result['object_url_fragment'])) {
      $options['fragment'] = $result['object_url_fragment'];
    }
    // Thumbnail link.
    $variables['results'][$key]['thumbnail'] = l($image, $result['object_url'], $options);
  }
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
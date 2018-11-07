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
	$form['simple']['advanced_link'] = array(
		'#markup' => t('<a href="@url" class="advanced-search">Advanced Search', array('@url' => '/advanced-search' )),
	);
}


?>
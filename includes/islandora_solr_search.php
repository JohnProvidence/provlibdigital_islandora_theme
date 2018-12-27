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

function pld_preprocess_islandora_solr_grid(&$variables) {
	module_load_include('inc', 'islandora_paged_content', 'includes/utilities');
	$num_results = count($variables['results']);
	$data = array();
	$no_thumb_path = drupal_get_path('theme', 'pld');
    $no_thumb = $base_url ."/$no_thumb_path/img/no_image_available.png";
    
    $copyright_img = $base_url ."/$no_thumb_path/img/image_under_copyright.png";

	for($i = 0; $i <= $num_results; $i++) {

		$image = NULL;
		$pid = $variables['results'][$i]['PID'];
		if(isset($pid)):
			$object = islandora_object_load($pid);
			
			if($object != NULL):
				$obj_models = $object->relationships->get('info:fedora/fedora-system:def/model#', 'hasModel');
				if($obj_models == FALSE):
					continue;
				else:

					$obj_model = $obj_models[0]['object']['value'];
					$copyright = $object->getDatastream('COPYRIGHT');

					if($obj_model == 'islandora:compoundCModel'):
						$parts = islandora_compound_object_get_parts($pid);
						$obj_count = count($parts);
						
						if($obj_count > 0):
							$first_child = $parts[0];
							
							$image ='/islandora/object/'.$first_child.'/datastream/MEDIUM_SIZE/view';
						else:
							$image = $no_thumb;
						endif;
					endif; // end islandora:compoundCModel

					if($obj_model == 'islandora:sp_basic_image' && $copyright == FALSE):
						$image ='/islandora/object/'.$pid.'/datastream/MEDIUM_SIZE/view';
					endif;

					if($obj_model == 'islandora:collectionCModel' && $copyright == FALSE):
						$image = '/islandora/object/'.$pid.'/datastream/TN/view';
					endif;

					if($obj_model == 'islandora:pageCModel' && $copyright == FALSE):
						$image = '/islandora/object/'.$pid.'/datastream/JPG/view';
					endif;

					if($obj_model == 'islandora:bookCModel'):
						$pages = islandora_paged_content_get_pages($object);
						reset($pages);
						$first_key = key($pages);
						$page_one = islandora_object_load($first_key);
						$jpg = $page_one->getDatastream('JPG');

						if(isset($jpg)):
							$image = '/islandora/object/'.$page_one.'/datastream/JPG/view';
						else:
							$image = $no_thumb;
						endif;
					endif;

					if($copyright != FALSE):
						$image = $copyright_img;
					endif;	

					$variables['results'][$i]['image_url'] = $image;

			endif; // end check of object models
		
		endif; // end null check for object
		
	endif; // end isset for pid
	
	}
}

?>
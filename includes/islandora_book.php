<?php

function pld_preprocess_islandora_book_book(array &$variables) {
  module_load_include('inc', 'islandora_paged_content', 'includes/utilities');
  module_load_include('inc', 'islandora', 'includes/solution_packs');
  module_load_include('inc', 'islandora', 'includes/metadata');
  module_load_include('inc', 'islandora', 'includes/datastream');
  drupal_add_js('misc/form.js');
  drupal_add_js('misc/collapse.js');

  $object = $variables['object'];

  $mods = $object->getDatastream('MODS');
  $dc = $object->getDatastream('DC');

  // generate datastream buttons
    if(isset($mods)):
    $mods_btn = '<div class="btn download-btn"><a href="/islandora/object/'.$object->id.'/datastream/MODS/view" download="'.$object->id.'-'.$object->label.'/_MODS.xml">Download MODS XML</a></div>';
  	$variables['mods_btn'] = $mods_btn;
  else:
    $variables['mods_btn'] = '';
  endif;

  $marcxml_btn = '<div class="btn download-btn"><a href="/islandora/object/'.$object->id.'/view_mods_as_marxml">Download MARCXML</a></div>';
  $variables['marcxml_btn'] = $marcxml_btn;

  if(isset($dc)):
      $dc_btn = '<div class="btn download-btn"><a href="/islandora/object/'.$object->id.'/datastream/DC/view" download="'.$object->id.'-'.$object->label.'/_DC.xml">Download DC XML</a></div>';
    $variables['dc_btn'] = $dc_btn;
  else:
      $variables['dc_btn'] = '';
  endif;

  $parents = $object->getParents();
      //var_dump($parents);
  if(!empty($parents)) {
    $parent_object = islandora_object_load($parents[0]);
    $parent_label = $parent_object->label;
    $variables['parent_collection'] = $parent_label;
    $variables['parent_url'] = '/islandora/object/'.$parent_object->id;
    $finding_aid = $parent_object->getDatastream('FINDING_AID');
  
    if($finding_aid != FALSE) {
      $finding_aid_button = '<div class="btn finding_aid_btn"><a href="/islandora/object/'.$parent_object->id.'/datastream/FINDING_AID/view">Download Collection Finding Aid <i class="far fa-file-alt"></i></a></div>';
          $variables['collection_finding_aid_button'] = $finding_aid_button;
      }
      
    } // end if not empty $parents



  $variables['viewer_id'] = islandora_get_viewer_id('islandora_book_viewers');
  $variables['viewer_params'] = array(
    'object' => $object,
    'pages' => islandora_paged_content_get_pages($object),
    'page_progression' => islandora_paged_content_get_page_progression($object),
  );

  $variables['display_metadata'] = variable_get('islandora_book_metadata_display', FALSE);
  $variables['parent_collections'] = islandora_get_parents_from_rels_ext($object);
  $variables['metadata'] = islandora_retrieve_metadata_markup($object);
  $variables['description'] = islandora_retrieve_description_markup($object);
}

?>
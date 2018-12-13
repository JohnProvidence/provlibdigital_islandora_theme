<?php
// overrides functions found in islandora_solution_pack_image

function pld_preprocess_islandora_basic_image(array &$variables) {

  drupal_add_js('misc/form.js');
  drupal_add_js('misc/collapse.js');
  $islandora_object = $variables['islandora_object'];
  $repository = $islandora_object->repository;
  module_load_include('inc', 'islandora', 'includes/datastream');
  module_load_include('inc', 'islandora', 'includes/utilities');
  module_load_include('inc', 'islandora', 'includes/metadata');

  // We should eventually remove the DC object and dc_array code as it only
  // exists to not break legacy implementations.
  if (islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $islandora_object['DC'])) {
    try {
      $dc = $islandora_object['DC']->content;
      $dc_object = DublinCore::importFromXMLString($dc);
    }
    catch (Exception $e) {
      drupal_set_message(t('Error retrieving object %s %t', array('%s' => $islandora_object->id, '%t' => $e->getMessage())), 'error', FALSE);
    }
  }
  $variables['islandora_dublin_core'] = isset($dc_object) ? $dc_object : NULL;
  $variables['dc_array'] = isset($dc_object) ? $dc_object->asArray() : array();
  //var_dump($variables['dc_array']);
  $variables['islandora_object_label'] = $islandora_object->label;
  $variables['theme_hook_suggestions'][] = 'islandora_basic_image__' . str_replace(':', '_', $islandora_object->id);
  $variables['parent_collections'] = islandora_get_parents_from_rels_ext($islandora_object);
  
  $variables['metadata'] = islandora_retrieve_metadata_markup($islandora_object);
  $variables['description'] = $variables['dc_array']['dc:description']['value'];
  $variables['obj_label'] = $islandora_object->label;

  // Original.
  if (isset($islandora_object['OBJ']) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $islandora_object['OBJ'])) {
    $full_size_url = url("islandora/object/{$islandora_object->id}/datastream/OBJ/view", array('absolute' => TRUE));
    $variables['islandora_full_url'] = $full_size_url;
    $params = array(
      'title' => $islandora_object->label,
      'path' => $full_size_url,
    );
    $variables['islandora_full_img'] = theme('image', $params);
  }
  // Thumbnail.
  if (isset($islandora_object['TN']) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $islandora_object['TN'])) {
    $thumbnail_size_url = url("islandora/object/{$islandora_object->id}/datastream/TN/view");
    $params = array(
      'title' => $islandora_object->label,
      'path' => $thumbnail_size_url,
    );
    $variables['islandora_thumbnail_img'] = theme('image', $params);
  }
  // Medium size.
  if (isset($islandora_object['MEDIUM_SIZE']) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $islandora_object['MEDIUM_SIZE'])) {
    $medium_size_url = url("islandora/object/{$islandora_object->id}/datastream/MEDIUM_SIZE/view");
    $params = array(
      'title' => $islandora_object->label,
      'path' => $medium_size_url,
    );
    $variables['islandora_medium_img'] = theme('image', $params);
    if (isset($full_size_url)) {
      $variables['islandora_content'] = l($variables['islandora_medium_img'], $full_size_url, array('html' => TRUE));
    }
    else {
      $variables['islandora_content'] = $variables['islandora_medium_img'];
    }
  }

  // get datastreams to generate download buttons
  $obj_pid = $islandora_object->id;
  $object = islandora_object_load($obj_pid);
  $mods = $object->getDatastream('MODS');
  $dc = $object->getDatastream('DC');
  $img_obj = $object->getDatastream('OBJ');
  $copyright = $object->getDatastream('COPYRIGHT');
  $copyright_image = drupal_get_path('theme', 'pld') . '/img/image_under_copyright.png';

  // generate datastream buttons
    if(isset($mods)):
    $mods_btn = '<div class="btn download-btn"><a href="/islandora/object/'.$obj_pid.'/datastream/MODS/view" download="'.$obj_pid.'-'.$islandora_object->label.'/_MODS.xml">Download MODS XML</a> <i class="fas fa-file-download"></i></div>';
  $variables['mods_btn'] = $mods_btn;
  else:
    $variables['mods_btn'] = NULL;
  endif;

  if(isset($dc)):
      $dc_btn = '<div class="btn download-btn"><a href="/islandora/object/'.$obj_pid.'/datastream/DC/view" download="'.$obj_pid.'-'.$islandora_object->label.'/_DC.xml">Download DC XML</a> <i class="fas fa-file-download"></i></div>';
    $variables['dc_btn'] = $dc_btn;
  else:
      $variables['dc_btn'] = NULL;
  endif;

  if(isset($img_obj) && $copyright == FALSE):
    $img_btn = '<div class="btn download-btn"><a href="/islandora/object/'.$obj_pid.'/datastream/OBJ/view" download="'.$obj_pid.'-'.$islandora_object->label.'/_OBJ.jpg">Download Image <i class="fas fa-file-download"></i></a></div>';
    $variables['img_btn'] = $img_btn; 
  else:
    $variable['img_btn'] = NULL;
  endif;

  if($copyright != FALSE):
    $variables['under_copyright'] = '<div class="copyright_restriction">This image is under copyright restriction. <br><br> A print is availble for viewing at the Providence Public Library.</div>';
  else:
    $varibles['under_copyright'] = NULL;
  endif;

  $marcxml_btn = '<div class="btn download-btn"><a href="/islandora/object/'.$obj_pid.'/view_mods_as_marcxml">View MARCXML</a></div>';
  $variables['marcxml_btn'] = $marcxml_btn;

  // get content models
  $obj_models = $object->relationships->get('info:fedora/fedora-system:def/model#', 'hasModel');
  $content_model = $obj_models[0]['object']['value'];
  //var_dump($content_model);


  $parents = $object->getParents();
      //var_dump($parents);
  if(!empty($parents)) {
    $parent_object = islandora_object_load($parents[0]);
    $parent_label = $parent_object->label;
    $variables['parent_collection'] = $parent_label;
    $variables['parent_url'] = '/islandora/object/'.$parent_object->id;
    $finding_aid = $parent_object->getDatastream('FINDING_AID');
  
    if($finding_aid != FALSE) {
      $finding_aid_button = '<div class="btn finding_aid_btn"><a href="/islandora/object/'.$parent_object->id.'/datastream/FINDING_AID/view">Download Collection Finding Aid <i class="fas fa-file-download"></i></a></div>';
          $variables['collection_finding_aid_button'] = $finding_aid_button;
      }
      
    } // end if not empty $parents

    if(empty($parents)) {
       $relationships = $object->relationships->get('info:fedora/fedora-system:def/relations-external#', 'isConstituentOf');
       $parent = $relationships[0]['object']['value'];
       $parent_object = islandora_object_load($parent);
       $collection = $parent_object->getParents();
       $collection_object = islandora_object_load($collection[0]);
       $variables['parent_collection'] = $collection_object->label;
       $variables['parent_url'] = '/islandora/object/'.$collection_object->id;
       $finding_aid = $collection_object->getDatastream('FINDING_AID');

       if($finding_aid != FALSE) {
         $finding_aid_button = '<div class="btn finding_aid_btn"><a href="/islandora/object/'.$collection_object->id.'/datastream/FINDING_AID/view">Download Collection Finding Aid <i class="far fa-file-alt"></i></a></div>';
          $variables['collection_finding_aid_button'] = $finding_aid_button;
       }
    }

    // Social media sharing buttons
    $path = $GLOBALS['base_url'];
    $object_url =  $path .'/islandora/object/'.$obj_pid;
   
   
    $facebook_button = '<div id="fb-share" data-url="'.$object_url.'" data-title="'.$object->label.'" data-descrip="'.$variables['description'].'" data-image="'.$object_url. '/datastream/OBJ/view" data-width="520" data-height="350"><i class="fab fa-facebook-f"></i></div>';

    $variables['facebook_button'] = $facebook_button;

    $twitter_share_url = 'https://twitter.com/?status='.$object->label.' View this image at: http://'.$object_url;

    $twitter_button = '<div id="twitter-share"><a href="'.$twitter_share_url.'" target="_blank"><i class="fab fa-twitter"></i></a></div>';
    $variables['twitter_button'] = $twitter_button;

}


?>
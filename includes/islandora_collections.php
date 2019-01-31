<?php

/**
* Overrides for preprocess functions in islandora_solution_pack_collection
*/

function pld_preprocess_islandora_basic_collection_grid(&$variables) {
	pld_preprocess_islandora_basic_collection($variables);
}

function pld_preprocess_islandora_basic_collection(&$variables) {
	$islandora_object = $variables['islandora_object'];

  try {
    $dc = $islandora_object['DC']->content;
    $dc_object = DublinCore::importFromXMLString($dc);
  }
  catch (Exception $e) {
    drupal_set_message(t('Error retrieving object %s %t', array('%s' => $islandora_object->id, '%t' => $e->getMessage())), 'error', FALSE);
  }
  $page_number = (empty($_GET['page'])) ? 0 : $_GET['page'];
  $page_size = (empty($_GET['pagesize'])) ? variable_get('islandora_basic_collection_page_size', '12') : $_GET['pagesize'];
  $results = $variables['collection_results'];
  $total_count = count($results);
  $variables['islandora_dublin_core'] = isset($dc_object) ? $dc_object : array();
  $variables['islandora_object_label'] = $islandora_object->label;
  $display = (empty($_GET['display'])) ? 'list' : $_GET['display'];
  if ($display == 'grid') {
    $variables['theme_hook_suggestions'][] = 'islandora_basic_collection_grid__' . str_replace(':', '_', $islandora_object->id);
  }
  else {
    $variables['theme_hook_suggestions'][] = 'islandora_basic_collection__' . str_replace(':', '_', $islandora_object->id);
  }
  if (isset($islandora_object['OBJ'])) {
    $full_size_url = url("islandora/object/{$islandora_object->id}/datastram/OBJ/view");
    $params = array(
      'title' => $islandora_object->label,
      'path' => $full_size_url);
    $variables['islandora_full_img'] = theme('image', $params);
  }
  if (isset($islandora_object['TN'])) {
    $full_size_url = url("islandora/objects/{$islandora_object->id}/datastream/TN/view");
    $params = array(
      'title' => $islandora_object->label,
      'path' => $full_size_url);
    $variables['islandora_thumbnail_img'] = theme('image', $params);
  }
  if (isset($islandora_object['MEDIUM_SIZE'])) {
    $full_size_url = url("islandora/object/{$islandora_object->id}/datastream/MEDIUM_SIZE/view");
    $params = array(
      'title' => $islandora_object->label,
      'path' => $full_size_url);
    $variables['islandora_medium_img'] = theme('params', $params);
  }

  $associated_objects_array = array();

  foreach ($results as $result) {
    $pid = $result['object']['value'];
    $fc_object = islandora_object_load($pid);
    if (!is_object($fc_object)) {
      // NULL object so don't show in collection view.
      continue;
    }
    $associated_objects_array[$pid]['object'] = $fc_object;
    try {
      $dc = $fc_object['DC']->content;
      $dc_object = DublinCore::importFromXMLString($dc);
      $associated_objects_array[$pid]['dc_array'] = $dc_object->asArray();
    }
    catch (Exception $e) {
      drupal_set_message(t('Error retrieving object %s %t', array('%s' => $islandora_object->id, '%t' => $e->getMessage())), 'error', FALSE);
    }
    $object_url = 'islandora/object/' . $pid;

    $title = $result['title']['value'];
    if($title == '') {
      $title = 'Untitled';
    }
    $associated_objects_array[$pid]['pid'] = $pid;
    $associated_objects_array[$pid]['path'] = $object_url;
    $associated_objects_array[$pid]['title'] = $title;
    $associated_objects_array[$pid]['class'] = drupal_strtolower(preg_replace('/[^A-Za-z0-9]/', '-', $pid));

    // check for content model then generate image thumbs conditionally
    $obj_models = $fc_object->relationships->get('info:fedora/fedora-system:def/model#', 'hasModel');
    $obj_model = $obj_models[0]['object']['value'];
    $medium_size = '';

    $no_thumb_path = drupal_get_path('theme', 'pld');
    $no_thumb = theme('image', array('path' => "$no_thumb_path/img/no_image_available.png", 'alt' => $title));

     if(isset($fc_object['MEDIUM_SIZE']) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $fc_object['MEDIUM_SIZE'])) {
      $medium_size = theme('image', array('path' => "$object_url/datastream/MEDIUM_SIZE/view", 'alt' => $title));
    } else {
      $medium_size = NULL;
    }

    if (isset($fc_object['TN']) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $fc_object['TN'])) {
      $thumbnail_img = theme('image', array('path' => "$object_url/datastream/TN/view", 'alt' => $title));
    }
    else {
      $thumbnail_img = $no_thumb;
    }

    if($obj_model == 'islandora:compoundCModel') {
      $parts = islandora_compound_object_get_parts($fc_object->id);
      $obj_count = count($parts);
      if($obj_count <= 0) {
        $medium_size = $no_thumb;
      } else {
         $first_child = $parts[0];
         $medium_size = theme('image', array('path' => "islandora/object/".$first_child."/datastream/MEDIUM_SIZE/view", 'alt' => $title));
      }
    }

    $associated_objects_array[$pid]['thumbnail'] = $thumbnail_img;
    $associated_objects_array[$pid]['medium_size'] = $medium_size;
    $associated_objects_array[$pid]['title_link'] = l($title, $object_url, array('html' => TRUE, 'attributes' => array('title' => $title)));


    if($obj_model == 'islandora:collectionCModel') {
      $associated_objects_array[$pid]['obj_link'] = l($thumbnail_img, $object_url, array('html' => TRUE, 'attributes' => array('title' => $title)));
    } else {
      $associated_objects_array[$pid]['obj_link'] = l($medium_size, $object_url, array('html' => TRUE, 'attributes' => array('title' => $title)));
    }

  }

  $variables['associated_objects_array'] = $associated_objects_array;
}

function pld_preprocess_islandora_objects_subset(&$variables) {

  $current_pid = arg(2);

  $parent_object = islandora_object_load($current_pid);
  $dc = $parent_object->getDatastream('DC');
  $dc_content = $dc->content;
  $dc_object = DublinCore::importFromXMLString($dc_content);
  $dc_object = $dc_object->asArray();

  //var_dump($dc_object);
  $collection_title = $dc_object['dc:title']['value'];
  $collection_description = $dc_object['dc:description']['value'];
  $variables['collection_title'] = $collection_title;
  $variables['collection_description'] = $collection_description;

  //print $collection_description;
}

?>

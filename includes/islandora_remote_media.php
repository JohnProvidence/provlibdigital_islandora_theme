<?php
/**
* Overrides preprocess functions for islandora remote media module
* - mainly to pass additional variables / data to the theme get_included_file
* @see templates/islandora-remote-media.tpl.php
**/

function pld_preprocess_islandora_remote_media(array &$variables) {
    module_load_include('inc', 'islandora', 'includes/datastream');
    module_load_include('inc', 'islandora', 'includes/utilities');
    module_load_include('inc', 'islandora', 'includes/solution_packs');
    module_load_include('inc', 'islandora', 'includes/authtokens');
    module_load_include('inc', 'islandora', 'includes/metadata');
    drupal_add_js('misc/form.js');
    drupal_add_js('misc/collapse.js');
    $object = $variables['object'];
    $repository = $object->repository;


    // We should eventually remove the DC object and dc_array code as it only
    // exists to not break legacy implementations.
    $variables['islandora_dublin_core'] = isset($dc_object) ? $dc_object : NULL;
    $variables['dc_array'] = isset($dc_object) ? $dc_object->asArray() : array();
    $variables['islandora_object_label'] = $object->label;
    $variables['theme_hook_suggestions'][] = 'islandora_remote_media__' . str_replace(':', '_', $object->id);
    $variables['parent_collections'] = islandora_get_parents_from_rels_ext($object);
    $variables['metadata'] = islandora_retrieve_metadata_markup($object);
    $variables['description'] = islandora_retrieve_description_markup($object);

    $viewer_dsid = 'OBJ';

    $media_params = array(
      'pid' => $object->id,
    );
    // Media player.
    if (isset($object[$viewer_dsid]) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $object[$viewer_dsid])) {
      $embedded_media = $object[$viewer_dsid]->content;
    }

    // Thumbnail.
    if (isset($object['TN']) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $object['TN'])) {
      $media_params += array(
        'tn' => url("islandora/object/{$object->id}/datastream/TN/view", array('absolute' => TRUE)),
      );
    }

    // get datastreams to generate download buttons
    $obj_pid = $object->id;
    $object = islandora_object_load($obj_pid);
    $mods = $object->getDatastream('MODS');
    $dc = $object->getDatastream('DC');
    $copyright = $object->getDatastream('COPYRIGHT');
    $copyright_image = drupal_get_path('theme', 'pld') . '/img/image_under_copyright.png';



    // generate datastream buttons
    if(isset($mods)):
      $mods_btn = '<div class="btn download-btn"><a href="/islandora/object/'.$obj_pid.'/datastream/MODS/view" download="'.$obj_pid.'-'.$object->label.'/_MODS.xml">Download MODS XML</a> <i class="fas fa-file-download"></i></div>';
    $variables['mods_btn'] = $mods_btn;
    else:
      $variables['mods_btn'] = NULL;
    endif;

    if(isset($dc)):
        $dc_btn = '<div class="btn download-btn"><a href="/islandora/object/'.$obj_pid.'/datastream/DC/view" download="'.$obj_pid.'-'.$object->label.'/_DC.xml">Download DC XML</a> <i class="fas fa-file-download"></i></div>';
      $variables['dc_btn'] = $dc_btn;
    else:
        $variables['dc_btn'] = NULL;
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

    $parents = $object->getParents();
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
         if($parent_object != FALSE):
           $collection = $parent_object->getParents();
           $collection_object = islandora_object_load($collection[0]);
           $variables['parent_collection'] = $collection_object->label;
           $variables['parent_url'] = '/islandora/object/'.$collection_object->id;
           $finding_aid = $collection_object->getDatastream('FINDING_AID');
        endif;

         if($finding_aid != FALSE) {
           $finding_aid_button = '<div class="btn finding_aid_btn"><a href="/islandora/object/'.$collection_object->id.'/datastream/FINDING_AID/view">Download Collection Finding Aid <i class="far fa-file-alt"></i></a></div>';
            $variables['collection_finding_aid_button'] = $finding_aid_button;
         }
      }

      // Social media sharing buttons
      $path = $GLOBALS['base_url'];
      $object_url =  $path .'/islandora/object/'.$obj_pid;


      $facebook_button = '<div id="fb-share" data-url="'.$object_url.'" data-title="'.$object->label.'" data-descrip="'.$object->label.'" data-image="'.$object_url. '/datastream/OBJ/view" data-width="520" data-height="350"><i class="fab fa-facebook-f"></i></div>';

      $variables['facebook_button'] = $facebook_button;

      $twitter_share_url = 'https://twitter.com/intent/tweet?text='.$object->label.' '.$object_url;

      $twitter_button = '<div id="twitter-share"><a href="'.$twitter_share_url.'" target="_blank"><i class="fab fa-twitter"></i></a></div>';
      $variables['twitter_button'] = $twitter_button;


      $variables['islandora_content'] = '';
      if ($embedded_media) {
        $variables['islandora_content'] = $embedded_media;
      }
      else {
        $variables['islandora_content'] = NULL;
      }
      return array('' => $embedded_media);
}
 ?>

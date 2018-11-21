<?php
/**
 * @file
 * Islandora Solr grid template
 *
 * Variables available:
 * - $results: Primary profile results array
 *
 * @see template_preprocess_islandora_solr_grid()
 */

?>

<?php if (empty($results)): ?>
  <p class="no-results"><?php print t('Sorry, but your search returned no results.'); ?></p>
<?php else: ?>
  <div class="islandora-solr-search-results">
    <div class="islandora-solr-grid clearfix">
    <?php foreach($results as $result): 
      // override to grab medium sized image and display that if that datastream is present
      $pid = $result['PID'];
      $medium_size_url = '';
      $image = '';
      $no_thumb_path = drupal_get_path('theme', 'pld');
      $no_thumb = theme('image', array('path' => "$no_thumb_path/img/ppl-pattern.png", 'alt' => $title));
      // Get content models from islandora object
      $object = islandora_object_load($pid);
      $obj_models = $object->relationships->get('info:fedora/fedora-system:def/model#', 'hasModel');
      $obj_model = $obj_models[0]['object']['value'];
     
      // check content model, then get either the MEDIUM SIZE image or the MEDIUM SIZE of the first child if cModel == compound
      if($obj_model == 'islandora:compoundCModel'):
          $parts = islandora_compound_object_get_parts($object->id);
          $obj_count = count($parts);
          
          if($obj_count > 0): // count number of objects in parts, if greater than 0 set the medium size of the first child object as the image to display
            $first_child = $parts[0];
            $medium_size_url = '/islandora/object/'.$first_child.'/datastream/MEDIUM_SIZE/view';
            $image = '<img src="'.$medium_size_url.'" alt="'.$result['object_label'].'" />';
          else:
            $image = $no_thumb;
         endif;   
      
      endif; // end obj_model check
     
      if($obj_model == 'islandora:sp_basic_image'):
        $medium_size_url = '/islandora/object/'.$pid.'/datastream/MEDIUM_SIZE/view';
        $image = '<img src="'.$medium_size_url.'" alt="'.$result['object_label'].'" />';
      endif;

      if($obj_model == 'islandora:collectionCModel'):
        $image = '<img src="' . url($result['thumbnail_url'], array('query' => $result['thumbnail_url_params'])) . '" alt="' . $result['object_label'] . '"/>';
      endif;
      ?>

      <dl class="solr-grid-field">
        <dt class="solr-grid-thumb">
          <?php
            print l($image, $result['object_url'], array(
              'html' => TRUE,
              'query' => $result['object_url_params'],
              'fragment' => isset($result['object_url_fragment']) ? $result['object_url_fragment'] : '',
              'attributes' => array('title' => $result['object_label']),
            ));
          ?>
        </dt>
        <dd class="solr-grid-caption">
         <h4><?php
            $object_label = isset($result['object_label']) ? $result['object_label'] : '';
            print l($object_label, $result['object_url'], array(
              'query' => $result['object_url_params'],
              'fragment' => isset($result['object_url_fragment']) ? $result['object_url_fragment'] : '',
              'attributes' => array('title' => $result['object_label']),
            ));
          ?></h4>
        </dd>
      </dl>
    <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>
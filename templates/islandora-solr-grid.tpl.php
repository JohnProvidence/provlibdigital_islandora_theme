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
    <?php foreach($results as $result): ?>
      <?php $data = $result['solr_doc'];
      //var_dump($result); // uncomment to see data array from solr
      ?>
      <?php
      if(isset($result['image_url'])):
      ?>

        <dl class="solr-grid-field">
          <dt class="solr-grid-thumb">
            <?php
              $image = '<img src="' . url($result['image_url'], array('query' => $result['thumbnail_url_params'])) . '" alt="' . $result['object_label'] . '"/>';
              print l($image, $result['object_url'], array(
                'html' => TRUE,
                'query' => $result['object_url_params'],
                'fragment' => isset($result['object_url_fragment']) ? $result['object_url_fragment'] : '',
                'attributes' => array('title' => $result['object_label']),
              ));
            ?>
          </dt>
          <dd class="solr-grid-caption">
            <?php
              $object_label = isset($result['object_label']) ? $result['object_label'] : '';
              $object_label = htmlspecialchars_decode($object_label);
              print l($object_label, $result['object_url'], array(
                'query' => $result['object_url_params'],
                'fragment' => isset($result['object_url_fragment']) ? $result['object_url_fragment'] : '',
                'attributes' => array('title' => $result['object_label']),
              ));
            ?>
            <div class="additional_data">

              <?php if(isset($result['PID'])): ?>
              <!--<span class="pid"><strong>PID: </strong> <?php print $result['PID']; ?> </span>-->
            <?php endif; ?>

             <?php if(isset($data['mods_identifier_local_ss'])): ?>
              <span class="identifier"><strong>Identifier: </strong> <?php print $data['mods_identifier_local_ss']; ?></span>
            <?php endif; ?>

            <?php if(isset($data['mods_subject_topic_ss'])): ?>
              <span class="description"><strong>Topics: </strong> <?php print $data['mods_subject_topic_ss']; ?></span>
            <?php endif; ?>
            </div>
          </dd>
        </dl>
    <?php endif; ?>
    <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>

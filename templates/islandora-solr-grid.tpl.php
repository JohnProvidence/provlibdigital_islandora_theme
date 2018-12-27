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
      var_dump($data);
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
              <span class="pid"><strong>PID: </strong> <?php print $data['PID']; ?> </span>
              <span class="identifier"><strong>Identifier: </strong> <?php print $data['dc.identifier'][1]; ?></span>
              <span class="description"><strong>Subject | Topics </strong> <?php print $data['dc.subject'][0]; ?></span>
            </div>
          </dd>
        </dl>
    <?php endif; ?>
    <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>
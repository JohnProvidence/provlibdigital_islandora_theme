<?php

/**
* Override of islandora compound prev / next display
*/

?>

<div class="islandora-compound-prev-next">
 <div class="islandora-compound-title"><?php
  //print t('Part of: @parent (@count @objects)', array('@parent' => t(html_entity_decode($parent_label)), '@count' => $child_count, '@objects' => format_plural($child_count, 'object', 'objects'))); ?>
 <?php if ($parent_url): ?>
    <?php print l(t('manage parent'), $parent_url, array('attributes' => array('class' => 'manage-parent-btn'))); ?>
 <?php endif; ?>
   <?php if ($parent_tn): ?>
    <?php print l(
       theme_image(
         array(
           'path' => $parent_tn,
           'attributes' => array('class' => 'parent-tn'),
         )
       ),
       'islandora/object/' . $parent_pid,
       array('html' => TRUE)
     ); ?>
 <?php endif; ?>
 </span>

 <?php if (!empty($previous_pid)): ?>
   <?php print l(t('Previous'), 'islandora/object/' . $previous_pid, array('attributes' => array('class' => 'compound-btn'))); ?>
 <?php endif; ?>
 <?php if (!empty($previous_pid) && !empty($next_pid)): ?>
    |
 <?php endif;?>
 <?php if (!empty($next_pid)): ?>
   <?php print l(t('Next'), 'islandora/object/' . $next_pid, array('attributes' => array('class' => 'compound-btn'))); ?>
 <?php endif; ?>

 <?php if (count($themed_siblings) > 0): ?>
   <?php $query_params = drupal_get_query_parameters(); ?>
   <div class="islandora-compound-thumbs">
   <?php foreach ($themed_siblings as $sibling): ?>
     <div class="islandora-compound-thumb">
     <span class='islandora-compound-caption'><?php print $sibling['label'];?></span>
     <?php print l(
       theme_image(
         array(
           'path' => $sibling['TN'],
           'attributes' => array('class' => $sibling['class']),
         )
       ),
       'islandora/object/' . $sibling['pid'],
       array('html' => TRUE, 'query' => $query_params)
     );?>
     </div>
   <?php endforeach; // each themed_siblings ?>
   </div> <!-- // islandora-compound-thumbs -->
 <?php endif; // count($themed_siblings) > 0 ?>
 </div>


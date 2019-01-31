<?php
//var_dump($variables);
?>
<div class="islandora-objects clearfix">
  <span class="islandora-objects-display-switch">
    <?php
    print theme('links', array(
                           'links' => $display_links,
                           'attributes' => array('class' => array('links', 'inline')),
                         )
    );
    ?>
  </span>
<?php if($variables['collection_description'] != ''): ?>
  <div class="collection_description">
    <div class="toggle-description"><span>
      <?php
        if(strpos('The' ,$variables['collection_title'])):
            print 'About '. $variables['collection_title'];
        else:
            print 'About The '.$variables['collection_title'];
        endif;
        ?>
        <span class="arrow-up"><i class="fas fa-arrow-up"></i></span></span>
    </div>
    <div class="display-description visible">
      <?php print $variables['collection_description']; ?>
    </div>
  </div>
<?php endif; ?>
  <?php print $pager; ?>
  <?php print $content; ?>
  <?php print $pager; ?>
</div>

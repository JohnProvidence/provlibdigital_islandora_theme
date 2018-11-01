<?php

/**
* @file
*/

?>

<?php include('includes/header.php'); ?>

<?php $current_path = current_path();
	if($current_path === 'islandora/object/islandora:root'):
 ?>
	<?php if($page['featured_collections']): ?>
		<div class="featured_collection_object">
			<?php print render($page['featured_collections']); ?>
		</div>
	<?php endif; ?>
<?php endif; ?>

<?php if(theme_get_setting('pld_collections_description_text') && $current_path === 'islandora/object/islandora:root'): 
		$collections_description = theme_get_setting('pld_collections_description_text');
	?>
	<div class="collections-description__wrapper">
		<div class="collections-description__text">
			<h2>Welcome to Providence Public Library Digital Collections</h2>
			<?php print $collections_description; ?>
		</div>
	</div>
<?php endif; ?>

<div id="page" class="<?php print $classes; ?>" <?php print $attributes; ?>>
	<div id="main">
		<div id="container">
			<?php if ($page['sidebar_first']): ?>
		        <aside id="sidebar-first">
		          <?php print render($page['sidebar_first']); ?>
		        </aside>
      		<?php endif; ?><!-- /sidebar-first -->
			<section id="content">
				<?php if ($breadcrumb || $title || $messages || $tabs || $action_links): ?>

					<?php  print $breadcrumb; ?>

					<?php if ($page['highlighted']) : ?>
						<div id="highlighted">
							<?php print render($page['highlighted']) ?>
						</div>
					<?php endif; ?>

					<?php if ($title): ?>
						<!--<h1 class="title"><?php print $title; ?></h1>-->
					<?php endif; ?>

					<?php print render($title_suffix); ?>
					<?php print $messages; ?>
            		<?php print render($page['help']); ?>		
            		
            		<?php if (render($tabs)): ?>
              		<div class="tabs"><?php print render($tabs); ?></div>
            		<?php endif; ?>

            		<?php if ($action_links): ?>
              		<ul class="action-links"><?php print render($action_links); ?></ul>
            		<?php endif; ?>			

				<?php endif; ?>

				 <div id="content-area">
         		 <?php print render($page['content']) ?>
        		</div>

        		<?php print $feed_icons; ?>

			</section><!-- ./content -->
			

		      <?php if ($page['sidebar_second']): ?>
		        <aside id="sidebar-second">
		          <?php print render($page['sidebar_second']); ?>
		        </aside>
		      <?php endif; ?><!-- /sidebar-second -->
		</div>
	</div><!-- ./main -->
</div>
<?php include('includes/search-modal.php'); ?>

<?php include('includes/footer.php'); ?>
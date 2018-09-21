<?php

/**
* site header template
*/
?>

<header id="header" class="site-header__wrapper">
	
	<div class="logo__wrapper">
		<a href="<?php print $front_page; ?>" title="<?php print $site_name; ?>" rel="home" id="logo">
			<img src="<?php print $logo; ?>" alt="<?php print $site_name; ?> logo"/>
		</a>
		<div class="site-name__wrapper">
			<?php if($library_name): ?>
			<div class="library_name">
				<?php print $library_name; ?>		
			</div>
			<?php endif; 
				if($dc):
			?>
			<div class="repository_name">
				<?php print $dc; ?>
				<?php endif; ?>
			</div>
		</div> 
	</div> <!-- end logo__wrapper -->
	<?php include('secondaryNav.php'); ?>
</header>

<?php include('navigation.php'); ?>

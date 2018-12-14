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

	<div class="menu-toggle">
		<i class="fas fa-bars" aria-hidden="true" title="Menu"></i>
		<div class="icon-title">Menu</div>
	</div>

	<div id="search-icon">
		<i class="fas fa-search" aria-hidden="true" title="Search Collection"></i>
		<div class="icon-title">Search</div>
	</div>

	<div class="user-login-toggle">
		<?php if(!user_is_logged_in()): ?>
			<a href="/user/login"><i class="fas fa-sign-in-alt" aria-hidden="true" title="Account Login"></i></a>
			<div class="icon-title">Login</div>
		<?php else: ?>
			<a href="/user"><i class="far fa-user-circle" aria-hidden="true" title="Account"></i></a>
			<div class="icon-title">Your Account</div>
		<?php endif; ?>
	</div>

	<?php if(user_is_logged_in()): ?>
		<div class="user-login-toggle">
			<a href="/user/logout">
				<i class="fas fa-sign-out-alt" aria-hidden="true" title="Logout"></i>
			</a>
			<div class="icon-title">
				Logout
			</div>
	<?php endif; ?>
	
	<?php //include('secondaryNav.php'); ?>
</header>

<?php include('navigation.php'); ?>

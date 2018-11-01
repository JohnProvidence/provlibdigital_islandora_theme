<?php
/**
* Site Navigation
*/


if( $main_menu || $secondary_menu ):
?>

<nav id="navigation" class="hidden site-nav__wrapper menu

<?php
	if( !empty($main_menu) ):
		print "with-primary";
	endif;
?>">
	<div class="menu-header">
		<span class="menu-title">Menu</span> 
		<span class="menu-close"><i class="fas fa-window-close" aria-hidden="true"></i>
	</div>
	<div class="menu-container">
	
		<?php
		
		print theme('links', array(
			'links'			=> $main_menu,
			'attributes' 	=> array(
				'id'		=> 'primary',
				'class'		=> array('main-menu'),
			),
		));
		?>
	
	</div>

</nav>

<?php
endif;
?>
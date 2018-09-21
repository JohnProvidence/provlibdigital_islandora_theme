<?php
/**
* Site Navigation
*/


if( $main_menu || $secondary_menu ):
?>

<nav id="navigation" class="site-nav__wrapper menu

<?php
	if( !empty($main_menu) ):
		print "with-primary";
	endif;
?>">
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
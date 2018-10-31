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

<?php if($page['collections_search']): ?>
	<div class="search-form__wrapper">
		<div class="collections-search__form-wrapper hidden">
			<?php print render($page['collections_search']); ?>
		</div>
	</div>
<?php endif; ?>

</nav>

<?php
endif;
?>
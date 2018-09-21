<?php
/** 
* Secondary Navigation -- includes login / logout and my account buttons 
**/
?>

<div class="secondary-nav login-area">
	<?php
	print theme('links', array(
			'links'			=> $secondary_menu,
			'attributes'	=> array(
				'id'		=> 'secondary',
				'class'		=> array('sub-menu'),
			),
		));
	?>
</div>
		
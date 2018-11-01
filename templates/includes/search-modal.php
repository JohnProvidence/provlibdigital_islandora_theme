<?php

/**
* Modal window for search modal - triggered by search icon in header
*/


if($page['collections_search']): ?>

<div class="search-modal">

	<div class="search-modal__close"><i class="fas fa-window-close" aria-hideen="true"></i></div>
	
	<div class="search-form__wrapper">
		<div class="collections-search__form-wrapper">
			<?php print render($page['collections_search']); ?>
		</div>
	</div>

</div><!-- end modal window -->
<?php endif; ?>
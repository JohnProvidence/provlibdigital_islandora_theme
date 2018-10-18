jQuery(document).ready(function($) {
	// Code below can use jQuery $ 
	var searchIcon = $('#search-icon');
	var searchForm = $('.collections-search__form-wrapper');

	searchIcon.on('click', function() {
		$(this).addClass('hidden');
		searchForm.removeClass('hidden');
		console.log('clicked');
	})
})
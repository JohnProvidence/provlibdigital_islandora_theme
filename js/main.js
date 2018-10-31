jQuery(document).ready(function($) {
	// Code below can use jQuery $ 
	var searchIcon = $('#search-icon');
	var searchForm = $('.collections-search__form-wrapper');

	searchIcon.on('click', function() {
		$(this).addClass('hidden');
		searchForm.removeClass('hidden');
		console.log('clicked');
	});

	$('.view-all-collections').on('click', function() {
		$('html,body').animate({
			scrollTop: $('.islandora-basic-collection-wrapper').offset().top
		}, 'slow');
	});
})
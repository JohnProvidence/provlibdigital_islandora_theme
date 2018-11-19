jQuery(document).ready(function($) {
	// Code below can use jQuery $ 
	// Search modal toggle
	var searchIcon = $('#search-icon');
	var searchForm = $('.search-modal');
	var searchClose = $('.search-modal__close');
	
	searchIcon.on('click', function() {
		searchForm.addClass('visible');
	});

	searchClose.on('click', function() {
		searchForm.removeClass('visible');
	});

	// Navigation toggle
	var menuTog = $('.menu-toggle');
	var nav = $('#navigation.site-nav__wrapper');
	var navClose = $('.menu-header .menu-close');

	menuTog.on('click', function() {
		nav.toggleClass('visible');
		nav.toggleClass('hidden');
	});
	navClose.on('click', function() {
		nav.removeClass('visible');
		nav.addClass('hidden');
	})

	$('.view-all-collections').on('click', function() {
		$('html,body').animate({
			scrollTop: $('.islandora-basic-collection-wrapper').offset().top - 200
		}, 'slow');
	});

	// toggle facets options on search page
	var facetTitle = $('.islandora-solr-facet-wrapper h3');

	facetTitle.on('click', function() {
		var facets = $(this).next('.solr-facet-results');
		$(this).find('span.down-arrow').toggleClass('rotated');
		facets.toggleClass('hidden');
	});

});
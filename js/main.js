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

	var metadataLegend = $('span.fieldset-legend');

	metadataLegend.on('click', function() {
		$('.fieldset-wrapper').toggleClass('expanded');
		$(this).children('span.arrow-up').toggleClass('rotated');
	});

	var compoundThumbToggle = $('.compound-thumbs-display-toggle span');

	compoundThumbToggle.on('click', function() {
		compoundThumbToggle.toggleClass('hidden');
		$('.islandora-compound-title').toggle('fast');
	});



	// Copy Bookmark list URL
	function copyBookmarkURL() {
		var listURL = $('#list_url_link').val();
		var copyBtn = $('.share-list-url-btn');

		copyBtn.on('click', function(e) {
			var $temp = $('<input>');
			$('body').append($temp);
			$temp.val(listURL).select();
			document.execCommand('copy');
			$temp.remove();
		});
	} 
	copyBookmarkURL();

	// IA Bookreader overrides

	var bookreader_options = {
			ui: 'responsive',
			flipSpeed: 'slow',
			showLogo: false,
	};
	
	if(typeof Bookreader == 'function') {
		var br = new Bookreader(bookreader_options);
	}
	

	br.init();

});
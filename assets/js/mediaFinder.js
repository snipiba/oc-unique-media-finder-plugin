/**
 * Author: SNiPI
 * E-Mail: snipi@snipi.sk
 * Last Edited: 6 April 2021
 */
 var _load_aditional_info = false;
 var mediafinderEnabled = false;
 var currentProvider = 'unsplash';
jQuery(document).ready(function() {
	if($('div[data-control="media-manager"]').length>0) {
		initMediaFinder();
	}
	$("body").on('DOMSubtreeModified', 'div[data-control="media-manager"]', function() {
		if(!mediafinderEnabled) {
			initMediaFinder();
		}
	});

});

function initMediaFinder() {

	mediafinderEnabled = true;
	$('#media-provider,#provider-details,#loader').hide();
	$('a[data-command]').click(function(e){
		e.stopPropagation();
		if($(this).data('command') != 'open-provider') {
			$('#media-provider').hide();
			$('#main-content').show();
		}
	});

	$('a[data-command="open-provider"]').click(function(e){
		e.stopPropagation();
		$('li[role="presentation"]').removeClass('active');
		$(this).parent('li[role="presentation"]').addClass('active');
		currentProvider = $(this).data('provider');
		$('#media-provider,#provider-searchbar').show();
		$('#main-content').hide();
		if($('input[name="qs"]').val() != '') {
			$('#currentPage').val(1);
			search(currentProvider);
			initFilters(currentProvider);
		} else {
			initProvider(currentProvider);
		}
	});

	if(_load_aditional_info) {
		loadAditionalInfo();
	}
	
}

function initFilters(provider) {
	$.request('onLoadFilters', {
		loading: $('#loader'),
		data: {
			provider: provider
		},
		update: {
			'ajax/filters' : '#provider-filters'
		},
		beforeSend: function() {
			$('#provider-content').html('');
			$('#provider-searchbar input[name="qs"]').off("keyup");			
			$('#provider-searchbar input[name="qs"]').on('keyup',function(e){
				if(e.which == 13) {
					$('#currentPage').val(1);
					search(currentProvider);
				}
			});
		}
	});
}

function loadAditionalInfo() {
	searchingMetadata = false;
	$sidebar = $('div[data-control="preview-sidebar"]');	
	$('body').on('DOMSubtreeModified', '[data-control="sidebar-labels"]',function(){
		//$('#media-metadata').html('');		
	});
	$('body').on('DOMSubtreeModified', 'div.sidebar-image-placeholder',function(){
		
		$image = $sidebar.find('.sidebar-image-placeholder').data('path');

		$.request('onLoadMetadata',{
			beforeSend: function() {									
				$('[data-control="media-manager"]').on('mediarefresh',function(){
					//alert('media refreshed');
				});
				if($('#media-metadata').length==0) {
					$('div[data-control="sidebar-labels"]').append('<div id="media-metadata"></div>');
				} 
				$('#media-metatada').html('... lookup for metadata ...');
			},
			data: {
				path : $image
			},
			update: {
				'ajax/metadata' : '#media-metadata'
			}
		});
	
	});
}

function showDetails() {
	//$('#provider-details').show();
}

function initProvider(provider) 
{
	$.request('onInitProvider',{
		loading: $('#loader'),
		data: {
			'provider': provider,
		},
		update: {
			'ajax/providerContent' : '#provider-content'
		},
		beforeSend: function() {
			$('#provider-content').html('');
			$('#mediafinder-provider').html('<img src="/plugins/snipi/uniquemediafinder/assets/img/' + provider + '.svg" width="20" alt=""/> ' + provider.toUpperCase()
				+ ' ~ <em>Latest photos</em>');
		}
	});	
	$.request('onLoadFilters', {
		loading: $('#loader'),
		data: {
			provider: currentProvider
		},
		update: {
			'ajax/filters' : '#provider-filters'
		},
		beforeSend: function() {
			$('#provider-content').html('');
			$('#provider-searchbar input[name="qs"]').off("keyup");			
			$('#provider-searchbar input[name="qs"]').on('keyup',function(e){
				if(e.which == 13) {	
					$('#currentPage').val(1);				
					search(currentProvider);
				}
			});
		}
	});
}

function search(provider) {
	
	filters = $('#provider-searchbar input').serialize();

	$.request('onSearchProvider', {
		loading: $('#loader'),
		beforeSend: function() {
			$('#provider-content').html('');
			$('#mediafinder-provider').html('<img src="/plugins/snipi/uniquemediafinder/assets/img/' + provider + '.svg" width="20" alt=""/> ' + provider.toUpperCase()
				+ ' ~ ' + __lang_searching_for + ': <strong>' + $('#qs').val().toUpperCase() + '</strong>');

		},
		data: {
			provider: provider,
			filters: filters,
			page: parseInt($('#currentPage').val())
		},
		update: {
			'ajax/search' : '#provider-content'
		}
	});
		
}

function photoDownloaded(folder,filename) {
	$.oc.flashMsg({
        'text' : __lang_pic_downloaded + folder,
        'class' : 'success',
	});
	setTimeout(function(){
		if(confirm(__lang_open_download_folder)) {
			$('[data-type="current-folder"]').val(folder);
			$('button[data-command="refresh"]').trigger('click');
			$('#media-provider').hide();
			$('#main-content').show();
			$('.modal').trigger('close.oc.popup'); 
		}
	},1500);
}

function initPagination() {
	var currentPage = parseInt($('#currentPage').val());
	if(currentPage > 1) {
		$('[data-call="prevPage"]').show();	
	} else {
		$('[data-call="prevPage"]').hide();
	}
	$('[data-call="prevPage"]').click(function(){		
		$('#currentPage').val(currentPage-1);
		search(currentProvider);
	});
	$('[data-call="nexPage"]').click(function(){
		$('#currentPage').val(currentPage+1);
		search(currentProvider);
	});
}
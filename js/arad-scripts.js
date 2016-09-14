/**
* Reserved metabox id for automatically show
*
*/
jQuery(function($){
	'use strict';
	/** 
	* Code to hide and show the post meta related name
	*
	*/
	var reserve_id = new Array('arad_gallery','arad_video','arad_audio','arad_quote');
	var reserve_postf = new Array('post-format-gallery','post-format-video','post-format-audio','post-format-quote');
	
	function aradHideAllReserve(){
		var arrayLength = reserve_id.length;
		for (var i = 0; i < arrayLength; i++) {
			if($('#'+reserve_id[i]).length > 0){
				$('#'+reserve_id[i]).slideUp();
			}
		}
	}
	function aradCheckAllReserve(){
		aradHideAllReserve();
		var arrayLength = reserve_postf.length;
		for (var i = 0; i < arrayLength; i++) {
			if($('#'+reserve_postf[i]).length > 0){
				
				if($('#'+reserve_postf[i]).is(':checked') ){
					if($('#'+reserve_id[i]).length > 0){
						$('#'+reserve_id[i]).slideDown();
					}
				}
			}
		}
	}
	aradCheckAllReserve();
	$('.post-format').change(function(){
		aradCheckAllReserve();
	});
	
	/** 
	* Code to make special field like images
	*
	*/
	function aradMediaUpload( element, filter ) {
		var custom_file_frame = null;
		var input_name = $(element).attr('data-name');

		var multiple = false;
		if(filter == 'images'){
			multiple = true;
		}
		
		var type = filter;
		if(type == 'images'){
			type = 'image';
		}
			
		// Create the media frame.
		custom_file_frame = wp.media.frames.customHeader = wp.media({
			title: 'Choose file(s)',
			multiple: multiple,
			library: {
				type: type
			},
			button: {
				text: 'Select'
			}
		});

		custom_file_frame.on( "select", function() {
			var attachment = custom_file_frame.state().get("selection");
			var firstAttachment = custom_file_frame.state().get("selection").first();
			switch(filter){
				case 'images' :
					var selected = attachment.models;
					var id = "";
					
					$('.'+input_name+'_imgsblock').empty();
					
					for ( var i = 0; i < selected.length; i++ ) {
						id += selected[i].id + ",";
						$('.'+input_name+'_imgsblock').append('<div class="arad_thumbnail"><div class="arad_centered"><img src="'+selected[i].attributes.url+'" width="100%" /></div></div>');
					}
					
					$('input[name='+input_name+']').val(id);
					element.closest('label').children('.arad_remove_images').removeClass('arad_hide').show();

				break;
				case 'video' :
					$('input[name='+input_name+']').val(firstAttachment.attributes.id);
					
					$('.'+input_name+'_infvid').empty();
					$('.'+input_name+'_infvid').html("<i class='icon-music'></i> " + firstAttachment.attributes.filename);
					$('.'+input_name+'_infvid').removeClass('arad_hide').show();
					
					element.closest('label').children('.arad_remove_video').removeClass('arad_hide').show();
				break;
				case 'audio' :
					$('input[name='+input_name+']').val(firstAttachment.attributes.id);
					
					$('.'+input_name+'_infaudio').empty();
					$('.'+input_name+'_infaudio').html("<i class='icon-music'></i> " + firstAttachment.attributes.filename);
					$('.'+input_name+'_infaudio').removeClass('arad_hide').show();
					
					element.closest('label').children('.arad_remove_audio').removeClass('arad_hide').show();
				break;
			}

			element.hide();
		});

		custom_file_frame.open();

	}

	/**
	* Javascript handle the post meta images type
	*
	*/
	$('.arad_images').on('click',  function(){
		aradMediaUpload($(this), 'images');
	});
	$('.arad_remove_images').on('click', function(){
		var input_name = $(this).attr('data-name');
		
		$('a[data-name='+input_name+']').removeClass('arad_hide');
		$('a[data-name='+input_name+']').show();
		
		$('.'+input_name+'_imgsblock').empty();
		$('input[name='+input_name+']').val('');
		$(this).hide();
	});
	
	/**
	* Javascript handle the post meta video type
	*
	*/
	$('.arad_video').on('click',  function(){
		aradMediaUpload($(this), 'video');
	});
	$('.arad_remove_video').on('click', function(){
		var input_name = $(this).attr('data-name');
		
		$('a[data-name='+input_name+']').removeClass('arad_hide');
		$('a[data-name='+input_name+']').show();
		
		$('.'+input_name+'_infvid').empty();
		$('input[name='+input_name+']').val('');
		$(this).hide();
	});
	
	/**
	* Javascript handle the post meta audio type
	*
	*/
	$('.arad_audio').on('click',  function(){
		aradMediaUpload($(this), 'audio');
	});
	$('.arad_remove_audio').on('click', function(){
		var input_name = $(this).attr('data-name');
		
		$('a[data-name='+input_name+']').removeClass('arad_hide');
		$('a[data-name='+input_name+']').show();
		
		$('.'+input_name+'_infaudio').empty();
		$('input[name='+input_name+']').val('');
		$(this).hide();
	});

});
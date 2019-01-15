/*
 *  Module: uploader
 */

var $ 				= require('jquery');

/**
 * Initialize uploader
 */
function dc_init() {

	btn = $('body').find('a.dc_modal_trigger');
	modal = $('.dc_modal');
	btn.each(function(x){
		var this_but = $(this);
		var apt_num = $(this).data('apt_num');
		this_but.on('click', function(e){
			e.preventDefault();			
			// reset form fields
			dc_clear_form();
			// load up wp file tools
			dc_create_wp_uploader();
			// add unit # to title
			$('.dc_pdf_form label').text('PDF for Unit #' + apt_num);
			$('.dc_pdf_form #dc_apt_num').val(apt_num);
			// open modal
			modal.show(function(){
				$('#dc_pdf_save_btn').on('click', function(e){
					e.preventDefault();
					dc_save_file();
				})
			});
		});
	});
	dc_close_modal();
}


function dc_close_modal() {
	$('#dc_upload_modal .dc_modal_close').on('click', function(e){
		if (modal.is(':visible')) {
			dc_clear_form();
			modal.hide();
		}	
	});
	window.onclick = function(e) {
		if ($(e.target).hasClass('dc_modal')) {
			dc_clear_form();
			modal.hide();
		}
	}
}

function dc_clear_form(){
	$('.dc_pdf_form #dc_apt_num').val('');
	$('.dc_pdf_form #dc_file_name' ).val('');
	$('.dc_pdf_form .dc_file-preview').text('');
}



function dc_create_wp_uploader() {
	// Uploading files
	var file_frame;
	var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
	var set_to_post_id = 99999; // Set this
	$('#dc_upload_file').on('click', function( event ){
		// console.log('button clicked'); 
		event.preventDefault();
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			// Set the post ID to what we want
			file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
			// Open frame
			file_frame.open();
			return;
		} else {
			// Set the wp.media post id so the uploader grabs the ID we want when initialised
			wp.media.model.settings.post.id = set_to_post_id;
		}
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select a file to upload',
			button: {
				text: 'Use this file',
			},
			multiple: false	// Set to true to allow multiple files to be selected
		});
		// When an file is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one file from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();
			// Do something with attachment.id and/or attachment.url here
			var url = attachment.url;
			var url = url.substring(url.lastIndexOf('/')+1);
			$('.dc_file_preview').text(url);
			$('#dc_file_name' ).val(attachment.url);
			// Restore the main post ID
			wp.media.model.settings.post.id = wp_media_post_id;
		});
		// Finally, open the modal
		file_frame.open();
	});
	// Restore the main ID when the add media button is pressed
	$( 'a.add_media' ).on( 'click', function() {
		wp.media.model.settings.post.id = wp_media_post_id;
	});
}

function dc_save_file(){
	var FileName = $('#dc_file_name').val();
	var ApartmentName = $('#dc_apt_num').val();
	if (FileName != '') {
		$.ajax({
			url : urls.ajax,
			type : 'post',
			data : {
				action : 'dc_save_file',
				file_name: FileName,
				apt_num: ApartmentName
			},
			success : function( response ) {
				dc_close_modal();
				$('.lds-ring-wrapper').show();
				$('.units-table').remove();
				$.ajax({
					url : urls.ajax,
					type : 'get',
					data : {
						action : 'dc_get_units_ajax'
					},
					success : function( response ) {
						$('.lds-ring-wrapper').hide(); // hide loader 
						$('.unit-table-wrapper').html( response );
						dc_init();
					}
				});
			},
			error : function( data, status ) {
				// console.log('error data.responseText: ' & data.responseText);
				// console.log('error status: ' & status);
				// console.log(data.responseText);
			}
		});
	} else {
		// console.log('FileName is missing!');
	}
}


/**
 * Public API
 * @type {Object}
 */
module.exports = {
	dc_init: dc_init
};
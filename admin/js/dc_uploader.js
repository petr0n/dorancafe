/*
 *  Module: uploader
 */

var $ 				= require('jquery');

/**
 * Initialize uploader
 */
function init() {
	
	console.log('uploader ready');

	btn = $('.unit-grid').find('a.modal-trigger');
	modal = $('.modal');
	btn.each(function(x){
		var this_but = $(this);
		var this_id = $(this).data('unit-id');
		var this_num = $(this).data('unit-num');
		this_but.on('click', function(e){
			e.preventDefault();			
			// open modal
			create_form(this_id);
			modal.show(function(){
				// add unit # to title
				$('body').find('#dc_schedule_form_' + this_id + ' .acf-label label').text('PDF for Unit #' + this_num);
			});
		});
	});

	$('.close').on('click', function(e){
		if (modal.is(':visible')) {
			modal.hide();
		}	
	});
	window.onclick = function(e) {
		if ($(e.target).hasClass('modal')) {
			modal.hide();
		}
	}

};

function create_form(form_id) {
	var form_wrapper = $('.modal-form-wrapper');
	$.ajax({
		url : urls.ajax,
		type : 'post',
		data : {
			action : 'dc_create_upload_form',
			form_id: form_id
		},
		success : function( response ) {
			// console.log('success response: ' + response);
			form_wrapper.html(response);
			$('#acf-field_5c085ee2c814f').val(form_id);

		},
		error : function( data, status ) {
			// console.log('error data.responseText: ' & data.responseText);
			// console.log('error status: ' & status);
			form_wrapper.append(data.responseText);
		}
	});
}

/**
 * Public API
 * @type {Object}
 */
module.exports = {
	init: init
};
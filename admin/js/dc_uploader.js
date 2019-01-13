/*
 *  Module: uploader
 */

//var $ 				= require('jquery');

/**
 * Initialize uploader
 */
function init() {
	
	console.log('uploader ready');

	btn = $('.unit-grid').find('a.modal-trigger');
	modal = $('.modal');
	btn.each(function(x){
		var this_but = $(this);
		var apt_id = $(this).data('unit-id');
		var apt_num = $(this).data('unit-num');
		this_but.on('click', function(e){
			e.preventDefault();			
			// open modal
			create_form(apt_id, apt_num);
			modal.show(function(){
				// add unit # to title
				$('body').find('#dc_schedule_form_' + apt_id + ' .acf-field.unit-pdf label').text('PDF for Unit #' + apt_num);
			});
		});
	});

	$('.close').on('click', function(e){
		if (modal.is(':visible')) {
			$('body').find('form[id^="dc_schedule_form"]').remove();
			modal.hide();
		}	
	});
	window.onclick = function(e) {
		if ($(e.target).hasClass('modal')) {
			$('body').find('form[id^="dc_schedule_form"]').remove();
			modal.hide();
		}
	}

};

function create_form(apt_id, apt_num) {
	var form_wrapper = $('.modal-form-wrapper');
	$.ajax({
		url : urls.ajax,
		type : 'post',
		data : {
			action : 'dc_create_upload_form',
			unit_id: apt_id,
			unit_num: apt_num
		},
		success : function( response ) {
			form_wrapper.html(response);
			console.log('apt id: ' + $('#dc_schedule_form_' + apt_id + ' .acf-field.apt-id input'));
			$('#dc_schedule_form_' + apt_id + ' .acf-field.apt-id input').val(apt_id);
			$('#dc_schedule_form_' + apt_id + ' .acf-field.apt-num input').val(apt_num);
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
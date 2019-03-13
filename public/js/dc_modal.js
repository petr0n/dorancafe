/*
 *  Module: modal
 */

var $ = require('jquery');

/**
 * Initialize modal
 */
function dc_init() {
	btn = $('body').find('#dc_image-search-box g.floor');
	modal = $('.dc_modal');
	btn.each(function(x){
		var this_but = $(this);
		var file_name = $(this).data('modal');
		var title = $(this).data('display-name');
		var path_to_file = '/wp-content/plugins/DoranCafe/public/partials/';
		this_but.on('click', function(e){
			e.preventDefault();	
			modal.fadeIn('fast', function(){
				// console.log(title);
				modal.find('h3').text(title);
				$('.dc_modal-form-wrapper').load( path_to_file + file_name + '.php');
			});
		});
	});
	dc_close_modal();
}


function dc_close_modal() {
	$('#dc_upload_modal .dc_modal_close').on('click', function(e){
		if (modal.is(':visible')) {
			modal.fadeOut('fast', function() {
				$('.dc_modal-form-wrapper').empty();
			});
		}	
	});
	window.onclick = function(e) {
		if ($(e.target).hasClass('dc_modal')) {
			modal.fadeOut('fast', function() {
				$('.dc_modal-form-wrapper').empty();
			});
		}
	}
}



/**
 * Public API
 * @type {Object}
 */
module.exports = {
	dc_init: dc_init
};
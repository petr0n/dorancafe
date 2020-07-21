/*
 *  Module: modal
 */

var $ = require('jquery');

/**
 * Initialize modal
 */
function dc_init() {
	const btn = $('body').find('#dc_image-search-box g.floor');
	modal = $('.dc_modal');
	isFloorplan();
	btn.each(function(x){
		const this_but = $(this);
		const file_name = $(this).data('modal');
		const title = $(this).data('display-name');
		const path_to_file = '/wp-content/plugins/DoranCafe/public/partials/';
		this_but.on('click', function(e){
			e.preventDefault();	
			modal.fadeIn('fast', function(){
				modal.find('h3').text(title);
				$('.dc_modal-form-wrapper').load( path_to_file + file_name + '.php');
				saveLocation(file_name, title);
			});
		});
	});
	dc_close_modal();
}


function dc_close_modal() {
	$('#dc_upload_modal .dc_modal_close').on('click', function(e){
		if (modal.is(':visible')) {
			modal.fadeOut('fast', function() {
				localStorage.removeItem('dc_floor');
				$('.dc_modal-form-wrapper').empty();
			});
		}	
	});
	window.onclick = function(e) {
		if ($(e.target).hasClass('dc_modal')) {
			modal.fadeOut('fast', function() {
				localStorage.removeItem('dc_floor');
				$('.dc_modal-form-wrapper').empty();
			});
		}
	}
}


function isFloorplan() {
	if (localStorage.getItem('dc_floor')) {
		const path_to_file = '/wp-content/plugins/DoranCafe/public/partials/';
		const url = path_to_file + localStorage.getItem('dc_floor') + '.php';
		// console.log('url', url);
		modal.fadeIn('fast', function(){
			modal.find('h3').text(localStorage.getItem('dc_modal_title'));
			$('.dc_modal-form-wrapper').load(url);
		});

	}
}

function saveLocation(dc_floor, dc_title){
	if (typeof(Storage) !== "undefined") {
		localStorage.setItem('dc_floor', dc_floor);
		localStorage.setItem('dc_modal_title', dc_title);
	} else {
		console.log('local storage not available')
	}
}


/**
 * Public API
 * @type {Object}
 */
module.exports = {
	dc_init: dc_init
};
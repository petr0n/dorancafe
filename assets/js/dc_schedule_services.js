/*
 *  Module: api_services
 */

var $ 				= require('jquery');
var $schedule_form 	= $('#schedule_form');

/**
 * Initialize api_services
 */
function init() {
	
	console.log('schedule_services ready');

	btn = $schedule_form.find('button');
	btn.on('click', function(e){
		e.preventDefault();
		
		$.ajax({
			url : urls.ajax,
			type : 'post',
			data : {
				action : 'dc_delete_schedule_job'
			},
			success : function( response ) {
				$schedule_form.append(response);
			},
			error : function( data, status ) {
				console.log('data.responseText: ' & data.responseText);
				console.log('status: ' & status);
				$schedule_form.append(data.responseText);
			}
		});
	})

};

/**
 * Public API
 * @type {Object}
 */
module.exports = {
	init: init
};
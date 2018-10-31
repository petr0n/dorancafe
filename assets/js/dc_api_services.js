/*
 *  Module: api_services
 */

var $ 			= require('jquery');
var $the_form 	= $('#api_floorplan_get');

/**
 * Initialize api_services
 */
function init() {
	
	console.log('api_services ready');

	btn = $the_form.find('button');
	btn.on('click', function(e){
		e.preventDefault();
		var api_url = $the_form.find('input').val();
		if ( api_url == '' ) {
			api_services_error( $the_form, 'URL required');
		} else {

			console.log('value ' + $the_form.find('input').val() );
			var note = $('#notifications');
			note.empty();

			$.ajax({
				url : urls.ajax,
				type : 'post',
				data : {
					action : 'dc_get_floorplans',
					api_url_floorplan: api_url_floorplan,
					api_url_aptavail: api_url_floorplan
				},
				success : function( response ) {
					note.css('background-color', 'green').fadeIn('fast', function(){
						$(this).append(response);
					});
				},
				error : function( data, status ) {
					console.log('data.responseText: ' & data.responseText);
					console.log('status: ' & status);
					note.fadeIn('fast', function(){
						$(this).append(data.responseText);
					});
				}
			});
		}
	})

};

function api_services_error( frm, err ) {
	console.log(err);
};

function api_save_data(){

}

/**
 * Public API
 * @type {Object}
 */
module.exports = {
	init: init
};
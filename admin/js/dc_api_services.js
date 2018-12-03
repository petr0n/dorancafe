/*
 *  Module: api_services
 */

var $ 			= require('jquery');



/**
 * Initialize api_services
 */
function init() {
	
	console.log('api_services ready');

	var $the_form 	= $('#api_get_units');
	btn = $the_form.find('button');
	btn.on('click', function(e){
		e.preventDefault();
		var url_floorplan = $the_form.find('input#api_url_floorplan').val();
		var url_aptavail = $the_form.find('input#api_url_aptavail').val();
		if ( url_floorplan == '' ) {
			api_services_error( $the_form, 'Floorplan URL required');
		} else if ( url_aptavail == '' ) {
			api_services_error( $the_form, 'AptAvail URL required');
		} else {

			//console.log( 'value ' + $the_form.find('input#api_url_aptavail').val() );
			var note = $('#notifications');
			note.empty();

			$.ajax({
				url : urls.ajax,
				type : 'post',
				data : {
					action : 'dc_get_unit_data',
					api_url_floorplan: url_floorplan,
					api_url_aptavail: url_aptavail
				},
				success : function( response ) {
					note.fadeIn('slow', function(){
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
/*
 *  Module: api_services
 */
var $ 			= require('jquery');

/**
 * Initialize api_services
 */
function dc_init() {
	
	// console.log('api_services ready');

	var $the_form 	= $('#api_get_units');
	var the_table 	= $('.units-table');
	var $the_table_wrapper = $('.unit-table-wrapper');
	btn = $the_form.find('button');
	btn.on('click', function(e){
		e.preventDefault();
		var thisBtn = $(this);
		thisBtn.attr('disabled','disabled');
		$('.lds-ring-wrapper').show();
		the_table.remove();
		var url_aptavail = $the_form.find('input#api_url_aptavail').val();
		if ( url_aptavail == '' ) {
			dc_api_services_error( $the_form, 'AptAvail URL required');
		} else {

			$.ajax({
				url : urls.ajax,
				type : 'post',
				data : {
					action : 'dc_get_unit_data',
					api_url_aptavail: url_aptavail
				},
				success : function( response ) {
					// console.log('success');
					$.ajax({
						url : urls.ajax,
						type : 'get',
						data : {
							action : 'dc_get_units_ajax'
						},
						success : function( response ) {
							thisBtn.prop('disabled', false); //re-enable button
							$('.lds-ring-wrapper').hide(); // hide loader 
							$the_table_wrapper.html( response );
						}
					});					
				},
				error : function( data, status ) {
					// console.log('data.responseText: ' & data.responseText);
					// console.log('status: ' & status);
				}
			});
		}
	})

};

function dc_api_services_error( frm, err ) {
	//console.log(err);
};


/**
 * Public API
 * @type {Object}
 */
module.exports = {
	dc_init: dc_init
};
/*
 *  Module: public unit search/filter 
 */ 

var $ = require('jquery');

/**
 * Initialize search form actions
 */
function dc_init() {

	search_fields = $('#dc_search_form :input');
	
	search_fields.each(function (){
		var el = $(this);

		el.on('keyup change', function(){
			var this_name = $(this).attr('name');
			var this_val = $(this).val();
			var all_vars = dc_get_url_vars();
			var url_params = '';
			var url = window.location.href;
			url = url.split('?')[0];

			if ( all_vars[this_name] ) {
				delete all_vars[this_name]; // delete it 
				all_vars[this_name] = this_val; // now re-add it
			} else {
				// console.log(this_name + ' does NOT exist');
				all_vars[this_name] = this_val;
			}
			
			Object.keys(all_vars).forEach(function(key) {
				if (key !== undefined)
					url_params += key + '=' + all_vars[key] + '&';
			});
			window.location.href = url + '?' + url_params;
		});

	});

	$('#clear_filter').on('click', function(e){
		e.preventDefault();
		var url = window.location.href;
		url = url.split('?')[0];
		window.location.href = url;
	});
}

function dc_set_form_vals(){
	var curr_vals = dc_get_url_vars();
	if ( curr_vals ) {
		Object.keys(curr_vals).forEach(function(key) {
			if (key !== undefined) {
				var form_el = $("[name='" + key + "']");
				// var el_type = '';
				// if( form_el.length && form_el[0].nodeName.toLowerCase() == 'input' ) {
				// 	el_type = form_el[0].nodeName.toLowerCase();
				// } else {
				// 	el_type = form_el.attr('type');
				// }
				// console.log('form_el.attr(type): ' + form_el.attr('type'));
				if ( form_el.attr('type') == 'checkbox' ) {
					$("input[name='" + key + "']").attr('checked','checked');
				} else {
					$("[name='" + key + "']").val(curr_vals[key]);
				}
			}
		});
	}
}

function dc_get_url_vars() {
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		vars[key] = value;
	});
	return vars;
}


/**
 * Public API
 * @type {Object}
 */
module.exports = {
	dc_init: dc_init,
	dc_set_form_vals: dc_set_form_vals
};
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
			// remove page because it will force user to first record
			delete all_vars['page'];
			// delete all_vars['display_count'];
			var url_params = '';
			var url = window.location.href;
			url = url.split('?')[0];

			if ( all_vars[this_name] ) {
				// console.log(); 
				// console.log($('#' + all_vars[this_name]).is(':checked'));
				if ( $(this).is(':checkbox') && 
					!$(this).is(':checked') ) {
					delete all_vars[this_name]; // delete it 
					all_vars[this_name] = ''; // remove for checkbox
					//console.log('checkbox fired');
				} else {
					delete all_vars[this_name]; // delete it 
					all_vars[this_name] = this_val; // now re-add it
				}
				//console.log('all_vars[this_name]: ' + all_vars[this_name]);
			} else {
				//console.log(this_name + ' does NOT exist');
				all_vars[this_name] = this_val;
			}
			
			Object.keys(all_vars).forEach(function(key) {
				if (key && all_vars[key]) {	
					// console.log('key: ' + key);
					// console.log('all_vars[key]: ' + all_vars[key]);
					url_params += key + '=' + all_vars[key] + '&';
				}
			});
			window.location.href = url + '?' + url_params + '#dc_search_form';
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
	// console.log(curr_vals);
	if ( curr_vals ) {
		Object.keys(curr_vals).forEach(function(key) {
			if (key !== undefined) {
				var form_el = $("[name='" + key + "']");
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
		var n = value.indexOf('#');
		val = value.substring(0, n != -1 ? n : value.length); // remove the hash
		// vars[key] = val != '' ? val : '';
		vars[key] = val;
	});
	return vars;
}

	


function dc_build_map() {
	// console.log('dd');
	// $dc_map = $('#dc_img-map');
	// floor6 = $dc_map.find('.floor6');

	// floor6.on('mouseover', function(){
	// 	$(this).css('border', '1px solid #000;z-index:999');
	// });
}



/**
 * Public API
 * @type {Object}
 */
module.exports = {
	dc_init: dc_init,
	dc_set_form_vals: dc_set_form_vals,
	dc_build_map: dc_build_map
};
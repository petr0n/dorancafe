/*
 *  Main entry point
 */

// require('es5-shim');

var $               	= require('jquery');
var dc_search        	= require('./dc_public_search.js');


/**
 * Initialize the app on DOM ready
 */
$(function() {
	dc_search.dc_init();
	dc_search.dc_set_form_vals();
});
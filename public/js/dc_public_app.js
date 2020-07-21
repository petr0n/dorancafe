/*
 *  Main entry point
 */

// require('es5-shim');

var $               	= require('jquery');
var dc_search        	= require('./dc_public_search.js');
// var dc_hover        	= require('./dc_hover_image.js');
var dc_modal        	= require('./dc_modal.js');


/**
 * Initialize the app on DOM ready
 */
$(function() {
	dc_search.dc_init();
	dc_search.dc_set_form_vals();
	dc_search.dc_build_map();
	// dc_hover.dc_init();
	dc_modal.dc_init();
});
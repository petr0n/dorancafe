/*
 *  Main entry point
 */

// require('es5-shim');

var $					= require('jquery');
var dc_api_services		= require('./dc_api_services.js');
var dc_uploader		 	= require('./dc_uploader.js');
var dc_tabs 		 	= require('./dc_tabs.js');
var dc_tablesorter		= require('./dc_tablesorter.js')

/**
 * Initialize the app on DOM ready
 */
$(function() {
	dc_api_services.dc_init();
	dc_uploader.dc_init();
	dc_tabs.dc_init();
	dc_tablesorter.dc_init();
}); 
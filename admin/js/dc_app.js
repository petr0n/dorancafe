/*
 *  Main entry point
 */

require('es5-shim');

var $               	= require('jquery');
var api_services        = require('./dc_api_services.js');
var schedule_services 	= require('./dc_schedule_services.js');
var uploader		 	= require('./dc_uploader.js');
var tabs 			 	= require('./dc_tabs.js');
var tablesorter			= require('./dc_tablesorter.js')

/**
 * Initialize the app on DOM ready
 */
$(function() {
	api_services.init();
	schedule_services.init();
	uploader.init();
	tabs.init();
	tablesorter.init();
}); 
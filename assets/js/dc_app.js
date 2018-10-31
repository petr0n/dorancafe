/*
 *  Main entry point
 */

require('es5-shim');
require('consolelog');

var $               	= require('jquery');
var api_services        = require('./dc_api_services.js');
// var nav		        = require('./nav.js');

/**
 * Initialize the app on DOM ready
 */
$(function() {
	api_services.init();
	// nav.init();
});
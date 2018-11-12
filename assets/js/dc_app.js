/*
 *  Main entry point
 */

require('es5-shim');
require('consolelog');

var $               	= require('jquery');
var api_services        = require('./dc_api_services.js');
var schedule_services 	= require('./dc_schedule_services.js');


/**
 * Initialize the app on DOM ready
 */
$(function() {
	api_services.init();
	schedule_services.init();
});
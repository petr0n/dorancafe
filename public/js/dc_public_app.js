/*
 *  Main entry point
 */

require('es5-shim');
require('consolelog');

var $               	= require('jquery');
var search        		= require('./dc_public_search.js');
// var schedule_services 	= require('./dc_schedule_services.js');


/**
 * Initialize the app on DOM ready
 */
$(function() {
	search.init();
	search.set_form_vals();
	// api_services.init();
	// schedule_services.init();
});
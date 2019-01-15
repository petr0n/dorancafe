/*
 *  Module: tablesorter
 */

var $ = require('jquery');
require('./vendor/jquery.tablesorter.min');
require('./vendor/jquery.tablesorter.widgets.min');

/**
 * Initialize tablesorter
 */
function dc_init() {
	
	$('.unit-grid').tablesorter({
		widgets: ['columns']
	});

};

/**
 * Public API
 * @type {Object}
 */
module.exports = {
	dc_init: dc_init
};
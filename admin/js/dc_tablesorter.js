/*
 *  Module: tablesorter
 */

//var $ 				= require('jquery');
require('./vendor/jquery.tablesorter.min');
require('./vendor/jquery.tablesorter.widgets.min');

/**
 * Initialize tablesorter
 */
function init() {
	
	console.log('tablesorter ready');

	$('.unit-grid').tablesorter({
		widgets: ['columns']
	});

};

/**
 * Public API
 * @type {Object}
 */
module.exports = {
	init: init
};
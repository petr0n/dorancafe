/*
 *  Module: dc_addEndpoint
 */

var $ = require('jquery');

/**
 * Initialize dc_addEndpoint
 */
function dc_init() {
	
	const addBtn = $('.dc_addEndpoint');
	const endPointEl = $('.EndPointEl');
	const endPointWrapperEl = $('.endPointField-wrapper');
	let newFieldCt = 1;
	
	addBtn.on('click', function(e) {
		e.preventDefault();
		newEl = endPointEl.clone();
		newEl.find("input").attr("id", "EndpointUrl" + newFieldCt).val("");
		newEl.appendTo(endPointWrapperEl);
		++newFieldCt;
		if (newFieldCt===5){
			addBtn.attr("disabled", "disabled");
		}
	});

};

/**
 * Public API
 * @type {Object}
 */
module.exports = {
	dc_init: dc_init
};
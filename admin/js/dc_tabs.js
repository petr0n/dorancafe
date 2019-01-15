/*
 *  Module: dc_tabs
 */

var $ 				= require('jquery');

/**
 * Initialize tabs
 */
function dc_init() {
	
	dc_tabs = $('.dc_tabs a');
	dc_tabs.each(function(x){
		$(this).on('click', function(e) {
			var tab = $(this);
			var panel = $(this).attr('href');
			e.preventDefault();
			$('.dc_tabs .panel').hide(100, function(){
				//console.log($('.panel.' + panel));
				dc_tabs.removeClass('active');
				$('.panel.' + panel).show(100, function(){
					tab.addClass('active');
				});
			});
		});
	});

};

/**
 * Public API
 * @type {Object}
 */
module.exports = {
	dc_init: dc_init
};
/*
 *  Module: tabs
 */

//var $ 				= require('jquery');

/**
 * Initialize tabs
 */
function init() {
	
	console.log('tabs ready');

	tabs = $('.tabs a');
	tabs.each(function(x){
		$(this).on('click', function(e) {
			tab = $(this);
			panel = $(this).attr('href');
			e.preventDefault();
			$('.dc-tabs .panel').hide(100, function(){
				//console.log($('.panel.' + panel));
				tabs.removeClass('active');
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
	init: init
};
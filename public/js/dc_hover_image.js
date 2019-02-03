/*
 *  Module: hover image
 */ 

var $ = require('jquery');

/**
 * Initialize hover map functions
 */

 function dc_init() {

	hovers = $('#aria-floor-hovers .floor');

	hovers.on({
		mouseover: function() {
			var floor = $(this);
			var myId = floor.attr('id');
			txt = floor.data('display-name');
			var floorEl = document.getElementById(myId).getBoundingClientRect();
			var imgEl = document.getElementById('dc_image-search-box').getBoundingClientRect();

			positionArr = {
				floor1: 150,
				floor2: 110,
				floor3: 87,
				floor4: 90,
				floor5: 95,
				floor6: 120,
			}
			r = floorEl.right - imgEl.right; 
			t = (floorEl.top + positionArr[myId]) - imgEl.top; 
			b = floorEl.bottom - imgEl.bottom;
			
			// console.log('floorEl.top: ' + floorEl.top);
			// console.log('imgEl.top: ' + imgEl.top);

			// console.log('r: ' + r);
			// console.log('t: ' + t);
			hoverBox = $('<div></div>');
			hoverBox.append(txt)
				.addClass('title')
				.css({ 'top' : t, 'right' : '227px' });
			hoverBox.appendTo('.dc_image-search-wrapper');

		}, 
		mouseout: function() {
			$('.dc_image-search-wrapper').find('.title').remove();
		}
	})

 }




/**
 * Public API
 * @type {Object}
 */
module.exports = {
	dc_init: dc_init
};
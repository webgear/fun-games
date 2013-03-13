(function($) {
	'use strict';
	
	var Game = Game || { };
	
	Game.animationSpeed = 'fast';
	
	Game.initBoard = function() {
		$.each($('table.guess.game tbody tr td'), function(idx, elm) {
			var _celm = $(this).find('div.mask');
			
			if(_celm.length == 0) {
				// Create mask
				$('<div class="mask"><a href="#">&nbsp;</a></div>').appendTo($(this))
					.css({ width:0, height:$(this).height() + 'px'})
					.animate({
						width:$(elm).width() + 'px'
					}, 'slow');
			} else {
				// Just display the mask, it's already created & bound
				_celm.animate({
						width:0
					}, Game.animationSpeed).animate({
						width:$(elm).width() + 'px'
					}, Game.animationSpeed);
			}
			
			// Display number when clicking on mask
			($(elm).find('div.mask a')).unbind('click')
				.bind('click', function(evt) {
					evt.preventDefault();
					
					var _maskParent = $(this).parent();
					
					if(!_maskParent.hasClass('open')) {
						var _oMasks = _maskParent.parent().parent().parent().find('div.mask.open');
						
						// Open current mask
						_maskParent.addClass('open')
							.animate({ width:0}, Game.animationSpeed, function() {
								// If there are open masks, compare them and if not identical, close them
								if(_oMasks.length == 2) {
									if(_oMasks.first().parent().children().first().html() != _oMasks.last().parent().children().first().html()) {
										$.each(_oMasks, function(midx, melm) {
											$(melm).removeClass('open')
												.animate({ width:$(elm).width() + 'px'}, Game.animationSpeed);
										});
									} else {
										$.each(_oMasks, function(midx, melm) {
											$(melm).removeClass('open');
											$(melm).parent().addClass('guessed');
										});
									}
								} else if(_oMasks.length == 1) {
									// Compare the current mask with the previously uncovered one
									if(_oMasks.first().parent().children().first().html() == _maskParent.parent().children().first().html()) {
										_oMasks.first().removeClass('open');
										_oMasks.first().parent().addClass('guessed');
										
										_maskParent.removeClass('open');
										_maskParent.parent().addClass('guessed');	
									}
								}
								
								// See if there are any more unguessed numbers
								if($(elm).parent().parent().parent().find('.guessed').length == $(elm).parent().parent().parent().find('div.mask').length) {
									if(confirm('Congratulations! You uncovered all numbers!\n\nPlay again?')) {
										window.location.href = window.location.href;
									}
								}
							});
					}
			});
		});
	};
	
	$(document).ready(function() {
		console.log('Initializing game board...');
		
		Game.initBoard();
	});
})(jQuery);
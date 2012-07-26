/**
 * @author Samuel Molinski
 */

(function($) {

	$.fn.inputLabel = function(labelSelector, addInputClass) {
	
		if(this.length) {
			return this.each(function() {
			if(!labelSelector) {
				//auto search parent and sibling
				if('label' == $(this).parent().get(0).nodeName) {
					//var label = this.parent().html();
				} else if($(this).siblings('label').length > 0) {
					var id = $(this).attr('id');
					window.console.log(id);
					var l = jQuery('label[for=' + id + ']').html();
					window.console.log(l);
					if(l) {
						var label = l;
					}
				} else {
					var label = $(this).siblings('label').html();
				}
			} else {
				var label = jQuery(labelSelector).html();
			}

			if(!addInputClass) {
				addInput = 'active'
			}

			//initialize
			var input = jQuery(this);
			window.console.log(input.val());
			window.console.log(label);
			if ((input.val() == '')){
				input.val(label);
			}

			$(this).focus(function() {
				if((input.val() == '') || (input.val() == label)) {
					input.val('');
					if(addInputClass) {
						input.removeClass(addInputClass);
					}
				}
			}).blur(function() {
				if(input.val() == '') {
					input.val(label);
					if(addInputClass) {
						input.addClass(addInputClass);
					}
				}
			});
			});
		}
		

	};
})(jQuery); 
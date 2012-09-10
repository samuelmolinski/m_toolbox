/**
 * @author Samuel
 */

if(!window.log) {window.log = function() {log.history = log.history || [];log.history.push(arguments);if(this.console) {console.log(Array.prototype.slice.call(arguments));}};}

(function(window, $, undefined){
	$.fn.d = function() {
		if(this.length) {
			$('head').append('<style>.d_expand {height:1em;} .m_expandButton{display:inline-block;width: 1em; height:1em; cursor:pointer; background:url(http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/images/ui-icons_222222_256x240.png) NO-REPEAT -36px -128px;} .m_expandButton.open{background-position: -64px -128px;} .m_expandWin{display:none;}</style>');
				
			return this.each(function() {
				log('this', this);
				var subDump = $(this).html();
				//var temp = subdump;
				var modDump = '';
				var struct = {'parentheses':[],'orderP': []};
				//get opening '(' and closing ')'
				var nestingOffset = 0;
				var count = struct.parentheses.length;
				var regexp = /\(|\)/g;
				
				while ((match = regexp.exec(subDump)) != null) {
					struct.orderP.push([match.index, match[0]]);
				}
				
				//after fighting with various algorithms this seems pointless :(
				/*while ((match = regexp.exec(subDump)) != null) {					
					log('match.index: ', match.index);
					if (match[0] == '(') {
						log('count',count);
						struct.parentheses[count] = [-1, -1];
						struct.parentheses[count][0] = match.index;
					} else if(match[0] == ')') {
						nestingOffset++;
						log('count',count);
						log('nestingOffset',nestingOffset);
						log('count - nestingOffset',count - nestingOffset);
						struct.parentheses[count - nestingOffset][1] = match.index;
					}
					count = struct.parentheses.length;
				}*/
				//log('struct.parentheses: ', struct.parentheses);
				
				//ok time to reconstruct this monster with some css and html
				//init modDump
				log('struct.orderP', struct.orderP)
				if (struct.orderP.length) {
					modDump = subDump.substr(0, struct.orderP[0][0]);
					for (var i=0; i < struct.orderP.length; i++) {
						if (struct.orderP[i][1] == '(') {
							modDump += '<span class="d_expand"><span class="m_expandButton"></span><span class="m_expandWin">' + subDump.substring(struct.orderP[i][0], struct.orderP[i+1][0]);
						} else if(struct.orderP[i][1] == ')') {
							if( i == struct.orderP.length-1){
								modDump += ')</span></span>' + subDump.substring(struct.orderP[i][0]+1, subDump.length-1);
							} else {
								modDump += ')</span></span>' + subDump.substring(struct.orderP[i][0]+1, struct.orderP[i+1][0]);
							}
						}
					}
				}
				//log('subDump', subDump);
				//log('modDump', modDump);
				if(modDump){
					$(this).html(modDump);
				}
			});
			// none element stuff
			// add css to the page
		}
	}
})(window, jQuery);

function nestArray(arr, arg){
	return arr[arg];
}

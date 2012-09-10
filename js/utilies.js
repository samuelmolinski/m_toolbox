/**
 * @author Samuel Molinski
 *
 *
 */

/*
 *  A simple log function so make life happy (thanks Paul Irish)
 */
if(!window.log) {window.log = function() {log.history = log.history || [];log.history.push(arguments);if(this.console) {console.log(Array.prototype.slice.call(arguments));}};}

/*
 *  Similar to the PHP explode()
 */
function explode(item, delimiter) {
	tempArray = new Array(1);
	var Count = 0;
	var tempString = new String(item);

	while(tempString.indexOf(delimiter) > 0) {
		tempArray[Count] = tempString.substr(0, tempString.indexOf(delimiter));
		tempString = tempString.substr(tempString.indexOf(delimiter) + 1, tempString.length - tempString.indexOf(delimiter) + 1);
		Count = Count + 1
	}

	tempArray[Count] = tempString;
	return tempArray;
}

function getUrlVars() {
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	for(var i = 0; i < hashes.length; i++) {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	return vars;
}

var URL = function(a) {
	return {
		// create a querystring from a params object
		serialize : function(params) {
			var key, query = [];
			for(key in params) {
				query.push(encodeURIComponent(key) + "=" + encodeURIComponent(params[key]));
			}
			return query.join('&');
		},

		// create a params object from a querystring
		unserialize : function(query) {
			var pair, params = {};
			query = query.replace(/^\?/, '').split(/&/);
			for(pair in query) {
				pair = query[pair].split('=');
				params[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
			}
			return params;
		},

		parse : function(url) {
			a.href = url;
			return {
				// native anchor properties
				hash : a.hash,
				host : a.host,
				hostname : a.hostname,
				href : url,
				pathname : a.pathname,
				port : a.port,
				protocol : a.protocol,
				search : a.search,
				// added properties
				file : a.pathname.split('/').pop(),
				params : URL.unserialize(a.search)
			};
		}
	};
}
/**
 * @author Samuel Molinski
 */

function browserDetect() {
	// Useragent RegExp
	userAgent = navigator.userAgent.toLowerCase(), rwin = /(windows) ([\w.]+)/, rmac = /(mac) ([\w.]+)/, rlinux = /(linux) ([\w.]+)/, rwebkit = /(webkit)[ \/]([\w.]+)/, rchrome = /(chrome)[ \/]([\w.]+)/, ropera = /(opera)(?:.*version)?[ \/]([\w.]+)/, rmsie = /(msie) ([\w.]+)/, rmozilla = /(mozilla)(?:.*? rv:([\w.]+))?/;
	rfirefox = /(firefox)[ \/]([\w.]+)/i, g = 'gecko', w = 'webkit', s = 'safari', o = 'opera', m = 'mobile';

	var agent = jQuery.browser;
	var agent = new Object;
	var browser = browser2 = version = classes = '';
	is = function(t) {
		return userAgent.indexOf(t) > -1
	}
	if( match = rfirefox.exec(userAgent)) {
		agent.browser = 'ff';
		agent.version = match[2];
		version = cleanVersion(match[2]);
		classes += match[1] + ' ' + match[1] + '-' + version;
	}
	if( match = rchrome.exec(userAgent)) {
		agent.browser = match[1];
		agent.version = match[2];
		version = cleanVersion(String(match[2]));
		classes += match[1] + ' ' + match[1] + '-' + version;
	}

	//Simple Checks
	moreclasses = [(!(/opera|webtv/i.test(userAgent)) && /msie\s(\d)/.test(userAgent)) ? ('ie ie' + RegExp.$1) : is('gecko/') ? g : is('opera') ? o + (/version\/(\d+)/.test(userAgent) ? ' ' + o + RegExp.$1 : (/opera(\s|\/)(\d+)/.test(userAgent) ? ' ' + o + RegExp.$2 : '')) : is('konqueror') ? 'konqueror' : is('blackberry') ? m + ' blackberry' : is('android') ? m + ' android' : is('iron') ? w + ' iron' : is('applewebkit/') ? w + ' ' + s + (/version\/(\d+)/.test(userAgent) ? ' ' + s + RegExp.$1 : '') : is('mozilla/') ? g : '', is('j2me') ? m + ' j2me' : is('iphone') ? m + ' iphone' : is('ipod') ? m + ' ipod' : is('ipad') ? m + ' ipad' : is('mac') ? 'mac' : is('darwin') ? 'mac' : is('webtv') ? 'webtv' : is('win') ? 'win' + (is('windows nt 6.0') ? ' vista' : (is('windows nt 6.1') ? ' win7' : '')) : is('freebsd') ? 'freebsd' : (is('x11') || is('linux')) ? 'linux' : '', 'js'];

	moreclasses = moreclasses.join(' ');
	document.documentElement.className += ' ' + classes + ' ' + moreclasses;
};
/*
 *  Cleans the string to return the proper version number ready to use in css
 */
function cleanVersion(str) {
	var version = parseFloat(str);
	if(Math.floor(version) == version) {
		parseInt(version);
	} else {
		version = String(version);
		version = version.replace('.', '_', version);
	}
	return version;
}

browserDetect();


/**
 * @author Samuel
 * 
 * example for Facebook:
 * jQuery('a').click(function(){ fbs_click(jQuery(this).attr()); return false;});
 * 
 */



function fbs_click(u, p) {
	u = encodeURIComponent(u);
	t = encodeURIComponent(document.title);
	if (p==null) {	p='';}
	window.open('http://www.facebook.com/sharer.php?u=' + u + '&t=' + t + p, 'Facebook Sharer', 'toolbar=0,status=0,width=650,height=460');
	return false;
}

function twt_click(u, p) {
	u = encodeURIComponent(u);
	t = encodeURIComponent(document.title);
	if (p==null) {	p='';}
	window.open('http://twitter.com/home?status=Reading:' + t + ' ' + u + p, 'Twitter sharer', 'toolbar=0,status=0,width=650,height=460');
	return false;
}

function del_click(u, p) {
	u = encodeURIComponent(u);
	t = encodeURIComponent(document.title);
	if (p==null) {	p='';}
	window.open('http://del.icio.us/post?url=' + u + '&title=' + t + p, 'Delicious Sharer', 'toolbar=0,status=0,width=650,height=460');
	return false;
}

function dig_click(u, p) {
	u = encodeURIComponent(u);
	t = encodeURIComponent(document.title);
	if (p==null) {	p='';}
	window.open('http://digg.com/submit?phase=2&amp;amp;url=' + u + '&title=' + t + p, 'sharer', 'toolbar=0,status=0,width=650,height=460');
	return false;
}

function stu_click(u, p) {
	u = encodeURIComponent(u);
	t = encodeURIComponent(document.title);
	if (p==null) {	p='';}
	window.open('http://www.stumbleupon.com/submit?url=' + u + '&title=' + t + p, 'sharer', 'toolbar=0,status=0,width=650,height=460');
	return false;
}
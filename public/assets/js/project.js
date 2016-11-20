function showBox(id, display) {
	$('#'+id).css("display", display);
}
function downBox(id) {
	$('#'+id).css("display", "none");
}
function chattingdown() {
	$('#chat').css("display", "none");
	$('#waterspread').css("bottom", "0");
	document.getElementById('waterspread').innerHTML = '<img src="assets/img/waterspread.png" data-toggle="tooltip" title="Click Me!" onclick="chattingup();">';
	$('[data-toggle="tooltip"]').tooltip();
}
function autoLink(id) {
	var regURL = new RegExp('(^|[^"])(http|https|ftp|telnet|news|irc)://([-/.a-zA-Z0-9_~#%$?&=:200-377()]+)', 'gi');
	var regURL2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
    $(id).html($(id).html()
    				.replace(regURL, ' <a class="autoLink" href="://" target="_blank">$2://$3</a>')
    				.replace(regURL2, ' <a class="autoLink" href="http://" target="_blank">$2</a>')
    );
}
function chattingup() {
	$('#chat').css("display", "block");
	$('#waterspread').css("bottom", "380px");
	document.getElementById('waterspread').innerHTML = '<img src="assets/img/waterspread.png" data-toggle="tooltip" title="Click Me!" onclick="chattingdown();">';
    $('[data-toggle="tooltip"]').tooltip();
}
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
function checkMessage() {
	var textAutoLink = $('.message');
	for(var i = 0; textAutoLink.length > i; i++) {
		var tempText = textAutoLink[i];
		autoLink(tempText);
	}
}
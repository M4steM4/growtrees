function show(x) {
	$('#' + x).css("display", "block");
}
function closeflex() {
	$('#calender').css("display", "none");
}
function closetel() {
	$('#office').css("display", "none");
}
function showflex(x) {
	$('#' + x).css("display", "flex");
}
function rollon() {
	$('#roll').css("display", "flex");
}
function rollout() {
	$('#roll').css("display", "none");
}
function todoliston() {
	$('#todolist').css("display", "flex");
}
function todolistout() {
	$('#todolist').css("display", "none");
}
function chattingdown() {
	$('#chat').css("display", "none");
	$('#waterspread').css("bottom", "0");
	document.getElementById('waterspread').innerHTML = '<img src="assets/img/waterspread.png" data-toggle="tooltip" title="Click Me!" onclick="chattingup();">';
	$('[data-toggle="tooltip"]').tooltip();
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
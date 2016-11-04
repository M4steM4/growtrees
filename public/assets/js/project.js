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
	document.getElementById('waterspread').innerHTML = '<img src="assets/img/waterspread.png" width="100" height="60"  onclick="chattingup();">';
}
function chattingup() {
	$('#chat').css("display", "block");
	$('#waterspread').css("bottom", "380px");
	document.getElementById('waterspread').innerHTML = '<img src="assets/img/waterspread.png" width="100" height="60"  onclick="chattingdown();">';
}

/* youben code */
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
	document.getElementById('waterspread').innerHTML = '<img src="/images/waterspread.png" width="100" height="60"  onclick="chattingup();">';
}
function chattingup() {
	$('#chat').css("display", "block");
	$('#waterspread').css("bottom", "380px");
	document.getElementById('waterspread').innerHTML = '<img src="/images/waterspread.png" width="100" height="60"  onclick="chattingdown();">';
}

/* JunYoung */

var msgCnt = 0;

var entityMap = {
	"&": "&amp;",
	"<": "&lt;",
	">": "&gt;",
	'"': '&quot;',
	"'": '&#39;',
	"/": '&#x2F;'
};

function escapeHtml(string) {
	return String(string).replace(/[&<>"'\/]/g, function (s) {
		return entityMap[s];
	});
}

function getNew (response) {
	for(var i=msgCnt; i<response.length; i++) {
		$('#message_wrapper').append('<div><div class="name green">' 
				+ escapeHtml(response[i].name) + '</div> <div class="message">' 
				+ escapeHtml(response[i].message) + '</div></div>');
	}

	if(msgCnt < response.length) {
		$('#message_wrapper').animate({
			scrollTop: $('#message_wrapper').get(0).scrollHeight
		});
	
		msgCnt = response.length;
	}
}

function noNew (response) {
	console.log(response);
}

function getNewList () {
	var formData = new FormData();
	
	formData.append('key_p', $('meta[name="key_p"]').attr('content'));

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/chat_list',
        contentType: false,
        processData: false,
        data: formData,
        success: getNew,
		error: noNew,
	});
}

$(document).ready(function () {
	setInterval(getNewList, 300);
});

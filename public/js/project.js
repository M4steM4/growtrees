function uncheckedHover(element) {
    element.setAttribute('src', '/images/check_c.png');
}
function uncheckedUnhover(element) {
    element.setAttribute('src', '/images/check_u.png');
}
function xHover(element) {
    element.setAttribute('src', '/images/x_l.png');
}
function xUnhover(element) {
    element.setAttribute('src', '/images/x_f.png');
}
function checkedHover(element) {
    element.setAttribute('src', '/images/v_l.png');
}
function checkedUnhover(element) {
    element.setAttribute('src', '/images/v_f.png');
}
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
	document.getElementById('waterspread').innerHTML = '<img src="/images/waterspread.png" data-toggle="tooltip" title="Click Me!" width="100" height="60"  onclick="chattingup();">';
	$('[data-toggle="tooltip"]').tooltip();
}
function chattingup() {
	$('#chat').css("display", "block");
	$('#waterspread').css("bottom", "380px");
	document.getElementById('waterspread').innerHTML = '<img src="/images/waterspread.png" width="100" height="60" data-toggle="tooltip" title="Click Me!" onclick="chattingdown();">';
	$('[data-toggle="tooltip"]').tooltip();
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

function autoLink(id) {
        var regURL = new RegExp('(^|[^"])(http|https|ftp|telnet|news|irc)://([-/.a-zA-Z0-9_~#%$?&=:200-377()]+)', 'gi');
        var regURL2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;

        $(id).html(
                $(id).html().replace(regURL, ' <a class="autoLink" href="://" target="_blank">$2://$3</a>')
                        .replace(regURL2, ' <a class="autoLink" href="http://" target="_blank">$2</a>')
        );

	
	return id;
}

function getNew (response) {
	for(var i=msgCnt; i<response.length; i++) {
		var msg = '<div>' +
				'<div class="name green">' + escapeHtml(response[i].name) + '</div>' + 
				'<div class="message">' + escapeHtml(response[i].message) + '</div>' +
			  '</div>';

		$('#message_wrapper').append(msg);
		autoLink($('#message_wrapper > div:last-child .message'));
	}

	if(msgCnt < response.length) {
		$('#message_wrapper').animate({
			scrollTop: $('#message_wrapper').get(0).scrollHeight
		});
	
		msgCnt = response.length;
	}
}

function noNew (response) {
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

function hideSideMenu() {
	$('.sidemenu').hide();
}

$(document).ready(function () {
	setInterval(getNewList, 300);
	$('[data-toggle="tooltip"]').tooltip();
	
	$(document).on('mouseenter', '#todolist .green-box img, .normal-15 img:first-child', function () {
		checkedHover(this);
	});
	$(document).on('mouseleave', '#todolist .green-box img, .normal-15 img:first-child', function () {
		checkedUnhover(this);	
	});
	$(document).on('mouseenter', '#todolist .white-box img', function () {
		uncheckedHover(this);
	});
	$(document).on('mouseleave', '#todolist .white-box img', function () {
		uncheckedUnhover(this);
	});
	$(document).on('mouseenter', '.normal-15 img:last-child', function () {
                xHover(this);
        });
        $(document).on('mouseleave', '.normal-15 img:last-child', function () {
                xUnhover(this);
        });
});

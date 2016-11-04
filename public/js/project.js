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

var msgCnt = 0;

function getNew (response) {
	for(var i=msgCnt; i<response.length; i++) {
		$('#message_wrapper').append('<div><div class="name green">' 
			+ response[i].name + '</div> <div class="message">' 
			+ response[i].message + '</div></div>');
	}

	$('#message_wrapper').animate({
		scrollTop: $('#message_wrapper').get(0).scrollHeight
	});
	
	msgCnt = response.length;
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

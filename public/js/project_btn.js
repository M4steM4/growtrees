function sendSuccess (response, status, msg) {
	$('#chat input[name="message"]').val('');
}

function sendFailed (response, status, errorCode) {
}

function onSendBtnClicked() {
	var formData = new FormData();

	formData.append('key_p', $('meta[name="key_p"]').attr('content'));
	formData.append('key_u', $('meta[name="key_u"]').attr('content'));
	formData.append('message', $('#chat input[name="message"]').val());

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/chattings',
        contentType: false,
        processData: false,
        data: formData,
        success: sendSuccess,
        error: sendFailed
    });
}

$(document).ready(function () {
	$('#chat button').click(onSendBtnClicked);
	$('#chat input[name="message"]').keypress(function(e) {
		if (e.which == 13) {/* 13 == enter key@ascii */
			onSendBtnClicked();
			e.preventDefault();
		}
	});
});

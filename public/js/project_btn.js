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

function updateSuccess(response, status, msg) {
	var roll = JSON.parse(msg.responseText);

	if(roll.text == '') {
		$('.rolldata[data-idx="' + roll.idx + '"]').remove();
		$('#user_roll > li:nth-child(' + (parseInt(roll.idx)+1) + ')').remove();
	} else {
		$('#user_roll > li:nth-child(' + (parseInt(roll.idx)+1) + ')').html(roll.text);
	}
}
function updateFailed(response, status, errorCode) {
	alert(response.responseText);
}

function updateRoll(idx, roll) {
	var formData = new FormData();

	formData.append('key_p', $('meta[name="key_p"]').attr('content'));
        formData.append('key_u', $('meta[name="key_u"]').attr('content'));
        formData.append('roll', roll);
	formData.append('idx', idx);

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/update_roll',
        contentType: false,
        processData: false,
        data: formData,
        success: updateSuccess,
        error: updateFailed
    });
}

function addRollSuccess(response, status, msg) {
	var idx = parseInt($('.rolldata:last-child').data('idx')) + 1;

	var li = '<li class="rolldata" data-idx="' + idx + '">';
		li += response;
	li += '</li>';
	$('#divisiontable > ul').append(li);

	li = '<li class="rollprofilelist">';
		li += response;
	li += '</li>';
	$('#user_roll').append(li);

	$('input[name="roll"]').val('');
}
function addRollFailed(response, status, errorCode) {
	alert(JSON.parse(response.responseText));
}

function addRoll() {
	var roll = $('input[name="roll"]').val().trim();
	if(roll == '') { return; }

	var formData = new FormData();

        formData.append('key_p', $('meta[name="key_p"]').attr('content'));
        formData.append('key_u', $('meta[name="key_u"]').attr('content'));
        formData.append('roll', roll);
        
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }   
    }); 
    
    $.ajax({
        type: 'POST',
        url: '/rolls',
        contentType: false,
        processData: false,
        data: formData,
        success: addRollSuccess,
        error: addRollFailed
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
	$('input[name="roll"]').keypress(function(e) {
		if (e.which == 13) {
			addRoll();
			e.preventDefault();
		}
	});

	$(document).on('click', '.rolldata', function () {
		$(this).attr('contentEditable', true);
		$(this).focus();

	}).on('blur', '.rolldata', function () {
		var roll = $(this);
                updateRoll(roll.data('idx'), roll.html());
		
		$(this).attr('contentEditable', false);
        });

	$(document).on('keypress', '.rolldata', function(e) {
                if (e.which == 13) {
			var roll = $(this);
			updateRoll(roll.data('idx'), roll.html());
                     
                        e.preventDefault();
                }
        });

});

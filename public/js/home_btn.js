function onProfileEditBtnClicked () {
	$('#profile').modal('hide');
	setTimeout(function () {
		$('#profile_update').modal('show');
	}, 500);
}

function clearUpdateNotice () {
	var names = ['nickname', 'phone', 'email', 'password', 'profile_image'];
        for(var i=0; i<names.length; i++) {
                var $notice = $('#profile_update .notice[for="' + names[i] + '"]');
                $notice.parent().removeClass('has-error');
                $notice.html('');
        }
}

function updateSuccess (response, status, msg) {
	var nickname = response.nickname;
	var phone = response.phone;
	var email = response.email;

	$('#profile div[name="nickname"]').html('닉네임 : ' + nickname);	
	$('#profile div[name="phone"]').html('휴대전화[연락처] : ' + phone);
	$('#profile div[name="email"]').html('이메일 : ' + email);

	nickname = '기존 닉네임 : ' + nickname;
	phone = '기존 연락처 : ' + phone;
	email = '기존 이메일 : ' + email;

	inputPlaceHolders['nickname'] = nickname;
	inputPlaceHolders['phone'] = phone;
	inputPlaceHolders['email'] = email;

	$('#profile_update input[name="nickname"]').val(nickname);
	$('#profile_update input[name="phone"]').val(phone);
	$('#profile_update input[name="email"]').val(email);
	$('#profile_update input[name="password"]').val('비밀번호 입력');
	$('#profile_update input[name="password"]').attr('type', 'text');

	$('#profile_update').modal('hide');
        setTimeout(function () {
                $('#profile').modal('show');
        }, 500);
}
function updateFailed (response, status, errorCode) {
	var errors = JSON.parse(response.responseText);
        var names = Object.keys(errors);

        for(var i=0; i<names.length; i++) {
                var $notice = $('#profile_update .notice[for="' + names[i] + '"]');
		if(names[i] != 'profile_image') {
			$notice.parent().addClass('has-error');
		}
                $notice.html('* ' + errors[names[i]][0]);
        }
}

function updateProfile () {
	var formData = new FormData();

	formData.append('nickname', $('#profile_update input[name="nickname"]').val());
	formData.append('email', $('#profile_update input[name="email"]').val());
	formData.append('phone', $('#profile_update input[name="phone"]').val());
	formData.append('password', $('#profile_update input[name="password"]').val());
	formData.append('profile_image', $("#profile_update input[name='profile_image']").prop('files')[0]);
	formData.append("x1", $("#profile_update input[name='x1']").val());
        formData.append("y1", $("#profile_update input[name='y1']").val());
        formData.append("size", $("#profile_update input[name='size']").val());
	formData.append('_method', 'PATCH');

	$.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
        });

        $.ajax({
                type: 'POST',
                url: 'update_profile',
                contentType: false,
                processData: false,
                data: formData,
                success: updateSuccess,
                error: updateFailed
        });
}
function onProfileEditFinished () {
	clearUpdateNotice();
	updateProfile();
}

$(document).ready(function () {
	$('#profile .modal-body button').click(onProfileEditBtnClicked);
	$('#profile_update .modal-header button').click(function () {
		$('#profile_update').modal('hide');
		setTimeout(function () {
			$('#profile').modal('show');
		}, 500);
	});
	$('#profile_update .modal-body button').click(onProfileEditFinished);
});

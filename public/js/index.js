function clearRegisterNotice() {
	var names = ['name', 'phone', 'email', 'user_id', 'password'];
	for(var i=0; i<names.length; i++) {
		var $notice = $('#register .notice[for="' + names[i] + '"]');
		$notice.parent().removeClass('has-error');
		$notice.html('');
	}
}

function registerSuccess() {
	alert('회원가입이 완료되었습니다.');
	location.href = 'logout';
}

function registerFailed(request, status, errorCode) {
	var errors = JSON.parse(request.responseText);
	var names = Object.keys(errors);

	for(var i=0; i<names.length; i++) {
		var $notice = $('#register .notice[for="' + names[i] + '"]');
		$notice.parent().addClass('has-error');
		$notice.html('* ' + errors[names[i]]);
	}
}

function requestRegister() {
	var values = {};

	clearRegisterNotice();

	values.name = $("#register input[name='name']").val();
        values.email = $("#register input[name='email']").val();
        values.phone = $("#register input[name='phone']").val();
        values.user_id = $("#register input[name='user_id']").val();
        values.password = $("#regiter input[name='password']").val();
        values.password_confirmation = $("#register input[name='password_confirmation").val();
	
	$.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
        });

	$.ajax({
		type: 'POST',
		url: 'register',
		data: values,
		success: registerSuccess,
		error: registerFailed
	});
}

function requestFindPw() {

}

$(document).ready(function () {
	$('#register_btn').click(requestRegister);
	$('#find_pw_btn').click(requestFindPw);
});

var ias = null;
var inputPlaceHolders = {
        'name' : '이름',
        'nickname' : '닉네임',
        'email' : '이메일',
        'phone' : '연락처',
        'user_id' : '아이디',
        'password' : '비밀번호',
};

function onFocusInputTag () {
	if(this.callCnt === undefined) { 
		inputPlaceHolders[this.name] = this.value;
		this.callCnt = 0; 
	}
        if(this.type == 'file' || this.value.indexOf(inputPlaceHolders[this.name]) == -1) { 
		return; 
	}

        this.value = '';
        if(this.name.indexOf('password') != -1) {
                this.type = 'password';
        } else if(this.name.indexOf('date') != -1) {
		this.type = 'date';
	}
}

function onFocusOutInputTag () {
        if(this.type == 'file' || this.value) { return; }

        if(this.name.indexOf('password') != -1 || this.name.indexOf('date') != -1) {
                this.type = 'text';
        }
        this.value = inputPlaceHolders[this.name];
}

function onMouseEnterPreview () {
	$('#tooltip').animate({
		top: '110px'
	}, 300);
}
function onMouseLeavePreview () {
	$('#tooltip').animate({
		top: '150px'
	}, 300);
}

function onImageChanged (input) {
        if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                        $('#preview').attr('src', e.target.result);
                        $('#selected_image').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
        }

        $('#profile_update').modal('hide');
        $('#image_edit').modal('show');
}

function preview(img, selection) {
    if (!selection.width || !selection.height)
        return;

    var scaleX = 150 / selection.width;
    var scaleY = 150 / selection.height;

    $('#preview').css({
        width: Math.round(scaleX * 250),
        height: Math.round(scaleY * 250),
        marginLeft: -Math.round(scaleX * selection.x1),
        marginTop: -Math.round(scaleY * selection.y1),
    });

    $('#profile_update input[name="x1"]').val(selection.x1);
    $('#profile_update input[name="y1"]').val(selection.y1);
    $('#profile_update input[name="size"]').val(selection.width);
}
function onEditFinished () {
        $('#image_edit').modal('hide');
        ias.cancelSelection();

        setTimeout(function () {
                $('#profile_update').modal('show');
        }, 500);
}


$(document).ready(function () {
	$('input, textarea').focus(onFocusInputTag);
        $('input, textarea').focusout(onFocusOutInputTag);
	$('#preview_wrapper').mouseenter(onMouseEnterPreview);
	$('#preview_wrapper').mouseleave(onMouseLeavePreview);
	$('#tooltip').click(function () { $('input[name="profile_image"]').click(); });
	$('input[name="profile_image"]').change(function () {
		onImageChanged(this);
	});

	ias = $('#selected_image').imgAreaSelect({
                aspectRatio: '1:1',
                handles: true,
                fadeSpeed: 200,
                onSelectChange: preview,
                instance: true,
        });
	$('#image_edit .modal-body button').click(onEditFinished);
});	

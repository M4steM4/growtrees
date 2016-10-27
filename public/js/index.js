var ias = null;

function heightResize () {
	var mainPage = document.getElementById('main');
	mainPage.style.height = window.innerHeight + 'px';
	mainPage.style.width = window.innerWidth + 15 +'px';
	mainPage.style.padding = "0 0 0 10px";
	//mainPage.style.margin = "0 -5px 0 -5px";
}
function onFocusLoginId () {
	if(this.callCnt > 0) { return; }
	else if(this.callCnt == undefined) { this.callCnt = 0; }

	$(this).val('');
	this.callCnt++;
}
function onFocusLoginPw () {
	if(this.callCnt > 0) { return; }
	else if(this.callCnt == undefined) { this.callCnt = 0; }

	$(this).val('');
	$(this).attr('type', 'password');
	this.callCnt++;
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

	$('#register').modal('hide');
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
        left: -Math.round(scaleX * selection.x1),
        top: -Math.round(scaleY * selection.y1),
    });

    $('#register input[name="x1"]').val(selection.x1);
    $('#register input[name="y1"]').val(selection.y1);
    $('#register input[name="size"]').val(selection.width);
}

function onEditFinished () {
	$('#image_edit').modal('hide');
	ias.cancelSelection();

	setTimeout(function () {
		$('#register').modal('show');
	}, 500);
}

$(document).ready(function () {
	heightResize();
	window.addEventListener('resize', heightResize);

	/* login form focus */
	var $loginIdForm = $('#login_form input[name="user_id"]');
	var $loginPwForm = $('#login_form input[name="password"]');
	
	$loginIdForm.focus(onFocusLoginId);

	$loginPwForm.attr('type', 'text');
	$loginPwForm.focus(onFocusLoginPw);
	
	/* profile image */
	var $inputFile = $('input[name="profile_image"]');
	$inputFile.change(function () {
		onImageChanged(this)
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

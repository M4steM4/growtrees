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

	console.log(this.callCnt);
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

$(document).ready(function () {
	heightResize();
	window.addEventListener('resize', heightResize);

	var $loginIdForm = $('#login_form input[name="user_id"]');
	var $loginPwForm = $('#login_form input[name="password"]');
	
	$loginIdForm.focus(onFocusLoginId);

	$loginPwForm.attr('type', 'text');
	$loginPwForm.focus(onFocusLoginPw);
});

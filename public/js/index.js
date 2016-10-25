function heightResize() {
	var mainPage = document.getElementById('main');
	mainPage.style.height = window.innerHeight + 'px';
	mainPage.style.width = window.innerWidth + 15 +'px';
	mainPage.style.padding = "0 0 0 10px";
	//mainPage.style.margin = "0 -5px 0 -5px";
}
window.onload = function() {
	heightResize();
	window.addEventListener('resize', heightResize);
}

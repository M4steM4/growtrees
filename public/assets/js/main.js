/*function heightResize() {
	var mainPage = document.getElementById('test');
	mainpage.style.padding = "";
	//mainPage.style.margin = "0 -5px 0 -5px";
}
window.onload = function() {
	heightResize();
	window.addEventListener('resize', heightResize);
}

window.onload = function() {
	window.addEventListener('onclick', onSearch);
}
function onSearch() {
	var test = document.getElementById('test');
	test.innerHTML = "<input type='text' id='dataSearch' onfocus='onFocus();'/><a href='javascript:void(0);'><div class='glyphicon glyphicon-search' onclick='offSearch()'></div></a>";
}
function offSearch() {
	var test = document.getElementById('test');
	test.innerHTML = "<a href='javascript:void(0)'' id='search'><div class='glyphicon glyphicon-search' onclick='onSearch()''></div></a>";

}
function onFocus() {
	var focus = document.getElementById('dataSearch');
	//search.innerHTML = "<input type='text' id='dataSearch' onfocus='onFocus(); onfocusout='offFocus()'/><div class='glyphicon glyphicon-search' onclick='offSearch()'></div><div id='dataList'></div>";
}
function offFocus() {
	var focus = document.getElementById('dataSearch');
	//search.innerHTML = "<input type='text' id='dataSearch' onfocus='onFocus(); onfocusout='offFocus()'/><div class='glyphicon glyphicon-search' onclick='offSearch()'></div>";
}
*/
//$('#searchlist').hide();


function search() {
	var search = document.getElementById('search');
	search.innerHTML = "<input type='text' id='dataSearch' placeholder='검색하고 싶은 팀명을 입력하세요.'/><li id='inputform' class='menu' onclick='desearch();''><a href='javascript:void(0)'><img src='assets/img/search.png' alt='' /></a></li>";
	$('#dataSearch').focus(function() {
		focus();
	});
	$('#dataSearch').focusout(function() {
		outfocus();
	});
}
function desearch() {
	var search = document.getElementById('search');
	search.innerHTML = "<li id='inputform' class='menu' onclick='search();''><a href='javascript:void(0)'><img src='assets/img/search.png' alt='' /></a></li>";
}
function focus() {
	$('#searchlist').css("display", "block");
}
function outfocus() {
	$('#searchlist').css("display", "none");
}
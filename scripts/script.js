function gotoModule(module) {
	window.location.href = "homepage.php?module=" + module;
}
function gotoSubModule(module, subModule) {
	window.location.href = "homepage.php?module=" + module + "&submenu="
			+ subModule;
}
function changMenu(id) {
	var selectedItem = $('#' + id).find(":selected").text();
	var selectedItem = $('#' + id).find(":selected").attr("value");
	alert(selectedItem);
}
function changUser(id) {
//	var selectedItem = $('#' + id).find(":selected").text();
	 var selectedItem=$('#' + id).find(":selected").attr("value");
	// alert(selectedItem);
	// $("#menuDrop").html('list menu of ' + selectedItem);
	var url = 'module/config/listmenu.php?user_id=' + encodeURIComponent(selectedItem);
//	alert(url);
	$("#menuDrop").load(url);
}

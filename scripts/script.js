function gotoModule(module) {
	window.location.href = "homepage.php?module=" + module;
}
function gotoSubModule(module, subModule) {
	window.location.href = "homepage.php?module=" + module + "&submenu="
			+ subModule;
}
function showSelected(id) {
	var selectedItem=$('#' + id).find(":selected").text();
	var selectedItem=$('#' + id).find(":selected").attr("value");
	alert(selectedItem);
}

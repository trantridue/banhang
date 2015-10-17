function gotoMenu(menu) {
	window.location.href = "homepage.php?menu=" + menu;
}
function gotoSubMenu(menu, submenu) {
	window.location.href = "homepage.php?menu=" + menu + "&submenu="
			+ submenu;
}
function changeUserMenu(id) {
	var selectedItem = $('#' + id).find(":selected").attr("value");
	var url = 'module/config/listMenuOfUser.php?user_id=' + encodeURIComponent(selectedItem);
	$("#userMenuDropDown").load(url);
}

function gotoMenu(menu) {
	window.location.href = "homepage.php?menu=" + menu;
}
function gotoSubMenu(menu, submenu) {
	window.location.href = "homepage.php?menu=" + menu + "&submenu="
			+ submenu;
}
function changeUserMenu(id) {
	var selectedItem = $('#' + id).find(":selected").attr("value");
	var listMenuOfUser = 'module/config/listMenuOfUser.php?user_id=' + encodeURIComponent(selectedItem);
	$("#userMenuTable").load(listMenuOfUser);
	var activeMenu = 'module/config/activeMenuOfUser.php?user_id=' + encodeURIComponent(selectedItem);
	$("#userMenuActive").load(activeMenu);
}

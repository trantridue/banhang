function gotoMenu(menu) {
	window.location.href = "homepage.php?menu=" + menu;
}
function gotoSubMenu(menu, submenu) {
	window.location.href = "homepage.php?menu=" + menu + "&submenu=" + submenu;
}
function changeUser(id, module, submodule) {
	if (module == 'config') {
		if (submodule == 'module_config') {
			var selectedItem = $('#' + id).find(":selected").attr("value");
			var listMenuOfUser = 'module/config/listMenuOfUser.php?user_id='
					+ encodeURIComponent(selectedItem) + "&menu=" + module;
			$("#userMenuTable").load(listMenuOfUser);
			var activeMenu = 'module/config/activeMenuOfUser.php?user_id='
					+ encodeURIComponent(selectedItem) + "&menu=" + module;
			$("#userMenuActive").load(activeMenu);
		}
	}
}
function changeMenu(id, module, submodule) {
	if (module == 'config') {
		if (submodule == 'module_config') {
			if (id == 'all_menu') {
				var selectedItem = $('#' + id).find(":selected").attr("value");
				var listSubMenuOfMenu = 'module/config/listSubMenuOfMenu.php?menu=' + encodeURIComponent(selectedItem);
				$("#menuSubMenuTable").load(listSubMenuOfMenu);
				var activeMenu = 'module/config/activeSubMenuOfMenu.php?menu=' + encodeURIComponent(selectedItem);
				$("#subMenuActive").load(activeMenu);
			} else if (id == 'menu_by_user') {
				alert('menu_by_user');
			}
		}
	}
}

function delete_datatable_module_by_user(id) {
	alert(id);
}
function delete_datatable_sub_module_by_module(id) {
	alert(id);
}

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
			var activeMenu = 'module/config/activeMenuOfUser.php?user_id='
					+ encodeURIComponent(selectedItem) + "&menu=" + module;
			var remainMenu = 'module/config/menuDropDownForUser.php?user_id='
					+ encodeURIComponent(selectedItem) + "&menu=" + module;
			$("#userMenuActive").load(activeMenu);
			$("#userMenuTable").load(listMenuOfUser);
			$("#menuDropDownForUser").load(remainMenu);

			$("#selected_user_id").val(selectedItem);

		}
	}
}
function changeMenu(id, module, submodule) {
	if (module == 'config') {
		if (submodule == 'module_config') {
			var selectedItem = $('#' + id).find(":selected").attr("value");
			if (id == 'all_menu') {
				var listSubMenuOfMenu = 'module/config/listSubMenuOfMenu.php?menu=' + encodeURIComponent(selectedItem);
				$("#menuSubMenuTable").load(listSubMenuOfMenu);
				var activeMenu = 'module/config/activeSubMenuOfMenu.php?menu=' + encodeURIComponent(selectedItem);
				$("#subMenuActive").load(activeMenu);
				$("#selected_menu_key").val(selectedItem);
			} else if (id == 'menu_by_user') {
				$("#default_menu_key").val(selectedItem);
			}
		}
	}
}
function changeSubMenu(id, module, submodule) {
	if (module == 'config') {
		if (submodule == 'module_config') {
			var selectedItem = $('#' + id).find(":selected").attr("value");
			$("#default_sub_menu_key").val(selectedItem);
		}
	}
}
function updateModuleUser(str) {
	var allFieldIsValid = validateNullFields('key_module_of_user,name_module_of_user');
	if (allFieldIsValid) {
		alert('continue');
	} else {
		alert('stop');
	}
}
function addModuleToUser(str) {
	var selectedModule = $('#' + str).find(":selected").attr("value");
	var selectedUser = $('#user_select').find(":selected").attr("value");
	var selectedActiveModule = $('#menu_by_user').find(":selected").attr("value");
	var addModuleToUserUrl = 'module/config/addModuleToUser.php?moduleKey='
			+ selectedModule + "&user_id=" + selectedUser + "&active_menu=" + selectedActiveModule;
	//if (validateNullField(str))
		$.ajax( {
			url : addModuleToUserUrl,
			success : function(data) {
				alert(data);
			}
		});
}
function delete_datatable_module_by_user(id) {

}
function delete_datatable_sub_module_by_module(id) {
	alert(id);
}
function validateNullFields(fields) {
	var validationArray = new Array();
	validationArray = fields.split(',');
	var flag = true;
	for ( var i = 0; i < validationArray.length; i++) {
		if (!validateNullField(validationArray[i])) {
			flag = false;
		}
	}
	return flag;
}
function validateNullField(field) {
	var flag = ($("#" + field).val() == "") ? false : true;
	if (!flag) {
		$("#" + field).addClass('errorField');
	} else {
		$("#" + field).removeClass('errorField');
	}
	return flag;
}
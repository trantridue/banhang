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
				var subModuleRemain = 'module/config/subModuleRemain.php?menu=' + encodeURIComponent(selectedItem);
				$("#subMenuActive").load(activeMenu);
				$("#subMenuDropDownForModule").load(subModuleRemain);
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

function addModuleToUser(str) {
	if (validateConfigModule()) {
		var arrayAll = getArrayIdDataFieldOfForm("configmodule_configForm");
		var addModuleToUserUrl = 'module/config/addModuleUser.php?' + parseFieldsToUrlStringEncode(arrayAll);
		$.ajax( {
			url : addModuleToUserUrl,
			success : function(data) {
				displayDialog('Update User Module, Sub Module', data);
				if(data==1){
					var remainMenu = 'module/config/menuDropDownForUser.php?user_id='
						+ encodeURIComponent(selectedItem) + "&menu=config";
				$("#menuDropDownForUser").load(remainMenu);
				}
			}
		});
	} else {

	}
}
function validateConfigModule() {
	var isModifModule = $("#is_modify_user_module").is(":checked");
	var isModifSubModule = $("#is_modify_module_sub_module").is(":checked");
	if (!(isModifModule || isModifSubModule)) {
		displayDialog('Gán module, sub module cho nhân viên',
				'Bạn phải chọn hoặc là sửa module của user hoặc là sửa sub module của module? ');
		return false;
	} else if (isModifModule) {
		return validateNullFields('user_select;menu_remain_for_user;menu_by_user');
	} else if (isModifSubModule) {
		return validateNullFields('all_menu;sub_menu_select;sub_menu_remain');
	} else {
		return true;
	}
}

function delete_datatable_module_by_user(id) {

}
function delete_datatable_sub_module_by_module(id) {
	alert(id);
}
function validateNullFields(fields) {
	var validationArray = new Array();
	validationArray = fields.split(';');
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
function parseFieldsToUrlStringEncode(arrayData) {
	var returnUrl = "";
	for ( var i = 0; i < arrayData[0].length; i++) {
		key = arrayData[0][i];
		type = arrayData[2][i];
		value = "";
		if (type == 'button') {
			if (arrayData[1][i].toLowerCase() == 'on'
					|| arrayData[1][i].toLowerCase() == 'women') {
				value = 1;
			} else {
				value = 0;
			}
		} else if (type == 'checkbox') {
			value = $('#' + arrayData[0][i]).is(":checked") ? 1 : 0;
		} else {
			value = arrayData[1][i];
		}
		returnUrl = returnUrl + arrayData[0][i] + "="
				+ encodeURIComponent(value) + "&";
	}
	returnUrl = returnUrl + "list_id="
			+ encodeURIComponent(arrayData[0].join(";")) + "&list_type="
			+ encodeURIComponent(arrayData[2].join(";"));

	return returnUrl;
}
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
	var selectedActiveModule = $('#menu_by_user').find(":selected").attr(
			"value");
	// var addModuleToUserUrl = 'module/config/addModuleToUser.php?moduleKey='
	// + selectedModule + "&user_id=" + selectedUser + "&active_menu=" +
	// selectedActiveModule;
	var arrayAll = getArrayIdDataFieldOfForm("configmodule_configForm");
	var addModuleToUserUrl = 'module/config/addModuleToUser.php?' + parseFieldsToUrlStringEncode(arrayAll);
	alert(addModuleToUserUrl);
	// if (validateNullField(str))
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
			+ encodeURIComponent(arrayData[0].join(";"));

	return returnUrl;
}
function getArrayIdDataFieldOfForm(formId) {
	var $inputs = $('#' + formId + ' :input');
	var alls = new Array();

	var arrayIds = new Array();
	var arrayValues = new Array();
	var arrayTypes = new Array();

	$inputs.each(function(index) {
		// ignore button
			if ($(this).attr('type') != 'button') {
				var idField = $(this).attr('id');
				arrayIds[index] = idField;
				arrayValues[index] = $('#' + idField).val();
				arrayTypes[index] = $(this).attr('type');
			}
		});
	alls[0] = arrayIds;
	alls[1] = arrayValues;
	alls[2] = arrayTypes;
	return alls;
}
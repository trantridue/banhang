function onOffbutton(fieldId, on, off) {
	if ($("#" + fieldId).val() == on) {
		$("#" + fieldId).val(off);
		$("#" + fieldId).addClass('buttonOff');
		$("#" + fieldId).removeClass('buttonOn');
	} else {
		$("#" + fieldId).val(on);
		$("#" + fieldId).addClass('buttonOn');
		$("#" + fieldId).removeClass('buttonOff');
	}
}
function onOffcheckbox(fieldId) {
	// var currentStatus = $('#' + fieldId).is(":checked");
	// alert(currentStatus);
	// $('#' + fieldId).prop('checked', currentStatus);
}
function go(obj, action) {
	alert(action);
	if (action.startsWith("Module")) {
		toggleMenuButton(obj);
		module = action.replace("Module", "");
		 alert(module);
		$("#body_data").load("module/" + module + "/main.php");
	} else {
//		eval(action + "()");
		alert(action);
	}
}
function resetCssMenuButton(btnId) {
	$("#" + btnId).css('backgroundColor', '');
}
function toggleMenuButton(obj) {
	var objId = obj.id;
	var user_module_key = $('#user_module_key').val();
	var modules = user_module_key.split(";");
	for ( var i = 0; i < modules.length; i++) {
		if (modules[i] == objId) {
			if (obj.style.backgroundColor == null
					|| obj.style.backgroundColor == '')
				obj.style.backgroundColor = 'violet';
			else {
				obj.style.backgroundColor = '';
			}
		} else {
			resetCssMenuButton(modules[i]);
		}
	}
}
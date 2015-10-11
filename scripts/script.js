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
	if (action.startsWith("Module")) {
		module = action.replace("Module", "");
		window.location.href = "homepage.php?module=" + module;
//		toggleMenuButton(obj);
//		obj.style.backgroundColor = 'violet';
	} else {
		// eval(action + "()");
		// alert(action);
	}
}
function resetCssMenuButton(btnId) {
	$("#" + btnId).css('backgroundColor', '');
}
function toggleMenuButton(obj) {
	var objId = obj.id;
	var session_user_module_key = $('#session_user_module_key').val();
	alert(session_user_module_key);
	var modules = session_user_module_key.split(";");
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
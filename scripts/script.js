var seperator = ";";
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
}
function go(obj, onclick, module) {
	if (onclick.startsWith("Module")) {
		module = onclick.replace("Module", "");
		window.location.href = "homepage.php?module=" + module;
	} else {
		var action = onclick.replace('action', '').toLowerCase();
		alert(module + action + "Form");
		var arrayAll = getArrayIdDataFieldOfForm(module + action + "Form");
		var url = "module/" + module + "/" + action + ".php?"
				+ parseFieldsToUrlStringEncode(arrayAll);
//		alert(url);
		$.ajax( {
			url : url,
			success : function(data) {
//				window.location.href = "homepage.php?module=" + module;
			alert(data);
			}
		});
	}
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
	returnUrl = returnUrl + $('#list_id').val() + "="
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
			if (!$(this).attr('id').startsWith('id_btn_')) {
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
function gotoModule(module) {
	alert(module);
}
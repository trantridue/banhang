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
function searchConfig(obj) {
	toggleButton(obj);
}
function toggleButton(obj){
	if (obj.style.backgroundColor == null || obj.style.backgroundColor == '')
		obj.style.backgroundColor = 'violet';
	else {
		obj.style.backgroundColor = '';
	}
}
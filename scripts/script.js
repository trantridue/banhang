function onOffButton(fieldId) {
	if ($("#" + fieldId).val() == "ON") {
		$("#" + fieldId).val('OFF');
		$("#" + fieldId).addClass('buttonOff');
		$("#" + fieldId).removeClass('buttonOn');
	} else {
		$("#" + fieldId).val('ON');
		$("#" + fieldId).addClass('buttonOn');
		$("#" + fieldId).removeClass('buttonOff');
	}
}
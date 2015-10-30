
function getArrayIdDataFieldOfForm(formId) {
	var $inputs = $('#' + formId + ' :input');
	var alls = new Array();

	var arrayIds = new Array();
	var arrayValues = new Array();
	var arrayTypes = new Array();

	$inputs.each(function(index) {
		// if ($(this).attr('type') != 'button') {
			var idField = $(this).attr('id');
			arrayIds[index] = idField;
			arrayValues[index] = $('#' + idField).val();
			arrayTypes[index] = $(this).attr('type');
			// }
		});
	alls[0] = arrayIds;
	alls[1] = arrayValues;
	alls[2] = arrayTypes;
	return alls;
}
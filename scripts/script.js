function gotoMenu(menu) {
	window.location.href = "homepage.php?menu=" + menu;
}
function gotoSubMenu(menu, submenu) {
	window.location.href = "homepage.php?menu=" + menu + "&submenu=" + submenu;
}
function getArrayIdDataFieldOfForm(formId) {
	var $inputs = $('#' + formId + ' :input');
	var alls = new Array();

	var arrayIds = new Array();
	var arrayValues = new Array();
	var arrayTypes = new Array();

	$inputs.each(function(index) {
		var idField = $(this).attr('id');
		arrayIds[index] = idField;
		arrayValues[index] = $('#' + idField).val();
		arrayTypes[index] = $(this).attr('type');
	});
	alls[0] = arrayIds;
	alls[1] = arrayValues;
	alls[2] = arrayTypes;
	return alls;
}
function displayDialog(title, content) {
	$("#dialog-message").prop("title", title);
	$("#dialog-message-content").html(content);
	$(function() {
		$("#dialog-message").dialog( {
			modal : true,
			buttons : {
				Ok : function() {
					$(this).dialog("close");
				}
			}
		});
	});
}
<?php
class Util {
	
	function getShortTime() {
		return date ( dateShortFormat );
	}
	function getLongTime() {
		return date ( dateLongFormat );
	}
	
	function addLongTimeInputDate($date, $nbr, $type) {
		$expression = '+' . $nbr . ' ' . $type;
		return date ( dateLongFormat, strtotime ( $expression, strtotime ( $date ) ) );
	}
	function addLongTime($nbr, $type) {
		$expression = '+' . $nbr . ' ' . $type;
		return date ( dateLongFormat, strtotime ( $expression, strtotime ( $this->getLongTime () ) ) );
	}
	
	function addShortTimeInputDate($date, $nbr, $type) {
		$expression = '+' . $nbr . ' ' . $type;
		return date ( dateShortFormat, strtotime ( $expression, strtotime ( $date ) ) );
	}
	function addShortTime($nbr, $type) {
		$expression = '+' . $nbr . ' ' . $type;
		return date ( dateShortFormat, strtotime ( $expression, strtotime ( $this->getShortTime () ) ) );
	}
	function displayInt($number) {
		return number_format ( $number, 0, '.', ' ' );
	}
	function displayFloat($number) {
		return number_format ( $number, 2, '.', ' ' );
	}
	function displayStrPadLeftInput($value, $lenght, $replace) {
		return str_pad ( $value, $lenght, $replace, STR_PAD_LEFT );
	}
	function displayStrPadLeft($value) {
		return $this->displayStrPadLeftInput ( $value, StrPadLeftLength, StrPadLeftReplace );
	}
	
	function isAdmin() {
		return $_SESSION ['session_id_of_user'] == 1 ? true : false;
	}
	function startsWith($haystack, $needle) {
		// search backwards starting from haystack length characters from the end
		return $needle === "" || strrpos ( $haystack, $needle, - strlen ( $haystack ) ) !== FALSE;
	}
	function endsWith($haystack, $needle) {
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen ( $haystack ) - strlen ( $needle )) >= 0 && strpos ( $haystack, $needle, $temp ) !== FALSE);
	}
	function generateHTMLField($field) {
		$html = "";
		if ($field->type == "button") {
			$html = $html . "<input type='" . $field->type . "' id='" . $field->id . "' value='" . $field->value . "' 
		class='" . $field->class . " " . $field->activeClass . "' onclick='" . $field->onClick . "'/>";
		} else if ($field->type == "select") {
			
			$html = $html . "<select id='" . $field->id . "' 
			onChange='" . $field->onChange . "' class='" . $field->class . "'>";
			$arrayKeys = explode ( ";", $field->keys );
			$arrayValues = explode ( ";", $field->values );
			for($i = 0; $i < count ( $arrayValues ); $i ++) {
				$selected = ($arrayKeys [$i] == $field->activeItem) ? "selected='selected'" : "";
				$html = $html . "<option  value='" . $arrayKeys [$i] . "' " . $selected . ">" . $arrayValues [$i] . "</option>";
			}
			$html = $html . "</select>";
		} else if ($field->type == "text") {
			$html = $html . "<input type='" . $field->type . "' id='" . $field->id . "' value='" . $field->value . "' 
			class='" . $field->class . "'/>";
		} else if ($field->type == "hidden") {
			$html = $html . "<input type='" . $field->type . "' id='" . $field->id . "' value='" . $field->value . "'/>";
		}
		return $html;
	}
	
	function getListModuleOfUser($userId) {
		for($i = 0; $i < count ( $_SESSION ['session_users'] ); $i ++) {
			if ($_SESSION ['session_users'] [$i]->id == $userId) {
				if (isset ( $_REQUEST ['menu'] )) {
					$_SESSION ['session_active_menu'] = $_REQUEST ['menu'];
				} else {
					$_SESSION ['session_active_menu'] = $_SESSION ['session_users'] [$i]->active_module->key;
				}
				return $_SESSION ['session_users'] [$i]->modules;
			}
		}
	}
	function getListSubMenuOfMenu($menuKey) {
		for($i = 0; $i < count ( $_SESSION ['session_modules'] ); $i ++) {
			if ($_SESSION ['session_modules'] [$i]->key == $menuKey) {
				if (isset ( $_REQUEST ['submenu'] )) {
					$_SESSION ['session_active_sub_menu'] = $_REQUEST ['submenu'];
				} else {
					$_SESSION ['session_active_sub_menu'] = $_SESSION ['session_modules'] [$i]->active_sub->key;
				}
				return $_SESSION ['session_modules'] [$i]->subModules;
			}
		}
	}
	function buildMenuButton() {
		$lstMenus = $this->getListModuleOfUser ( $_SESSION ['session_id_of_user'] );
		$lstField = array ();
		$html = "";
		for($i = 0; $i < count ( $lstMenus ); $i ++) {
			$html = $html . $this->generateHTMLField ( $this->convertModuleItemToFieldButton ( $lstMenus [$i] ) );
		}
		return $html;
	}
	function buildSubMenu() {
		$lstSubMenus = $this->getListSubMenuOfMenu ( $_SESSION ['session_active_menu'] );
		$lstField = array ();
		$html = "";
		for($i = 0; $i < count ( $lstSubMenus ); $i ++) {
			$html = $html . $this->generateHTMLField ( $this->convertSubModuleItemToField ( $lstSubMenus [$i] ) );
		}
		return $html;
	}
	function convertModuleItemToFieldButton($module) {
		$field = new Field ( );
		
		$field->type = 'button';
		$field->idPrefix = 'menu_';
		$field->class = 'perform_button';
		$field->activeClass = ($module->key == $_SESSION ['session_active_menu']) ? 'activeButtonGreen' : '';
		$field->onClick = 'gotoMenu("' . $module->key . '")';
		$field->id = $module->key;
		$field->value = $module->value;
		
		return $field;
	}
	function convertSubModuleItemToField($submodule) {
		$field = new Field ( );
		
		$field->type = 'button';
		$field->idPrefix = 'sub_menu_';
		$field->class = 'perform_button';
		$field->activeClass = ($submodule->key == $_SESSION ['session_active_sub_menu']) ? 'activeButtonViolet' : '';
		$field->onClick = 'gotoSubMenu("' . $_SESSION ['session_active_menu'] . '","' . $submodule->key . '")';
		$field->id = $submodule->key;
		$field->value = $submodule->value;
		
		return $field;
	}
	
	function buildUserSelect() {
		$users = $_SESSION ['session_users'];
		$field = $this->convertListUserToSelectBoxField ( $users );
		return $this->generateHTMLField ( $field );
	}
	function buildModuleSelect($id) {
		$modules = $_SESSION ['session_modules'];
		$field = $this->convertListModuleToSelectBoxField ( $modules, $id );
		return $this->generateHTMLField ( $field );
	}
	function buildSubModuleSelect($id) {
		$modules = $_SESSION ['session_sub_modules'];
		$field = $this->convertListModuleToSelectBoxField ( $modules, $id );
		return $this->generateHTMLField ( $field );
	}
	function convertListUserToSelectBoxField($users) {
		$field = new Field ( );
		
		$keys = "";
		$values = "";
		
		for($i = 0; $i < count ( $users ); $i ++) {
			$keys = $keys . $users [$i]->id . ";";
			$values = $values . $users [$i]->name . ";";
		}
		
		$field->type = 'select';
		$field->class = 'selectClass';
		$field->id = 'user_select';
		$field->value = 'user';
		$field->onChange = 'changeUser("' . $field->id . '","' . $_SESSION ['session_active_menu'] . '","' . $_SESSION ['session_active_sub_menu'] . '")';
		$field->keys = substr ( $keys, 0, - 1 );
		$field->values = substr ( $values, 0, - 1 );
		$field->activeItem = $_SESSION ['session_id_of_user'];
		
		return $field;
	}
	function convertListModuleToSelectBoxField($modules, $id) {
		$field = new Field ( );
		
		$keys = "";
		$values = "";
		$activeItem = "";
		
		for($i = 0; $i < count ( $modules ); $i ++) {
			$keys = $keys . $modules [$i]->key . ";";
			$values = $values . $modules [$i]->value . ";";
		}
		
		$field->type = 'select';
		$field->class = 'selectClass';
		$field->id = $id;
		$field->value = 'menu';
		$field->onChange = 'changeMenu("' . $field->id . '","' . $_SESSION ['session_active_menu'] . '","' . $_SESSION ['session_active_sub_menu'] . '")';
		$field->keys = substr ( $keys, 0, - 1 );
		$field->values = substr ( $values, 0, - 1 );
		$field->activeItem = $_SESSION ['session_active_menu'];
		
		return $field;
	}
	function convertListSubModuleToSelectBoxField($subModules) {
		$field = new Field ( );
		
		$keys = "";
		$values = "";
		$activeItem = "";
		
		for($i = 0; $i < count ( $subModules ); $i ++) {
			$keys = $keys . $subModules [$i]->key . ";";
			$values = $values . $subModules [$i]->value . ";";
		}
		
		$field->type = 'select';
		$field->class = 'selectClass';
		$field->id = 'sub_menu_select';
		$field->value = 'sub_menu';
		$field->onChange = 'changeSubMenu("' . $field->id . '","' . $_SESSION ['session_active_menu'] . '","' . $_SESSION ['session_active_sub_menu'] . '")';
		$field->keys = substr ( $keys, 0, - 1 );
		$field->values = substr ( $values, 0, - 1 );
		$field->activeItem = $_SESSION ['session_active_sub_menu'];
		
		return $field;
	}
	function buildModuleSelectByUser($userId,$id) {
		$modules = $this->getListModuleOfUser ( $userId );
		$field = $this->convertListModuleToSelectBoxField ( $modules, $id );
		return $this->generateHTMLField ( $field );
	}
	function buildSubModuleSelectByModule($moduleKey) {
		$subModules = $this->getListSubMenuOfMenu ( $moduleKey );
		$field = $this->convertListSubModuleToSelectBoxField ( $subModules );
		return $this->generateHTMLField ( $field );
	}
	function buildModuleTableByUser($userId) {
		$modules = $this->getListModuleOfUser ( $userId );
		
		$table = new Table ( );
		
		$table->id = "datatable_module_by_user";
		$table->orderColumn = 0;
		$table->orderType = "asc";
		//		$table->pageLength = 4;
		$table->headers = explode ( ";", "ID;KEY;NAME" );
		$columnNames = explode ( ";", "id;key;value" );
		$table->columnNames = $columnNames;
		$columTypes = explode ( ";", "delete;label;label" );
		$table->columTypes = $columTypes;
		
		$dataRows = array ();
		
		for($i = 0; $i < count ( $modules ); $i ++) {
			$row = array ();
			for($j = 0; $j < count ( $columnNames ); $j ++) {
				$row [$columnNames [$j]] = $modules [$i]->$columnNames [$j];
			}
			$dataRows [] = $row;
		}
		$table->dataRows = $dataRows;
		$this->generateDataTableJS ( $table );
	}
	function buildSubModuleTableByModule($moduleKey) {
		//		echo $moduleKey;
		$subModules = $this->getListSubMenuOfMenu ( $moduleKey );
		//		print_r($subModules);
		$table = new Table ( );
		
		$table->id = "datatable_sub_module_by_module";
		$table->orderColumn = 0;
		$table->orderType = "asc";
		$table->headers = explode ( ";", "ID;KEY;NAME" );
		$columnNames = explode ( ";", "id;key;value" );
		$table->columnNames = $columnNames;
		$columTypes = explode ( ";", "delete;link;label" );
		$table->columTypes = $columTypes;
		
		$dataRows = array ();
		
		for($i = 0; $i < count ( $subModules ); $i ++) {
			$row = array ();
			for($j = 0; $j < count ( $columnNames ); $j ++) {
				$row [$columnNames [$j]] = $subModules [$i]->$columnNames [$j];
			}
			$dataRows [] = $row;
		}
		$table->dataRows = $dataRows;
		$this->generateDataTableJS ( $table );
	}
	
	function generateDataTableJS($table) {
		echo $this->generateJSDatatableSimple ( $table );
		echo $this->generateDataTable ( $table );
	
	}
	function generateDataTable($table) {
		$numberColumn = count ( $table->headers );
		$numberRows = count ( $table->dataRows );
		$columnTypes = $table->columTypes;
		
		$html = "<table id=" . $table->id . " width='100%' cellspacing='0' class='display order-column'><thead style='font-weight:bold;'><tr>";
		
		for($i = 0; $i < $numberColumn; $i ++) {
			$html = $html . "<td>" . $table->headers [$i] . "</td>";
		}
		$html = $html . "</tr></thead><tbody>";
		
		for($i = 0; $i < $numberRows; $i ++) {
			$html = $html . "<tr>";
			for($j = 0; $j < $numberColumn; $j ++) {
				if ($columnTypes [$j] == 'delete') {
					$str = 'delete_' . $table->id . '("' . $table->dataRows [$i] ['id'] . '")';
					$html = $html . "<td title='Id : " . $table->dataRows [$i] [$table->columnNames [$j]] . "'>
					<div class='deleteIcon'><input type='hidden' value ='" . $str . "'></div></td>";
				} else {
					$html = $html . "<td>" . $table->dataRows [$i] [$table->columnNames [$j]] . "</td>";
				}
			}
			$html = $html . "</tr>";
		}
		
		$html = $html . "</tbody><tfoot><tr><th colspan='" . $numberColumn . "'></th></tr></tfoot></table>";
		
		return $html;
	}
	function generateJSDatatableSimple($table) {
		$itemPerPage = $table->pageLength ? $table->pageLength : default_number_item_per_page;
		$html = "<script>";
		$html = $html . "$(document).ready(function() { $('#" . $table->id . "').dataTable({
				'order': [[ " . $table->orderColumn . ", '" . $table->orderType . "' ]], 
				'pageLength': " . $itemPerPage . ", 
				'destroy': true,
				'aLengthMenu': [[5, 10, 15, 100], ['5 Per Page', '10 Per Page', '15 Per Page', '100 Per Page']],
				'bPaginate': true,
        		'sDom':'fptip'
				});});";
		$html = $html . "</script>";
		$html = $html . $this->generateJsDeleteButton ();
		return $html;
	}
	function generateJsDeleteButton() {
		return "<script>
$(document).ready(
		function() {
			$('.deleteIcon').click(
					function() {
						var elem = $(this).closest('.item');
						var elemtxt = $(this).find(
								'input[type=hidden],textarea,select').filter(
								':hidden:first').val();
						$.confirm( {
							'title' : 'Hãy xác nhận',
							'destroy' : 'true',
							'message' : 'Bạn có muốn xóa không?',
							'buttons' : {
								'Có' : {
									'class' : 'blue',
									'action' : function() {
										eval(elemtxt);
									}
								},
								'Không' : {
									'class' : 'gray',
									'action' : function() {
									}
								}
							}
						});

					});

		});
</script>";
	}
	function getModuleIdByKey($key) {
		$modules = $_SESSION ['session_modules'];
		for($i = 0; $i < count ( $modules ); $i ++) {
			if ($modules [$i]->key = $key)
				return $modules [$i]->id;
		}
	}
	function getSubModuleIdByKey($key) {
		$subModules = $_SESSION ['session_sub_modules'];
		for($i = 0; $i < count ( $subModules ); $i ++) {
			if ($subModules [$i]->key = $key)
				return $subModules [$i]->id;
		}
	}
	function generateTdBlockLabelAndField($label, $value, $idDivValue) {
		$html = "";
		if ($idDivValue == '') {
			$html = "<td class='tdLable'>" . $label . "</td><td>" . $value . "</td>";
		} else {
			$html = "<td class='tdLable'>" . $label . "</td><td><div id='" . $idDivValue . "'>" . $value . "</div></td>";
		}
		return $html;
	}
	function generateTitlePage() {
		echo "<div class='titleModule'> &nbsp;&nbsp;&nbsp;" . $_SESSION ['session_active_menu'] . "->" . $_SESSION ['session_active_sub_menu'] . "</div>";
	}
	function initSimpleTextField($id) {
		$field = new Field ( );
		$field->id = $id;
		$field->type = 'text';
		$field->class = 'textField';
		return $field;
	}
	function generateHiddenField($id, $value) {
		$field = new Field ( );
		$field->id = $id;
		$field->type = 'hidden';
		$field->value = $value;
		return $this->generateHTMLField ( $field );
	}
	function getActiveModuleSubModule() {
		return $_SESSION ['session_active_menu'] . "_" . $_SESSION ['session_active_sub_menu'];
	}
	function buildButton($id, $action, $label, $str) {
		$field = new Field ( );
		
		$field->type = 'button';
		$field->class = 'perform_button';
		$field->onClick = $action . '("' . $str . '")';
		$field->id = $id;
		$field->value = $label;
		
		return $field;
	}
}
?>
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
				$html = $html . "<option value='" . $arrayKeys [$i] . "' " . $selected . ">" . $arrayValues [$i] . "</option>";
			}
			$html = $html . "</select>";
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
		$field->id = 'user_id_select';
		$field->value = 'user';
		$field->onChange = 'changeUserMenu("' . $field->id . '")';
		$field->keys = substr ( $keys, 0, - 1 );
		$field->values = substr ( $values, 0, - 1 );
		$field->activeItem = $_SESSION ['session_id_of_user'];
		
		return $field;
	}
function convertListModuleToSelectBoxField($modules) {
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
		$field->id = 'user_menu_id_select';
		$field->value = 'user_menu';
		$field->onChange = 'changeMenu("' . $field->id . '")';
		$field->keys = substr ( $keys, 0, - 1 );
		$field->values = substr ( $values, 0, - 1 );
		$field->activeItem = $_SESSION ['session_active_menu'];
		
		return $field;
	}
	function buildModuleSelectByUser($userId) {
		$modules = $this->getListModuleOfUser ( $userId );
		
		$field = $this->convertListModuleToSelectBoxField ( $modules );
		return $this->generateHTMLField ( $field );
	}

}
?>
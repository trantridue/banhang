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
	function generateHTMLField($field, $idPrefix, $activeId, $activeClassName) {
		$activeClass = ($activeId == $field->id || $_SESSION ['session_selected_menu'] . "_" . $activeId == $field->id) ? $activeClassName : "";
		$html = "";
		if ($field->type == "button") {
			$html = $html . "<input type='" . $field->type . "' id='" . $idPrefix . $field->id . "' value='" . $field->value . "' 
		class='" . $field->class . " " . $activeClass . "' onclick='" . $field->onClick . "'/>";
		} else if ($field->type == "select") {
			$html = $html . "<select id='" . $idPrefix . $field->id . "' onChange='" . $field->onChange . "'>";
			$arrayKeys = explode ( ";", $field->defaultKey );
			$arrayValues = explode ( ";", $field->defaultValue );
			for($i = 0; $i < count ( $arrayValues ); $i ++) {
				$selected = ($arrayValues [$i] == $field->activeItem) ? "selected='selected'" : "";
				$html = $html . "<option value='" . $arrayKeys [$i] . "' " . $selected . ">" . $arrayValues [$i] . "</option>";
			}
			$html = $html . "</select>";
		}
		return $html;
	}
	
	function setSelectedMenu() {
		$_SESSION ['session_selected_menu'] = default_menu;
		if (isset ( $_REQUEST ['module'] )) {
			$_SESSION ['session_selected_menu'] = $_REQUEST ['module'];
		}
	}
	function setSelectedSubMenu() {
		$_SESSION ['session_selected_sub_menu'] = $_SESSION ['session_selected_sub_menu' . $_SESSION ['session_selected_menu']];
		if (isset ( $_REQUEST ['submenu'] )) {
			$_SESSION ['session_selected_sub_menu'] = $_REQUEST ['submenu'];
		}
	}
}
?>
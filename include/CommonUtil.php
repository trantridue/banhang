<?php
class CommonUtil {
	var $connection;
	
	function CommonUtil($connection) {
		$this->connection = $connection;
	}
	
	function getShortTime() {
		return date ( dateShortFormat );
	}
	function getLongTime() {
		return date ( dateLongFormat );
	}
	
	function getResultByQuery($qry) {
		$items = array ();
		$result = mysql_query ( $qry, $this->connection );
		while ( $rows = mysql_fetch_array ( $result ) ) {
			$items [] = $rows;
		}
		return $items;
	}
	
	function addRow($table, $colums, $values) {
		$qry = $this->buildInsertQry ( $table, $colums, $values );
		return $this->executeQuery ( $qry );
	}
	
	function addRows($table, $colums, $values) {
		$qry = $this->buildInsertQrys ( $table, $colums, $values );
		return $this->executeQuery ( $qry );
	}
	
	function buildInsertQry($table, $colums, $values) {
		$qry = "insert into " . $table . "(`";
		// list columns name
		for($i = 0; $i < count ( $colums ); $i ++) {
			$qry = $qry . $colums [$i] . "`,`";
		}
		// remove two last characters ",`"
		$qry = substr ( $qry, 0, - 2 ) . ") values ('";
		
		// list columns value
		for($i = 0; $i < count ( $values ); $i ++) {
			$qry = $qry . $values [$colums [$i]] . "','";
		}
		// remove two last characters ",'"
		$qry = substr ( $qry, 0, - 2 ) . ")";
		
		return $qry;
	}
	function buildInsertQrys($table, $colums, $values) {
		$qry = "insert into " . $table . "(`";
		// list columns name
		for($i = 0; $i < count ( $colums ); $i ++) {
			$qry = $qry . $colums [$i] . "`,`";
		}
		// remove two last characters ",`"
		$qry = substr ( $qry, 0, - 2 ) . ") values ";
		
		// list columns value
		for($i = 0; $i < count ( $values ); $i ++) {
			$qry = $qry . "('";
			for($j = 0; $j < count ( $colums ); $j ++) {
				$qry = $qry . $values [$i] [$colums [$j]] . "','";
			}
			$qry = substr ( $qry, 0, - 2 ) . "),";
		}
		// remove two last characters ",'"
		$qry = substr ( $qry, 0, - 2 ) . ")";
		
		return $qry;
	}
	
	function executeQuery($qry) {
		return mysql_query ( $qry, $this->connection );
	}
	function commitTransaction($flag) {
		if ($flag) {
			mysql_query ( "COMMIT" );
		} else {
			echo mysql_error ( $this->connection );
			mysql_query ( "ROLLBACK" );
		}
	}
	function getStringToArray($table_name) {
		return explode ( ';', $table_name );
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
	
	function getTableStructure($table) {
		$qry = "SHOW COLUMNS FROM " . $table;
		$qColumnNames = mysql_query ( $qry, $this->connection );
		$numColumns = mysql_num_rows ( $qColumnNames );
		for($i = 0; $i < $numColumns; $i ++) {
			$colname = mysql_fetch_row ( $qColumnNames );
			$col [0] [] = $colname [0];
			$col [1] [] = $colname [1];
		}
		return $col;
	}
	function getListColumnOfTable($table) {
		$tables = $this->getTableStructure ( $table );
		return $tables [0];
	}
	function initUserInformation($userId) {
		//Init Only Personal Information
		$str = "";
		$table = "user";
		$qry = "select * from " . $table . " where id = " . $userId;
		$columns = $this->getListColumnOfTable ( $table );
		$result = $this->getResultByQuery ( $qry );
		$values = $result [0];
		for($i = 0; $i < count ( $columns ); $i ++) {
			$_SESSION ['session_user_' . $columns [$i]] = $values [$i];
			$str = $str . "<input type='hidden' id='hidden_user_" . $columns [$i] . "' value='" . $values [$i] . "'/>";
		}
		return $str;
	}
	function generateHiddenFieldUserInformation($userId) {
		//Init Only Personal Information
		$str = "";
		$table = "user";
		$qry = "select * from " . $table . " where id = " . $userId;
		$columns = $this->getListColumnOfTable ( $table );
		$result = $this->getResultByQuery ( $qry );
		$values = $result [0];
		for($i = 0; $i < count ( $columns ); $i ++) {
			if ($columns [$i] != 'password')
				$str = $str . "<input type='hidden' id='" . prefix_hidden_user . $columns [$i] . "' value='" . $values [$i] . "'/>";
		}
		return $str;
	}
	function generateHiddenFieldConfig() {
		//Init Only Personal Information
		$str = "";
		$result = $this->getResultByQuery ( select_all_config );
		for($i = 0; $i < count ( $result ); $i ++) {
			$row = $result [$i];
			$str = $str . "<input type='hidden' id='" . prefix_hidden_session . $row ['key'] . "' value='" . $row ['value'] . "'/>";
		}
		return $str;
	}
	function getOneResult($qry) {
		$result = mysql_query ( $qry, $this->connection );
		$rows = mysql_fetch_assoc ( $result );
		if ($rows ['value'])
			return $rows ['value'];
		else
			return '';
	}
	function isAdmin() {
		return $_SESSION ['session_user_is_admin'] == 0 ? false : true;
	}
	function displayByUserRole() {
		if (! $this->isAdmin ())
			echo " class='displayNone' ";
	}
	function generateTdLabel($title, $label) {
		return "<td title='" . $title . "' class='tableTdLabel'>" . $label . "</td>";
	}
	function generateTdText($type, $key, $value, $onclick, $on, $off) {
		return "<td class='tableTdText'>" . $this->generateInputField ( $type, $key, $value, $onclick, $on, $off ) . table_td_closed;
	}
	function generateButtons($buttonList) {
		$html = "";
		for($i = 0; $i < count ( $buttonList ); $i ++) {
			$button = $buttonList [$i];
			$value = $button ["value"];
			$onclick = $button ["onclick"];
			$html = $html . $this->generateButton ( $value, $onclick );
		}
		return $html;
	}
	function generateInputField($type, $key, $value, $onclick, $on, $off) {
		$html = "";
		if ($type == button) {
			$isOnOff = $value == 0 ? $off : $on;
			$classOnOff = $value == 0 ? css_class_buttonOff : css_class_buttonOn;
			$html = $html . "<input type='" . $type . "' id='" . $key . "' value='" . strtoupper ( $isOnOff ) . "' onclick='" . $onclick . $type . "(\"" . $key . "\",\"" . $on . "\",\"" . $off . "\");' class='" . $classOnOff . "'/>";
		} else if ($type == number) {
			$html = $html . "<input type='" . $type . "' id='" . $key . "' value='" . $value . "' class='number50'/>";
		} else if ($type == datetime) {
			$html = $html . "<input type='text' class='datetimefield' id='" . $key . "' value='" . $value . "'/>";
		} else if ($type == date) {
			$html = $html . "<input type='text' class='datefield' id='" . $key . "' value='" . $value . "'/>";
		} else if ($type == textarea) {
			$html = $html . "<textarea id=\"" . $key . "\" value=" . $value . " onfocus=\"if (this.value == this.defaultValue) this.value = ''\" onblur=\"if (this.value == '') this.value = this.defaultValue\" rows=\"4\" cols=\"80\">" . $value . "</textarea>";
		} else if ($type == checkbox) {
			$isChecked = $value == 0 ? '' : 'checked="checked"';
			$html = $html . "<input type='" . $type . "' id='" . $key . "' " . $isChecked . " onclick='" . $onclick . $type . "(\"" . $key . "\");'/>";
		} else {
			$html = $html . "<input type='" . $type . "' id='" . $key . "' value='" . $value . "'/>";
		}
		return $html;
	}
	function getTableColspanOpen($numColumn) {
		return table_tr . "<td colspan='" . $numColumn . "'>";
	}
	function generateButtonsColspan($buttonList, $numColumn) {
		return $this->getTableColspanOpen ( $numColumn ) . $this->generateButtons ( $buttonList ) . table_td_closed . table_tr_closed;
	}
	function generateButton($value, $onclick) {
		return "<input type='button' value='" . $value . "' class='perform_button' onclick='" . $onclick . "();'>";
	}
	function prepareButtonData($strValues, $strOnclicks) {
		
		$arrayValues = explode ( ";", $strValues );
		$arrayOnclicks = explode ( ";", $strOnclicks );
		$itemCounter = count ( $arrayValues );
		$buttonList = array ();
		for($i = 0; $i < $itemCounter; $i ++) {
			$button = array ();
			$button ['value'] = $arrayValues [$i];
			$button ['onclick'] = $arrayOnclicks [$i];
			$buttonList [$i] = $button;
		}
		return $buttonList;
	}
}
?>
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
				$str = $str . "<input type='hidden' id='hidden_user_" . $columns [$i] . "' value='" . $values [$i] . "'/>";
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
}
?>
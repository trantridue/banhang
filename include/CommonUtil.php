<?php
class CommonUtil {
	var $connection;
	var $dateLongFormat = 'Y-m-d H:i:s';
	var $dateShortFormat = 'Y-m-d';
	//	var $StrPadLeftLength = 4;
	//	var $StrPadLeftReplace = '0';
	

	function CommonUtil($connection) {
		$this->connection = $connection;
	}
	
	function getShortTime() {
		return date ( $this->dateShortFormat );
	}
	function getLongTime() {
		return date ( $this->dateLongFormat );
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
		return date ( $this->dateLongFormat, strtotime ( $expression, strtotime ( $date ) ) );
	}
	function addLongTime($nbr, $type) {
		$expression = '+' . $nbr . ' ' . $type;
		return date ( $this->dateLongFormat, strtotime ( $expression, strtotime ( $this->getLongTime () ) ) );
	}
	
	function addShortTimeInputDate($date, $nbr, $type) {
		$expression = '+' . $nbr . ' ' . $type;
		return date ( $this->dateShortFormat, strtotime ( $expression, strtotime ( $date ) ) );
	}
	function addShortTime($nbr, $type) {
		$expression = '+' . $nbr . ' ' . $type;
		return date ( $this->dateShortFormat, strtotime ( $expression, strtotime ( $this->getShortTime () ) ) );
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
}
?>
<?php
class CommonUtil {
	var $connection;
	
	function CommonUtil($connection) {
		$this->connection = $connection;
	}
	
	function getCurrentDateFormat_YYYYMMDD() {
		return date ( 'Y-m-d' );
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
			$qry = $qry . $values [$i] . "','";
		}
		// remove two last characters ",'"
		$qry = substr ( $qry, 0, - 2 ) . ")";
		
		return $qry;
	}
	function buildInsertQrys($table, $colums, $values) {
	
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

}
?>
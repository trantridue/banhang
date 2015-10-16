<?php
class CommonService {
	var $connection;
	var $util;
	
	function CommonService($connection, $util) {
		$this->connection = $connection;
		$this->util = $util;
	}
	function initSession() {
		
	}
	
	function loadAllSubMenu(){
		
	}
	function loadAllMenu(){
		
	}
	function loadAllUser(){
		
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
}
?>
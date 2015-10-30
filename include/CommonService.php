<?php
class CommonService {
	var $connection;
	var $util;
	
	function CommonService($connection, $util) {
		$this->connection = $connection;
		$this->util = $util;
	}
	function initSession() {
		$this->initEntity ();
		$this->buildFullModules ();
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
	function getResultByQuery($qry) {
		$items = array ();
		$result = mysql_query ( $qry, $this->connection );
		while ( $rows = mysql_fetch_array ( $result ) ) {
			$items [] = $rows;
		}
		return $items;
	}
	function loadAllRowsFromTable($table, $objName) {
		$arrayListColumn = $this->getListColumnOfTable ( $table );
		$qry = 'select * from ' . $table;
		$arrayData = $this->getResultByQuery ( $qry );
		$objs = array ();
		for($i = 0; $i < count ( $arrayData ); $i ++) {
			$obj = new $objName ( );
			for($j = 0; $j < count ( $arrayListColumn ); $j ++) {
				$obj->$arrayListColumn [$j] = $arrayData [$i] [$arrayListColumn [$j]];
			}
			$objs [] = $obj;
		}
		return $objs;
	}
	function buildFullModules() {
		$modules = $_SESSION ['session_modules'];
		$module_sub_modules = $_SESSION ['session_module_sub_modules'];
		$sub_modules = $_SESSION ['session_sub_modules'];
		
		$modulestmp = array ();
		for($i = 0; $i < count ( $modules ); $i ++) {
			$module = $modules [$i];
			$subModuleOfModules = array ();
			for($j = 0; $j < count ( $module_sub_modules ); $j ++) {
				if ($module->id == $module_sub_modules [$j]->module_id) {
					for($k = 0; $k < count ( $sub_modules ); $k ++) {
						if ($module_sub_modules [$j]->sub_module_id == $sub_modules [$k]->id) {
							$subModuleOfModules [] = $sub_modules [$k];
						}
					}
				}
			}
			for($l = 0; $l < count ( $sub_modules ); $l ++) {
				if ($module->active_sub == $sub_modules [$l]->id) {
					$module->active_sub = $sub_modules [$l];
				}
			}
			$module->subModules = $subModuleOfModules;
			$modulestmp [] = $module;
		}
		$_SESSION ['session_modules'] = $modulestmp;
		// Then build user module
		$this->buildFullUsers ();
	}
	function buildFullUsers() {
		$users = $_SESSION ['session_users'];
		$user_modules = $_SESSION ['session_user_modules'];
		$modules = $_SESSION ['session_modules'];
		
		$userstmp = array ();
		for($i = 0; $i < count ( $users ); $i ++) {
			$user = $users [$i];
			$moduleOfUsers = array ();
			for($j = 0; $j < count ( $user_modules ); $j ++) {
				if ($user->id == $user_modules [$j]->user_id) {
					for($k = 0; $k < count ( $modules ); $k ++) {
						if ($user_modules [$j]->module_id == $modules [$k]->id) {
							$moduleOfUsers [] = $modules [$k];
						}
					}
				}
			}
			for($l = 0; $l < count ( $modules ); $l ++) {
				if ($user->active_module == $modules [$l]->id) {
					$user->active_module = $modules [$l];
				}
			}
			$user->modules = $moduleOfUsers;
			$userstmp [] = $user;
		}
		$_SESSION ['session_users'] = $userstmp;
	}
	function initEntity() {
		$_SESSION ['session_users'] = $this->loadAllRowsFromTable ( 'user', 'User' );
		$_SESSION ['session_user_modules'] = $this->loadAllRowsFromTable ( 'user_module', 'UserModule' );
		$_SESSION ['session_modules'] = $this->loadAllRowsFromTable ( 'module', 'Module' );
		$_SESSION ['session_sub_modules'] = $this->loadAllRowsFromTable ( 'sub_module', 'SubModule' );
		$_SESSION ['session_module_sub_modules'] = $this->loadAllRowsFromTable ( 'module_sub_module', 'ModuleSubModule' );
	}
	
}
?>
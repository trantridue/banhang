<?php
class CommonService {
	var $connection;
	var $util;
	
	function CommonService($connection, $util) {
		$this->connection = $connection;
		$this->util = $util;
	}
	function initUserMenu() {
		$menuButtons = $_SESSION ['session_menuButtons'];
		
		$html = "";
		$idPrefix = "menu_";
		$activeClassName = "activeButtonGreen";
		$activeId = $_SESSION ['session_selected_menu'];
		
		for($i = 0; $i < count ( $menuButtons ); $i ++) {
			$html = $html . $this->util->generateHTMLField ( $menuButtons [$i], $idPrefix, $activeId, $activeClassName );
		}
		echo $html;
	}
	function initSession($userId) {
		$this->initSessionMenu ( $userId );
	}
	
	function initSessionMenu($userId) {
		//Get list module by User ID
		$qry = "select * from module where id in (select module_id from user_module where user_id = " . $userId . ")";
		$result = $this->getResultByQuery ( $qry );
		$menuButtons = array ();
		for($i = 0; $i < count ( $result ); $i ++) {
			
			$field = new Field ( );
			
			$field->id = $result [$i] ['key'];
			$field->value = $result [$i] ['value'];
			$field->type = 'button';
			$field->class = 'menuButton';
			$field->onClick = 'gotoModule("' . $result [$i] ['key'] . '")';
			
			$menuButtons [] = $field;
		}
		$_SESSION ['session_menuButtons'] = $menuButtons;
		//get list sub Button
		$qry = "select ";
	}
	
	function getResultByQuery($qry) {
		$items = array ();
		$result = mysql_query ( $qry, $this->connection );
		while ( $rows = mysql_fetch_array ( $result ) ) {
			$items [] = $rows;
		}
		return $items;
	}
}
?>
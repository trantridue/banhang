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
			if ($_SESSION ['session_selected_menu'] == $menuButtons [$i]->id) {
				$_SESSION ['session_submenu_buttons'] = $menuButtons [$i]->subMenu;
				$_SESSION ['session_selected_sub_menu' . $_SESSION ['session_selected_menu']] = $menuButtons [$i]->activeItem;
			}
		}
		echo $html;
	}
	function initSubMenu() {
		$subMenuButtons = $_SESSION ['session_submenu_buttons'];
		$html = "";
		$idPrefix = "sub_menu_";
		$activeClassName = "activeButtonViolet";
		if (isset ( $_REQUEST ['submenu'] )) {
			$activeId = $_REQUEST ['submenu'];
		} else {
			$activeId = $_SESSION ['session_selected_sub_menu' . $_SESSION ['session_selected_menu']];
		}
		if (count ( $subMenuButtons ) == 1) {
			$activeId = default_submenu_key;
			$_SESSION ['session_selected_sub_menu' . $_SESSION ['session_selected_menu']] = default_submenu_key;
		}
		for($i = 0; $i < count ( $subMenuButtons ); $i ++) {
			$html = $html . $this->util->generateHTMLField ( $subMenuButtons [$i], $idPrefix, $activeId, $activeClassName );
		}
		echo $html;
	}
	
	function initSession($userId) {
		$this->initSessionMenu ( $userId );
		$this->initSessionAllUser ();
	}
	
	function initSessionMenu($userId) {
		//Get list module by User ID
		//		$qry = "select * from module where id in (select module_id from user_module where user_id = " . $userId . ")";
		$qry = "select t1.*, REPLACE(group_concat(t3.`key`),',',';') as subKey, REPLACE(group_concat(t3.`value`),',',';') as subValue,
				(select `key` from sub_module where id = t1.active_sub) as active_sub_menu
				from module t1
				left join module_sub_module t2 on t2.module_id = t1.id
				left join sub_module t3 on t2.sub_module_id = t3.id
				where t1.id in (select module_id from user_module where user_id =" . $userId . ")
				group by t1.`key` order by t1.id desc";
		$result = $this->getResultByQuery ( $qry );
		$menuButtons = array ();
		
		for($i = 0; $i < count ( $result ); $i ++) {
			
			$subMenuKey = ($result [$i] ['subKey'] == '') ? default_submenu_key : $result [$i] ['subKey'];
			$subMenuValue = ($result [$i] ['subValue'] == '') ? default_submenu_value : $result [$i] ['subValue'];
			
			$field = new Field ( );
			
			$field->id = $result [$i] ['key'];
			$field->value = $result [$i] ['value'];
			$field->type = 'button';
			$field->class = 'menuButton';
			$field->onClick = 'gotoModule("' . $result [$i] ['key'] . '")';
			$field->activeItem = $result [$i] ['active_sub_menu'];
			$field->subMenu = $this->buildSubMenu ( $result [$i] ['key'], $subMenuKey, $subMenuValue );
			
			$menuButtons [] = $field;
		}
		$_SESSION ['session_menuButtons'] = $menuButtons;
	}
	function buildSubMenu($menuKey, $subMenuKey, $subMenuValue) {
		$arraySubKey = explode ( ";", $subMenuKey );
		$arraySubValue = explode ( ";", $subMenuValue );
		$subMenuList = array ();
		for($i = 0; $i < count ( $arraySubKey ); $i ++) {
			$subMenu = new SubMenu ( );
			$subMenu->id = $menuKey . "_" . $arraySubKey [$i];
			$subMenu->value = $arraySubValue [$i];
			$subMenu->type = 'button';
			$subMenu->class = 'menuButton';
			$subMenu->onClick = 'gotoSubModule("' . $menuKey . '","' . $arraySubKey [$i] . '")';
			$subMenuList [] = $subMenu;
		}
		return $subMenuList;
	}
	function getResultByQuery($qry) {
		$items = array ();
		$result = mysql_query ( $qry, $this->connection );
		while ( $rows = mysql_fetch_array ( $result ) ) {
			$items [] = $rows;
		}
		return $items;
	}
	function getListMenuAsSelectBox() {
		$listMenu = $_SESSION ['session_menuButtons'];
		$defaultKey = "";
		$defaultValue = "";
		$total = count ( $listMenu );
		for($i = 0; $i < $total; $i ++) {
			$defaultKey = $defaultKey . $listMenu [$i]->id . ";";
			$defaultValue = $defaultValue . $listMenu [$i]->value . ";";
		}
		$defaultKey = substr ( $defaultKey, 0, - 1 );
		$defaultValue = substr ( $defaultValue, 0, - 1 );
		
		$field = new Field ( );
		
		$field->class = 'selectClass';
		$field->id = 'menu_id';
		$field->type = 'select';
		$field->defaultKey = $defaultKey;
		$field->defaultValue = $defaultValue;
		$field->onChange = 'changMenu(this.id)';
		$field->activeItem = $_SESSION ['session_selected_menu'];
		return $this->util->generateHTMLField ( $field, 'select_', '', '' );
	}
	function getListUserAsSelectBox() {
		$listUser = $_SESSION ['session_all_user'];
		$defaultKey = "";
		$defaultValue = "";
		$total = count ( $listUser );
		for($i = 0; $i < $total; $i ++) {
			$defaultKey = $defaultKey . $listUser [$i]->id . ";";
			$defaultValue = $defaultValue . $listUser [$i]->name . ";";
		}
		$defaultKey = substr ( $defaultKey, 0, - 1 );
		$defaultValue = substr ( $defaultValue, 0, - 1 );
		
		$field = new Field ( );
		
		$field->class = 'selectClass';
		$field->id = 'user_id';
		$field->type = 'select';
		$field->defaultKey = $defaultKey;
		$field->defaultValue = $defaultValue;
		$field->onChange = 'changUser(this.id)';
		$field->activeItem = $_SESSION ['session_id_of_user'];
		return $this->util->generateHTMLField ( $field, 'select_', '', '' );
	}
	function initSessionAllUser() {
		$qry = "select * from user";
		$result = $this->getResultByQuery ( $qry );
		$users = array ();
		
		for($i = 0; $i < count ( $result ); $i ++) {
			$user = new User ( );
			
			$user->id = $result [$i] ['id'];
			$user->name = $result [$i] ['name'];
			$users [] = $user;
		}
		$_SESSION ['session_all_user'] = $users;
	}
}
?>
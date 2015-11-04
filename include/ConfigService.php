<?php
class ConfigService {
	
	var $commonService;
	var $util;
	
	function ConfigService($commonService, $util) {
		$this->commonService = $commonService;
		$this->util = $util;
	}
	function modifyUserModule($ids, $values, $types) {
		//		echo "update user module: " . $values ['is_modify_user_module'] . "<br>";
//		echo 'user_select' . ":" . $values ['user_select']."<br>";
//		echo 'menu_remain_for_user' . ":" . $this->util->getModuleIdByKey($values ['menu_remain_for_user'])."<br>";
//		$table, $colums, $values
		$table = 'user_module';
		$colums = explode(";","user_id;module_id");
		$values = explode(";",$values ['user_select'].";".$this->util->getModuleIdByKey($values ['menu_remain_for_user']));
//		echo $this->util->buildInsertQryIndex($table, $colums, $values);
		$data = $this->commonService->addRowIndex($table, $colums, $values);
		if($data=='1'){
			$this->commonService->initSession();
		} 
		return $data;
	}
	function modifyModuleSubModule($ids, $values, $types) {
		echo "update module sub module:" . $values ['is_modify_module_sub_module'];
	}
}
?>
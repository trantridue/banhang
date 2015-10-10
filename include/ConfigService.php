<?php
class ConfigService {
	var $commonUtil;
	
	function ConfigService($commonUtil) {
		$this->commonUtil = $commonUtil;
	}
	//	load all configuration parameters into session
	function loadConfiguration() {
		session_start ();
		
		$result = $this->commonUtil->getResultByQuery ( select_all_config );
		for($i = 0; $i < count ( $result ); $i ++) {
			$_SESSION [prefix_session_config . $result [$i] ['key']] = $result [$i] ['value'];
		}
		// load user module
		$qry = "select * from module where id in (select module_id from user_module where user_id = " . $_SESSION [prefix_session_user . 'id'] . ")";
		$result = $this->commonUtil->getResultByQuery ( $qry );
		$session_user_module_key = "";
		$session_user_module_value = "";
		for($i = 0; $i < count ( $result ); $i ++) {
			$session_user_module_key = $session_user_module_key . "goModule" . $result [$i] ['key'] . ";";
			$session_user_module_value = $session_user_module_value . $result [$i] ['value'] . ";";
			$_SESSION ['session_user_module_key'] = substr ( $session_user_module_key, 0, - 1 );
			$_SESSION ['session_user_module_value'] = substr ( $session_user_module_value, 0, - 1 );
		}
	}
	
	function generateConfigurationEditForm() {
		$nbr_column = number_column_config_form;
		$counter = 0;
		$form = "update_config_form";
		
		$strBtnValues = label_button_search . ";" . label_button_insert . ";" . label_button_delete . ";" . label_button_update;
		$strBtnOnclicks = "searchConfig;insertConfig;deleteConfig;updateConfig";
		
		$buttonList = $this->commonUtil->prepareButtonData ( $strBtnValues, $strBtnOnclicks );
		
		$on = "ON";
		$off = "OFF";
		$onclick = 'onOff';
		
		$result = $this->commonUtil->getResultByQuery ( select_all_config );
		$html = table_start;
		for($i = 0; $i < count ( $result ); $i ++) {
			if (($counter % $nbr_column) == 0) {
				$html = $html . table_tr;
			}
			$title = $result [$i] ['description'];
			$label = $result [$i] ['label'];
			$key = $result [$i] ['key'];
			$type = $result [$i] ['type'];
			$value = $result [$i] ['value'];
			
			$html = $html . $this->commonUtil->generateTdLabel ( $title, $label );
			$html = $html . $this->commonUtil->generateTdText ( $type, $key, $value, $onclick, $on, $off );
			if ((($counter - $nbr_column + 1) % $nbr_column) == 0) {
				$html = $html . table_tr_closed;
			}
			$counter ++;
		}
		$html = $html . $this->commonUtil->generateButtonsColspan ( $buttonList, $nbr_column * 2 );
		$html = $html . table_closed;
		
		return $html;
	}

}
?>
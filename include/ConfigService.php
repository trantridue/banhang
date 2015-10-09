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
	}
	
	function generateConfigurationEditForm() {
		$nbr_column = number_column_config_form;
		$counter = 0;
		
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
		$html = $html . table_closed . hr_tag;
		$onclick_update_method = 'updateConfig';
		$html = $html . $this->commonUtil->generateUpdateButton ($onclick_update_method);
		return $html;
	}

}
?>
<?php
class ConfigService {
	
	var $commonUtil;
	var $on = "ON";
	var $off = "OFF";
	var $onclick = 'onOff';
	
	function ConfigService($commonUtil) {
		$this->commonUtil = $commonUtil;
	}
	
	function generateConfigurationInsertForm() {
		$table = "config";
		$result = $this->commonUtil->getTableStructure ( $table );
		
		$keys = $result [0];
		//		print_r($result [1]);
		$types = $this->commonUtil->convertMysqlTypeToHtmlType ( $result [1] );
		
		$html = table_start . table_th;
		
		for($i = 1; $i < count ( $keys ); $i ++) {
			$html = $html . table_td . $keys [$i] . table_td_closed;
		}
		$html = $html . table_th_closed;
		
		$html = $html . table_tr;
		for($i = 1; $i < count ( $keys ); $i ++) {
			$html = $html . table_td . $this->commonUtil->generateInputField ( $types [$i], $keys [$i], '', $this->onclick, $this->on, $this->off ) . table_td_closed;
		}
		$strBtnValues = label_button_insert;
		$strBtnOnclicks = "actionInsert";
		
		$buttonList = $this->commonUtil->prepareButtonData ( $strBtnValues, $strBtnOnclicks );
		$html = $html . $this->commonUtil->generateButtonsColspan ( $buttonList, count ( $keys ) );
		$html = $html . table_tr_closed;
		
		return $html . table_closed;
	}
	function generateConfigurationEditForm() {
		$nbr_column = number_column_config_form;
		$counter = 0;
		
		$strBtnValues = label_button_update;
		$strBtnOnclicks = "actionUpdate";
		
		$buttonList = $this->commonUtil->prepareButtonData ( $strBtnValues, $strBtnOnclicks );
		
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
			$html = $html . $this->commonUtil->generateTdText ( $type, $key, $value, $this->onclick, $this->on, $this->off );
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
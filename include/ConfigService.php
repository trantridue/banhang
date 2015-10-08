<?php
class ConfigService {
	var $commonUtil;
	var $qry = "select * from configuration";
	
	function ConfigService($commonUtil) {
		$this->commonUtil = $commonUtil;
	}
	//	load all configuration parameters into session
	function loadConfiguration() {
		session_start ();
		$result = $this->commonUtil->getResultByQuery ( $this->qry );
		for($i = 0; $i < count ( $result ); $i ++) {
			$_SESSION [$result [$i] ['name']] = $result [$i] ['value'];
		}
	}
	
	function generateConfigurationEditForm() {
		$nbr_column = $_SESSION ['nbr_column_edit_param'];
		$counter = 0;
		$result = $this->commonUtil->getResultByQuery ( $this->qry );
		$html = "<table width='100%'>";
		for($i = 0; $i < count ( $result ); $i ++) {
			if (($counter % $nbr_column) == 0) {
				$html = $html . "<tr>";
			}
			$html = $html . "<td class='tableTdLabel'>" . $result [$i] ['label'] . "</td>";
			$html = $html . "<td class='tableTdText'><input type='number' id='" . $result [$i] ['name'] . "' value='" . $result [$i] ['value'] . "'/></td>";
			
			if ((($counter - $nbr_column + 1) % $nbr_column) == 0) {
				$html = $html . "</tr>";
			}
			$counter ++;
		}
		$html = $html . "</table>";
		return $html;
	}
}
?>
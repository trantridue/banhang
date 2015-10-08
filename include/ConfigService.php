<?php
class ConfigService {
	var $commonUtil;
	var $qry = "select * from config";
	
	function ConfigService($commonUtil) {
		$this->commonUtil = $commonUtil;
	}
	//	load all configuration parameters into session
	function loadConfiguration() {
		session_start ();
		$result = $this->commonUtil->getResultByQuery ( $this->qry );
		for($i = 0; $i < count ( $result ); $i ++) {
			$_SESSION [$result [$i] ['key']] = $result [$i] ['value'];
		}
	}
	
	function generateConfigurationEditForm() {
		$nbr_column = number_column_config_form;
		$counter = 0;
		$result = $this->commonUtil->getResultByQuery ( $this->qry );
		$html = "<table width='100%'>";
		for($i = 0; $i < count ( $result ); $i ++) {
			if (($counter % $nbr_column) == 0) {
				$html = $html . "<tr>";
			}
			$html = $html . "<td class='tableTdLabel'>" . strtoupper ( $result [$i] ['label'] ) . "</td>";
			if ($result [$i] ['type'] == 'button') {
				$isOnOff = $result [$i] ['value'] == 0 ? "OFF" : "ON";
				$classOnOff = $result [$i] ['value'] == 0 ? "buttonOff" : "buttonOn";
				$html = $html . "<td class='tableTdText'>
				<input type='" . $result [$i] ['type'] . "' id='" . $result [$i] ['key'] . "' value='" . strtoupper ( $isOnOff ) . "' 
				onclick='onOffButton(\"" . $result [$i] ['key'] . "\");' class='" . $classOnOff . "'/>
				</td>";
			} else if ($result [$i] ['type'] == 'number') {
				$html = $html . "<td class='tableTdText'><input type='" . $result [$i] ['type'] . "' id='" . $result [$i] ['key'] . "' value='" . $result [$i] ['value'] . "'/></td>";
			} else {
				$html = $html . "<td class='tableTdText'><input type='" . $result [$i] ['type'] . "' id='" . $result [$i] ['key'] . "' value='" . $result [$i] ['value'] . "'/></td>";
			}
			
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
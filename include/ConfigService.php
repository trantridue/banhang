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
			$_SESSION [prefix_session_config.$result [$i] ['key']] = $result [$i] ['value'];
		}
	}
	
	function generateConfigurationEditForm() {
		$nbr_column = number_column_config_form;
		$counter = 0;
		$on = "ON";
		$off = "OFF";
		$result = $this->commonUtil->getResultByQuery ( select_all_config );
		$html = table_start;
		for($i = 0; $i < count ( $result ); $i ++) {
			if (($counter % $nbr_column) == 0) {
				$html = $html . "<tr>";
			}
			$html = $html . "<td title='" . $result [$i] ['label'] . "' class='tableTdLabel'>" . $result [$i] ['label']  . "</td>";
			if ($result [$i] ['type'] == 'button') {
				$isOnOff = $result [$i] ['value'] == 0 ? $off : $on;
				$classOnOff = $result [$i] ['value'] == 0 ? "buttonOff" : "buttonOn";
				$html = $html . "<td class='tableTdText'>
				<input type='" . $result [$i] ['type'] . "' id='" . $result [$i] ['key'] . "' value='" . strtoupper ( $isOnOff ) . "' 
				onclick='onOffButton(\"" . $result [$i] ['key'] . "\",\"" . $on . "\",\"" . $off . "\");' class='" . $classOnOff . "'/>
				</td>";
			} else if ($result [$i] ['type'] == 'number') {
				$html = $html . "<td class='tableTdText'><input type='" . $result [$i] ['type'] . "' id='" . $result [$i] ['key'] . "' value='" . $result [$i] ['value'] . "' class='number50'/></td>";
			} else if ($result [$i] ['type'] == 'datetime') {
				$html = $html . "<td class='tableTdText'><input type='text' class='datetimefield' id='" . $result [$i] ['key'] . "' value='" . $result [$i] ['value'] . "'/></td>";
			} else if ($result [$i] ['type'] == 'date') {
				$html = $html . "<td class='tableTdText'><input type='text' class='datefield' id='" . $result [$i] ['key'] . "' value='" . $result [$i] ['value'] . "'/></td>";
			} else if ($result [$i] ['type'] == 'textarea') {
				$html = $html . "<td class='tableTdText'>
				<textarea id=\"".$result [$i] ['key']."\" value=".$result [$i] ['value']." onfocus=\"if (this.value == this.defaultValue) this.value = ''\" onblur=\"if (this.value == '') this.value = this.defaultValue\" rows=\"4\" cols=\"80\">".$result [$i] ['value']."</textarea>
				</td>";
			} else {
				$html = $html . "<td class='tableTdText'><input type='" . $result [$i] ['type'] . "' id='" . $result [$i] ['key'] . "' value='" . $result [$i] ['value'] . "'/></td>";
			}
			
			if ((($counter - $nbr_column + 1) % $nbr_column) == 0) {
				$html = $html . "</tr>";
			}
			$counter ++;
		}
		$html = $html . table_closed;
		return $html;
	}

}
?>
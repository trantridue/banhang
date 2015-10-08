<?php
class ConfigService {
	var $commonUtil;
	
	function ConfigService($commonUtil) {
		$this->commonUtil = $commonUtil;
	}
	
	function loadConfiguration() {
		session_start ();
		$qry = "select * from configuration";
		$result = $this->commonUtil->getResultByQuery ( $qry );
		for($i = 0; $i < count ( $result ); $i ++) {
			$_SESSION [$result [$i] ['name']] = $result [$i] ['value'];
		}
	}
}
?>
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

function loadConfiguration() {
	session_start ();
	$result = $this->commonUtil->getResultByQuery ( $this->qry );
	for($i = 0; $i < count ( $result ); $i ++) {
		$_SESSION [$result [$i] ['name']] = $result [$i] ['value'];
	}
}

}
?>
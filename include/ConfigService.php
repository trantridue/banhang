<?php
class ConfigService {
	
	var $commonService;
	var $util;
	
	function ConfigService($commonService, $util) {
		$this->commonService = $commonService;
		$this->util = $util;
	}
	
}
?>
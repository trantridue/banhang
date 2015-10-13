<?php
class UserService {
	var $commonService;
	var $util;
	
	function UserService($commonService,$util) {
		$this->commonService = $commonService;
		$this->util = $util;
	}

}
?>
<?php
class CommonService {
	var $connection;
	var $util;
	
	function CommonService($connection, $util) {
		$this->connection = $connection;
		$this->util = $util;
	}
	
}
?>
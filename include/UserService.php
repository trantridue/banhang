<?php
class UserService {
	var $commonUtil;
	var $connection;
	
	function UserService($commonUtil) {
		$this->commonUtil = $commonUtil;
	}
	
	function getAllUser() {
		$qry = "select * from brand";
		return $this->commonUtil->getResultByQuery ( $qry );
	}
}
?>
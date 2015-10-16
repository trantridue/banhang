<?php 
require_once ("../../include/membersite_config.php");
//echo $_REQUEST['user_id'];
session_start();
echo $commonService->getListMenuByUser ($_REQUEST['user_id']);
?>
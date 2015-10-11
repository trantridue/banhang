<?php
require_once ("../../include/membersite_config.php");
$list_ids = explode ( ";", $_REQUEST [list_id] );
$list_values = array ();
for($i = 0; $i < count ( $list_ids ); $i ++) {
	$list_values [] = $_REQUEST [$list_ids [$i]];
}
echo $commonUtil->addRowIndex ( 'config', $list_ids, $list_values );
unset ( $_SESSION [session_all_field] );
?>
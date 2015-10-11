<?php
require_once ("../../include/membersite_config.php");
$table = $_SESSION ['table_name_insert'];
$list_ids = explode ( ";", $_REQUEST [list_id] );
$list_values = array ();
for($i = 0; $i < count ( $list_ids ); $i ++) {
	$list_values [] = $_REQUEST [$list_ids [$i]];
}
echo $commonUtil->addRowIndex ( $table, $list_ids, $list_values );
unset ( $_SESSION [session_all_field] );
?>
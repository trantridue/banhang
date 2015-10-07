<?php
//$users = $userService->getAllUser ();
//for($i = 0; $i < count ( $users ); $i ++) {
//	echo "<br>" . $users [$i] ['id'].". " . $users [$i] ['name'];
//}
$flag = true;
mysql_query ( "BEGIN" );

$table = "category";
$colums = array ('id', 'name' );
$values = array ('2', 'due');

$flag = $flag && $commonUtil->addRow ( $table, $colums, $values );

$table = "brand";
$colums = array ('id', 'name' );
$values = array ('2', 'due');


$flag = $flag && $commonUtil->addRow ( $table, $colums, $values );

$commonUtil->commitTransaction($flag)
?>
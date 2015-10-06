<?php
//$users = $userService->getAllUser ();
//for($i = 0; $i < count ( $users ); $i ++) {
//	echo "<br>" . $users [$i] ['id'].". " . $users [$i] ['name'];
//}


$table = "user";
$colums = array ('id', 'username', 'password' );
$values = array ('1', 'due', 'tran' );

$commonUtil->addRow ( $table, $colums, $values );
?>
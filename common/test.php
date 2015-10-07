<?php
/*
$users = $userService->getAllUser ();
for($i = 0; $i < count ( $users ); $i ++) {
	echo "<br>" . $users [$i] ['id'].". " . $users [$i] ['name'];
} 
*/
mysql_query ( "BEGIN" );
$flag = true;

/*
$table = "category";
$colums = array ('id', 'name' );
$values = array ('2', 'due');

$flag = $flag && $commonUtil->addRow ( $table, $colums, $values );

$table = "brand";
$colums = array ('id', 'name' );
$values = array ('2', 'due');


$flag = $flag && $commonUtil->addRow ( $table, $colums, $values );
*/
$values = array ();
$table = "test";
$colums = $commonUtil->getStringToArray ( table_test );

for($i = 0; $i < 5; $i ++) {
	$values [$i] = array ();
	for($j = 0; $j < count ( $colums ); $j ++) {
		if ($colums [$j] == 'name') {
			$values [$i] [$colums [$j]] = 'name_' . $i;
		} else if ($colums [$j] == 'date') {
			$values [$i] [$colums [$j]] = date ( 'Y-m-d h:i:s A', strtotime($commonUtil->getCurrentDateFormat_YYYYMMDD_HHMISS()) + 3600 * $i );
		} else {
			$values [$i] [$colums [$j]] = $i % 2 ? false : true;
		}
	}
}
//echo $commonUtil->buildInsertQrys ( $table, $colums, $values );
$commonUtil->addRows ( $table, $colums, $values );
//print_r($commonUtil->getStringToArray(table_user));
//print_r($values);
$commonUtil->commitTransaction ( $flag )?>
<?php
/*
$users = $userService->getAllUser ();
for($i = 0; $i < count ( $users ); $i ++) {
	echo "<br>" . $users [$i] ['id'].". " . $users [$i] ['name'];
} 
*/

$flag = true;
mysql_query ( "BEGIN" );

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
$values = array();
$table = "test";
$colums = array ('name', 'pass' );


for ($i=0;$i<2;$i++) {
	$values[$i] = array();
	for($j=0;$j<count($colums);$j++) {
		$values[$i][$colums[$j]] = 'row_'.$i.'*col_'.$j;
	}
}
echo $commonUtil->buildInsertQry( $table, $colums, $values[0] );
//$flag = $flag && $commonUtil->addRows ( $table, $colums, $values );
//print_r($values); 

$commonUtil->commitTransaction($flag)
?>
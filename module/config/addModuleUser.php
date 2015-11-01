<?php
ob_start ();
require_once ("../../include/membersite_config.php");
session_start ();

$ids = explode ( ';', $_REQUEST ['list_id'] );
$types = explode ( ';', $_REQUEST ['list_type'] );
$values = $util->getListValuesByIds($ids);

$is_modify_user_module = $_REQUEST ['is_modify_user_module'];
$is_modify_module_sub_module = $_REQUEST ['is_modify_module_sub_module'];

if ($values['is_modify_user_module'] == 1) {
	modifyUserModule ( $ids, $values, $types );
}
if ($values['is_modify_module_sub_module'] == 1) {
	modifyModuleSubModule ( $ids, $values, $types );
}
function modifyUserModule($ids, $values, $types) {
	echo "update user module: " . $values ['is_modify_user_module']."<br>";
}
function modifyModuleSubModule($ids, $values, $types) {
	echo "update module sub module:" . $values ['is_modify_module_sub_module'];
}
?>
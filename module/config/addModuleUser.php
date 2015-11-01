<?php
ob_start ();
require_once ("../../include/membersite_config.php");
session_start ();

$ids = explode ( ';', $_REQUEST ['list_id'] );
$types = explode ( ';', $_REQUEST ['list_type'] );
$values = $util->getListValuesByIds ( $ids );

$is_modify_user_module = $_REQUEST ['is_modify_user_module'];
$is_modify_module_sub_module = $_REQUEST ['is_modify_module_sub_module'];

if ($values ['is_modify_user_module'] == 1) {
	$configService->modifyUserModule ( $ids, $values, $types );
}
if ($values ['is_modify_module_sub_module'] == 1) {
	$configService->modifyModuleSubModule ( $ids, $values, $types );
}

?>
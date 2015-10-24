<?php
ob_start();
require_once ("../../include/membersite_config.php");
session_start();
//echo $_REQUEST ['user_select'].":".$util->getModuleIdByKey($_REQUEST ['menu_by_user']).":".$util->getModuleIdByKey($_REQUEST ['menu_remain_for_user']);
//echo $util->getModuleIdByKey($_REQUEST ['all_menu']).":".$util->getSubModuleIdByKey($_REQUEST ['sub_menu_select']).":".$util->getSubModuleIdByKey($_REQUEST ['sub_menu_remain_for_menu']);

echo $_REQUEST ['list_id']."-";
echo $_REQUEST ['list_type']."";
?>
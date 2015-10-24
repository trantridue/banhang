<?php
ob_start();
require_once ("../../include/membersite_config.php");
session_start();
echo $_REQUEST ['user_select'].":".$util->getModuleIdByKey($_REQUEST ['menu_by_user']).":".$util->getModuleIdByKey($_REQUEST ['menu_remain_for_user']);
?>
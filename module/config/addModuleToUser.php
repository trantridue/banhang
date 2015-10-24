<?php
ob_start();
require_once ("../../include/membersite_config.php");
session_start();
echo $util->getModuleIdByKey($_REQUEST ['moduleKey']).$util->getModuleIdByKey($_REQUEST ['active_menu']).$_REQUEST ['user_id'];
?>
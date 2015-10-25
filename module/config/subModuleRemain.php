<?php
ob_start();
require_once ("../../include/membersite_config.php");
session_start();
echo $util->buildSubModuleSelectRemainForModule ($_REQUEST ['menu'],'sub_menu_remain');
?>

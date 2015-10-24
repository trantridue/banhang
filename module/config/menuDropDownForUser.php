<?php
ob_start();
require_once ("../../include/membersite_config.php");
session_start();
echo $util->buildMenuDropDownRemainForUser ( $_REQUEST ['user_id'],'menu_remain_for_user' );
?>
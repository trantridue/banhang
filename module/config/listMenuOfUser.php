<?php
ob_start();
require_once ("../../include/membersite_config.php");
session_start();
echo $util->buildModuleSelectByUser ( $_REQUEST ['user_id'] );
?>
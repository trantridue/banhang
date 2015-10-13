<?php
//session_start();
$_SESSION ['session_selected_menu'] = default_menu;
if (isset ( $_REQUEST ['module'] )) {
	$_SESSION ['session_selected_menu'] = $_REQUEST ['module'];
}
include 'module/' . $_SESSION ['session_selected_menu'] . "/main.php";
?>
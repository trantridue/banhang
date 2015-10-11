<?php
if (isset ( $_REQUEST ['module'] )) {
	$_SESSION ['active_module'] = $_REQUEST ['module'];
} else {
	$_SESSION ['active_module'] = $_SESSION [prefix_session_config . 'default_module'];
}

$strBtnOnclicks = $_SESSION ['session_user_module_key'];
$strBtnValues = $_SESSION ['session_user_module_value'];

$buttonList = $commonUtil->prepareButtonData ( $strBtnValues, $strBtnOnclicks );

echo div_tag_left . $commonUtil->generateButtons ( $buttonList ) . div_tag_closed;
?>
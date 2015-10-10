<?php
$strBtnOnclicks = $_SESSION ['session_user_module_key'];
$strBtnValues = $_SESSION ['session_user_module_value'];

$buttonList = $commonUtil->prepareButtonData ( $strBtnValues, $strBtnOnclicks );

echo div_tag_left . $commonUtil->generateButtons ( $buttonList ) . div_tag_closed;
?>
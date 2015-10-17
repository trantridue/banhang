<div id="body_data_sub_menu">
<?php
	echo $util->buildSubMenu();
?>
</div>

<div id="body_data_main">
<?php
$formName = $_SESSION ['session_active_menu'] . $_SESSION ['session_active_sub_menu'] . "Form";
?>
<form id="<?php
echo $formName;
?>">
<?php
include 'module/' . $_SESSION ['session_active_menu'] . "/".$_SESSION ['session_active_sub_menu'].".php";
?>
</form>
</div>
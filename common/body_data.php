<div id="body_data_sub_menu">
<?php
$commonService->initSubMenu ();
?>
</div>

<div id="body_data_main">
<?php
$formName = $_SESSION ['session_selected_menu'] . $_SESSION ['session_selected_sub_menu']; 
?>
<form id="<?php echo $formName;?>">
<?php
include 'module/' . $_SESSION ['session_selected_menu'] . "/main.php";
?>
</form>
</div>
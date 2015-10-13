<div id="body_data_sub_menu">
<?php
$commonService->initSubMenu ();
?>
</div>

<div id="body_data_main">
<?php
include 'module/' . $_SESSION ['session_selected_menu'] . "/main.php";
?>
</div>
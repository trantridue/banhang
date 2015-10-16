<div id="body_data_sub_menu">
<?php
//$commonService->initSubMenu ();
$field = new Field ('test','button','activeButtonViolet','perform_button','INSERT','alert("aaa")');

echo $util->generateHTMLField ($field);
?>
</div>

<div id="body_data_main">
<?php
$formName = $_SESSION ['session_selected_menu'] . $_SESSION ['session_selected_sub_menu'] . "Form";
?>
<form id="<?php
echo $formName;
?>">
<?php
//include 'module/' . $_SESSION ['session_selected_menu'] . "/main.php";
?>
</form>
</div>
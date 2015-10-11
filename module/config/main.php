<form id="<?php echo $_SESSION ['active_module'].'updateForm';?>">
<?php
echo $configService->generateConfigurationEditForm ();
?>
</form>
<hr>
<form id="<?php echo $_SESSION ['active_module'].'insertForm';?>">
<?php
echo $configService->generateConfigurationInsertForm ();
?>
</form>

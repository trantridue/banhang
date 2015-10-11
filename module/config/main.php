<form id="<?php echo $_SESSION ['active_module'].'Form';?>">
<?php
echo $configService->generateConfigurationEditForm ();
?>
</form>
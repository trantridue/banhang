<form id="<?php
echo $_SESSION ['active_module'] . 'updateForm';
?>">
<?php
echo $configService->generateConfigurationEditForm ();
?>
</form>
<hr>
<table width="100%">
	<tr class="tr_head">
		<td>CONFIG</td>
		<td>BRAND</td>
	</tr>
	<tr>
		<td>
		<form
			id="<?php
			echo $_SESSION ['active_module'] . 'insertconfigForm';
			?>">
<?php
echo $configService->generateConfigurationInsertForm ( 'config' );
?>
</form>
		</td>
		<td>
		<form
			id="<?php
			echo $_SESSION ['active_module'] . 'insertbrandForm';
			?>">
<?php
echo $configService->generateConfigurationInsertForm ( 'brand' );
?>
</form>
		</td>
	</tr>

</table>




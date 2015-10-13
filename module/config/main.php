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
<tr class="tr_head">
		<td>SHOP</td>
		<td>USER</td>
	</tr>
	<tr>
		<td>
		<form
			id="<?php
			echo $_SESSION ['active_module'] . 'insertshopForm';
			?>">
<?php
echo $configService->generateConfigurationInsertForm ( 'shop' );
?>
</form>
		</td>
		<td>
		<form
			id="<?php
			echo $_SESSION ['active_module'] . 'insertuserForm';
			?>">
<?php
echo $configService->generateConfigurationInsertForm ( 'user' );
?>
</form>
		</td>
	</tr>
</table>




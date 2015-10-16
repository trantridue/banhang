<table>
	<tr>
		<th>User</th>
		<th>Module</th>
	</tr>
	<tr>
		<td>
		<div id="userDrop">
<?php
echo $commonService->getListUserAsSelectBox ();
?>
</div>
		</td>
		<td>
		<div id="menuDrop">
<?php
echo $commonService->getListMenuByUser ($_SESSION['session_id_of_user']);
?>
</div>
		</td>
	</tr>
</table>




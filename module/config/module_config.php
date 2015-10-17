<table>
	<tr>
		<th>User</th>
		<th>Module</th>
		<th>Active Module</th>
	</tr>
	<tr>

		<td>
		<div id="userDropDown">
	<?php
	echo $util->buildUserSelect ();
	?>
</div>
		</td>
		<td>
		<div id="userMenuDropDown">
<?php
echo $util->buildModuleSelectByUser ( $_SESSION ['session_id_of_user'] );
?>
</div>
		</td>
		<td>
		<div>
<?php

?>
</div>
		</td>
	</tr>
</table>




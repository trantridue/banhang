<table width="100%">
	<tr><td>
		<div id="userDropDown">
	<?php
	echo $util->buildUserSelect ();
	?>
</div>
<div id="userMenuActive">
<?php
echo $util->buildModuleSelectByUser ( $_SESSION ['session_id_of_user'] );
?>
</div>
		<div id="userMenuTable">
<?php
echo $util->buildModuleTableByUser ( $_SESSION ['session_id_of_user'] );
?>
</div>
		</td>
		
	</tr>
	
</table>




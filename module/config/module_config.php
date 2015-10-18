<table width="100%">
	<tr>
		<?php  echo $util->generateTdBlockLabelAndField('Nhân viên : ',$util->buildUserSelect (),'userDropDown'); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Module : ',$util->buildModuleSelect (),'menuDropDown'); ?>
	</tr>
	<tr>
		<?php  echo $util->generateTdBlockLabelAndField('Module mặc định : ',$util->buildModuleSelectByUser ( $_SESSION ['session_id_of_user'] ),'userMenuActive'); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Sub mặc định : ',$util->buildModuleSelectByUser ( $_SESSION ['session_id_of_user'] ),'subMenuActive'); ?>
	</tr>
	<tr>
		<td colspan="2">
		<div id="userMenuTable">
			<?php
			echo $util->buildModuleTableByUser ( $_SESSION ['session_id_of_user'] );
			?>
		</div>
		</td>
		<td colspan="2">
		<div id="menuSubMenuTable">
			<?php
			echo $util->buildSubModuleTableByModule ( $_SESSION ['session_active_menu'] );
			?>
		</div>
		</td>
	</tr>
</table>



